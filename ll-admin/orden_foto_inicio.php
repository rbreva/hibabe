<?php

// require_once "funciones/lla_db_fns.php";
// require_once "funciones/admin_lla_fnc.php";

require_once './functions/lla_admin.php';

$id_prod = $_POST['id_prod'];
$select = $_POST['select'];
if ($select) {
    if ($select == "check") {
        $query = "UPDATE productos SET inicio = '1' WHERE id = '$id_prod'";
        actualizar_registro($query);
    }
    if ($select == "nocheck") {
        $query = "UPDATE productos SET inicio = '0' WHERE id = '$id_prod'";
        actualizar_registro($query);
    }
} else {
    $id_producto =  $_POST['actualizarOrdenSlide'];
    $ordenfoto =  $_POST['actualizarOrdenItem'];

    $query_update = "UPDATE productos SET orden_inicio = '$ordenfoto' WHERE id = '$id_producto'";
    actualizar_registro($query_update);
}
