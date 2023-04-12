<?php
include_once "ldap_support.inc.php";
include_once "ldap_constants.inc.php";
require_once "../php/sql.php";

function getroles()
{
    try {
        $lnk = ConnectAndCheckLDAP();
    } catch (Exception $ex) {
        die($ex->getMessage());
    }
    $userDN = GetUserDNFromUID($lnk, $_SERVER["AUTHENTICATE_UID"]);
    $groups = GetAllLDAPGroupMemberships($lnk, $userDN);

    $roles = [];
    $positie = 0;
    $offset = 3;
    $length = 0;

    foreach ($groups as $group) {
        $char = "";
        while ($char != ",") {
            $char = $group[$length];
            $length++;
        }
        $length = $length - 4;
        $roles[$positie] = substr($group, $offset, $length);
        $length = 0;
        $positie++;
    }
    return $roles;
}

function get_permissions_name($roles)
{
    $userPermissions = [];
    $db = new DataBase();
    foreach ($roles as $role){
        $rolePermissions = $db->getRolePermissions($role);
        foreach ($rolePermissions as $rolePermission){
            if (empty($userPermissions[$rolePermission])){
                $userPermissions[$rolePermission] = $rolePermission;
            }
        }
    }
    $db = null;
    return $userPermissions;
}

function set_userinfo_vname()
{
    $db = new DataBase();
    return $db->getUser($_SERVER["AUTHENTICATE_UID"])->fetchColumn(1);
}

function set_userinfo_aname()
{
    $db = new DataBase();
    return $db->getUser($_SERVER["AUTHENTICATE_UID"])->fetchColumn(2);
}

function set_userinfo_id()
{
    return $_SERVER["AUTHENTICATE_UID"];
}