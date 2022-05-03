<?php

/* automated class from skeleton 1.02022-03-20  */

class auth_class
{
    public $id_user;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $google_sub_id;

    private $db;

    function __construct()
    {
        include_once("../database_pdo_sing.php");
        $obj = DatabasePdoClass::getInstance();
        $this->db = $obj->creaConnessione();
    }

    public function login()
    {
        $query = $this->db->prepare("SELECT id, first_name, last_name, email FROM  `utenti` WHERE email = :email AND password = :password");
        $query->bindValue(":email", $this->email);
        $query->bindValue(":password", $this->password);
        try {
            $query->execute();
            return $query->fetch();
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    public function login_google_auth()
    {
        $query = $this->db->prepare("SELECT id, first_name, last_name, email FROM  `utenti` WHERE email = :email");
        // $query = $this->db->prepare("SELECT id, first_name, last_name, email FROM  `utenti` WHERE email = :email AND google_sub_id = :google_sub_id");
        $query->bindValue(":email", $this->email);
        // $query->bindValue(":google_sub_id", $this->google_sub_id);
        try {
            $query->execute();
            return $query->fetch();
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }
}
