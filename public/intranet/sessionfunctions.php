<?php
include_once "ldap_support.inc.php";
include_once "ldap_constants.inc.php";
function connectDB()
{

    $servername = "localhost";
    $username = "student";
    $password = 'j2y$bbaadDFw%F8z!f';
    $dbname = "ziekenhuis";

    $conn = new mysqli($servername, $username, $password, $dbname);

    return $conn;
}

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

function get_rol_ids()
{

    $conn = connectDB();
//getrols()
    $rols = ['rol1', 'rol2', 'rol3'];
    $rolsid = [];
    $position = 0;

    foreach ($rols as $rol) {
        $get_rolid_sql = "SELECT rolid FROM rol WHERE rolnaam = :rol";
        $result = $conn->prepare($get_rolid_sql)->execute([$rol]);


        while ($row = mysqli_fetch_assoc($result)) {
            $rolsid[$position] = $row['rolid'];
        }
        $position++;
    }
    return $rolsid;
}

function get_permissions_id()
{

    $conn = connectDB();
//get_rols_id()
    $rolids = [1, 2, 3];
    $duplicate = false;
    $permissionids = [];

    foreach ($rolids as $rolid) {

        $get_rolid_sql = "SELECT permiessieid FROM rolpermissies WHERE rolid = '$rolid'";
        $result = $conn->query($get_rolid_sql);

        while ($row = mysqli_fetch_assoc($result)) {

            if (sizeof($permissionids) == 0) {

                $permissionids[0] = $row['permiessieid'];
            } else {

                foreach ($permissionids as $permissionid) {
                    if ($permissionid == $row['permiessieid']) {
                        $duplicate = true;
                    }
                }
                if ($duplicate) {
                    $duplicate = false;
                } else {
                    $permissionids[sizeof($permissionids)] = $row['permiessieid'];
                }
            }

        }
    }
    return $permissionids;
}

function get_permissions_name()
{
    $conn = connectDB();
    $permissionids = get_permissions_id();
    $permissionnames = [];
    $position = 0;

    foreach ($permissionids as $permissionid) {

        $get_permissionname_sql = "SELECT permissienaam FROM permissies WHERE permissieid = '$permissionid'";
        $result = $conn->query($get_permissionname_sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $permissionnames[sizeof($permissionnames)] = $row['permissienaam'];
        }
    }
    return $permissionnames;
}

function set_userinfo_vname()
{

    $conn = connectDB();
    $email = "voorbeeld@gmail.com";
    $v_name = "";

    $get_userinfo_sql = "SELECT voornaam FROM user WHERE email = '$email'";
    $result = $conn->query($get_userinfo_sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $vname = $row['voornaam'];
    }
    return $v_name;
}

function set_userinfo_aname()
{

    $conn = connectDB();
    $email = "voorbeeld@gmail.com";
    $a_name = "";

    $get_userinfo_sql = "SELECT achternaam FROM user WHERE email = '$email'";
    $result = $conn->query($get_userinfo_sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $a_name = $row['achternaam'];
    }
    return $a_name;
}

function set_userinfo_id()
{

    $conn = connectDB();
    $email = "voorbeeld@gmail.com";
    $id = 0;

    $get_userinfo_sql = "SELECT userid FROM user WHERE email = '$email'";
    $result = $conn->query($get_userinfo_sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['userid'];
    }
    return $id;
}