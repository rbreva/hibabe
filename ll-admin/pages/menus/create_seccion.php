<?php

function create_seccion($menu)
{
    $id_menu = $menu["id"];

    $txt_name = "";
    if (isset($_POST['txt_name'])) {
        $txt_name = $_POST['txt_name'];
    }
    if ($txt_name) {
        create_seccion_accion($txt_name, $id_menu);
    } else {
        crear_seccion_form($menu);
    }
}

function crear_seccion_form($menu)
{
    $id_menu = $menu["id"];
    $nombre_menu = $menu["name"];
    ?>
    <div class="barra_titulo">
        <h2 class="titulo_h2">Crear Sección en: <?php echo $nombre_menu ?></h2>
    </div>
    <?php
    $link_action = "menus.php?id=$id_menu&acc=create_seccion";
    $id_form = "form_crear_seccion";
    form_header($link_action, $id_form);
    item_form(
        'Sección:',
        'input',
        'txt_name',
        'text',
        '',
        '',
        'required'
    );
    $btn_acc = "Agregar Nueva Sección";
    $btn01_link = "menus.php?id=$id_menu";
    $btn_a_list = [[$btn01_link, "Regresar"]];
    botonera($btn_acc, $btn_a_list);
    ?>       
<script src="./js/form_crear_seccion.js"></script>
        <?php
}

function create_seccion_accion($txt_name, $id_menu)
{
    $query_seccion = "INSERT INTO secciones ( 
          name
          ) VALUE (
          '$txt_name')";
          $resultado = actualizar_registro($query_seccion);
    if ($resultado) {
        $query_last = "SELECT id FROM secciones ORDER BY id DESC LIMIT 1";
        $last_id_data = obtener_linea($query_last);
        $last_id = $last_id_data["id"];
        $query_menu_seccion = "INSERT INTO menu_seccion ( 
            menu_id,
            seccion_id
            ) VALUE (
            '$id_menu',
            '$last_id')";
            $resultado_menu_seccion = actualizar_registro($query_menu_seccion);
        if ($resultado_menu_seccion) {
            $msj = "Sección: $txt_name creada correctamente";
        } else {
                  $msj = "Error al crear sección";
        }
    } else {
        $msj = "Error al crear sección";
    }
          $retorno = "menus.php?id=$id_menu";

          retorno($retorno, $msj);
}
