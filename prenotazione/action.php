<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('display_startup_errors', 1);

include_once('prenotazione_class.php');
$controller = new prenotazione_class();

$cheazione = $_REQUEST['action'];
if (isset($_REQUEST['giorno'])) {
    $controller->giorno = $_REQUEST['giorno'];
}
if (isset($_REQUEST['firstDay'])) {
    $controller->firstDay = $_REQUEST['firstDay'];
}
if (isset($_REQUEST['lastDay'])) {
    $controller->lastDay = $_REQUEST['lastDay'];
}
if (isset($_REQUEST['id_menu'])) {
    $controller->id_menu = $_REQUEST['id_menu'];
}
if (isset($_REQUEST['id_prenotazione'])) {
    $controller->id_prenotazione = $_REQUEST['id_prenotazione'];
}
if (isset($_REQUEST['id_piatti'])) {
    $controller->id_piatti = $_REQUEST['id_piatti'];
}
if (isset($_REQUEST['id_tipologia'])) {
    $controller->id_tipologia = $_REQUEST['id_tipologia'];
}
if (isset($_REQUEST['id_utente'])) {
    $controller->id_utente = $_REQUEST['id_utente'];
}
if (isset($_REQUEST['takeaway'])) {
    $controller->takeaway = $_REQUEST['takeaway'];
}
if (isset($_REQUEST['note_takeaway'])) {
    $controller->note_takeaway = $_REQUEST['note_takeaway'];
}
if (isset($_REQUEST['turno'])) {
    $controller->turno = $_REQUEST['turno'];
    if ($_REQUEST['turno'] == 'null') {
        $controller->turno = null;
    }
}
if (isset($_REQUEST['consumazione'])) {
    $controller->consumazione = $_REQUEST['consumazione'];
}
switch ($cheazione) {
    case 'getAllPiatti':
        $PiattiGiorno = $controller->getPiattiGiorno();
        $Prenotazione_data = $controller->getPrenotazione();
        $has_order = count($Prenotazione_data) ? true : false;
        $Prenotazione = [];
        if ($has_order) {
            $Prenotazione = [
                'consumazione' => intval($Prenotazione_data[0]['consumazione']),
                'id' => intval($Prenotazione_data[0]['id']),
                'note_takeaway' => $Prenotazione_data[0]['note_takeaway'],
                'takeaway' => intval($Prenotazione_data[0]['takeaway']),
                'turno' => intval($Prenotazione_data[0]['turno']),
            ];
            $controller->id_prenotazione = $Prenotazione_data[0]['id'];
            $PiattiPrenotazione = $controller->getPiattiPrenotazione();
        } else {
            $PiattiPrenotazione = [];
        }

        $id_piatti = [];
        foreach ($PiattiPrenotazione as $value) {
            $id_piatti[] = $value['id_piatto'];
        }

        $data = [];
        foreach ($PiattiGiorno as $key => $value) {
            if (!isset($data[$value['id_tipologia']])) {
                if ($key == 0) {
                    $data[$value['id_tipologia']]['show_tipologia'] = true;
                } else {
                    $data[$value['id_tipologia']]['show_tipologia'] = false;
                }
                $data[$value['id_tipologia']]['tipologia'] = $value['tipologia'];
                $data[$value['id_tipologia']]['id_tipologia'] = $value['id_tipologia'];
            }
            $data[$value['id_tipologia']]['piatti'][$value['id_piatto']] = [
                "id_piatto" => $value['id_piatto'],
                "piatto" => $value['piatto'],
                "show_allergene" => false,
                "ingredienti" => $controller->getIngredientiByIdPiatto($value['id_piatto']),
                "selected" => in_array($value['id_piatto'], $id_piatti)
            ];
        }
        echo json_encode(['prenotazione' => $Prenotazione, 'piatti' => $data, 'has_order' => $has_order]);
        break;
    case 'datesWithOrders':
        $data = $controller->getUtenteDataConOrdine();
        $formated_data = [];
        foreach ($data as $date) {
            $formated_data[] = [
                'giorno' => str_replace(' 00:00:00', '', $date['giorno']),
                'takeaway' => $date['takeaway'],
                'consumazione' => $date['consumazione'],
            ];
        }
        echo json_encode(["datesWithOrders" => $formated_data]);

        break;

    case 'getDesabledDates':
        $data = $controller->getDesabledDates();
        echo json_encode(["desabledDates" => $data]);

        break;

    case 'save-prenotazione':
        if ($controller->id_prenotazione) {
            $controller->dropPrenotazionePiatii();
            $controller->updatePrenotazione();
        } else {
            $controller->id_prenotazione = $controller->savePrenotazione();
        }
        foreach ($_REQUEST['piatti_data'] as $id_piatto) {
            $controller->id_piatto = $id_piatto;
            $controller->postPrenotazionePiatto();
        }

        echo json_encode("Prenotazione effettuata");

        break;
    case 'delete-prenotazione':
        $controller->dropPrenotazionePiatii();
        $controller->dropPrenotazione();
        echo json_encode("Prenotazione cancellata");
        break;
    default:
        echo 'nessuna azione trovata';
        break;
}
//cmq vada devo aggiornare la tabella
