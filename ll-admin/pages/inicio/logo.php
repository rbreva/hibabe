<?php

function logo($config, $id_lat)
{
    $edit = "";

    if (isset($_GET["edit"])) {
        $edit = $_GET["edit"];
    }

    $usuario = $_SESSION[$config['session']];
    $query_usuario = "SELECT * FROM users WHERE username = '$usuario'";
    $datos_usuario = obtener_linea($query_usuario);
    $nivel = $datos_usuario['level'];

    $titulo = "Logo";
    $btn_a_list = [];
    barra_titulo($titulo, $nivel, $btn_a_list);

    if ($edit) {
        edit_logo($id_lat);
    } else {
        inicio_logo($id_lat);
    }
}

function edit_logo($id_lat)
{
    echo "edit_logo";
}

function inicio_logo($id_lat)
{
    $query_logo = "SELECT logo FROM store_config WHERE id = 1";
    $logo = obtener_linea($query_logo);

    $link_action = "inicio.php?menu_lat=$id_lat&edit=logo";
    $id_form = "form_editar_logo";
    form_header($link_action, $id_form);
    ?>
    <div class="item">
        <input 
          id="file_url" 
          type="file" 
          name="logosvg" 
          required 
        >
        <div class="file_msg"></div>
    </div>  
    <div class="imagen_logo">
        <img 
        id="img_destino" 
        src="../images/svg/logo/<?php echo $logo['logo'] ?>" 
        alt="Imagen" 
        >
    </div>
    <?php
    $btn_acc = "Actualizar logo";
    $btn_a_list = [];
    botonera($btn_acc, $btn_a_list);
    ?>
<script src="./js/validate_image.js"></script>
    <?php
}
