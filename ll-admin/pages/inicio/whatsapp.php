<?php

function whatsapp($config, $id_lat)
{
    $edit = "";

    if (isset($_GET["edit"])) {
        $edit = $_GET["edit"];
    }

    $usuario = $_SESSION[$config['session']];
    $query_usuario = "SELECT * FROM users WHERE username = '$usuario'";
    $datos_usuario = obtener_linea($query_usuario);
    $nivel = $datos_usuario['level'];

    $titulo = "WhatsApp";
    $btn_a_list = [];
    barra_titulo($titulo, $nivel, $btn_a_list);

    if ($edit) {
        edit_whatsapp($id_lat);
    } else {
        inicio_whatsapp($id_lat);
    }
}

function inicio_whatsapp($id_lat)
{
    $query_whatsapp = "SELECT * FROM whatsapp WHERE id = 1";
    $whatsapp = obtener_linea($query_whatsapp);
    $active = $whatsapp['active'];
    $numero = $whatsapp['numero'];
    $link = $whatsapp['link'];
    $anuncio = $whatsapp['anuncio'];
    $check = "";
    if ($active == 1) {
        $check = "checked";
    }

    $link_action = "inicio.php?menu_lat=$id_lat&edit=whatsapp";
    $id_form = "form_editar_whatsapp";
    form_header($link_action, $id_form);
    item_form(
        'Activo :',
        'input',
        'chk_whatsapp',
        'checkbox',
        $check,
        '',
        'required'
    );
    item_form(
        'Número Whatsapp :',
        'input',
        'numero_wsp',
        'number',
        $numero,
        '',
        'required'
    );
    item_form(
        'Url :',
        '',
        '',
        '',
        $link,
        '',
        'disabled'
    );
    item_form(
        'Mensaje :',
        'input',
        'descripcion_wsp',
        'text',
        $anuncio,
        '',
        'required'
    );
    $btn_acc = "Modificar Whatsapp";
    $btn_a_list = [];
    botonera($btn_acc, $btn_a_list);
    ?>
<script src="./js/form_whatsapp.js"></script>
    <?php
}

function edit_whatsapp($id_lat)
{
    $chk_whatsapp = 0;
    if (isset($_POST['chk_whatsapp'])) {
        $chk_whatsapp = $_POST['chk_whatsapp'];
        if ($chk_whatsapp == 'on') {
            $chk_whatsapp = 1;
        }
    }
    $numero_wsp = $_POST['numero_wsp'];
    $descripcion_wsp = $_POST['descripcion_wsp'];
    $query = "UPDATE whatsapp SET 
      active = $chk_whatsapp, 
      numero = $numero_wsp, 
      anuncio = '$descripcion_wsp' 
      WHERE id = 1";
    $resultado = actualizar_registro($query);
    if ($resultado) {
        $msj = "Datos actualizados correctamente";
    } else {
        $msj = "Error al actualizar los datos";
    }
    $retorno = "inicio.php?menu_lat=$id_lat";

    retorno($retorno, $msj);
}
