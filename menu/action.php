<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('display_startup_errors', 1);

include_once('menu_class.php');
$objmenu = new menu_class();

$cheazione = $_REQUEST['action'];

if (isset($_REQUEST['nomeMenu'])) {
    $objmenu->menu = $_REQUEST['nomeMenu'];
}
if (isset($_REQUEST['piattiscelti'])) {
    $objmenu->listapiatti = $_REQUEST['piattiscelti'];
}
if (isset($_REQUEST['id'])) {
    $objmenu->id = $_REQUEST['id'];
}
if (isset($_REQUEST['takeaway'])) {
    $objmenu->takeaway = $_REQUEST['takeaway'];
} else {
    $objmenu->takeaway = 0;
}

switch ($cheazione) {
    case 'post':
        $objmenu->post();
        echo "correttamente inserito";

        break;
    case 'put':
        $objmenu->put();
        echo "correttamente modificato";

        break;
    case 'delete':
        $objmenu->delete();
        echo "correttamente eliminato";
        
        break;

    case 'getById':
        $listone = $objmenu->getById();
        echo json_encode($listone);
        
        break;
    default:

        break;
}
