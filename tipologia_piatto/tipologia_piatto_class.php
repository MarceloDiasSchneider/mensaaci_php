<?php

/* automated class from skeleton 1.02022-03-24  */

class tipologia_piatto_class
{ // propriet //
    public $tipologia;
    public $note;

    function __construct()
    {


        include_once("../database_pdo_sing.php");
        $obj = DatabasePdoClass::getInstance();
        $this->db = $obj->creaConnessione();
    }
    // metodo post //
    public function post()

    {
        $query = $this->db->prepare("INSERT INTO tipologia_piatti (tipologia,note) VALUES (tipologia,:note);");
        $query->bindValue(":tipologia", $this->tipologia);
        $query->bindValue(":note", $this->note);

        try {
            $query->execute();
            $id_tobe_returned = $this->id;
            //restituisce il modificato
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }

    // metodo put //
    public function put()

    {
        $query = $this->db->prepare("UPDATE tipologia_piatti SET tipologia =:tipologia,note =:note, WHERE id=:id ; ");
        $query->bindValue(":tipologia", $this->tipologia);
        $query->bindValue(":note", $this->note);

        try {
            $query->execute();
            $id_tobe_returned = $this->id;
            //restituisce il modificato
        } catch (PDOException $e) {
            error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
            return $e;
        }
    }
//restituisce tutto
public function getAll()
{
    $query = $this->db->prepare("SELECT * FROM tipologia_piatti");

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
public function getById()
{
    $query = $this->db->prepare("SELECT * FROM tipologia_piatti  WHERE id=:id order by tipologia");
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
    $query = $this->db->prepare("DELETE FROM tipologia_piatti  WHERE id=:id");
    $query->bindValue(":id", $this->id);
    try {
        $query->execute();
       
    } catch (PDOException $e) {
        echo $e;
        error_log($e->getMessage() . PHP_EOL, 3, "../logs/" . __CLASS__ . "_" . __FUNCTION__ . "_error_log_" . date("Ymd_h") . ".log");
        return $e;
    }
}
}//fine classe }//fine classe 