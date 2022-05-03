<?php

/* automated class from skeleton 1.02022-03-20  */

class calendario_class
{
    public $id;
    public $giorno;
    public $id_menu;
    public $disabled_date;

    private $db;

    function __construct()
    {
        include_once("../database_pdo_sing.php");
        $obj = DatabasePdoClass::getInstance();
        $this->db = $obj->creaConnessione();
    }
    // metodo post //
    public function post()
    {
        $query = $this->db->prepare("INSERT INTO rel_menu_giorno (id_menu, giorno) VALUES (:id_menu, :giorno);");
        $query->bindValue(":id_menu", $this->id_menu);
        $query->bindValue(":giorno", $this->giorno);
        // echo 'sto passando da qui' . __LINE__ . __FILE__;
        try {
            $query->execute();
            $id_tobe_returned =  $this->db->lastInsertId();
        } catch (PDOException $e) {
            echo $e;
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }
    // metodo put //
    public function put()
    {
        $query = $this->db->prepare("UPDATE menu SET nome =:nome WHERE id=:id ; ");
        $query->bindValue(":nome", $this->nome);

        try {
            $query->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }
    //restituisce tutto
    public function getAll()
    {
        $query = $this->db->prepare("SELECT * FROM menu order by nome ");

        try {
            $query->execute();
            $data = $query->fetchall();

            if ($data > 0) {

                return $data;
            } else {

                return 0;
            }

            //restituisce il modificato
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }
    public function getMenuGiorno()
    {
        $query = $this->db->prepare("SELECT rmg.id_menu, m.nome, p.id as id_piatto, p.piatto, t.id as id_tipologia, t.tipologia
        FROM `rel_menu_giorno` as rmg
        LEFT JOIN `menu` as m ON rmg.id_menu = m.id
        LEFT JOIN `rel_menu_piatti` as rmp ON rmg.id_menu = rmp.id_menu
        LEFT JOIN `piatto` as p ON rmp.id_piatto = p.id
        LEFT JOIN `tipologia_piatti` as t ON p.id_tipologia_piatto = t.id
        WHERE rmg.giorno = :giorno");
        $query->bindValue(":giorno", $this->giorno);
        try {
            $query->execute();
            $data = $query->fetchall();
            return $data;
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }
    public function getById()
    {
        $query = $this->db->prepare("SELECT * FROM menu  WHERE id=:id ");
        $query->bindValue(":id", $this->id);
        try {
            $query->execute();

            $data = $query->fetchall();

            if ($data > 0) {

                return $data;
            } else {

                return 0;
            }
            //  var_dump($listone);

        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }
    public function delete()
    {
        echo $this->id_menu;
        echo $this->giorno;
        $query = $this->db->prepare("DELETE FROM rel_menu_giorno WHERE id_menu=:id_menu AND giorno=:giorno");
        $query->bindValue(":id_menu", $this->id_menu);
        $query->bindValue(":giorno", $this->giorno);
        try {
            $query->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }
    public function associaPiatto($_id_menu, $_id_piatto)
    {
        $queryinner = $this->db->prepare("INSERT INTO rel_menu_piatti  (id_menu,id_piatto) VALUES (:id_menu,:id_piatto);");
        $queryinner->bindValue(":id_menu", $_id_menu);
        $queryinner->bindValue(":id_piatto", $_id_piatto);
        try {
            $queryinner->execute();
        } catch (PDOException $e) {
            echo $e;
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }
    public function disableDate()
    {
        $query = $this->db->prepare("INSERT INTO disabled_dates (disabled_date) VALUES (:disabled_date);");
        $query->bindValue(":disabled_date", $this->disabled_date);
        try {
            $query->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }
    public function getDisableDates()
    {
        $today = date("Y-m-d H:i:s");
        // echo "<pre>";
        // print_r($today);
        // echo "</pre>";
        // exit;
        $query = $this->db->prepare("SELECT * FROM disabled_dates WHERE disabled_date >= :today;");
        $query->bindValue(":today", $today);
        try {
            $query->execute();
            return $query->fetchall();
        } catch (PDOException $e) {
            echo $e->getMessage();
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    public function removeDisableDate()
    {
        $query = $this->db->prepare("DELETE FROM disabled_dates WHERE disabled_date = :disabled_date;");
        $query->bindValue(":disabled_date", $this->disabled_date);
        try {
            $query->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }
}
//fine classe 