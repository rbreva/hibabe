<?php

session_start();
include_once 'includes/lla_generales.php';
$config = store_config();

if (isset($_SESSION[$config['session']])) {
    $page = "Upload";
    doctype($page, $config);
    ll_header($page, $config);
    include_once("pages/ll_upload.php");
    ll_footer($config);
} else {
    header("Location: login.php");
}
