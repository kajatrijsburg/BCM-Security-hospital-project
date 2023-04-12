<?php
require_once("sql.php");
require_once("clean-input.php");
require_once "../../User.php";


//open a database connection
$db = new DataBase();
$pdo = $db->createPDO();

//get the input
$firstName = validateFirstName($_POST['firstName']);
$lastName = validateLastName($_POST['lastName']);
$email = validateEmail($_POST['email']);
$password =  validatePassword($_POST['password1'], $_POST['password2']);

$email = checkIfEmailExists($email, $pdo);


//insert user into database
$statement = $pdo->prepare("INSERT INTO user (voornaam, achternaam, email) VALUES (:firstName, :lastName, :email);");
$statement->execute([$firstName, $lastName, $email]);
$statement = null;
$pdo = null;

//insert user into LDAP
User::createInternal($firstName, $lastName, $email, $password);