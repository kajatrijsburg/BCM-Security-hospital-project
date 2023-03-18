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
    rolid        int NOT NULL,
    permiessieid int NOT NULL,
    PRIMARY KEY (rolid),
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
    userid       int   NOT NULL,
    PRIMARY KEY (gegevensid),
    FOREIGN KEY (userid) REFERENCES user (userid)
);

CREATE TABLE voedingsplan
(
    voedingsplanid int  NOT NULL AUTO_INCREMENT,
    descriptie     text NOT NULL,
    userid         int  NOT NULL,
    PRIMARY KEY (voedingsplanid),
    FOREIGN KEY (userid) REFERENCES user (userid)
);

CREATE TABLE behandelplan
(
    behandelplanid int NOT NULL AUTO_INCREMENT,
    descriptie text NOT NULL,
    userid int     NOT NULL,
    PRIMARY KEY (behandelplanid),
    FOREIGN KEY (userid) REFERENCES user (userid)
);

CREATE TABLE patienten
(
    specialistid int NOT NULL,
    patientid    int NOT NULL,
    PRIMARY KEY (specialistid),
    FOREIGN KEY (specialistid) REFERENCES user (userid),
    FOREIGN KEY (patientid) REFERENCES user (userid)
);