<?php

session_start();
include_once("includes/lla_generales.php");
$config = store_config();
unset($_SESSION[$config['session']]);
header("Location: login.php");
