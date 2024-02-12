<?php

function img_suscriptores()
{
    $editar_modal = "";
    if (isset($_POST['editar_modal'])) {
        $editar_modal = $_POST['editar_modal'];
    }
    if ($editar_modal) {
        $archivo = $_FILES['nuevofoto_modal']['name'];
        $archivo_mobile = $_FILES['nuevofoto_modal_mobile']['name'];
        if (isset($archivo) && $archivo != "") {
            $dir_destino = '../images/modal/';
            $imagen = trim($_FILES['nuevofoto_modal']['name']);
            $tipo = $_FILES['nuevofoto_modal']['type'];
            $tamano = $_FILES['nuevofoto_modal']['size'];
            $temp = $_FILES['nuevofoto_modal']['tmp_name'];

            if ($tipo == 'image/jpeg') {
                $nombre_tipo = '.jpg';
            } elseif ($tipo == 'image/png') {
                $nombre_tipo = '.png';
            } elseif ($tipo == 'video/mp4') {
                $nombre_tipo = $imagen;
            }
            $nombrerand = time() . rand(0, 9) . rand(100, 9999) . rand(100, 9999) . rand(1000, 99999) . $nombre_tipo;
            if (!((strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")))) {
                $msj_desk = '<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>
            - Se permiten archivos .gif, .jpg, .png. y de 1.5 mb como máximo.</b></div>';
            } else {
                if ($tamano < 1500000) {
                    if ($tipo == 'image/jpeg' || $tipo == "image/png" || $tipo == "video/mp4") {
                        if (agregar_imagen_modal($temp, $tipo, $nombrerand, $dir_destino)) {
                            $query_agregar_banner = "UPDATE modal SET imagen_modal = '$nombrerand' WHERE id_modal = 1";
                            if (actualizar_registro($query_agregar_banner)) {
                                $msj_desk = "Imagen Desktop Actualizada";
                            } else {
                                $msj_desk = "Error, por favor intentar de nuevo";
                            }
                        } else {
                            $msj_desk = "No se pudo subir la imagen, por favor intentar de nuevo";
                        }
                    } else {
                        $msj_desk = "La imagen debe de ser de formato .jpg o .png, No se permite otro formato";
                    }
                } else {
                    $msj_desk = "La imagen supera el tamaño permitido '1.5 Mb'";
                }
            }
        }
        if (isset($archivo_mobile) && $archivo_mobile != "") {
            $dir_destino_mobile = '../images/modal/';
            $tipo_mobile = $_FILES['nuevofoto_modal_mobile']['type'];
            $tamano_mobile = $_FILES['nuevofoto_modal_mobile']['size'];
            $temp_mobile = $_FILES['nuevofoto_modal_mobile']['tmp_name'];
            if ($tipo_mobile == 'image/jpeg') {
                $nombre_tipo_mobile = '.jpg';
            } elseif ($tipo_mobile == 'image/png') {
                $nombre_tipo_mobile = '.png';
            } elseif ($tipo_mobile == 'video/mp4') {
                $nombre_tipo_mobile = $imagen;
            }
            $nombrerand_mobile = time() . rand(0, 9) . rand(100, 9999) . rand(100, 9999) . rand(1000, 99999) . $nombre_tipo_mobile;
            if (!((strpos($tipo_mobile, "jpeg") || strpos($tipo_mobile, "jpg") || strpos($tipo_mobile, "png")))) {
                $msj_mobile = '<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>
            - Se permiten archivos .gif, .jpg, .png. y de 1.5 mb como máximo.</b></div>';
            } else {
                if ($tamano_mobile < 1500000) {
                    if ($tipo_mobile == 'image/jpeg' || $tipo_mobile == "image/png" || $tipo_mobile == "video/mp4") {
                        if (agregar_imagen_modal($temp_mobile, $tipo_mobile, $nombrerand_mobile, $dir_destino_mobile)) {
                            $query_agregar_banner_mobile = "UPDATE 
                                modal 
                                SET 
                                imagen_modal_mobile = '$nombrerand_mobile' 
                                WHERE 
                                id_modal = 1";
                            if (actualizar_registro($query_agregar_banner_mobile)) {
                                $msj_mobile = "Imagen Mobile Actualizada";
                            } else {
                                $msj_mobile = "Error, por favor intentar de nuevo";
                            }
                        } else {
                            $msj_mobile = "No se pudo subir la imagen, por favor intentar de nuevo";
                        }
                    } else {
                        $msj_mobile = "La imagen debe de ser de formato .jpg o .png, No se permite otro formato";
                    }
                } else {
                    $msj_mobile = "La imagen supera el tamaño permitido '1.5 Mb'";
                }
            }
        }
        $msj = $msj_desk . '<br>' . $msj_mobile;
        $ruta = "suscripcion.php?menu_lat=33";
        $boton = "Regresar";
        mensaje_generico($msj, $ruta, $boton);
    } else {
        $query_modal = "SELECT * FROM modal";
        $modal = obtener_linea($query_modal);
        ?>
        <div class="barra_titulo">
            <h2 class="titulo_h2">Imágenes de Suscriptores</h2>
        </div>

        <form class="suscripcion_form" action="suscripcion.php?menu_lat=33" method="post" enctype="multipart/form-data">
            <div class="bloque_sus">
                <h3 class="subtitulo_h3">Imagen Suscripción Desktop:</h3>
                <div class="nota">
                    Tamaño de la imagen 600px * 400px horizontal.
                    Cualquier otro tamaño va a generar resultado imprevistos.
                </div>
                <input class="input_file" id="file_url" type="file" name="nuevofoto_modal">
                <img class="img_form_susc" id="img_destino" src="../images/modal/<?php echo $modal['imagen_modal'] ?>" alt="Imagen">
            </div>
            <div class="bloque_sus">
                <h3 class="subtitulo_h3">Imagen Suscripción Mobile:</h3>
                <div class="nota">
                    Tamaño de la imagen 300px * 450px vertical.
                    Cualquier otro tamaño va a generar resultado imprevistos.
                </div>
                <input class="input_file" id="file_url_mobile" type="file" name="nuevofoto_modal_mobile">
                <img class="img_form_susc_modal" id="img_destino_mobile" src="../images/modal/<?php echo $modal['imagen_modal_mobile'] ?>" alt="Imagen">
            </div>

            <div class="botonera">
                <input type="hidden" value="editar_modal" name="editar_modal">
                <button type="submit" class="acc_btn">Actualizar imágenes</button>
            </div>
        </form>
        <script>
            function mostrarImagen(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    var valida = input.files[0].type;
                    if (valida == "image/jpeg") {
                        reader.onload = function(e) {
                            $('#img_destino').attr('src', e.target.result);
                        }
                    } else if (valida == "video/mp4") {
                        reader.onload = function(e) {
                            $('#videoban').attr('src', e.target.result);
                        }
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#file_url").change(function() {
                mostrarImagen(this);
            });
        </script>
        <script>
            function mostrarImagen_mobile(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    var valida = input.files[0].type;
                    if (valida == "image/jpeg") {
                        reader.onload = function(e) {
                            $('#img_destino_mobile').attr('src', e.target.result);
                        }
                    } else if (valida == "video/mp4") {
                        reader.onload = function(e) {
                            $('#videoban_mobile').attr('src', e.target.result);
                        }
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#file_url_mobile").change(function() {
                mostrarImagen_mobile(this);
            });
        </script>
        <?php
    }
}

function agregar_imagen_modal($temporal, $imagen_type, $nombrerand, $dir_destino)
{
    $max = 2000;
    if ($imagen_type == 'image/jpeg') {
        $original = imagecreatefromjpeg($temporal);
    } elseif ($imagen_type == 'image/png') {
        $original = imagecreatefrompng($temporal);
    }

    $ancho_original = imagesx($original);
    $alto_original = imagesy($original);

    if ($ancho_original == $alto_original) {
        $manda = "iguales";
    } elseif ($ancho_original < $alto_original) {
        $manda = "alto";
    } elseif ($ancho_original > $alto_original) {
        $manda = "ancho";
    }

    if ($ancho_original > $max) {
        muygrande($manda, $ancho_original, $alto_original, $max, $original, $nombrerand, $imagen_type, $dir_destino);
    } else {
        estabien($ancho_original, $alto_original, $original, $nombrerand, $imagen_type, $dir_destino);
    }
    return true;
}

function muygrande($manda, $ancho_original, $alto_original, $max, $original, $nombrerand, $imagen_type, $dir_destino)
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
        imagejpeg($copia, $dir_destino . $nombrerand, 90);
    } elseif ($imagen_type == 'image/png') {
        imagepng($copia, $dir_destino . $nombrerand, 8);
    }
}

function estabien($ancho_original, $alto_original, $original, $nombrerand, $imagen_type, $dir_destino)
{
    //echo "se queda igual </br>";
    $copia = imagecreatetruecolor($ancho_original, $alto_original);
    imagecopyresampled($copia, $original, 0, 0, 0, 0, $ancho_original, $alto_original, $ancho_original, $alto_original);

    if ($imagen_type == 'image/jpeg') {
        //exportar/guardar imagen
        imagejpeg($copia, $dir_destino . $nombrerand, 90);
    } elseif ($imagen_type == 'image/png') {
        imagepng($copia, $dir_destino . $nombrerand, 8);
    }
}
