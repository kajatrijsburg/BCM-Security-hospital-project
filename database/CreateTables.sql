SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS rol;
CREATE TABLE rol
(
    rolid   int          NOT NULL AUTO_INCREMENT,
    rolnaam varchar(100) NOT NULL,
    actief  boolean      NOT NULL,
    PRIMARY KEY (rolid)
);

DROP TABLE IF EXISTS permissies;
CREATE TABLE permissies
(
    permissieid   int          NOT NULL AUTO_INCREMENT,
    permissienaam varchar(100) NOT NULL,
    actief        boolean      NOT NULL,
    PRIMARY KEY (permissieid)
);

DROP TABLE IF EXISTS rolpermissies;
CREATE TABLE rolpermissies
(
    rolpermissiesid int NOT NULL AUTO_INCREMENT,
    rolid        int NOT NULL,
    permissieid int NOT NULL,
    PRIMARY KEY (rolpermissiesid),
    FOREIGN KEY (rolid) REFERENCES rol (rolid),
    FOREIGN KEY (permissieid) REFERENCES permissies(permissieid)
);

DROP TABLE IF EXISTS user;
CREATE TABLE user
(
    userid     int          NOT NULL AUTO_INCREMENT,
    voornaam   varchar(100) NOT NULL,
    achternaam varchar(100) NOT NULL,
    email      varchar(100) NOT NULL,
    PRIMARY KEY (userid)
);

DROP TABLE IF EXISTS medischegegevens;
CREATE TABLE medischegegevens
(
    gegevensid   int   NOT NULL AUTO_INCREMENT,
    gewicht      float NOT NULL,
    bloeddruk    float NOT NULL,
    hartslagrust float NOT NULL,
    medicijnen varchar(255),
    userid       int   NOT NULL,
    datum timestamp NOT NULL,
    PRIMARY KEY (gegevensid),
    FOREIGN KEY (userid) REFERENCES user (userid)
);

DROP TABLE IF EXISTS voedingsplan;
CREATE TABLE voedingsplan
(
    voedingsplanid int  NOT NULL AUTO_INCREMENT,
    beschrijving     text NOT NULL,
    datum date NOT NULL,
    userid         int  NOT NULL,
    PRIMARY KEY (voedingsplanid),
    FOREIGN KEY (userid) REFERENCES user (userid)
);

DROP TABLE IF EXISTS behandelplan;
CREATE TABLE behandelplan
(
    behandelplanid int NOT NULL AUTO_INCREMENT,
    beschrijving text NOT NULL,
    datum date NOT NULL,
    userid int     NOT NULL,
    PRIMARY KEY (behandelplanid),
    FOREIGN KEY (userid) REFERENCES user (userid)
);

DROP TABLE IF EXISTS medicijn;
CREATE TABLE medicijn
(
    medicijnid int NOT NULL AUTO_INCREMENT,
    medicijnnaam varchar(100) NOT NULL,
    beschrijving text NOT NULL,
    dosis float NOT NULL,
    userid int NOT NULL,
    PRIMARY KEY (medicijnid),
    FOREIGN KEY (userid) REFERENCES user (userid)
);

DROP TABLE IF EXISTS patienten;
CREATE TABLE patienten
(
    patiententabelid int NOT NULL AUTO_INCREMENT,
    specialistid int NOT NULL,
    patientid    int NOT NULL,
    PRIMARY KEY (patiententabelid),
    FOREIGN KEY (specialistid) REFERENCES user (userid),
    FOREIGN KEY (patientid) REFERENCES user (userid)
);
DROP TABLE IF EXISTS afspraken;
CREATE TABLE afspraken
(
    afsprakenid  int     NOT NULL AUTO_INCREMENT,
    locatie      varchar(255),
    online       boolean NOT NULL,
    datum        date    NOT NULL,
    tijd         time    NOT NULL,
    specialistid int     NOT NULL,
    patientid    int     NOT NULL,
    PRIMARY KEY (afsprakenid),
    FOREIGN KEY (specialistid) REFERENCES user (userid),
    FOREIGN KEY (patientid) REFERENCES user (userid)
);

DROP TABLE IF EXISTS gebruikgeschiedenis;
CREATE TABLE gebruikgeschiedenis
(
  geschiedenisid    int     NOT NULL AUTO_INCREMENT,
  actie             text    NOT NULL,
  userid            int     NOT NULL,
  datum             date     NOT NULL,
  tijd              time    NOT NULL,
  PRIMARY KEY (geschiedenisid),
  FOREIGN KEY (userid) REFERENCES user (userid)
);
SET FOREIGN_KEY_CHECKS=1;