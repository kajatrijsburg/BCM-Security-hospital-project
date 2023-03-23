<?php
require_once 'public/intranet/ldap_support.inc.php';
require_once 'public/intranet/ldap_constants.inc.php';
Class Role {

    static function createApplicationRole($cn) {
        Role::createRole($cn, USERS_APPLICATION_DN);
    }

    static function createInternalRole($cn) {
        Role::createRole($cn, USERS_INTERN_DN);
    }

    static function createExternalRole($cn) {
        Role::createRole($cn, USERS_EXTERN_DN);
    }

    /**
     * @throws Exception
     */
    static function getAll() {
        $ldap = ConnectAndCheckLDAP();
        $roles = GetAllLDAPGroups();
        ldap_close($ldap);
        return $roles;
    }

    private static function createRole($cn, $dn) {
        $dn = "cn=" . $cn . "," . $dn;
        $ldap = ConnectAndCheckLDAP();
        CreateNewRole($ldap, $dn, $cn);
        //CreateNewUser($ldap, $dn, $cn, $lastname, $username, $firstName);
        //$instance = new User($username);
        //$instance->setPassword($password);
        //$instance->addRole(GROUPS_DN);
        ldap_close($ldap);
        //return $instance;
    }
}
?>