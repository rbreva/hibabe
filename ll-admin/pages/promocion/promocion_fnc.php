<?php

function cupones()
{
    cupones_fnc();
}

function marquesinas()
{
    marquesina_acc();
}

function fondocolor()
{
    fondocolor_acc();
}

function promociones()
{
    listar_promociones();
}

function montominimo()
{
    echo "montominimo";
}

function etiquetas($config)
{
    etiquetas_acc($config);
}

function muygrande($manda, $ancho_original, $alto_original, $max, $original, $nombrerand, $imagen_type, $dir_destino)
{
    if ($manda == "iguales") {
        $ancho_nuevo = $max;
        $alto_nuevo = round($ancho_nuevo * $alto_original / $ancho_original);
    } elseif ($manda == "alto") {
        $alto_nuevo = $max;
        $ancho_nuevo = round($alto_nuevo * $ancho_original / $alto_original);
    } elseif ($manda == "ancho") {
        $ancho_nuevo = $max;
        $alto_nuevo = round($ancho_nuevo * $alto_original / $ancho_original);
    }
    $copia = imagecreatetruecolor($ancho_nuevo, $alto_nuevo);
    imagecopyresampled($copia, $original, 0, 0, 0, 0, $ancho_nuevo, $alto_nuevo, $ancho_original, $alto_original);
    if ($imagen_type == 'image/jpeg') {
        imagejpeg($copia, $dir_destino . $nombrerand, 90);
    } elseif ($imagen_type == 'image/png') {
        imagepng($copia, $dir_destino . $nombrerand, 8);
    }
}

function estabien($ancho_original, $alto_original, $original, $nombrerand, $imagen_type, $dir_destino)
{
    $copia = imagecreatetruecolor($ancho_original, $alto_original);
    imagecopyresampled($copia, $original, 0, 0, 0, 0, $ancho_original, $alto_original, $ancho_original, $alto_original);
    if ($imagen_type == 'image/jpeg') {
        imagejpeg($copia, $dir_destino . $nombrerand, 90);
    } elseif ($imagen_type == 'image/png') {
        imagepng($copia, $dir_destino . $nombrerand, 8);
    }
}
