<?php

/* automated class from skeleton 1.02022-03-20  */

class prenotazione_class
{
    public $giorno;
    public $firstDay;
    public $lastDay;
    public $id_menu;
    public $id_prenotazione;
    public $id_piatti;
    public $id_tipologia;
    public $id_utente;
    public $takeaway;
    public $note_takeaway;
    public $turno;
    public $consumazione;

    private $db;

    function __construct()
    {
        include_once("../database_pdo_sing.php");
        $obj = DatabasePdoClass::getInstance();
        $this->db = $obj->creaConnessione();
    }

    public function getPiattiGiorno()
    {
        $query = $this->db->prepare("SELECT rmg.id_menu, p.id as id_piatto, p.piatto, t.id as id_tipologia, t.tipologia, m.takeaway
        FROM `rel_menu_giorno` as rmg
        LEFT JOIN `menu` as m ON rmg.id_menu = m.id
        LEFT JOIN `rel_menu_piatti` as rmp ON rmg.id_menu = rmp.id_menu
        LEFT JOIN `piatto` as p ON rmp.id_piatto = p.id
        LEFT JOIN `tipologia_piatti` as t ON p.id_tipologia_piatto = t.id
        WHERE rmg.giorno = :giorno AND m.takeaway = :takeaway");
        $query->bindValue(":giorno", $this->giorno);
        $query->bindValue(":takeaway", $this->takeaway);
        try {
            $query->execute();
            $data = $query->fetchall();
            return $data;
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }
    public function getIngredientiByIdPiatto($id_piatto)
    {
        $query = $this->db->prepare("SELECT rpi.id_ingrediente, i.ingrediente, i.allergene
        FROM `rel_piatti_ingredienti` as rpi 
        LEFT JOIN `ingredienti` as i ON rpi.id_ingrediente = i.id
        WHERE rpi.id_piatto = :id_piatto");
        $query->bindValue(":id_piatto", $id_piatto);
        try {
            $query->execute();
            $data = $query->fetchall();
            return $data;
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    public function dropPrenotazione()
    {
        $query = $this->db->prepare("DELETE FROM prenotazione WHERE id = :id;");
        $query->bindValue(":id", $this->id_prenotazione);
        // echo 'sto passando da qui' . __LINE__ . __FILE__;
        try {
            $query->execute();
        } catch (PDOException $e) {
            echo $e;
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    public function dropPrenotazionePiatii()
    {
        $query = $this->db->prepare("DELETE FROM rel_prenotazione_piatti WHERE id_prenotazione = :id_prenotazione;");
        $query->bindValue(":id_prenotazione", $this->id_prenotazione);
        // echo 'sto passando da qui' . __LINE__ . __FILE__;
        try {
            $query->execute();
        } catch (PDOException $e) {
            echo $e;
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    public function savePrenotazione()
    {
        $query = $this->db->prepare("INSERT INTO prenotazione (id_utente, giorno, note_takeaway, turno, takeaway, consumazione) 
            VALUES (:id_utente, :giorno, :note_takeaway, :turno, :takeaway, :consumazione);");
        $query->bindValue(":id_utente", $this->id_utente);
        $query->bindValue(":giorno", $this->giorno);
        $query->bindValue(":note_takeaway", $this->note_takeaway);
        $query->bindValue(":turno", $this->turno);
        $query->bindValue(":takeaway", $this->takeaway);
        $query->bindValue(":consumazione", $this->consumazione);

        // echo 'sto passando da qui' . __LINE__ . __FILE__;
        try {
            $query->execute();
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            echo $e;
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }
    public function updatePrenotazione()
    {
        $query = $this->db->prepare("UPDATE prenotazione 
            SET note_takeaway = :note_takeaway, 
                turno = :turno,
                takeaway = :takeaway,
                consumazione = :consumazione
            WHERE id_utente = :id_utente 
            AND giorno = :giorno
        ;");
        $query->bindValue(":id_utente", $this->id_utente);
        $query->bindValue(":giorno", $this->giorno);
        $query->bindValue(":note_takeaway", $this->note_takeaway);
        $query->bindValue(":turno", $this->turno);
        $query->bindValue(":takeaway", $this->takeaway);
        $query->bindValue(":consumazione", $this->consumazione);

        // echo 'sto passando da qui' . __LINE__ . __FILE__;
        try {
            $query->execute();
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            echo $e;
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    public function postPrenotazionePiatto()
    {
        $query = $this->db->prepare("INSERT INTO rel_prenotazione_piatti (id_prenotazione, id_piatto) 
            VALUES (:id_prenotazione, :id_piatto);");
        $query->bindValue(":id_prenotazione", $this->id_prenotazione);
        $query->bindValue(":id_piatto", $this->id_piatto);
        // echo 'sto passando da qui' . __LINE__ . __FILE__;
        try {
            $query->execute();
        } catch (PDOException $e) {
            echo $e;
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    public function getUtenteDataConOrdine()
    {
        $query = $this->db->prepare("SELECT giorno, takeaway, consumazione
            FROM prenotazione 
            WHERE id_utente = :id_utente AND 
            giorno BETWEEN :firstDay AND :lastDay
        ;");
        $query->bindValue(":id_utente", $this->id_utente);
        $query->bindValue(":firstDay", $this->firstDay);
        $query->bindValue(":lastDay", $this->lastDay);

        // echo 'sto passando da qui' . __LINE__ . __FILE__;
        try {
            $query->execute();
            $data = $query->fetchall();
            return $data;
        } catch (PDOException $e) {
            echo $e;
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }
    public function getPrenotazione()
    {
        $query = $this->db->prepare("SELECT id, note_takeaway, turno, takeaway, consumazione 
            FROM prenotazione
            WHERE id_utente = :id_utente
            AND giorno = :giorno
        ;");
        $query->bindValue(":id_utente", $this->id_utente);
        $query->bindValue(":giorno", $this->giorno);

        // echo 'sto passando da qui' . __LINE__ . __FILE__;
        try {
            $query->execute();
            $data = $query->fetchall();
            return $data;
        } catch (PDOException $e) {
            echo $e;
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    public function getPiattiPrenotazione()
    {
        $query = $this->db->prepare("SELECT id_piatto
            FROM rel_prenotazione_piatti
            WHERE id_prenotazione = :id_prenotazione 
        ;");
        $query->bindValue(":id_prenotazione", $this->id_prenotazione);
        // echo 'sto passando da qui' . __LINE__ . __FILE__;
        try {
            $query->execute();
            return $query->fetchall();
        } catch (PDOException $e) {
            echo $e;
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    public function getDesabledDates()
    {
        $query = $this->db->prepare("SELECT disabled_date FROM disabled_dates
            WHERE disabled_date BETWEEN :firstDay AND :lastDay;");
        $query->bindValue(":firstDay", $this->firstDay);
        $query->bindValue(":lastDay", $this->lastDay);
        try {
            $query->execute();
            return $query->fetchall();
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    public function debug($data, $json = true)
    {
        if ($json) {
            echo json_encode($data);
        } else {
            echo "<pre>";
            print_r($data);
            echo "</pre>";
        }
        exit;
    }
}
