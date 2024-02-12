<?php

function onlyyou()
{
    $sec = "act/des";
    if (isset($_GET["sec"])) {
        $sec = $_GET["sec"];
    }

    menu_lateral($sec);
    contenido_inicio($sec);
}

/*-----funciones-------------*/

function menu_lateral($sec)
{
    ?>
    <div class="lateralizq">
        <nav>
            <ul>
                <li class="item <?php if ($sec == "act/des") {
                                    echo 'seleccionado';
                                } ?>"><a href="promocion.php?menu_lat=36&sec=act/des">Activar/Desactivar</a></li>
                <li class="item <?php if ($sec == "background") {
                                    echo 'seleccionado';
                                } ?>"><a href="promocion.php?menu_lat=36&sec=background">Background</a></li>
                <li class="item <?php if ($sec == "background_mob") {
                                    echo 'seleccionado';
                                } ?>"><a href="promocion.php?menu_lat=36&sec=background_mob">Background Mobile</a></li>
                <li class="item <?php if ($sec == "password") {
                                    echo 'seleccionado';
                                } ?>"><a href="promocion.php?menu_lat=36&sec=password">Contraseña</a></li>
            </ul>
        </nav>
    </div>
    <?php
}

function contenido_inicio($sec)
{
    ?>
    <div class="contenido">
        <div class="titulo">Datos Generales - <?php echo $sec ?></div>
        <div class="cuadro">
            <?php
            if ($sec == "act/des") {
                actdes();
            }
            if ($sec == "background") {
                background();
            }
            if ($sec == "background_mob") {
                background_mob();
            }
            if ($sec == "password") {
                password();
            }
            ?>
        </div>
    </div>
    <?php
}

// funciones actdes

function actdes()
{

    $query_onlyyou = "SELECT * FROM onlyyou WHERE id = '1'";
    $data_onlyyou = obtener_linea($query_onlyyou);

    //echo "<pre>";
    //  print_r($data_onlyyou);
    //echo "</pre>";
    //
    $activo = $data_onlyyou['active'];
    //
    //echo "activo: ".$activo;

    $accion = "";

    ?>
    <div class="barra_titulo">
        <div class="titulo_sec">Only You - Activar/Desactivar</div>
    </div>
    <?php

    if (isset($_POST['accion_prender'])) {
        $accion = $_POST['accion_prender'];

        if ($accion == 'activar') {
            $query_prender = "UPDATE 
                onlyyou 
                SET 
                active = '1' 
                WHERE 
                id = '1'";
            actualizar_registro($query_prender);
            $msg = "Only You Activo";
        } elseif ($accion == 'desactivar') {
            $query_apagar = "UPDATE 
                onlyyou 
                SET 
                active = '0' 
                WHERE 
                id = '1'";
            actualizar_registro($query_apagar);
            $msg = "Only You Inactivo";
        }
        ?>
        <div class="msj_gen">
            <div class="msj"><?php echo $msg ?></div>
            <div class="btn_gen"><a href="promocion.php?menu_lat=36&sec=act/des">Regresar</a></div>
        </div>
        <?php
    } else {
        $actual_state = "Desactivado";
        $btn_state = "activar";
        if ($activo == 1) {
            $actual_state = "Activado";
            $btn_state = "desactivar";
        }
        ?>
        <div class="mensaje_onlyyou"> Only You se encuentra: <?php echo $actual_state ?></div>

        <div class="formulario">
            <form enctype="multipart/form-data" action="promocion.php?menu_lat=36&sec=act/des" method="post">
                <div class="precaucion">
                    <input type="hidden" name="accion_prender" value="<?php echo $btn_state ?>">
                    <button class="btn_precaucion"><?php echo $btn_state ?></button>
                </div>
            </form>
        </div>
        <?php
    }
}

// funciones BANNERS

function background()
{
    ?>
    <div class="barra_titulo">
        <div class="titulo_sec">Background Only you</div>
    </div>
    <div class="nota">
        El tamaño ideal del banner o modificar es de 2000*1125 px o proporcional,
        otros tamaños puede ocasionar descuadres inesperados
    </div>
    <?php
    edit_background();
}

function edit_background()
{

    $query_onlyyou = "SELECT * FROM onlyyou WHERE id = '1'";
    $data_onlyyou = obtener_linea($query_onlyyou);

    //echo "<pre>";
    //  print_r($data_onlyyou);
    //echo "</pre>";

    $imagen_banner = $data_onlyyou['bg_desk'];

    $editar = "";
    $msj = "";
    if (isset($_POST['editar'])) {
        $editar = $_POST['editar'];
        $imagen = trim($_FILES['nuevo_banner']['name']);
        if ($imagen) {
            $dir_destino = '../images/background/';
            $imagen = trim($_FILES['nuevo_banner']['name']);
            $temporal = $_FILES['nuevo_banner']['tmp_name'];
            $imagen_size = $_FILES['nuevo_banner']['size'];
            $imagen_type = $_FILES['nuevo_banner']['type'];
            if ($imagen_type == 'image/jpeg') {
                $nombre_tipo = '.jpg';
            } elseif ($imagen_type == 'image/png') {
                $nombre_tipo = '.png';
            }
            $nombrerand = time() . rand(0, 9) . rand(100, 9999) . rand(100, 9999) . rand(1000, 99999) . $nombre_tipo;
            if ($imagen_type == 'image/jpeg' || $imagen_type == 'image/png') {
                if ($imagen_size < 2000000) {
                    agregar_imagen_banner($temporal, $imagen_type, $nombrerand, $dir_destino);
                    $query_nueva_foto = "UPDATE onlyyou SET bg_desk='$nombrerand' WHERE id='1'";

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
        }
        $ruta = "promocion.php?menu_lat=36&sec=background";
        $boton = "Regresar";
        mensaje_generico($msj, $ruta, $boton);
    } else {
        ?>
        <div class="titulo_prod">Editar Background</div>
        <form action="promocion.php?menu_lat=36&sec=background" method="post" enctype="multipart/form-data">
            <div class="banner">
                <div class="subtitulo"><input id="file_url" type="file" name="nuevo_banner"></div>
                <div class="imagen">
                    <img id="img_destino" src="../images/background/<?php echo $imagen_banner ?>" alt="Imagen">
                </div>
                <div class="imagen">
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
                                    $('#videoban').hide("slow");
                                }
                            } else if (valida == "video/mp4") {
                                reader.onload = function(e) {
                                    $('#videoban').attr('src', e.target.result);
                                    $('#img_destino').hide("slow");
                                    $('#videoban').show("slow");
                                }
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                    $("#file_url").change(function() {
                        mostrarImagen(this);
                    });
                </script>
                <div class="botonera">
                    <input name="editar" value="editar" type="hidden">
                    <input class="crear" type="submit" value="Editar Background">
                    <a href="promocion.php?menu_lat=36&sec=background" class="boton">Regresar</a>
                </div>
            </div>
        </form>
        <?php
    }
}

// funciones BANNERS_MOB

function background_mob()
{
    ?>
    <div class="barra_titulo">
        <div class="titulo_sec">Background Mobile Only you</div>
    </div>
    <div class="nota">
        El tamaño ideal del banner o modificar es de 800*1400 px o proporcional,
        otros tamaños puede ocasionar descuadres inesperados
    </div>
    <?php
    edit_background_mob();
}

function edit_background_mob()
{

    $query_onlyyou = "SELECT * FROM onlyyou WHERE id = '1'";
    $data_onlyyou = obtener_linea($query_onlyyou);

    //echo "<pre>";
    //  print_r($data_onlyyou);
    //echo "</pre>";

    $imagen_banner = $data_onlyyou['bg_mob'];

    $editar = "";
    $msj = "";
    if (isset($_POST['editar'])) {
        $editar = $_POST['editar'];
        $imagen = trim($_FILES['nuevo_banner']['name']);
        if ($imagen) {
            $dir_destino = '../images/background/';
            $imagen = trim($_FILES['nuevo_banner']['name']);
            $temporal = $_FILES['nuevo_banner']['tmp_name'];
            $imagen_size = $_FILES['nuevo_banner']['size'];
            $imagen_type = $_FILES['nuevo_banner']['type'];
            if ($imagen_type == 'image/jpeg') {
                $nombre_tipo = '.jpg';
            } elseif ($imagen_type == 'image/png') {
                $nombre_tipo = '.png';
            }
            $nombrerand = time() . rand(0, 9) . rand(100, 9999) . rand(100, 9999) . rand(1000, 99999) . $nombre_tipo;
            if ($imagen_type == 'image/jpeg' || $imagen_type == 'image/png') {
                if ($imagen_size < 2000000) {
                    agregar_imagen_banner($temporal, $imagen_type, $nombrerand, $dir_destino);
                    $query_nueva_foto = "UPDATE 
                        onlyyou 
                        SET 
                        bg_mob='$nombrerand' 
                        WHERE 
                        id='1'";

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
        }
        $ruta = "promocion.php?menu_lat=36&sec=background_mob";
        $boton = "Regresar";
        mensaje_generico($msj, $ruta, $boton);
    } else {
        ?>
        <div class="titulo_prod">Editar Background</div>
        <form action="promocion.php?menu_lat=36&sec=background_mob" method="post" enctype="multipart/form-data">
            <div class="banner">
                <div class="subtitulo"><input id="file_url" type="file" name="nuevo_banner"></div>
                <div class="imagen">
                    <img id="img_destino" src="../images/background/<?php echo $imagen_banner ?>" alt="Imagen">
                </div>
                <div class="imagen">
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
                                    $('#videoban').hide("slow");
                                }
                            } else if (valida == "video/mp4") {
                                reader.onload = function(e) {
                                    $('#videoban').attr('src', e.target.result);
                                    $('#img_destino').hide("slow");
                                    $('#videoban').show("slow");
                                }
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                    $("#file_url").change(function() {
                        mostrarImagen(this);
                    });
                </script>
                <div class="botonera">
                    <input name="editar" value="editar" type="hidden">
                    <input class="crear" type="submit" value="Editar Background Mobile">
                    <a href="promocion.php?menu_lat=36&sec=background_mob" class="boton">Regresar</a>
                </div>
            </div>
        </form>
        <?php
    }
}

// funciones actdes

function password()
{

    $query_onlyyou = "SELECT * FROM onlyyou WHERE id = '1'";
    $data_onlyyou = obtener_linea($query_onlyyou);

    //echo "<pre>";
    //  print_r($data_onlyyou);
    //echo "</pre>";

    $password = $data_onlyyou['pass'];
    //
    //echo "activo: ".$activo;

    $accion = "";

    ?>
    <div class="barra_titulo">
        <div class="titulo_sec">Only You - Password</div>
    </div>
    <?php

    if (isset($_POST['accion_cambiar'])) {
        $accion = $_POST['accion_cambiar'];
        $newpass = $_POST['new_password'];

        if ($accion == 'nueva') {
            $query_prender = "UPDATE onlyyou SET pass = '$newpass' WHERE id = '1'";
            actualizar_registro($query_prender);
            $msg = "Password Actualizado";
        }
        ?>
        <div class="msj_gen">
            <div class="msj"><?php echo $msg ?></div>
            <div class="btn_gen"><a href="promocion.php?menu_lat=36&sec=password">Regresar</a></div>
        </div>
        <?php
    } else {
        ?>
        <div class="mensaje_onlyyou"> Contraseña Actual: <?php echo $password ?></div>

        <div class="formulario">
            <form enctype="multipart/form-data" action="promocion.php?menu_lat=36&sec=password" method="post">
                <div class="precaucion">
                    <label>Password Activa: </label>
                    <input type="text" name="new_password" value="<?php echo $password ?>"><br><br>
                    <input type="hidden" name="accion_cambiar" value="nueva">
                    <button class="btn_precaucion">Actualizar Contraseña</button>
                </div>
            </form>
        </div>
        <?php
    }
}

//-----CREA IMAGEN

function agregar_imagen_banner($temporal, $imagen_type, $nombrerand, $dir_destino)
{
    $max = 2000;

    //abrir la foto original

    if ($imagen_type == 'image/jpeg') {
        $original = imagecreatefromjpeg($temporal);
    } elseif ($imagen_type == 'image/png') {
        $original = imagecreatefrompng($temporal);
    }

    $ancho_original = imagesx($original);
    $alto_original = imagesy($original);

    //echo $ancho_original."<br>";
    //echo $alto_original."<br>";

    if ($ancho_original == $alto_original) {
        $manda = "iguales";
        //    echo $manda."<br>";
        if ($ancho_original > $max) {
            muygrande($manda, $ancho_original, $alto_original, $max, $original, $nombrerand, $imagen_type, $dir_destino);
        } else {
            estabien($ancho_original, $alto_original, $original, $nombrerand, $imagen_type, $dir_destino);
        }
    } elseif ($ancho_original < $alto_original) {
        $manda = "alto";
        //    echo $manda."<br>";
        if ($alto_original > $max) {
            muygrande($manda, $ancho_original, $alto_original, $max, $original, $nombrerand, $imagen_type, $dir_destino);
        } else {
            estabien($ancho_original, $alto_original, $original, $nombrerand, $imagen_type, $dir_destino);
        }
    } elseif ($ancho_original > $alto_original) {
        $manda = "ancho";
        //    echo $manda."<br>";
        if ($ancho_original > $max) {
            muygrande($manda, $ancho_original, $alto_original, $max, $original, $nombrerand, $imagen_type, $dir_destino);
        } else {
            estabien($ancho_original, $alto_original, $original, $nombrerand, $imagen_type, $dir_destino);
        }
    }
}
