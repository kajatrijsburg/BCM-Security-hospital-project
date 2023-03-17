<?php
require 'ldap_support.inc.php';
echo '<pre>';
//echo $_SERVER['PHP_AUTH_USER'];
//var_dump(get_defined_vars());
try {
    $LD = ConnectAndCheckLDAP();
    $UINF = ReportUser($LD, GetUserDNFromUID($LD, $_SERVER['PHP_AUTH_USER']));
    echo $UINF;
} catch (Exception $e) {
    echo "Couldn't get user info.";
}
echo '</pre>';
?>