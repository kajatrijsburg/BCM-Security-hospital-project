<?php
// set some constants

define("BASE_DN", "o=Energy,dc=energy,dc=org");
define("GROUPS_DN",            "cn=allwebsiteusers,ou=application," . BASE_DN );
define("USERS_EXTERN_DN",      "ou=extern,"                         . BASE_DN );
define("USERS_INTERN_DN",      "ou=intern,"                         . BASE_DN );
define("USERS_APPLICATION_DN", "ou=application,"                    . BASE_DN );


define("GROUP_ATTR_NAME", "uniqueMember");

define("LDAP_HOST","127.0.0.1");
define("LDAP_PORT",389);

// FIXME: This is GOD. should be cn=webuserldap,ou=application,o=Energy,dc=energy,dc=org
// problem: this user has too many rights and cn=webuserldap,.... has not enough.
define("LDAP_ADMIN_CN","cn=admin, dc=energy, dc=org");

// FIXME: Investigate how to prevent plaintext passwords.
define("LDAP_PASSWORD","wachtwoord");
