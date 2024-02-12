<?php

function cronometro()
{
    $acc = "";
    if (isset($_POST['accion'])) {
        $acc = $_POST['accion'];
    }

    if ($acc == "vamos") {
        $nombre_contador = $_POST['nombre_contador'];
        $texto_contador = $_POST['texto_contador'];
        $fecha_cierre = $_POST['final_dt'];
        $hora_cierre = $_POST['final_hr'];
        $activar = "0";
        if (isset($_POST['activar'])) {
            $activar = $_POST['activar'];
        }

        $query_crono = "UPDATE 
            contador 
            SET 
            nombre_contador = '$nombre_contador', 
            texto_contador = '$texto_contador', 
            fecha_contador = '$fecha_cierre', 
            hora_contador = '$hora_cierre',	
            activo_contador = '$activar' 
            WHERE 
            id_contador = '1'";

        if (actualizar_registro($query_crono)) {
            $msj = "Crono Actualizado";
        } else {
            $msj = "Error en el Servidor, por favor intente de nuevo";
        }
        ?>
        <div class="msj">
            <?php echo $msj; ?><br><br>
            <a href="promocion.php?menu_lat=35" class="boton">Regresar</a>
        </div>
        <?php
    } elseif ($acc == "desktop") {
        $imagen = trim($_FILES['desktop_img']['name']);
        $msj = "";
        if ($imagen) {
            $dir_destino = '../images/cuenta/';
            $imagen = trim($_FILES['desktop_img']['name']);
            $temporal = $_FILES['desktop_img']['tmp_name'];
            $imagen_size = $_FILES['desktop_img']['size'];
            $imagen_type = $_FILES['desktop_img']['type'];
            if ($imagen_type == 'image/jpeg') {
                $nombre_tipo = '.jpg';
            } elseif ($imagen_type == 'image/png') {
                $nombre_tipo = '.png';
            }
            $nombrerand = time() . rand(0, 9) . rand(100, 9999) . rand(100, 9999) . rand(1000, 99999) . $nombre_tipo;

            if ($imagen_type == 'image/jpeg' || $imagen_type == 'image/png') {
                if ($imagen_size < 2000000) {
                    agregar_imagen_desktop($temporal, $imagen_type, $nombrerand, $dir_destino);
                    $query_nueva_foto = "UPDATE contador SET foto_desk = '$nombrerand' WHERE id_contador = '1'";
                    //            echo $query_nueva_foto;
                    if (actualizar_registro($query_nueva_foto)) {
                        $msj .= "<p>Imagen: " . $imagen . ", agregada con éxito</p>";
                    } else {
                        $msj .= "<p>Error al subir la imagen: " . $imagen . ", por favor intentar nuevamente.</p>";
                    }
                } else {
                    $msj .= "<p>La Imagen: " . $imagen . ", tiene un peso mayor al permitido: 2 megas</p>";
                }
            } else {
                $msj .= "<p>El Archivo: " . $imagen . ", no es de un formato permitido: jpg o png.<p>";
            }

            $ruta = "promocion.php?menu_lat=35";
            $boton = "Regresar";
            mensaje_generico($msj, $ruta, $boton);
        }
    } elseif ($acc == "mobile") {
        $imagen = trim($_FILES['mobile_img']['name']);
        $msj = "";
        if ($imagen) {
            $dir_destino = '../images/cuenta/';
            $imagen = trim($_FILES['mobile_img']['name']);
            $temporal = $_FILES['mobile_img']['tmp_name'];
            $imagen_size = $_FILES['mobile_img']['size'];
            $imagen_type = $_FILES['mobile_img']['type'];
            if ($imagen_type == 'image/jpeg') {
                $nombre_tipo = '.jpg';
            } elseif ($imagen_type == 'image/png') {
                $nombre_tipo = '.png';
            }
            $nombrerand = time() . rand(0, 9) . rand(100, 9999) . rand(100, 9999) . rand(1000, 99999) . $nombre_tipo;

            if ($imagen_type == 'image/jpeg' || $imagen_type == 'image/png') {
                if ($imagen_size < 2000000) {
                    agregar_imagen_mobile($temporal, $imagen_type, $nombrerand, $dir_destino);
                    $query_nueva_foto = "UPDATE contador SET foto_mobile = '$nombrerand' WHERE id_contador = '1'";
                    //            echo $query_nueva_foto;
                    if (actualizar_registro($query_nueva_foto)) {
                        $msj .= "<p>Imagen: " . $imagen . ", agregada con éxito</p>";
                    } else {
                        $msj .= "<p>Error al subir la imagen: " . $imagen . ", por favor intentar nuevamente.</p>";
                    }
                } else {
                    $msj .= "<p>La Imagen: " . $imagen . ", tiene un peso mayor al permitido: 2 megas</p>";
                }
            } else {
                $msj .= "<p>El Archivo: " . $imagen . ", no es de un formato permitido: jpg o png.<p>";
            }

            $ruta = "promocion.php?menu_lat=35";
            $boton = "Regresar";
            mensaje_generico($msj, $ruta, $boton);
        }
    } else {
        $query_contador = "SELECT * FROM contador WHERE id_contador = '1'";
        $contador = obtener_linea($query_contador);
        $activo_contador = $contador['activo_contador'];
        $nombre_contador = $contador['nombre_contador'];
        $texto_contador = $contador['texto_contador'];
        $fecha_contador = $contador['fecha_contador'];
        $hora_contador = $contador['hora_contador'];
        $foto_desk = $contador['foto_desk'];
        $foto_mobile = $contador['foto_mobile'];

        ?>
        <div class="titulo_prod">Cronómetro Inverso</div>
        <div class="formulario">
            <form enctype="multipart/form-data" action="promocion.php?menu_lat=35" method="post">
                <div class="linea">
                    <div class="titulo_lin">Nombre: </div>
                    <div class="dato_lin">
                        <input 
                            class="codigo" 
                            name="nombre_contador" 
                            type="text" 
                            value="<?php echo $nombre_contador ?>" 
                            required 
                        />
                    </div>
                </div>
                <div class="linea">
                    <div class="titulo_lin">Texto: </div>
                    <div class="dato_lin">
                        <input 
                            class="texto_cron" 
                            name="texto_contador" 
                            type="text" 
                            value="<?php echo $texto_contador ?>" 
                            required
                        />
                    </div>
                </div>
                <div class="linea">
                    <div class="titulo_lin">Cronómetro Activo: </div>
                    <div class="dato_lin"><input type="checkbox" value="1" name="activar" <?php
                    if ($activo_contador == 1) {
                        echo " checked ";
                    }
                    ?> />
                    </div>
                </div>
                <hr />
                <div class="linea">
                    <div class="titulo_lin">Fecha y Hora Final: </div>
                    <div class="dato_lin">
                        <input name="final_dt" type="date" value="<?php echo $fecha_contador ?>" required>
                        <input name="final_hr" type="time" value="<?php echo $hora_contador ?>" required>
                    </div>
                </div>
                <hr />

                <div class="linea">
                    <input type="hidden" name="accion" value="vamos" />
                    <button type="submit" class="btn_linea">Actualizar Cronómetro</button>
                </div>
            </form>
        </div>
        <hr><br><br><br><br>
        <div class="titulo_prod">Imagen Desktop (sólo formato .jpg permitido)</div>
        <div class="formulario">
            <form enctype="multipart/form-data" action="promocion.php?menu_lat=35" method="post">
                <div class="subtitulo"><input id="file_url" type="file" name="desktop_img"></div>
                <div class="imagen">
                    <img id="img_destino" src="../images/cuenta/<?php echo $foto_desk ?>" alt="Imagen">
                </div>
                <script>
                    function mostrarImagen(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            var valida = input.files[0].type;
                            if (valida == "image/jpeg") {
                                reader.onload = function(e) {
                                    $('#img_destino').attr('src', e.target.result);
                                    $('#img_destino').show("slow");
                                }
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                    $("#file_url").change(function() {
                        mostrarImagen(this);
                    });
                </script>
                <hr />

                <div class="linea">
                    <input type="hidden" name="accion" value="desktop" />
                    <button type="submit" class="btn_linea">
                        Actualizar Imagen Desktop (sólo formato .jpg permitido)
                    </button>
                </div>
            </form>
        </div>
        <hr><br><br><br><br>
        <div class="titulo_prod">Imagen Mobile (sólo formato .jpg permitido)</div>
        <div class="formulario">
            <form enctype="multipart/form-data" action="promocion.php?menu_lat=35" method="post">
                <div class="subtitulo"><input id="file_url_mob" type="file" name="mobile_img"></div>
                <div class="imagen">
                    <img id="img_destino_mob" src="../images/cuenta/<?php echo $foto_mobile ?>" alt="Imagen">
                </div>
                <script>
                    function mostrarImagenMobi(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            var valida = input.files[0].type;
                            if (valida == "image/jpeg") {
                                reader.onload = function(e) {
                                    $('#img_destino_mob').attr('src', e.target.result);
                                    $('#img_destino_mob').show("slow");
                                }
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                    $("#file_url_mob").change(function() {
                        mostrarImagenMobi(this);
                    });
                </script>
                <hr />

                <div class="linea">
                    <input type="hidden" name="accion" value="mobile" />
                    <button type="submit" class="btn_linea">
                        Actualizar Imagen Mobile (sólo formato .jpg permitido)
                    </button>
                </div>
            </form>
        </div>
        <?php
    }
}

function agregar_imagen_desktop($temporal, $imagen_type, $nombrerand, $dir_destino)
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
        if ($ancho_original > $max) {
            muygrande($manda, $ancho_original, $alto_original, $max, $original, $nombrerand, $imagen_type, $dir_destino);
        } else {
            estabien($ancho_original, $alto_original, $original, $nombrerand, $imagen_type, $dir_destino);
        }
    } elseif ($ancho_original < $alto_original) {
        $manda = "alto";
        if ($alto_original > $max) {
            muygrande($manda, $ancho_original, $alto_original, $max, $original, $nombrerand, $imagen_type, $dir_destino);
        } else {
            estabien($ancho_original, $alto_original, $original, $nombrerand, $imagen_type, $dir_destino);
        }
    } elseif ($ancho_original > $alto_original) {
        $manda = "ancho";
        if ($ancho_original > $max) {
            muygrande($manda, $ancho_original, $alto_original, $max, $original, $nombrerand, $imagen_type, $dir_destino);
        } else {
            estabien($ancho_original, $alto_original, $original, $nombrerand, $imagen_type, $dir_destino);
        }
    }
}

function agregar_imagen_mobile($temporal, $imagen_type, $nombrerand, $dir_destino)
{
    $max = 380;

    if ($imagen_type == 'image/jpeg') {
        $original = imagecreatefromjpeg($temporal);
    } elseif ($imagen_type == 'image/png') {
        $original = imagecreatefrompng($temporal);
    }

    $ancho_original = imagesx($original);
    $alto_original = imagesy($original);

    if ($ancho_original == $alto_original) {
        $manda = "iguales";
        if ($ancho_original > $max) {
            muygrande($manda, $ancho_original, $alto_original, $max, $original, $nombrerand, $imagen_type, $dir_destino);
        } else {
            estabien($ancho_original, $alto_original, $original, $nombrerand, $imagen_type, $dir_destino);
        }
    } elseif ($ancho_original < $alto_original) {
        $manda = "alto";
        if ($alto_original > $max) {
            muygrande($manda, $ancho_original, $alto_original, $max, $original, $nombrerand, $imagen_type, $dir_destino);
        } else {
            estabien($ancho_original, $alto_original, $original, $nombrerand, $imagen_type, $dir_destino);
        }
    } elseif ($ancho_original > $alto_original) {
        $manda = "ancho";
        if ($ancho_original > $max) {
            muygrande($manda, $ancho_original, $alto_original, $max, $original, $nombrerand, $imagen_type, $dir_destino);
        } else {
            estabien($ancho_original, $alto_original, $original, $nombrerand, $imagen_type, $dir_destino);
        }
    }
}
