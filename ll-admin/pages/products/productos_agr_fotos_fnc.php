<?php

function agregar_imagenes($temporal, $imagen_type, $nombrerand)
{
    $thumb = 100;
    $small = 500;
    $max = 1200;

    //abrir la foto original

    if ($imagen_type == 'image/jpeg') {
        $original = imagecreatefromjpeg($temporal);
    } elseif ($imagen_type == 'image/png') {
        $original = imagecreatefrompng($temporal);
    }

    $ancho_original = imagesx($original);
    $alto_original = imagesy($original);

    if ($ancho_original == $alto_original) {
        $manda = "iguales";
        //nuevo ancho
        $ancho_nuevo_small = $small;
        $ancho_nuevo_thumb = $thumb;
        //nuevo alto
        $alto_nuevo_small = $small;
        $alto_nuevo_thumb = $thumb;

        if ($ancho_original > $max) {
            muygrande($manda, $ancho_original, $alto_original, $max, $original, $nombrerand, $imagen_type);
        } else {
            estabien($ancho_original, $alto_original, $original, $nombrerand, $imagen_type);
        }
    } elseif ($ancho_original < $alto_original) {
        $manda = "alto";
        //nuevo alto
        $alto_nuevo_small = $small;
        $alto_nuevo_thumb = $thumb;
        //nuevo ancho
        $ancho_nuevo_small = round($alto_nuevo_small * $ancho_original / $alto_original);
        $ancho_nuevo_thumb = round($alto_nuevo_thumb * $ancho_original / $alto_original);

        if ($alto_original > $max) {
            muygrande($manda, $ancho_original, $alto_original, $max, $original, $nombrerand, $imagen_type);
        } else {
            estabien($ancho_original, $alto_original, $original, $nombrerand, $imagen_type);
        }
    } elseif ($ancho_original > $alto_original) {
        $manda = "ancho";
        //nuevo ancho
        $ancho_nuevo_small = $small;
        $ancho_nuevo_thumb = $thumb;
        //nuevo alto
        $alto_nuevo_small = round($ancho_nuevo_small * $alto_original / $ancho_original);
        $alto_nuevo_thumb = round($ancho_nuevo_thumb * $alto_original / $ancho_original);

        if ($ancho_original > $max) {
            muygrande($manda, $ancho_original, $alto_original, $max, $original, $nombrerand, $imagen_type);
        } else {
            estabien($ancho_original, $alto_original, $original, $nombrerand, $imagen_type);
        }
    }

    //crear lienzo vacio ( foto destino tamaño variable)
    $copia_small = imagecreatetruecolor($ancho_nuevo_small, $alto_nuevo_small);
    $copia_thumb = imagecreatetruecolor($ancho_nuevo_thumb, $alto_nuevo_thumb);

    //copiar original -> copia
    //1-2 destino y original
    //3-4 x_y pegado
    //5-6 x_y original
    //7_8 ancho y alto detino
    //7_8 ancho y alto original

    imagecopyresampled(
        $copia_small,
        $original,
        0,
        0,
        0,
        0,
        $ancho_nuevo_small,
        $alto_nuevo_small,
        $ancho_original,
        $alto_original
    );

    imagecopyresampled(
        $copia_thumb,
        $original,
        0,
        0,
        0,
        0,
        $ancho_nuevo_thumb,
        $alto_nuevo_thumb,
        $ancho_original,
        $alto_original
    );

    if ($imagen_type == 'image/jpeg') {
        //exportar/guardar imagen
        imagejpeg($copia_small, '../images/productos/small/' . $nombrerand, 90);
        imagejpeg($copia_thumb, '../images/productos/thumb/' . $nombrerand, 90);
    } elseif ($imagen_type == 'image/png') {
        imagepng($copia_small, '../images/productos/small/' . $nombrerand, 8);
        imagepng($copia_thumb, '../images/productos/thumb/' . $nombrerand, 8);
    }
}

function muygrande($manda, $ancho_original, $alto_original, $max, $original, $nombrerand, $imagen_type)
{
    if ($manda == "iguales") {
        //echo "Iguales </br>";
        $ancho_nuevo = $max;
        $alto_nuevo = round($ancho_nuevo * $alto_original / $ancho_original);
    } elseif ($manda == "alto") {
        //echo "Manda Alto </br>";
        $alto_nuevo = $max;
        $ancho_nuevo = round($alto_nuevo * $ancho_original / $alto_original);
    } elseif ($manda == "ancho") {
        //echo "Manda Ancho </br>";
        $ancho_nuevo = $max;
        $alto_nuevo = round($ancho_nuevo * $alto_original / $ancho_original);
    }
    $copia = imagecreatetruecolor($ancho_nuevo, $alto_nuevo);
    imagecopyresampled($copia, $original, 0, 0, 0, 0, $ancho_nuevo, $alto_nuevo, $ancho_original, $alto_original);

    if ($imagen_type == 'image/jpeg') {
        imagejpeg($copia, '../images/productos/' . $nombrerand, 90);
    } elseif ($imagen_type == 'image/png') {
        imagepng($copia, '../images/productos/' . $nombrerand, 8);
    }
}

function estabien($ancho_original, $alto_original, $original, $nombrerand, $imagen_type)
{
    //echo "se queda igual </br>";
    $copia = imagecreatetruecolor($ancho_original, $alto_original);
    imagecopyresampled($copia, $original, 0, 0, 0, 0, $ancho_original, $alto_original, $ancho_original, $alto_original);

    if ($imagen_type == 'image/jpeg') {
        //exportar/guardar imagen
        imagejpeg($copia, '../images/productos/' . $nombrerand, 90);
    } elseif ($imagen_type == 'image/png') {
        imagepng($copia, '../images/productos/' . $nombrerand, 8);
    }
}
