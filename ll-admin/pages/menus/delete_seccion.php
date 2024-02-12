<?php

function delete_seccion($id_menu, $idsecdel)
{
    $accdel = "";
    if (isset($_GET['accdel'])) {
        $accdel = $_GET['accdel'];
    }

    if ($accdel) {
        $query_menu = "DELETE FROM menu_seccion WHERE seccion_id = $idsecdel";
        $query_seccion = "DELETE FROM secciones WHERE id = $idsecdel";
        $resultado_menu = actualizar_registro($query_menu);
        if ($resultado_menu) {
            $resultado_seccion = actualizar_registro($query_seccion);
            if ($resultado_seccion) {
                $msj = "Sección eliminada correctamente";
            } else {
                $msj = "Error al actualizar los datos";
            }
        } else {
            $msj = "Error al actualizar los datos";
        }
        $retorno = "menus.php?id=$id_menu";

        retorno($retorno, $msj);
    } else {
        $query_comp = "SELECT * FROM seccion_producto WHERE seccion_id = $idsecdel";
        $datos_comp = obtener_todo($query_comp);

        $query_seccion = "SELECT * FROM secciones WHERE id = $idsecdel";
        $datos_seccion = obtener_linea($query_seccion);
        $nombre_seccion = $datos_seccion['name'];

        if ($datos_comp) {
            $msj = "La seccion $nombre_seccion NO se puede eliminar porque tiene secciones";
        } else {
            $msj = "Se va a eliminar la Sección: $nombre_seccion";
        }
        ?>
        <div class="del_conf">
            <div class="del_msj"><?php echo $msj ?></div>
            <?php
            if (!$datos_comp) {
                ?>
                <a 
                href="menus.php?id=<?php echo $id_menu ?>&acc=del_seccion&idsecdel=<?php echo $idsecdel ?>&accdel=delete" 
                class="del_btn btn-danger"
                >Eliminar</a>
                <?php
            }
            ?>
            <a href="menus.php?id=<?php echo $id_menu ?>" class="del_reg">Regresar</a>
        </div>
        <?php
    }
}
