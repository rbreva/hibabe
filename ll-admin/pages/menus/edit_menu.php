<?php

function edit_menu($idmenedit)
{
    $txt_name = "";
    if (isset($_POST['txt_name'])) {
        $txt_name = $_POST['txt_name'];
    }
    if ($txt_name) {
        edit_menu_acc($txt_name, $idmenedit);
    } else {
        edit_menu_form($idmenedit);
    }
}

function edit_menu_form($idmenedit)
{
    $query_menu = "SELECT * FROM menus WHERE id = $idmenedit";
    $menu = obtener_linea($query_menu);
    $name = $menu["name"];

    ?>
    <div class="barra_titulo">
        <h2 class="titulo_h2">Editar Menú</h2>
    </div>
    <?php
    $link_action = "menus.php?acc=edit_menu&idmenedit=$idmenedit";
    $id_form = "form_edit_menu";
    form_header($link_action, $id_form);
    item_form(
        'Menú:',
        'input',
        'txt_name',
        'text',
        $name,
        '',
        'required'
    );
    $btn_acc = "Editar Menú";
    $btn01_link = "menus.php";
    $btn_a_list = [[$btn01_link, "Regresar"]];
    botonera($btn_acc, $btn_a_list);
    ?>       
<script src="./js/form_edit_menu.js"></script>
        <?php
}

function edit_menu_acc($txt_name, $idmenedit)
{
    $query = "UPDATE menus SET 
          name = '$txt_name'
          WHERE 
          id = $idmenedit";
          $resultado = actualizar_registro($query);
    if ($resultado) {
        $msj = "Menú: $txt_name editado correctamente";
    } else {
        $msj = "Error al crear menú";
    }
    $retorno = "menus.php";

    retorno($retorno, $msj);
}
