<?php

function delete_menu($idmendel)
{
    $accdel = "";
    if (isset($_GET['accdel'])) {
        $accdel = $_GET['accdel'];
    }

    if ($accdel) {
        $query = "DELETE FROM menus WHERE id = $idmendel";
        $resultado = actualizar_registro($query);
        if ($resultado) {
            $msj = "Menú eliminado correctamente";
        } else {
            $msj = "Error al actualizar los datos";
        }
        $retorno = "menus.php";

        retorno($retorno, $msj);
    } else {
        $query_comp = "SELECT * FROM menu_seccion WHERE menu_id = $idmendel";
        $datos_comp = obtener_todo($query_comp);

        $query_menu = "SELECT * FROM menus WHERE id = $idmendel";
        $datos_menu = obtener_linea($query_menu);
        $menu = $datos_menu['name'];

        if ($datos_comp) {
            $msj = "El menu $menu NO se puede eliminar porque tiene secciones";
        } else {
            $msj = "Se va a eliminar el Menú: $menu";
        }
        ?>
        <div class="del_conf">
            <div class="del_msj"><?php echo $msj ?></div>
            <?php
            if (!$datos_comp) {
                ?>
                <a href="menus.php?acc=del_menu&idmendel=<?php echo $idmendel ?>&accdel=delete" class="del_btn btn-danger">Eliminar</a>
                <?php
            }
            ?>
            <a href="menus.php" class="del_reg">Regresar</a>
        </div>
        <?php
    }
}
