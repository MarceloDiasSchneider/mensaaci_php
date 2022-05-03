<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('display_startup_errors', 1);

include_once('ingredienti_class.php');
$objingrediente = new ingredienti_class();

$cheazione = $_REQUEST['action'];

if (isset($_REQUEST['nomeIngrediente'])) {
    $objingrediente->ingrediente = $_REQUEST['nomeIngrediente'];
}
if (isset($_REQUEST['allergene'])) {
    $objingrediente->allergene = 'on';
}
if (isset($_REQUEST['id_ingrediente'])) {
    $objingrediente->id_ingrediente = $_REQUEST['id_ingrediente'];
}

switch ($cheazione) {
    case 'post':
        $objingrediente->post();
        echo "correttamente inserito";

        break;
    case 'put':
        $objingrediente->put();
        echo "correttamente modificato";

        break;
    case 'delete':
        $response =  $objingrediente->delete();
        echo $response;

        break;
    case 'getAll':
        echo 'sto passando da qui' . __LINE__ . __FILE__;

        break;
    case 'getById':
        $listone = $objingrediente->getById();
        echo json_encode($listone);

        break;
    default:

        break;
}
