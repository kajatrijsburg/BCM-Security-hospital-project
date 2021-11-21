<?php
// set some constants

define("BASE_DN", "ou=HumanIT,dc=molema,dc=local");
define("GROUPS_DN", "ou=groups," . BASE_DN );
define("USERS_DN", "ou=users," . BASE_DN );

define("GROUP_ATTR_NAME", "uniqueMember");

define("LDAP_HOST","127.0.0.2");
define("LDAP_PORT",389);
define("LDAP_ADMIN_CN","cn=webuserldap, ". USERS_DN);
define("LDAP_PASSWORD","wachtwoord"); // FIXME: Investigate how to prevent plaintext passwords.
