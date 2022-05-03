<?php

class menu_class
{
    public $menu;
    public $listapiatti;
    public $id;
    public $takeaway;

    private $db;

    function __construct()
    {
        include_once("../database_pdo_sing.php");
        $obj = DatabasePdoClass::getInstance();
        $this->db = $obj->creaConnessione();
    }

    public function post()
    {
        $query = $this->db->prepare("INSERT INTO menu (nome, takeaway) VALUES (:nome, :takeaway);");
        $query->bindValue(":nome", $this->menu);
        $query->bindValue(":takeaway", $this->takeaway);
        try {
            $query->execute();
            $this->id =  $this->db->lastInsertId();
            $piattidausare = explode(",", $this->listapiatti);
            unset($piattidausare[array_search('', $piattidausare)]);
            foreach ($piattidausare as $piatto) {
                $this->associaPiatto($piatto);
            }
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

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
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    public function getPiattiMenu()
    {
        $query = $this->db->prepare("SELECT piatto FROM menu as m
        LEFT JOIN  rel_menu_piatti ON m.id=rel_menu_piatti.id_menu
        LEFT JOIN  piatto ON rel_menu_piatti.id_piatto=piatto.id
        WHERE m.id=:id_menu and !isnull(piatto) order by piatto");
        $query->bindValue(":id_menu", $this->id);
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
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    public function delete()
    {
        $query = $this->db->prepare("DELETE FROM menu  WHERE id=:id");
        $query->bindValue(":id", $this->id);
        try {
            $query->execute();
        } catch (PDOException $e) {
            echo $e;
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }
    public function associaPiatto($_id_piatto)

    {
        $queryinner = $this->db->prepare("INSERT INTO rel_menu_piatti  (id_menu,id_piatto) VALUES (:id_menu,:id_piatto);");
        $queryinner->bindValue(":id_menu", $this->id);
        $queryinner->bindValue(":id_piatto", $_id_piatto);
        try {
            $queryinner->execute();
        } catch (PDOException $e) {
            echo $e;
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }
}
