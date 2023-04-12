<?php
function trimAndClean($dataString){
    $dataString = trim($dataString);
    $dataString = htmlspecialchars($dataString);
    return $dataString;
}

function validateFirstName($firstName){
    $firstName = trimAndClean($firstName);
    if (empty($firstName)){
        die("Voornaam is verplicht");
    }

    if (strlen($firstName) < 2) {
        die("Voornaam moet uit tenminste twee letters bestaan.");
    }

    if (strlen($firstName) > 100) {
        die("Voornaam mag maximaal uit 100 tekens bestaan.");
    }

    return $firstName;
}
function validateLastName($lastName){
    $lastName = trimAndClean($lastName);
    if (empty($lastName)){
        die("Achternaam is verplicht");
    }
    if (strlen($lastName) > 100) {
        die("Achternaam mag maximaal uit 100 tekens bestaan.");
    }

    return $lastName;
}

function validateEmail($email){
    $email = trimAndClean($email);
    if (empty($email)) {
        die("email is verplicht");
    }
    if (strlen($email) > 100) {
        die("email mag maximaal uit 100 tekens bestaan.");
    }
    return $email;
}
function checkIfEmailExists($email, $pdo){
    //check if email address is already used
    $statement = $pdo->prepare("SELECT * FROM user WHERE email=:email");
    $statement->execute([$email]);
    $count = $statement->rowCount();

    if($count > 0){
        die("Dit email adres is al in gebruik");
    }

    $statement = null;

    return $email;
}

function validatePassword($password1, $password2)
{
    $password1 = trimAndClean($password1);
    $password2 = trimAndClean($password2);
    if (empty($password1) || empty($password2)) {
        die("wachtwoord is verplicht");
    }

    if (strlen($password1) > 100){
        die("wachtwoord mag maximaal uit 100 tekens bestaan.");
    }

    if($password1 != $password2) {
        die("Wachtwoorden komen niet overeen");
    }

    return $password1;
}