<?php
require_once("sql.php");
require_once("clean-input.php");

$input = array(
    "inputLocatie" =>  trimAndClean($_POST["inputLocatie"]),
    "inputOnline" =>  trimAndClean($_POST["inputOnline"]),
    "inputDatum" =>  trimAndClean($_POST["inputDatum"]),
    "inputTijd" =>  trimAndClean($_POST["inputTijd"]),
    "inputPatient" =>  trimAndClean($_POST["inputPatient"]),
);

foreach ($input as $key => $value) {
    if (empty($value)){
        die($key . " is empty");
    }
}

if (strlen($input["inputLocatie"]) > 255){
    echo strlen($input["inputLocatie"]);
    die("locatie naam is te lang");
}
if (strlen($input["inputOnline"]) > 1){
    echo strlen($input["inputOnline"]);
    die("online is te lang");
}



