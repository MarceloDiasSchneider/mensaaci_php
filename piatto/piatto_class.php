<?php

class piatto_class
{
    public $piatto;
    public $listaingredienti;
    public $id_tipologia_piatto;
    public $id_piatto;

    private $db;

    function __construct()
    {
        include_once("../database_pdo_sing.php");
        $obj = DatabasePdoClass::getInstance();
        $this->db = $obj->creaConnessione();
    }

    public function post()
    {
        $query = $this->db->prepare("INSERT INTO piatto (piatto,id_tipologia_piatto) VALUES (:piatto,:id_tipologia_piatto);");
        $query->bindValue(":piatto", $this->piatto);
        $query->bindValue(":id_tipologia_piatto", $this->id_tipologia_piatto);
        try {
            $query->execute();
            $this->id_piatto =  $this->db->lastInsertId();
            $ingredientidausare = explode(",", $this->listaingredienti);
            unset($ingredientidausare[array_search('', $ingredientidausare)]);
            foreach ($ingredientidausare as $ingrediente) {
                $this->associaIngrediente($ingrediente);
            }
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    public function put()
    {
        $query = $this->db->prepare("UPDATE piatto SET piatto =:piatto,id_tipologia_piatto =:id_tipologia_piatto WHERE id=:id ; ");
        $query->bindValue(":piatto", $this->piatto);
        $query->bindValue(":id_tipologia_piatto", $this->id_tipologia_piatto);
        $query->bindValue(":id", $this->id_piatto);
        try {
            $query->execute();
            // $query->debugDumpParams();
            $this->cancellaAllIngredientiAssociati();
            $ingredientidausare = explode(",", $this->listaingredienti);
            $unset = array_search('', $ingredientidausare);
            if ($unset !== false) {
                unset($ingredientidausare[$unset]);
            }
            foreach ($ingredientidausare as $ingrediente) {
                $this->associaIngrediente($ingrediente);
            }
        } catch (PDOException $e) {
            echo $e;
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    public function getAll()
    {
        $query = $this->db->prepare("SELECT * FROM piatto order by piatto ");
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
    public function getPiattiIngredienti()
    {
        $query = $this->db->prepare("SELECT p.id,piatto,ingrediente,allergene FROM piatto as p
        LEFT JOIN  rel_piatti_ingredienti ON p.id=rel_piatti_ingredienti.id_piatto
        LEFT JOIN  ingredienti ON rel_piatti_ingredienti.id_ingrediente=ingredienti.id
        order by piatto");
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
    public function getIngredientiPiatto()
    {
        $query = $this->db->prepare("SELECT p.id,piatto,ingrediente,allergene FROM piatto as p
        LEFT JOIN  rel_piatti_ingredienti ON p.id=rel_piatti_ingredienti.id_piatto
        LEFT JOIN  ingredienti ON rel_piatti_ingredienti.id_ingrediente=ingredienti.id
        WHERE p.id=:id_piatto and !isnull(ingrediente) order by ingrediente");
        $query->bindValue(":id_piatto", $this->id);
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
        $query = $this->db->prepare("SELECT piatto.id, piatto.piatto, piatto.id_tipologia_piatto, 
            (SELECT GROUP_CONCAT(DISTINCT id_ingrediente SEPARATOR ',') 
            FROM rel_piatti_ingredienti 
            WHERE id_piatto = piatto.id) AS 'ingredienti'        
            FROM piatto     
            WHERE piatto.id=:id ");
        $query->bindValue(":id", $this->id_piatto);
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
        $query = $this->db->prepare("DELETE FROM piatto WHERE id=:id");
        $query->bindValue(":id", $this->id_piatto);
        try {
            $query->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    public function associaIngrediente($_id_ingrediente)
    {
        $queryinner = $this->db->prepare("INSERT INTO rel_piatti_ingredienti (id_piatto,id_ingrediente) VALUES (:id_piatto,:id_ingrediente);");
        $queryinner->bindValue(":id_piatto", $this->id_piatto);
        $queryinner->bindValue(":id_ingrediente", $_id_ingrediente);
        try {
            $queryinner->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    public function checkPiattoInMenu()
    {
        $query = $this->db->prepare("SELECT * FROM rel_menu_piatti WHERE id_piatto = :id_piatto;");
        $query->bindValue(":id_piatto", $this->id_piatto);
        try {
            $query->execute();
            $data = $query->fetchall();

            if (isset($data[0])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    public function removeAssociaIngrediente()
    {
        $query = $this->db->prepare("DELETE FROM rel_piatti_ingredienti WHERE id_piatto = :id_piatto;");
        $query->bindValue(":id_piatto", $this->id_piatto);
        try {
            $query->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    public function cancellaAllIngredientiAssociati()
    {
        $queryinner = $this->db->prepare("DELETE FROM rel_piatti_ingredienti where id_piatto=:id_piatto;");
        $queryinner->bindValue(":id_piatto", $this->id_piatto);
        try {
            $queryinner->execute();
            // $queryinner->debugDumpParams();
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }
}
