<?php
session_start();
include_once "ldap_constants.inc.php";
include_once "ldap_support.inc.php";
include_once "sessionfunctions.php";


//--------------------------------------------------------

//update page

//set session time in seconds
$_SESSION["TIMEOUT"] = time() + 10;

$_SESSION["ROLS"] = getrols();
$_SESSION["PERMISSIONS"] = get_permissions_name();
$_SESSION["V_NAME"] = set_userinfo_vname();
$_SESSION["A_NAME"] = set_userinfo_aname();
$_SESSION["USER_ID"] = set_userinfo_id();




