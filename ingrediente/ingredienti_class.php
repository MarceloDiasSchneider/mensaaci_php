<?php

class ingredienti_class
{
    public $ingrediente;
    public $allergene;
    public $data_inserimento;
    public $id_ingrediente;

    private $db;

    function __construct()
    {


        include_once("../database_pdo_sing.php");
        $obj = DatabasePdoClass::getInstance();
        $this->db = $obj->creaConnessione();
    }

    public function post()
    {
        $query = $this->db->prepare("INSERT INTO ingredienti (ingrediente,allergene) VALUES (:ingrediente,:allergene);");
        $query->bindValue(":ingrediente", $this->ingrediente);
        $query->bindValue(":allergene", $this->allergene);
        try {
            $query->execute();
        } catch (PDOException $e) {
            echo  error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    public function put()
    {
        $query = $this->db->prepare("UPDATE ingredienti SET ingrediente = :ingrediente, allergene = :allergene WHERE id = :id ;");
        $query->bindValue(":ingrediente", $this->ingrediente);
        $query->bindValue(":allergene", $this->allergene);
        $query->bindValue(":id", $this->id_ingrediente);
        try {
            $query->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    public function getAll()
    {
        $query = $this->db->prepare("SELECT * FROM ingredienti order by ingrediente ");
        try {
            $query->execute();
            $data = $query->fetchall();
            if ($data > 0) {
                return $data;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    public function getById()
    {
        $query = $this->db->prepare("SELECT * FROM ingredienti  WHERE id=:id order by ingrediente");
        $query->bindValue(":id", $this->id_ingrediente);
        try {
            $query->execute();
            $data = $query->fetchall();
            if ($data > 0) {
                return $data;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    public function delete()
    {
        $query = $this->db->prepare("DELETE FROM ingredienti  WHERE id=:id");
        $query->bindValue(":id", $this->id_ingrediente);
        try {
            $query->execute();
            return 'Ingrediente cancellato.';
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return 'L\'ingrediente appartiene a un piatto. non può essere cancellato';
            }
            echo $e->getMessage();
            echo "<br>";
            echo $e->getCode();
            echo "<br>";
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }
}
