<?php

session_start();
include_once 'includes/lla_generales.php';
$config = store_config();

if (isset($_SESSION[$config['session']])) {
    header("Location: index.php");
} else {
    $page = 'Login';
    doctype($page, $config);
    include("pages/ll_login.php");
}
