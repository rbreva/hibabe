<?php

function create_menu()
{
    $txt_name = "";
    if (isset($_POST['txt_name'])) {
        $txt_name = $_POST['txt_name'];
    }
    if ($txt_name) {
        create_menu_accion($txt_name);
    } else {
        create_menu_form();
    }
}

function create_menu_form()
{
    ?>
    <div class="barra_titulo">
        <h2 class="titulo_h2">Crear Menú</h2>
    </div>
    <?php
    $link_action = "menus.php?acc=create_menu";
    $id_form = "form_create_menu";
    form_header($link_action, $id_form);
    item_form(
        'Menú:',
        'input',
        'txt_name',
        'text',
        '',
        '',
        'required'
    );
    $btn_acc = "Agregar Nuevo Menú";
    $btn01_link = "menus.php";
    $btn_a_list = [[$btn01_link, "Regresar"]];
    botonera($btn_acc, $btn_a_list);
    ?>       
<script src="./js/form_create_menu.js"></script>
        <?php
}

function create_menu_accion($txt_name)
{
    $query = "INSERT INTO menus ( 
          name
          ) VALUE (
          '$txt_name')";
          $resultado = actualizar_registro($query);
    if ($resultado) {
        $msj = "Menú: $txt_name creado correctamente";
    } else {
        $msj = "Error al crear menú";
    }
          $retorno = "menus.php";

          retorno($retorno, $msj);
}
