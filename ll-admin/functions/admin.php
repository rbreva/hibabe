<?php

function store_config()
{
    include 'dbconnect.php';
    $query = "SELECT * FROM store_config WHERE id = 1";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        return false;
    } else {
        return $result;
    }
    $pdo = null;
}

function obtener_todo($query)
{
    include 'dbconnect.php';
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    if (!$result) {
        return false;
    }
    return $result;
    $pdo = null;
}

function obtener_linea($query)
{
    include 'dbconnect.php';
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        return false;
    }
    return $result;
    $pdo = null;
}

function actualizar_registro($query)
{
    include 'dbconnect.php';
    $statement = $pdo->prepare($query);
    $result = $statement->execute();
    if (!$result) {
        return false;
    } else {
        return true;
    }
    $pdo = null;
}

function get_pass_cliente($email)
{
    $query = "SELECT password FROM clientes WHERE email = '$email'";

    include 'dbconnect.php';
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        return false;
    } else {
        return $result['password'];
    }
    $pdo = null;
}

function tep_validate_password($plain, $encrypted)
{
    if (tep_not_null($plain) && tep_not_null($encrypted)) {
        $stack = explode(':', $encrypted);
        if (sizeof($stack) != 2) {
            return false;
        }
        if (md5($stack[1] . $plain) == $stack[0]) {
            return true;
        }
    }
    return false;
}

function tep_not_null($value)
{
    if (is_array($value)) {
        if (sizeof($value) > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        if ((is_string($value) || is_int($value)) && ($value != '') && ($value != 'NULL') && (strlen(trim($value)) > 0)) {
            return true;
        } else {
            return false;
        }
    }
}

function tep_encrypt_password($plain)
{
    $password = '';
    for ($i = 0; $i < 10; $i++) {
        $password .= tep_rand();
    }
    $salt = substr(md5($password), 0, 2);
    $password = md5($salt . $plain) . ':' . $salt;
    return $password;
}

function tep_rand($min = null, $max = null)
{
    static $seeded;
    if (!isset($seeded)) {
        mt_srand((double)microtime() * 1000000);
        $seeded = true;
    }
    if (isset($min) && isset($max)) {
        if ($min >= $max) {
            return $min;
        } else {
            return mt_rand($min, $max);
        }
    } else {
        return mt_rand();
    }
}
