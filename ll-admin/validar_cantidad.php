<?php

// require_once "../ll-admin/funciones/lla_db_fns.php";
// require_once "../ll-admin/funciones/admin_lla_fnc.php";

require_once './functions/lla_admin.php';

$seleccionado = $_POST['seleccionado'];
$nrosql = $_POST['nrosql'];

$query_producto = "UPDATE productos SET inicio = '$nrosql' WHERE id = '$seleccionado'";
actualizar_registro($query_producto);
