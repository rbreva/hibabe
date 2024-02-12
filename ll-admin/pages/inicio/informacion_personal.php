<?php

function informacion_personal($config, $id_lat)
{
    $edit = "";
    $acc = "";

    if (isset($_GET["edit"])) {
        $edit = $_GET["edit"];
        if (isset($_GET["acc"])) {
            $acc = $_GET["acc"];
        }
    }

    $usuario = $_SESSION[$config['session']];
    $query_usuario = "SELECT * FROM users WHERE username = '$usuario'";
    $datos_usuario = obtener_linea($query_usuario);
    $nivel = $datos_usuario['level'];
    $query_nivel = "SELECT * FROM user_level WHERE id = $nivel";
    $nivel_usuario = obtener_linea($query_nivel);

    $titulo = "Información Personal";
    $btn_a_list = [];
    barra_titulo($titulo, $nivel, $btn_a_list);

    if ($acc == 'editar') {
        editar_informacion_personal($datos_usuario, $id_lat);
    } else {
        formulario_informacion_personal($datos_usuario, $nivel_usuario, $edit, $id_lat);
    }
}

function formulario_informacion_personal($datos_usuario, $nivel_usuario, $edit, $id_lat)
{
    $input_edit = '';
    if ($edit) {
        $input_edit = 'input';
        $link_action = "inicio.php?menu_lat=$id_lat&edit=$edit&acc=editar";
        $id_form = "form_editar_informacion_personal";
        form_header($link_action, $id_form);
    }
        item_form(
            'Usuario :',
            '',
            '',
            '',
            $datos_usuario['username'],
            '(El nombre de usuario es único, no puede modificarse)',
            ''
        );
        item_form(
            'Nombre :',
            $input_edit,
            'txt_name',
            'text',
            $datos_usuario['name'],
            '',
            'required'
        );
        item_form(
            'Apellidos :',
            $input_edit,
            'txt_lastname',
            'text',
            $datos_usuario['lastname'],
            '',
            'required'
        );
        item_form(
            'Email :',
            '',
            '',
            '',
            $datos_usuario['email'],
            '(El email es único y no puede modificarse)',
            ''
        );
        item_form(
            'Cargo :',
            $input_edit,
            'txt_type',
            'text',
            $datos_usuario['type'],
            '',
            'required'
        );
        item_form(
            'Categoría :',
            '',
            '',
            '',
            $nivel_usuario['name'],
            '',
            'required'
        );

    if ($edit) {
        item_form(
            'Password :',
            $input_edit,
            'pass_txt',
            'password',
            '',
            '',
            ''
        );
        item_form(
            'Repetir Password :',
            $input_edit,
            'rep_pass_txt',
            'password',
            '',
            '',
            ''
        );

        $btn_acc = "Editar Datos Personales";
        $btn01_link = "inicio.php?menu_lat=$id_lat";
        $btn_a_list = [[$btn01_link, "Regresar"]];
        botonera($btn_acc, $btn_a_list);
        ?>       
<script src="./js/form_personal_info.js"></script>
        <?php
    } else {
        $btn_acc = "";
        $id_user = $datos_usuario['id'];
        $btn01_link = "inicio.php?menu_lat=$id_lat&edit=$id_user";
        $btn_a_list = [[$btn01_link, "Editar Datos Personales"]];
        botonera($btn_acc, $btn_a_list);
    }
}

function editar_informacion_personal($datos_usuario, $id_lat)
{
    $txt_name = $_POST["txt_name"];
    $txt_lastname = $_POST["txt_lastname"];
    $txt_type = $_POST["txt_type"];
    $pass_txt = $_POST["pass_txt"];
    $rep_pass_txt = $_POST["rep_pass_txt"];
    $id = $datos_usuario['id'];

    if ($pass_txt == $rep_pass_txt) {
        $password = password_hash($pass_txt, PASSWORD_DEFAULT);
        $query = "UPDATE users SET 
          name = '$txt_name', 
          lastname = '$txt_lastname', 
          type = '$txt_type', 
          password = '$password' 
          WHERE 
          id = $id";
        $resultado = actualizar_registro($query);
        if ($resultado) {
            $msj = "Datos actualizados correctamente";
        } else {
            $msj = "Error al actualizar los datos";
        }
        $retorno = "inicio.php?menu_lat=$id_lat";

        retorno($retorno, $msj);
    }
}
