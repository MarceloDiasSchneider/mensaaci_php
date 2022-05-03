<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('display_startup_errors', 1);

include_once('piatto_class.php');
$objpiatto = new piatto_class();

$cheazione = $_REQUEST['action'];

if (isset($_REQUEST['nomePiatto'])) {
    $objpiatto->piatto = $_REQUEST['nomePiatto'];
}
if (isset($_REQUEST['ingedientiscelti'])) {
    $objpiatto->listaingredienti = $_REQUEST['ingedientiscelti'];
}
if (isset($_REQUEST['tipologia'])) {
    $objpiatto->id_tipologia_piatto = $_REQUEST['tipologia'];
}
if (isset($_REQUEST['id_piatto'])) {
    $objpiatto->id_piatto = $_REQUEST['id_piatto'];
}

switch ($cheazione) {
    case 'post':
        $objpiatto->post();
        echo "correttamente inserito";

        break;
    case 'put':
        $objpiatto->put();
        echo "correttamente modificato";

        break;
    case 'delete':
        $piattoInMenu = $objpiatto->checkPiattoInMenu();
        if ($piattoInMenu) {
            echo 'Il piatto appartiene a un menu. Non può essere cancellato';
        } else {
            $objpiatto->removeAssociaIngrediente();
            $response = $objpiatto->delete();
            echo 'Piatto cancellato.';
        }

        break;
    case 'getAll':
        echo 'sto passando da qui' . __LINE__ . __FILE__;

        break;
    case 'getById':
        $listone = $objpiatto->getById();
        echo json_encode($listone);

        break;
    default:

        break;
}
