<?php
require_once("sql.php");
require_once("clean-input.php");

//get the input
$firstName = trimAndClean($_POST['firstName']);
$lastName = trimAndClean($_POST['lastName']);
$email = trimAndClean($_POST['email']);
$password1 = trimAndClean($_POST['password1']);
$password2 = trimAndClean($_POST['password2']);


//verify input
//check if input exists
if (empty($firstName)){
    die("Voornaam is verplicht");
}

if (empty($lastName)){
    die("Achternaam is verplicht");
}
if (empty($email)){
    die("email is verplicht");
}

if (empty($password1) || empty($password2)){
    die("wachtwoord is verplicht");
}

//check if input has the expected length
if (strlen($firstName) < 2) {
    die("Voornaam moet uit tenminste twee letters bestaan.");
}

if (strlen($firstName) > 100) {
    die("Voornaam mag maximaal uit 100 tekens bestaan.");
}

if (strlen($lastName) > 100) {
    die("Achternaam mag maximaal uit 100 tekens bestaan.");
}

if (strlen($email) > 100){
    die("email mag maximaal uit 100 tekens bestaan.");
}

if (strlen($password1) > 100){
    die("wachtwoord mag maximaal uit 100 tekens bestaan.");
}

//check if passwords match
if($password1 != $password2){
    die("Wachtwoorden komen niet overeen");
}

//open a database connection
$db = new DataBase();
$pdo = $db->createPDO();

//check if email address is already used
$statement = $pdo->prepare("SELECT FROM user WHERE email=$email");
$count = $statement->rowCount();

if($count > 0){
    die("Dit email adres is al in gebruik");
}

$pdo = null;
$statement = null;