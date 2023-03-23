CREATE TABLE rol
(
    rolid   int          NOT NULL,
    rolnaam varchar(100) NOT NULL,
    actief  boolean      NOT NULL,
    PRIMARY KEY (rolid)
);

CREATE TABLE permissies
(
    permissieid   int          NOT NULL,
    permissienaam varchar(100) NOT NULL,
    actief        boolean      NOT NULL,
    PRIMARY KEY (permissieid)
);

CREATE TABLE rolpermissies
(
    rolpermissiesid int NOT NULL AUTO_INCREMENT,
    rolid        int NOT NULL,
    permiessieid int NOT NULL,
    PRIMARY KEY (rolpermissiesid),
    FOREIGN KEY (rolid) REFERENCES rol (rolid),
    FOREIGN KEY (permiessieid) REFERENCES permissies(permissieid)
);

CREATE TABLE user
(
    userid     int          NOT NULL AUTO_INCREMENT,
    voornaam   varchar(100) NOT NULL,
    achternaam varchar(100) NOT NULL,
    email      varchar(100) NOT NULL,
    PRIMARY KEY (userid)
);

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

CREATE TABLE voedingsplan
(
    voedingsplanid int  NOT NULL AUTO_INCREMENT,
    beschrijving     text NOT NULL,
    datum date NOT NULL,
    userid         int  NOT NULL,
    datum timestamp NOT NULL,
    PRIMARY KEY (voedingsplanid),
    FOREIGN KEY (userid) REFERENCES user (userid)
);

CREATE TABLE behandelplan
(
    behandelplanid int NOT NULL AUTO_INCREMENT,
    beschrijving text NOT NULL,
    datum date NOT NULL,
    userid int     NOT NULL,
    datum timestamp NOT NULL,
    PRIMARY KEY (behandelplanid),
    FOREIGN KEY (userid) REFERENCES user (userid)
);

CREATE TABLE medicijn
(
    medicijnid int NOT NULL AUTO_INCREMENT,
    medicijnnaam varchar(100) NOT NULL,
    beschrijving text NOT NULL,
    dosis float NOT NULL,
    userid int NOT NULL,
    PRIMARY KEY (medicijnid),
    FOREIGN KEY (userid) REFERENCES user (userid)
)
CREATE TABLE patienten
(
    patiententabelid int NOT NULL AUTO_INCREMENT,
    specialistid int NOT NULL,
    patientid    int NOT NULL,
    PRIMARY KEY (patiententabelid),
    FOREIGN KEY (specialistid) REFERENCES user (userid),
    FOREIGN KEY (patientid) REFERENCES user (userid)
);

CREATE TABLE afspraken
(
    afsprakenid int NOT NULL AUTO_INCREMENT,
    locatie varchar(255),
    online boolean NOT NULL,
    datum date NOT NULL,
    tijd time NOT NULL,
    specialistid int NOT NULL,
    patientid    int NOT NULL,
    PRIMARY KEY (afsprakenid),
    FOREIGN KEY (specialistid) REFERENCES user (userid),
    FOREIGN KEY (patientid) REFERENCES user (userid)
);