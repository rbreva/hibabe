<?php

session_start();
require_once 'includes/lla_generales.php';
$config = store_config();

if (isset($_SESSION[$config['session']])) {
    header("Location: inicio.php");
} else {
    if (isset($_POST['user']) && isset($_POST['pass'])) {
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $check = get_pass_admin($user);

        if (password_verify($pass, $check)) {
            $_SESSION[$config['session']] = $user;
            header("Location: inicio.php");
        } else {
            header("Location: login.php?err=1");
        }
    } else {
        header("Location: login.php");
    }
}
