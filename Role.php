<?php
require_once 'public/intranet/ldap_support.inc.php';
require_once 'public/intranet/ldap_constants.inc.php';
Class Role {

    public $name;
    // TODO: Map permissions from DB
    public $permissions;
    public $dn;

    static function createApplicationRole($cn) {
        Role::createRole($cn, USERS_APPLICATION_DN);
    }

    static function createInternalRole($cn) {
        Role::createRole($cn, USERS_INTERN_DN);
    }

    static function createExternalRole($cn) {
        Role::createRole($cn, USERS_EXTERN_DN);
    }

    function __construct($dn) {
    $this->dn = $dn;
    $explode = ldap_explode_dn($dn, 0);
    $this->name = str_replace('cn=', '', $explode[0]);
    }

    /**
     * @throws Exception
     */
    static function getAll() {
        $ldap = ConnectAndCheckLDAP();
        $roleDNs = GetAllLDAPGroups($ldap);
        ldap_close($ldap);
        $roles = [];
        foreach ($roleDNs as $roleDN) {
            $roles[] = new Role($roleDN);
        }
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