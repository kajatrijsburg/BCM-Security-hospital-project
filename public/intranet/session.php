<?php

session_start();
include_once "sessionfunctions.php";


//--------------------------------------------------------
//session time
$timeInMinutes = 30;
$time = $timeInMinutes * 60;
//update page

//set session time in seconds
$_SESSION["TIMEOUT"] = time() + $time;

$_SESSION["ROLS"] = getroles();
$_SESSION["PERMISSIONS"] = get_permissions_name();
$_SESSION["V_NAME"] = set_userinfo_vname();
$_SESSION["A_NAME"] = set_userinfo_aname();
$_SESSION["USER_ID"] = set_userinfo_id();

header('location: ' . 'http://energy.org/intranet/Dashboard.php', true);
exit();