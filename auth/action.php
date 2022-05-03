<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('display_startup_errors', 1);

include_once('auth_class.php');
$auth = new auth_class();

$cheazione = $_REQUEST['action'];
if (isset($_REQUEST['id_user'])) {
    $auth->id_user = $_REQUEST['id_user'];
}
if (isset($_REQUEST['first_name'])) {
    $auth->first_name = $_REQUEST['first_name'];
}
if (isset($_REQUEST['last_name'])) {
    $auth->last_name = $_REQUEST['last_name'];
}
if (isset($_REQUEST['email'])) {
    $auth->email = $_REQUEST['email'];
}
if (isset($_REQUEST['password'])) {
    $auth->password = $_REQUEST['password'];
}
if (isset($_REQUEST['google_sub_id'])) {
    $auth->google_sub_id = $_REQUEST['google_sub_id'];
}


switch ($cheazione) {
    case 'login';
        $user = $auth->login();
        if (isset($user['id'])) {
            session_start();
            $_SESSION['user_data'] = $user;
            echo json_encode([
                'auth' => 'success',
                'user_data' => $user
            ]);
        } else {
            echo json_encode([
                'auth' => 'error',
                'message' => 'Email o password errati'
            ]);
        }

        break;
    case 'google_auth_login';
        $user = $auth->login_google_auth();
        if (isset($user['id'])) {
            session_start();
            $_SESSION['user_data'] = $user;
            echo json_encode([
                'auth' => 'success',
                'user_data' => $user
            ]);
        } else {
            echo json_encode([
                'auth' => 'error',
                'message' => 'Questo account Google non ha utenti collegati'
            ]);
        }

        break;
    default:
        echo 'nessuna azione trovata';
        break;
}
