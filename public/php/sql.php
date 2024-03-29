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

    function getTreatmentPlanForUser($userid){
        return $this->queryOnce("SELECT beschrijving, datum FROM behandelplan WHERE userid = :userid;", [$userid]);
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

    function addTreatmentPlan($id, $description, $date){
        $sql = "DELETE FROM behandelplan WHERE userid = :id";
        $this->queryOnce($sql, [$id]);

        $sql = "INSERT INTO behandelplan (beschrijving, datum, userid) VALUES (:description, :date, :id  )";
        $this->queryOnce($sql, [$description, $date, $id]);
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

    function getRolePermissions($rolename){
        $sql = "SELECT p.permissienaam FROM rol 
                JOIN rolpermissies rp ON rol.rolid = rp.rolid 
                JOIN permissies p on rp.permissieid = p.permissieid 
                WHERE rolnaam = :rolname";

        $statement = $this->queryOnce($sql, [$rolename])->fetchAll();

        if (empty($statement)){
            return [];
        }
        $permissions = [];
        foreach ($statement as $row){
            $val = array_pop($row);
            $permissions[$val] = $val;
        }

        return $permissions;
    }

    function updateRolePermissions($rolename, $permissions){
        //before anything we need the role ID
        $sql = "SELECT rolid FROM rol WHERE rolnaam = :rolename";
        $rolid = $this->queryOnce($sql, [$rolename])->fetch();
        $rolid =  array_pop($rolid);
        //we're doing this the lazy way
        //first we just delete all permissions
        $sql = "DELETE FROM rolpermissies WHERE rolid = :rolid";
        $this->queryOnce($sql, [$rolid]);
        //and then we set the permissions we want

        foreach ($permissions as $permissionname => $status){
            if (empty($status) || $status == false){
                continue;
            }
            $permission = trimAndClean($permissionname); //this prevents a bug somehow
            //wrong way get the permissionID
            $sql = "SELECT permissieid FROM permissies WHERE permissienaam = :permission";
            $permissionid = $this->queryOnce($sql, [$permission])->fetch();

            $permissionid = array_pop($permissionid);

            $sql = "INSERT INTO rolpermissies (rolid, permissieid) VALUES (:rolid, :permissionid)";
            $this->queryOnce($sql, [$rolid, $permissionid]);

        }
    }

    function log($session, $action){
        $id = $this->getUserID($session["USER_ID"]);
        $date = date("Y-m-d");
        $time = date("H:i:s");

        $sql = "INSERT INTO gebruikgeschiedenis (actie, userid, datum, tijd) VALUES (:action, :id, :date, :time)";
        $this->queryOnce($sql, [$action, $id, $date, $time]);
    }

    function getLog(){
        $sql = "SELECT datum, tijd, u.email, actie FROM gebruikgeschiedenis JOIN user u on u.userid = gebruikgeschiedenis.userid";
        return $this->queryOnce($sql, []);
    }
}


?>
