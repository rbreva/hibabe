<?php

function etiquetas_acc($config)
{
    $usuario = $_SESSION[$config['session']];
    $query_usuario = "SELECT * FROM users WHERE username = '$usuario'";
    $datos_usuario = obtener_linea($query_usuario);
    $nivel = $datos_usuario['level'];
    ?>
    <div class="barra_titulo">
        <h2 class="titulo_h2">Etiquetas</h2>
        <div class="botones_prod">
            <?php
            if ($nivel == 1 || $nivel == 2) {
                ?>
                <a href="promocion.php?menu_lat=32&acc=nuevoetiqueta" class="nuevo_btn">
                    Agregar etiqueta
                </a>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="cuadro">
        <?php
        if (isset($_GET['acc'])) {
            $opcion = $_GET['acc'];
            if ($opcion == "nuevoetiqueta") {
                nueva_etiqueta();
            }
            if ($opcion == "suspenderetiqueta") {
                suspender_etiqueta();
            }
            if ($opcion == "activaretiqueta") {
                activar_etiqueta();
            }
            if ($opcion == "borraretiqueta") {
                borrar_etiqueta();
            }
            if ($opcion == "editaretiqueta") {
                editar_etiqueta();
            }
        } else {
            $query_etiquetas = "SELECT * FROM etiquetas";
            $etiquetas = obtener_todo($query_etiquetas);
            listaretiquetas($etiquetas);
        }
        ?>
    </div>
    <?php
}

function listaretiquetas($etiquetas)
{
    ?>
    <div class="titulo_prod">Lista de Etiquetas</div>
    <?php
    if ($etiquetas) {
        foreach ($etiquetas as $row) {
            $id_etiqueta = $row['id_etiqueta'];
            $texto_etiqueta = $row['texto_etiqueta'];
            $estado_etiqueta = $row['estado_etiqueta'];
            ?>
            <div class='etiqueta_linea'>
                <div class="etiqueta_nombre"><?php echo $texto_etiqueta; ?></div>
                <div class="etiqueta_acciones">
                    <?php
                    $accion_etiqueta = "Activar";
                    $acc_etiqueta = "activaretiqueta";
                    if ($estado_etiqueta == 1) {
                        $accion_etiqueta = "Suspender";
                        $acc_etiqueta = "suspenderetiqueta";
                    }
                    ?>
                    <a class="btn_etiqueta" href='promocion.php?menu_lat=32&acc=<?php echo $acc_etiqueta ?>&id=<?php echo $id_etiqueta ?>'>
                        <?php echo $accion_etiqueta ?>
                    </a>
                    <a class="btn_etiqueta" href='promocion.php?menu_lat=32&acc=editaretiqueta&id=<?php echo $id_etiqueta ?>'>Editar</a>
                    <a class="btn_etiqueta" href='promocion.php?menu_lat=32&acc=borraretiqueta&id=<?php echo $id_etiqueta ?>'>Eliminar</a>
                </div>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="sindatos">No se registran Etiquetas</div>
        <?php
    }
}

function nueva_etiqueta()
{
    if (isset($_POST['nombre_etiqueta'])) {
        $etiqueta = $_POST['nombre_etiqueta'];
        $url_eti = $_POST['url_etiqueta'];
        $query_agregar_seccion = "INSERT INTO 
            etiquetas (
            texto_etiqueta,
            url_etiqueta
            ) VALUES (
            '$etiqueta',
            '$url_eti')
            ";
        if (actualizar_registro($query_agregar_seccion)) {
            $msj = "Etiqueta Agregada";
        } else {
            $msj = "Error en el servidor intente nuevamente por favor";
        }
        $ruta = "promocion.php?menu_lat=32";
        $boton = "Regresar";
        mensaje_generico($msj, $ruta, $boton);
    } else {
        ?>
        <div class="titulo_prod">Agregar Etiqueta</div>
        <form class="etiqueta_form" action="promocion.php?menu_lat=32&acc=nuevoetiqueta" method="post" enctype="multipart/form-data">
            <div class="etiqueta_dato">
                <label for="nombre_etiqueta">Texto Etiqueta: </label>
                <input id="nombre_etiqueta" name="nombre_etiqueta" type="text" value="" required>
            </div>
            <div class="etiqueta_dato">
                <label for="url_etiqueta">Link Etiqueta: </label>
                <input id="url_etiqueta" name="url_etiqueta" type="text" value="" required>
            </div>
            <div class="botonera">
                <button class="acc_btn" type="submit">Agregar Etiqueta</button>
                <a class="btn_a" href="promocion.php?menu_lat=32">Volver</a>
            </div>
        </form>
        <?php
    }
}

function editar_etiqueta()
{
    $id_eti = $_GET['id'];
    $query_etiqueta = "SELECT * FROM etiquetas WHERE id_etiqueta = $id_eti";
    $etiqueta = obtener_linea($query_etiqueta);
    $nombre_etiqueta = $etiqueta['texto_etiqueta'];
    $url_etiqueta = $etiqueta['url_etiqueta'];

    if (isset($_POST['nombre_etiqueta'])) {
        $etiqueta_new = $_POST['nombre_etiqueta'];
        $url_etiqueta_new = $_POST['url_etiqueta'];

        $query_editar_etiqueta = "UPDATE 
            etiquetas 
            SET
            texto_etiqueta ='$etiqueta_new',
            url_etiqueta = '$url_etiqueta_new'
            WHERE
            id_etiqueta = $id_eti
            ";
        if (actualizar_registro($query_editar_etiqueta)) {
            $msj = "Etiqueta Editada con éxito";
        } else {
            $msj = "Error en el servidor intente nuevamente por favor";
        }
        $ruta = "promocion.php?menu_lat=32";
        $boton = "Regresar";
        mensaje_generico($msj, $ruta, $boton);
    } else {
        ?>
        <div class="titulo_prod">Editar Etiqueta</div>
        <form class="etiqueta_form" action="promocion.php?menu_lat=32&acc=editaretiqueta&id=<?php echo $id_eti ?>" method="post" enctype="multipart/form-data">
            <div class="etiqueta_dato">
                <label for="nombre_etiqueta">Texto Etiqueta: </label>
                <input id="nombre_etiqueta" name="nombre_etiqueta" type="text" value="<?php echo $nombre_etiqueta ?>" required>
            </div>
            <div class="etiqueta_dato">
                <label for="url_etiqueta">Link Etiqueta: </label>
                <input id="url_etiqueta" name="url_etiqueta" type="text" value="<?php echo $url_etiqueta ?>" required>
            </div>
            <div class="botonera">
                <button class="acc_btn" type="submit">Editar Etiqueta</button>
                <a class="btn_a" href="promocion.php?menu_lat=32">Volver</a>
            </div>
        </form>
        <?php
    }
}

function borrar_etiqueta()
{
    $id_eti = $_GET['id'];
    $query_etiqueta = "SELECT * FROM etiquetas WHERE id_etiqueta = $id_eti";
    $etiqueta = obtener_linea($query_etiqueta);
    $nombre_etiqueta = $etiqueta['texto_etiqueta'];

    if (isset($_GET['conf'])) {
        $query_borrar_menu = "DELETE FROM etiquetas WHERE id_etiqueta = $id_eti";
        if (actualizar_registro($query_borrar_menu)) {
            $msj = "Etiqueta eliminada con éxito";
        } else {
            $msj = "Error en el servidor intente nuevamente por favor";
        }
        $ruta = "promocion.php?menu_lat=32";
        $boton = "Regresar";
        mensaje_generico($msj, $ruta, $boton);
    } else {
        ?>
        <div class="del_conf">
            <div class="del_msj">¿Desea eliminar la Etiqueta "<?php echo $nombre_etiqueta ?>"?</div>
            <div class="linea">
                <a href="promocion.php?menu_lat=32" class="retorno_btn">Regresar</a>
                <a href="promocion.php?menu_lat=32&acc=borraretiqueta&id=<?php echo $id_eti ?>&conf=borralo" class="del_btn">Si, ELIMINAR Etiqueta</a>
            </div>
        </div>
        <?php
    }
}

function suspender_etiqueta()
{
    $id_eti = $_GET['id'];
    $query_etiqueta = "SELECT * FROM etiquetas WHERE id_etiqueta = $id_eti";
    $etiqueta = obtener_linea($query_etiqueta);
    $nombre_etiqueta = $etiqueta['texto_etiqueta'];

    if (isset($_GET['conf'])) {
        $query_suspender_subcategoria = "UPDATE etiquetas SET estado_etiqueta = 0 WHERE id_etiqueta = '$id_eti'";
        if (actualizar_registro($query_suspender_subcategoria)) {
            $msj = "Etiqueta suspendida";
        } else {
            $msj = "Error en el servidor intente nuevamente por favor";
        }
        $ruta = "promocion.php?menu_lat=32";
        $boton = "Regresar";
        mensaje_generico($msj, $ruta, $boton);
    } else {
        ?>
        <div class="del_conf">
            <div class="del_msj">¿Desea Suspender la Etiqueta "<?php echo $nombre_etiqueta ?>"?</div>
            <div class="linea">
                <a href="promocion.php?menu_lat=32" class="retorno_btn">Regresar</a>
                <a href="promocion.php?menu_lat=32&acc=suspenderetiqueta&id=<?php echo $id_eti ?>&conf=suspendelo" class="del_btn">Si, Suspender Etiqueta</a>
            </div>
        </div>
        <?php
    }
}

function activar_etiqueta()
{
    $id_eti = $_GET['id'];
    $query_etiqueta = "SELECT * FROM etiquetas WHERE id_etiqueta = $id_eti";
    $etiqueta = obtener_linea($query_etiqueta);
    $nombre_etiqueta = $etiqueta['texto_etiqueta'];

    if (isset($_GET['conf'])) {
        $query_activar_subcategoria = "UPDATE etiquetas SET estado_etiqueta = 1 WHERE id_etiqueta = '$id_eti'";
        if (actualizar_registro($query_activar_subcategoria)) {
            $msj = "Etiqueta Activada";
        } else {
            $msj = "Error en el servidor intente nuevamente por favor";
        }
        $ruta = "promocion.php?menu_lat=32";
        $boton = "Regresar";
        mensaje_generico($msj, $ruta, $boton);
    } else {
        ?>
        <div class="del_conf">
            <div class="del_msj">¿Desea Activar la Etiqueta "<?php echo $nombre_etiqueta ?>"?</div>
            <div class="linea">
                <a href="promocion.php?menu_lat=32" class="retorno_btn">Regresar</a>
                <a href="promocion.php?menu_lat=32&acc=activaretiqueta&id=<?php echo $id_eti ?>&conf=activalo" class="del_btn">Si, Activar Etiqueta</a>
            </div>
        </div>
        <?php
    }
}
