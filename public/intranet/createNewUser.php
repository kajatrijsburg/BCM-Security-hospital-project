<?php
/** @file createNewUser.php
 * PHP script to create a new user. (@see ldap_support.inc.php and @CreateNewUser )
 *
 * @author Martin Molema <martin.molema@nhlstenden.com>
 * @copyright 2022
 *
 * This script uses a number of basic LDAP-functions that students can use to learn or adapt
 */
?>
<html>
<head>
    <title>New User Creation</title>
</head>
<body>
  <pre><code>
<?php

include_once "ldap_constants.inc.php";
include_once "ldap_support.inc.php";

try{
    $lnk = ConnectAndCheckLDAP();
}
catch(Exception $ex){
    die($ex->getMessage());
}


//FIXME: need to do a lot of security checks here!
$username = $_POST['username'];
$sn = $_POST['achternaam'];
$givenName = $_POST['voornaam'];

// setup some compound variables based upon the input
$cn = $sn . " " . $givenName;
$newUserDN = "cn=" . $cn . "," . USERS_INTERN_DN;


// FIXME: first check if user already exists.
try {
    CreateNewUser($lnk, $newUserDN, $cn, $sn, $username, $givenName);
    echo "Gebruiker aangemaakt met DN=$newUserDN \n";
} catch (Exception $exception) {
  // FIXME: do something with the exception;
}
echo "Gebruiker toegevoegd!\n";

// Now create a new password.
try {
    $password = SetPassword($lnk, $newUserDN, "DitIsMijnWachtwoord!");
    echo "New encoded password = $password\n";
} catch (Exception $exception) {
    die ($exception->getCode() . ":" . $exception->getMessage());
}

// Add user to a certain group ("CN=websiteusers")
$groupDN = GROUPS_DN;
try {
    AddUserToGroup($lnk, $groupDN, $newUserDN);
} catch (Exception $exception) {
    die ($exception->getCode() . ":" . $exception->getMessage());
}

echo "Gelukt!";

?>
        </code>
      </pre>
</body>
</html>

