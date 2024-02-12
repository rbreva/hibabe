<?php

session_start();
include_once 'includes/lla_generales.php';
$config = store_config();

if (isset($_SESSION[$config['session']])) {
    $page = "Pedidos";
    doctype($page, $config);
    ll_header($page, $config);
    include_once("pages/ll_pedidos.php");
    ll_footer($config);
} else {
    header("Location: login.php");
}
