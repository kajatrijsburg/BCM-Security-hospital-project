<?php
/** @file ldap_support.inc.php
 * Lots of documented LDAP function
 *
 * @author Martin Molema <martin.molema@nhlstenden.com>
 * @copyright 2022
 *
 * A number of basic functions to show students how to interact (read/modify/query) LDAP objects.
 */

/**
 * Makes a connection to the database (using  <a href="https://www.php.net/manual/en/function.ldap-connect.php">ldap_connect</a>)
 * and binds the user and password (<a href="https://www.php.net/manual/en/function.ldap-bind.php">ldap_bind</a>).
 * On success a resource/link is returned for further use in other functions.
 *
 * @see ldap_constants.inc.php
 * @see LDAP_ADMIN_CN   The DN of the user that will setup the connection
 * @see LDAP_PASSWORD
 * @see LDAP_PORT
 * @return resource
 * @throws Exception
 */
function ConnectAndCheckLDAP() {

// connect to the service
    $lnk = ldap_connect(LDAP_HOST, LDAP_PORT);

// check connectivity
    if ($lnk === false) {
        throw(new Exception("Cannot connect to " . LDAP_HOST . ":" . LDAP_PORT));
    } else {
        // expect protocol version 3 to be the standard
        ldap_set_option($lnk, LDAP_OPT_PROTOCOL_VERSION, 3);

        // bind to the service using a username & password
        $bindres = ldap_bind($lnk, LDAP_ADMIN_CN, LDAP_PASSWORD);
        if ($bindres === false) {
            throw(new Exception("Cannot bind using user " . LDAP_ADMIN_CN));
        }
    }

    return $lnk;
}

/**
 * Adds a user to an existing groupOfUniqueNames
 * @param $lnk connection to the LDAP server
 * @param $groupDN complete Distinguished name (DN) of the group the user must be added to
 * @param $userDN complete Distinguished name (DN) of the user to be added
 * @throws Exception if the user cannot be added to the group, throw an exception
 */
function AddUserToGroup($lnk, $groupDN, $userDN)
{
    $attributes = [GROUP_ATTR_NAME => $userDN];
    if (ldap_mod_add($lnk, $groupDN, $attributes) === false) {
        $error = ldap_error($lnk);
        $errno = ldap_errno($lnk);
        throw new Exception($error, $errno);
    }
}

/**
 * Creates a new user.
 *
 * @param $lnk the connection to the LDAP server
 * @param $newUserDN the complete Distinguished name (DN) of the user to be created
 * @param $cn The Canonical name of the new user
 * @param $sn The surname ("lastname") of the new user
 * @param $uid The UserID of the new user; must be unique!
 * @param $givenName The given name ("first name") of the new user
 * @throws Exception If the user cannot be created an exception is thrown
 */
function CreateNewUser($lnk, $newUserDN, $cn, $sn, $uid, $givenName)
{

    // setup an array with all the attributes needed to add a new user.
    $fields = array();

    // first indicate what kind of object we want te create ("Objectclass"). Multivalue attribute!!
    $fields['objectClass'][] = "top";
    $fields['objectClass'][] = "inetOrgPerson";
    $fields['objectClass'][] = "person";
    $fields['objectClass'][] = "organizationalPerson";

    $fields['cn'] = $cn;
    $fields['sn'] = $sn;
    $fields['uid'] = $uid;
    $fields['givenName'] = $givenName;

    echo "De gebruiker wordt aangemaakt op $newUserDN \n";

    // Now do the actual adding of the object to the LDAP-service
    if (ldap_add($lnk, $newUserDN, $fields) === false) {
        $error = ldap_error($lnk);
        $errno = ldap_errno($lnk);
        throw new Exception($error, $errno);
    }
}// CreateNewUser

/**
 * Changes or adds a new password for an existing user. Requires the Crypt-SHA-256 to be available as a hashing function
 * @param $lnk the connection to the LDAP server
 * @param $newUserDN the complete Distinguished name (DN) of the user to be created
 * @param $newPassword The new password to be set.
 * @return string the new encrypted password
 * @throws Exception
 */
function SetPassword($lnk, $newUserDN, $newPassword)
{
    if (CRYPT_SHA256 == 1) {
        $somesalt = uniqid(mt_rand(), true);

        /** Setup a new encrypted password using the Crypt function and the CRYPT-SHA-256 hash. See the URL below
         * notice how the crypt()-function has a salt starting with $5$ to indicate the SHA-256 hash
         *
         * https://www.php.net/manual/en/function.crypt.php
         *
         **/
        $encoded_newPassword = "{CRYPT}" . crypt($newPassword, '$5$' . $somesalt . '$');
    } else {
        throw new Exception("No encyption module for Crypt-SHA-256");
    }

    $entry = ['userPassword' => $encoded_newPassword];

    if (ldap_modify($lnk, $newUserDN, $entry) === false) {
        $error = ldap_error($lnk);
        $errno = ldap_errno($lnk);
        throw new Exception($error, $errno);
    }
    return $encoded_newPassword;
}// SetPassword

/**
 * Report information about a user
 * @param $lnk the connection to the LDAP server
 * @param $userDN the DN of the user to be reported
 * @throws Exception Throws an exception if the DN cannot be found or leads to multiple items.
 */
function ReportUser($lnk, $userDN)
{
    // get the object from the database and check the values.
    $ldapRes = ldap_read($lnk, $userDN, "(ObjectClass=*)", array("*"));

    if ($ldapRes !== false) {
        $entries = ldap_get_entries($lnk, $ldapRes);
        /*
         * De entries die teruggeven worden hebben
         *  - óf een index met een getal om attribuut-namen terug te geven
         *  - óf een index met een string om de waarde(n) van een attribuut terug te geven.
         */

        if ($entries['count'] == 1) {
            // take the first entry and check the 'count'-attribute
            $entry = $entries[0];
            $numAttrs = $entry['count'];

            // collect all the attribute names
            $attributesReturned = array();
            for ($i = 0; $i < $numAttrs; $i++) {
                $attr = strtolower($entry[$i]);
                $attributesReturned[$attr] = $attr;
            }//for each attribute number

            // Now get the attribute values
            $valuesNamed = array();
            foreach ($attributesReturned as $attributeName) {
                // check if a value is an Array or a single value
                if (is_array($entry[$attributeName])) {
                    $thisItem = $entry[$attributeName];

                    //remove the 'count'-attribute from the array and glue them together.
                    unset($entry[$attributeName]['count']);
                    $valuesNamed[$attributeName] = join("/", $entry[$attributeName]);
                } else {
                    $valuesNamed[$attributeName] = $entry[$attributeName];
                }
            }//for each attribute

            // Now show all the values
            foreach ($valuesNamed as $key => $value) {
                echo "{$key} = $value \n";
            }//for each value

        }// if exactly one item found (this must be!)
        else {
            throw new Exception("Cannot find the given DN ($userDN)");
        }
    }
}// ReportUser

/**
 * Gets all the groups in LDAP that has the given user's DN (DistinguishedName) as a UniqueMember. So this function
 * will get all the groups that the user is a memberOf.
 * @param $lnk
 * @param $userDN
 * @return array
 * @throws Exception
 */
function GetAllLDAPGroupMemberships($lnk, $userDN) {
    // https://www.php.net/manual/en/function.ldap-search.php

    /**
     * Perform search in the BASE_DN from the LDAP-constants (@see ldap_constants.inc.php)
     */
    $ldapRes = ldap_search($lnk, BASE_DN, "(&(objectClass=*)(uniqueMember=${userDN}))", ['*'], 0, -1,-1,0);
    if ($ldapRes ===  false ) {
        throw new Exception("GetAllLDAPGroupMemberships::Cannot execute query");
    }
    // now actually read the found entries
    $results = ldap_get_entries($lnk, $ldapRes);
    $groups = [];

    // cycle through the results. first check if there are results
    if ($results !== false && $results['count'] > 0) {
        $count = $results['count'];
        for ($i = 0; $i < $count ;$i++){
            // get one record from the result
            $record = $results[$i];

            // get the 'DN' and add it to the array of groups ($groups[] = ... will add a new value)
            $groups[] = $record['dn'];
        }
    }
    return $groups;
}//GetAllLDAPGroupMemberships

/**
 * Lookup the logged in user (by using the specified UID) in LDAP and return its DistinguishedName (DN)
 * @param $lnk the active link (connected & bound)
 * @param $uid the UserID to lookup
 * @return mixed|null will return a string (DN) or null if not found
 * @throws Exception If search raises an error an exception is thrown.
 */
function GetUserDNFromUID($lnk, $uid) {
    // https://www.php.net/manual/en/function.ldap-search.php
    $ldapRes = ldap_search($lnk, BASE_DN, "(&(objectClass=INetOrgPerson)(uid=${uid}))", ['*'], 0, -1,-1,0);
    if ($ldapRes ===  false ) {
        throw new Exception("GetUserDNFromUID::Cannot execute query");
    }

    $results = ldap_get_entries($lnk, $ldapRes);
    if ($results !== false && $results['count'] == 1) {
        $record = $results[0];
        if (isset($record['dn'])) {
            return $record['dn'];
        }
        else {
            return null;
        }
    }
    else {
        return null;
    }
}// GetUserDNFromUID