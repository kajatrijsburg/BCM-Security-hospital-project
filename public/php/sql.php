<?php
//we should move to some sort of encrypted credential management at some point
//but if anyone can read this dir we're pretty fucked anyway because that means they have access to the server

//include the credentials. Yes, that means they're compiled into this file
//this means that if php code execution is gained attackers will be able to leak credentials

require_once($_SERVER['DOCUMENT_ROOT']."/../credentials.php");
require_once ("clean-input.php");
class DataBase {
    private $credentials;

    public $options = [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES   => false,
        ];

    function __construct(){
        $this->credentials = new Credentials();
    }

    function createPDO(){
        $host = $this->credentials->strHostName;
        $dbname = $this->credentials->strDBName;
        $charset = $this->credentials->strCharSet;
        $port = $this->credentials->strPort;
        $username = $this->credentials->strUserName;
        $password = $this->credentials->strPassword;


        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset;port=$port";
        try {
            return $pdo = new \PDO($dsn, $username, $password, $this->options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    function queryOnce($SQL, $arr){
        //open connection
        $pdo = $this->createPDO();

        //execute sql
        $statement = $pdo->prepare($SQL);
        $statement->execute($arr);

        //close connection
        $pdo= null;

        //return statement
        return $statement;
    }

    function getAppointmentsForUser($userID){
        $specialistID = $userID;
        return $this->queryOnce(
            "SELECT locatie, online, datum, tijd, specialistid, user.achternaam 
                    FROM afspraken 
                    LEFT JOIN user on afspraken.specialistid = user.userid 
                    WHERE patientid = :userID OR specialistid= :specialistID 
                    ORDER BY datum;",
                    [$userID, $specialistID]);
    }

    function getTreatmentPlanForUser($userID){
        return $this->queryOnce("SELECT beschrijving, datum FROM behandelplan WHERE userid = :userID;", [$userID]);
    }

    function getPatientsForSpecialist($specialistID){
        return $this->queryOnce("SELECT userid, voornaam, achternaam, email 
                                FROM user JOIN patienten p on user.userid = p.patientid 
                                WHERE p.specialistid = :specialistID;",
                                [$specialistID]);
    }

    function addAppointment($locatie, $online, $datum, $tijd, $specialistid, $patientid){
        echo $sql = "INSERT INTO afspraken (locatie, online, datum, tijd, specialistid, patientid) 
                    VALUES (:locatie, :online, :datum, :tijd, :specialistid, :patientid);";
        $this->queryOnce($sql, [$locatie, $online, $datum, $tijd, $specialistid, $patientid]);
    }

    function getPrescriptedMedicineForUser($UserID){
        return $this->queryOnce("SELECT medicijnnaam, beschrijving, dosis FROM medicijn WHERE userid = :UserID", [$UserID]);
    }

    function getUserInfo($UserID){
        return $this->queryOnce("SELECT voornaam, achternaam, email FROM user WHERE userid = :UserID", [$UserID]);
    }

    function addMedicine($Medicijnnaam, $Beschrijving, $Dosis, $patientid){
        $sql = "INSERT INTO medicijn (medicijnnaam, beschrijving, dosis, userid) 
                    VALUES (:medicijnnaam, :beschrijving, :dosis, :userid)";
        $this->queryOnce($sql, [$Medicijnnaam, $Beschrijving, $Dosis, $patientid]);
    }

    function getUserID($userEmail){
        $userids = $this->queryOnce("SELECT userid FROM user WHERE email = :email", [$userEmail]);
        foreach($userids as $userid){
            return $userid['userid'];
        }
    }

    function getUser($userEmail){
        return $this->queryOnce("SELECT * FROM user WHERE email = :email", [$userEmail]);
    }

    function addPatient($specialistid, $patientid){
        $sql = "INSERT INTO patienten (specialistid, patientid) VALUES (:specialistid, :patientid)";
        $this->queryOnce($sql, [$specialistid, $patientid]);
    }

    function getUsers($searchValue){

        if(empty($searchValue)){
            $sql = "SELECT * FROM user";
            return $this->queryOnce($sql, []);
        }else{
            $searchValue = trimAndClean($searchValue);
            $sql = "SELECT * FROM user WHERE :searchValue in(voornaam, achternaam, email)";
            return $this->queryOnce($sql, [$searchValue]);
        }
    }
}


?>
