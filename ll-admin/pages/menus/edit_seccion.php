<?php

function edit_seccion($menu, $idsecedit)
{
    $txt_name = "";
    if (isset($_POST['txt_name'])) {
        $txt_name = $_POST['txt_name'];
    }
    if ($txt_name) {
        edit_seccion_accion($txt_name, $menu, $idsecedit);
    } else {
        edit_seccion_form($menu, $idsecedit);
    }
}

function edit_seccion_form($menu, $idsecedit)
{
    $query_seccion = "SELECT * FROM secciones WHERE id = $idsecedit";
    $seccion = obtener_linea($query_seccion);
    $name_seccion = $seccion["name"];
    $id_menu = $menu["id"];
    $name_menu = $menu["name"];

    ?>
    <div class="barra_titulo">
        <h2 class="titulo_h2">Editar Menú/Sección: <?php echo $name_menu . "/" . $name_seccion ?></h2>
    </div>
    <?php
    $link_action = "menus.php?id=$id_menu&acc=edit_seccion&idsecedit=$idsecedit";
    $id_form = "form_editar_seccion";
    form_header($link_action, $id_form);
    item_form(
        'Sección:',
        'input',
        'txt_name',
        'text',
        $name_seccion,
        '',
        'required'
    );
    $btn_acc = "Editar Sección";
    $btn01_link = "menus.php?id=$id_menu";
    $btn_a_list = [[$btn01_link, "Regresar"]];
    botonera($btn_acc, $btn_a_list);
    ?>       
<script src="./js/form_editar_seccion.js"></script>
        <?php
}

function edit_seccion_accion($txt_name, $menu, $idsecedit)
{
    $id_menu = $menu["id"];
    $query = "UPDATE secciones SET 
          name = '$txt_name'
          WHERE 
          id = $idsecedit";
          $resultado = actualizar_registro($query);
    if ($resultado) {
        $msj = "Sección: $txt_name editada correctamente";
    } else {
        $msj = "Error al editar sección";
    }
    $retorno = "menus.php?id=$id_menu";

    retorno($retorno, $msj);
}
