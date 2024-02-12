<?php

function marquesina_acc()
{
    ?>
    <div class="barra_titulo">
        <div class="titulo_sec">Mensajes Marquesina</div>
    </div>
    <?php
    $query = "SELECT * FROM texto_oferta";
    $obt = obtener_todo($query);
    $act = "";
    if (isset($_GET['act'])) {
        $act = $_GET['act'];
    }
    $descripcion = "";
    if (isset($_POST['descripcion'])) {
        $descripcion = $_POST['descripcion'];
    }
    $id_msj = "";
    if (isset($_POST['id_msj'])) {
        $id_msj = $_POST['id_msj'];
    }
    $activo_msj = "0";
    if (isset($_POST['activo_msj'])) {
        $activo_msj = "1";
    }
    if ($act) {
        if ($act == "des") {
            $activar = "UPDATE texto_oferta SET estado_textoferta = '0' WHERE id_textoferta = $id_msj";
            if (actualizar_registro($activar)) {
                $msj = "Marquesina Inactiva";
            } else {
                $msj = "Error en el Servidor, por favor intente de nuevo";
            }
        } elseif ($act == "act") {
            $activar = "UPDATE texto_oferta SET estado_textoferta = '1' WHERE id_textoferta = $id_msj";
            if (actualizar_registro($activar)) {
                $msj = "Marquesina Activa";
            } else {
                $msj = "Error en el Servidor, por favor intente de nuevo";
            }
        } elseif ($act == "actdes") {
            $activar = "UPDATE texto_oferta 
                SET 
                nombre_textoferta = '$descripcion', 
                estado_textoferta = '$activo_msj' 
                WHERE 
                id_textoferta = $id_msj";
            if (actualizar_registro($activar)) {
                $msj = "Marquesina Actualizada";
            } else {
                $msj = "Error en el Servidor, por favor intente de nuevo";
            }
        }
        $ruta = "promocion.php?menu_lat=8";
        $boton = "Regresar";
        mensaje_generico($msj, $ruta, $boton);
    } else {
        $i = 1;
        foreach ($obt as $row) {
            ?>
    <form class="marquesina_form" action="promocion.php?menu_lat=8&act=actdes" method="post">
        <div class="num"><?php echo $i; ?></div>
            <?php
            $checked = "";
            if ($row['estado_textoferta'] == 1) {
                $checked = "checked";
            }
            ?>
        <div class="activo">Activo: <input type="checkbox" name="activo_msj" <?php echo $checked ?>></div>
        <div class="desc">
            <input type="text" name="descripcion" value="<?php echo $row['nombre_textoferta'] ?>">
        </div>
        <div class="opciones">
            <input type="hidden" name="id_msj" value="<?php echo $row['id_textoferta'] ?>">
            <button type="submit" class="btn_linea">Actualizar Mensaje</button>
        </div>
    </form>
            <?php
            $i++;
        }
    }
}