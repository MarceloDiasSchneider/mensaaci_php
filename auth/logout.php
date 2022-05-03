<?php

session_start();
session_destroy();
require "../vendor/autoload.php";
header("Location: " . GOOGLE['redirectUri']);
exit;