<?php
//we should move to some sort of encrypted credential management at some point
//but if anyone can read this dir we're pretty fucked anyway because that means they have access to the server

//include the credentials. Yes, that means they're compiled into this file
//this means that if php code execution is gained attackers will be able to leak credentials

require_once($_SERVER['DOCUMENT_ROOT']."/../credentials.php");
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

    function queryOnce($SQL){
        //open connection
        $pdo = $this->createPDO();

        //execute sql
        $statement = $pdo->prepare($SQL);
        $statement->execute();

        //close connection
        $pdo= null;

        //return statement
        return $statement;
    }

    function getAppointmentsForUser($userID){
        return $this->queryOnce("SELECT locatie, online, datum, tijd, specialistid, user.achternaam 
                                FROM afspraken 
                                LEFT JOIN user on afspraken.specialistid = user.userid 
                                WHERE patientid = $userID ORDER BY datum;");
    }

    function getTreatmentPlanForUser($userID){
        return $this->queryOnce("SELECT beschrijving, datum FROM behandelplan WHERE userid = $userID;");
    }

}


?>
