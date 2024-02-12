<?php

function disable_seccion($id_menu, $idsecdis)
{
    $query = "UPDATE secciones SET active = '0' WHERE id = '$idsecdis'";
    $resultado = actualizar_registro($query);
    if ($resultado) {
        $msj = "Sección Desactivada correctamente";
    } else {
        $msj = "Error al Desactivar menú";
    }
    $retorno = "menus.php?id=$id_menu";

    retorno($retorno, $msj);
}

function enable_seccion($id_menu, $idsecact)
{
    $query = "UPDATE secciones SET active = '1' WHERE id = '$idsecact'";
    $resultado = actualizar_registro($query);
    if ($resultado) {
        $msj = "Sección Activada correctamente";
    } else {
        $msj = "Error al Activar menú";
    }
    $retorno = "menus.php?id=$id_menu";

    retorno($retorno, $msj);
}
