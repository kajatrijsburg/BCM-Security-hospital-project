<?php
require_once("../../php/sql.php");
require_once("../../php/clean-input.php");
require_once("../../php/permissies.php");
include_once("../../partials/session_part.php");

requirePermission($_SESSION, Permissions::$manageAppointments);

$input = array(
    "Locatie" =>  trimAndClean($_POST["inputLocatie"]),
    "Online" =>  trimAndClean($_POST["inputOnline"]),
    "Datum" =>  trimAndClean($_POST["inputDatum"]),
    "Tijd" =>  trimAndClean($_POST["inputTijd"]),
    "Patient" =>  trimAndClean($_POST["inputPatient"]),
);

$specialistID = 1; //get this from the session

foreach ($input as $key => $value) {
    if (empty($value) and $key != 'Online'){
        echo $key .":" . $value;
        die($key . " is empty");

    }
}

if (strlen($input["Locatie"]) > 255){
    echo strlen($input["Locatie"]);
    die("locatie naam is te lang");
}
if (strlen($input["Online"]) > 1){
    echo strlen($input["Online"]);
    die("online is te lang");
}

if (strlen($input["Datum"]) > 15){
    echo strlen($input["Online"]);
    die("Datum is te lang");
}

if (strlen($input["Tijd"]) > 15){
    echo strlen($input["Online"]);
    die("Tijd is te lang");
}

if(!($input["Online"] == 0 || $input["Online"] == 1)){
    die("Online moet 0 of 1 zijn");
}

//get the specialistid from the session
$db = new DataBase();
$db->addAppointment($input["Locatie"], $input["Online"], $input["Datum"], $input["Tijd"], $specialistID, $input["Patient"]);
$db = null;

//header('location: ' . 'http://energy.org/intranet/Afspraken.php', true);
exit();


