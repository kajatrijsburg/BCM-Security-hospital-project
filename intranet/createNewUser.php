<html>
<head>
    <title>New User Creation</title>
</head>
<body>
  <pre><code>
<?php
/**
 * Created by PhpStorm.
 * User: martin
 * Date: 1-3-2019
 * Time: 10:26
 */

include_once "ldap_constants.inc.php";
include_once "ldap_support.inc.php";

// connect to the service
$lnk = ldap_connect(LDAP_HOST, LDAP_PORT);

// check connectivity
if ($lnk === false) {
    throw(new Exception("Cannot connect to " . LDAP_HOST . ":" . LDAP_PORT));
} else {
    // expect protocol version 3 to be the standard
    ldap_set_option($lnk, LDAP_OPT_PROTOCOL_VERSION, 3);

    // bind to the service using a username & password
    $bindres = ldap_bind($lnk, LDAP_ADMIN_CN, LDAP_PASSWORD);
    if ($bindres === false) {
        throw(new Exception("Cannot bind using user " . LDAP_ADMIN_CN));
    }
}

//FIXME: need to do a lot of security checks here!
$username = $_POST['username'];
$sn = $_POST['achternaam'];
$givenName = $_POST['voornaam'];

// setup some compound variables based upon the input
$cn = $sn . " " . $givenName;
$newUserDN = "cn=" . $cn . "," . USERS_DN;

try {
    CreateNewUser($lnk, $newUserDN, $cn, $sn, $username, $givenName);
} catch (Exception $exception) {

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
$groupDN = "cn=websiteusers, " . GROUPS_DN;
try {
    AddUserToGroup($lnk, $groupDN, $newUserDN);
} catch (Exception $exception) {
    die ($exception->getCode() . ":" . $exception->getMessage());
}

?>
        </code>
      </pre>
</body>
</html>

