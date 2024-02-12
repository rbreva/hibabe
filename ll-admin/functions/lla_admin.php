<?php

function obtener_todo($query)
{
    include 'lla_dbconnect.php';
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
    include 'lla_dbconnect.php';
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
    include 'lla_dbconnect.php';
    $statement = $pdo->prepare($query);
    $result = $statement->execute();
    if (!$result) {
        return false;
    } else {
        return true;
    }
    $pdo = null;
}

function actualizar_registro_id($query)
{
    include 'lla_dbconnect.php';
    $statement = $pdo->prepare($query);
    $result = $statement->execute();
    if (!$result) {
        return false;
    } else {
        $id_autogenerado = $pdo->lastInsertId();
        return $id_autogenerado;
    }
    $pdo = null;
}

function actualizar_transaccion($query_transaccion)
{
    include 'lla_dbconnect.php';
    $pdo->beginTransaction();
    $exito = true;
    foreach ($query_transaccion as $query) {
        $statement = $pdo->prepare($query);
        $result = $statement->execute();
        if (!$result) {
            $exito = false;
            break;
        }
    }
    if ($exito) {
        $pdo->commit();
        return true;
    } else {
        $pdo->rollback();
        return false;
    }
    $pdo = null;
}

function get_pass_admin($user)
{
    include 'lla_dbconnect.php';
    $query = "SELECT password FROM users WHERE username = '$user'";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result['password'];
    $pdo = null;
}

function store_config()
{
    include 'lla_dbconnect.php';
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
