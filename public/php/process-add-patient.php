<?php
require_once("sql.php");
require_once("clean-input.php");

$input = array(
    "Emailpatient" =>  trimAndClean($_POST["inputEmailPatient"]),
    "Emaildokter" =>  trimAndClean($_POST["inputEmailDokter"]),
);




if (strlen($input["Emailpatient"]) > 255){
    echo strlen($input["Emailpatient"]);
    die("email van patiënt is te lang");
}
if (strlen($input["Emaildokter"]) > 255){
    echo strlen($input["Emaildokter"]);
    die("email van specialist is te lang");
}

//get the specialistid from the session
$db = new DataBase();

$patientID = $db->getUserID($input["Emailpatient"]);
$dokterID = $db->getUserID($input["Emaildokter"]);


$db->addPatient($dokterID, $patientID);
$db = null;

header('location: ' . 'http://energy.org/patient-toevoegen.php', true);
exit();
