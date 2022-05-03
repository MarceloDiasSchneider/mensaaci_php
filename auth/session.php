<?php
session_start();
if (!isset($_SESSION['user_data'])) {
  // session_start();
  // session_destroy();
  // require "../vendor/autoload.php";
  // header("Location: " . GOOGLE['redirectUri']);
  // exit;
}
