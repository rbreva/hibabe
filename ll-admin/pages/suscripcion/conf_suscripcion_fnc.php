<?php

function conf_suscriptores()
{
    $editar_conf = "";
    if (isset($_POST['editar_conf'])) {
        $editar_conf = $_POST['editar_conf'];
    }
    if ($editar_conf) {
        $check_act = 0;
        if (isset($_POST['check_act'])) {
            $check_act = 1;
        }
        $porce_new = $_POST['porce_new'];
        $meses_new = $_POST['meses_new'];
        $query_susconf = "UPDATE modal SET 
            estado_modal='$check_act ', 
            porcentaje_modal='$porce_new ', 
            meses_modal='$meses_new' 
            WHERE 
            id_modal='1'";
        if (actualizar_registro($query_susconf)) {
            $msj = "Suscripción Actualizada";
        } else {
            $msj = "Error en el Servidor, por favor intente de nuevo";
        }
        $ruta = "suscripcion.php?menu_lat=34";
        $boton = "Regresar";
        mensaje_generico($msj, $ruta, $boton);
    } else {
        $query_modal = "SELECT * FROM modal WHERE id_modal='1'";
        $modal = obtener_linea($query_modal);
        $estado_modal = $modal['estado_modal'];
        ?>
<div class="barra_titulo">
    <h2 class="titulo_h2">Configurar Suscripción</h2>
</div>
        <?php
        $activo = "";
        if ($estado_modal == 1) {
            $activo = "checked";
        }
        ?>
<div class="cuadro">
    <form class="suscripcion_form" action="suscripcion.php?menu_lat=34" enctype="multipart/form-data" method="post">
        <div class="linea_form">
            <label for="porcentaje">Activo: </label>
            <input id="chkactivo" type="checkbox" name="check_act" <?php echo $activo ?> />
        </div>
        <div class="linea_form">
            <label for="porcentaje">Porcentaje: </label>
            <input id="porcentaje" type="number" min="1" max="99" name="porce_new" value="<?php echo $modal['porcentaje_modal'] ?>" required />
        </div>
        <div class="linea_form">
            <label for="meses">Dias Activo: </label>
            <input id="meses" type="number" min="1" name="meses_new" value="<?php echo $modal['meses_modal'] ?>" required />
        </div>
        <div class="botonera">
            <input type="hidden" name="editar_conf" value="susconf" />
            <button class="acc_btn" type="submit">Actualizar Suscripción</button>
        </div>
    </form>
</div>
        <?php
    }
}
