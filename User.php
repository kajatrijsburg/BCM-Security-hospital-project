<?php
require_once 'public/intranet/ldap_support.inc.php';
require_once 'public/intranet/ldap_constants.inc.php';
class User {
    public $firstName;
    public $lastName;
    public $roles;
    // TODO: Permission Mapping
    public $permissions;
    private $userId;
    private $commonName;
    private $distinguishedName;

    /**
     * @throws Exception
     */
    function __construct($userId) {
        $ldap = ConnectAndCheckLDAP();
        $this->distinguishedName = GetUserDNFromUID($ldap, $userId);
        $user = ReportUser($ldap, $this->distinguishedName);
        $this->userId = $user["uid"];
        $this->firstName = $user["givenname"];
        $this->lastName = $user["sn"];
        $this->commonName = $user["cn"];

        $this->roles = GetAllLDAPGroupMemberships($ldap, $this->distinguishedName);
        ldap_close($ldap);
    }

    public static function createInternal($firstName, $lastname, $username, $password) {
        return self::create($firstName, $lastname, $username, $password, USERS_INTERN_DN);
    }

    public static function createExternal($firstName, $lastname, $username, $password) {
        return self::create($firstName, $lastname, $username, $password, USERS_EXTERN_DN);
    }

    public static function createApplication($firstName, $lastname, $username, $password) {
        return self::create($firstName, $lastname, $username, $password, USERS_APPLICATION_DN);
    }

    /**
     * @throws Exception
     */
    private static function create($firstName, $lastname, $username, $password, $userDN) {
        $cn = $lastname . " " . $firstName;
        $dn = "cn=" . $cn . "," . $userDN;
        $ldap = ConnectAndCheckLDAP();
        CreateNewUser($ldap, $dn, $cn, $lastname, $username, $firstName);
        $instance = new User($username);
        $instance->setPassword($password);
        $instance->addRole(GROUPS_DN);
        ldap_close($ldap);
        return $instance;
    }

    /**
     * @throws Exception
     */
    function addRole($role) {
        $ldap = ConnectAndCheckLDAP();
        AddUserToGroup($ldap, $role, $this->distinguishedName);
        $this->updateRoles($ldap);
        ldap_close($ldap);
    }

    /**
     * @throws Exception
     */
    function removeRole($role) {
        $ldap = ConnectAndCheckLDAP();
        RemoveUserFromGroup($ldap, $role, $this->distinguishedName);
        $this->updateRoles($ldap);
        ldap_close($ldap);
    }

    /**
     * @throws Exception
     */
    function setPassword($newPassword) {
        $ldap = ConnectAndCheckLDAP();
        SetPassword($ldap, $this->distinguishedName, $newPassword);
        ldap_close($ldap);
    }

    /**
     * @throws Exception
     */
    private function updateRoles($ldap) {
        $this->roles = GetAllLDAPGroupMemberships($ldap, $this->distinguishedName);
    }
}
?>