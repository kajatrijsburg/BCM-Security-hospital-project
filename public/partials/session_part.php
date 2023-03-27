<?php
session_start();

//check if the session hasn't timed out and if it has, redirect the user.
if ($_SESSION["TIMEOUT"] - time() < 0){
    header('location: ' . 'http://energy.org/SessionTimeOutWarning.php', true);
    exit();
}