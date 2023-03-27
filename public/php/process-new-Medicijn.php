<?php
require_once("sql.php");
require_once("clean-input.php");

$input = array(
    "Medicijnnaam" =>  trimAndClean($_POST["inputMedicijnNaam"]),
    "Beschrijving" =>  trimAndClean($_POST["inputBeschrijving"]),
    "Dosis" =>  trimAndClean($_POST["inputDosis"]),
);

$patientID = 1; //get this from the session


if (strlen($input["Medicijnnaam"]) > 255){
    echo strlen($input["Medicijnnaam"]);
    die("medicijn naam is te lang");
}
if (strlen($input["Beschrijving"]) > 65535){
    echo strlen($input["Beschrijving"]);
    die("Beschrijving is te lang");
}

if (strlen($input["Dosis"]) > 15){
    echo strlen($input["Dosis"]);
    die("Dosis is te lang");
}

//get the specialistid from the session
$db = new DataBase();
$db->addMedicine($input["Medicijnnaam"], $input["Beschrijving"], $input["Dosis"], $patientID);
$db = null;

header('location: ' . 'http://energy.org/Medicijnen.php', true);
exit();
