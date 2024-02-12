<?php

require_once 'includes/lla_generales.php';

    $foto = $_REQUEST['nomfoto'];
    $id = $_REQUEST['idfoto'];
    $eliminarfoto1 = "../images/productos/small/" . $foto;
    $eliminarfoto3 = "../images/productos/" . $foto;

if ($id) {
    $query_id = "DELETE FROM fotos WHERE id = $id";
    $codigos = actualizar_registro($query_id);
    unlink($eliminarfoto1);
    unlink($eliminarfoto3);
    echo "bien";
} else {
    echo "mal";
}
