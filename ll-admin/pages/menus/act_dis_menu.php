<?php

function disable_menu($idmendis)
{
    $query = "UPDATE menus SET active = '0' WHERE id = '$idmendis'";
    $resultado = actualizar_registro($query);
    if ($resultado) {
        $msj = "Menú Desactivado correctamente";
    } else {
        $msj = "Error al Desactivar menú";
    }
    $retorno = "menus.php";

    retorno($retorno, $msj);
}

function enable_menu($idmenact)
{
    $query = "UPDATE menus SET active = '1' WHERE id = '$idmenact'";
    $resultado = actualizar_registro($query);
    if ($resultado) {
        $msj = "Menú Activado correctamente";
    } else {
        $msj = "Error al Activar menú";
    }
    $retorno = "menus.php";

    retorno($retorno, $msj);
}
