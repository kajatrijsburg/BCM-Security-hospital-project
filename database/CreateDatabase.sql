create database nrg;

use nrg;

DROP TABLE IF EXISTS tbl_configuration;

CREATE TABLE tbl_configuration
(
    url     VARCHAR(200) NOT NULL COMMENT 'Home page URL',
    version VARCHAR(10)  NOT NULL COMMENT 'Version number'
) COMMENT  'Configuration';

INSERT INTO tbl_configuration (url, version)
VALUES ('http://energy.org',
        '0.1');
