INSERT INTO user (voornaam, achternaam, email) VALUES ('FirstName', 'lastName', 'exampleemail@test.com');
INSERT INTO user (voornaam, achternaam, email) VALUES ('DifferentFirstName', 'DifferentLastName', 'differentexampleemail@test.com');

INSERT INTO patienten (specialistid, patientid) VALUES ('1', '2');

INSERT INTO afspraken (locatie, online, datum, tijd, specialistid, patientid) VALUES ('TestLocatie', 0, '2023-04-05', '13:15:00', 2, 1);