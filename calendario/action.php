<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('display_startup_errors', 1);

include_once('calendario_class.php');
$objmenu = new calendario_class();

$cheazione = $_REQUEST['action'];
if (isset($_REQUEST['id'])) {
    $objmenu->id = $_REQUEST['id'];
}
if (isset($_REQUEST['giorno'])) {
    $objmenu->giorno = $_REQUEST['giorno'];
}
if (isset($_REQUEST['id_menu'])) {
    $objmenu->id_menu = $_REQUEST['id_menu'];
}
if (isset($_REQUEST['disabled_date'])) {
    $objmenu->disabled_date = $_REQUEST['disabled_date'];
}

switch ($cheazione) {
    case 'post':
        // echo 'sto passando da qui' . __LINE__ . __FILE__;
        $objmenu->post();
        echo "correttamente inserito";

        break;
    case 'put':
        //echo 'sto passando da qui' . __LINE__. __FILE__;
        $objmenu->put();
        echo "correttamente modificato";

        break;
    case 'delete':
        // echo 'sto passando da qui' . __LINE__ . __FILE__;
        $objmenu->delete();
        echo "correttamente eliminato";

        break;
    case 'getAll':
        $MenuGiorno = $objmenu->getMenuGiorno();
        $data = [];
        foreach ($MenuGiorno as $value) {
            if (!isset($data[$value['id_menu']])) {
                $data[$value['id_menu']] = [
                    "id_menu" => $value['id_menu'],
                    "nome" => $value['nome'],
                ];
            }
            $data[$value['id_menu']]['piatti'][] = [
                "id_piatto" => $value['id_piatto'],
                "nome" => $value['piatto'],
                "tipologia" => [
                    "id" => $value['id_tipologia'],
                    "nome" => $value['tipologia']
                ]
            ];
        }
        $dataWithoutKey = [];
        foreach ($data as $value) {
            $dataWithoutKey[] = $value;
        }
        echo json_encode(['menu' => $dataWithoutKey]);
        break;
    case 'getById':
        //echo 'sto passando da qui' . __LINE__ . __FILE__;
        // $lista = $territorio_collection->recupera_per_id($id);
        // echo json_encode($lista); // use json_encode to convert the PHP array into a JSON object
        $listone = $objmenu->getById();
        echo json_encode($listone);
        break;

    case 'disableDate':
        $objmenu->disableDate();
        echo json_encode("Data disabilitata");
        break;

    case 'getDisableDates':
        $dates = $objmenu->getDisableDates();
        echo json_encode(["dates" => $dates]);
        break;

    case 'removeDisableDate':
        $dates = $objmenu->removeDisableDate();
        echo json_encode("Data cancellata");
        break;

    
    default:

        break;
}
//cmq vada devo aggiornare la tabella
