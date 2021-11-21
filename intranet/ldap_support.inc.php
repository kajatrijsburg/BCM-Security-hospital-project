<?php

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

    // now get the object from the database and check the values.
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