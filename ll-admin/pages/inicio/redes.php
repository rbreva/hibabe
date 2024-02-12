<?php

function redes($config, $id_lat)
{
    $edit = "";
    $sus = "";
    $act = "";

    if (isset($_GET["edit"])) {
        $edit = $_GET["edit"];
    }
    if (isset($_GET["sus"])) {
        $sus = $_GET["sus"];
    }
    if (isset($_GET["act"])) {
        $act = $_GET["act"];
    }

    $usuario = $_SESSION[$config['session']];
    $query_usuario = "SELECT * FROM users WHERE username = '$usuario'";
    $datos_usuario = obtener_linea($query_usuario);
    $nivel = $datos_usuario['level'];

    $titulo = "Redes";
    $btn_a_list = [];
    barra_titulo($titulo, $nivel, $btn_a_list);

    if ($edit) {
        edit_red($edit, $id_lat);
    } elseif ($sus) {
        suspender_red($sus, $id_lat);
    } elseif ($act) {
        activar_red($act, $id_lat);
    } else {
        lista_redes($id_lat);
    }
}

function lista_redes($id_lat)
{
    $query_redes = "SELECT * FROM redes";
    $redes = obtener_todo($query_redes);
    if ($redes) {
        foreach ($redes as $row) {
            $id = $row['id'];
            $name = $row['name'];
            $link = $row['link'];
            $icon = $row['icon'];
            $active = $row['active'];

            $ruta = "../images/icons/redes/";
            $acc_btn = "sus";
            $name_btn = "Suspender";
            $red_class = "suspender";
            if ($active == "0") {
                $ruta = "../images/icons/redes/light/";
                $acc_btn = "act";
                $name_btn = "Activar";
                $red_class = "activar";
            }
            ?>
        <div class="red">
          <div class="red_icon"><img src="<?php echo $ruta . $icon ?>"></div>
          <div class="red_name"><?php echo $name ?>:</div>
          <div class="red_link"><?php echo $link ?></div>
          <div class="red_options">
            <a 
              class="red_btn <?php echo $red_class ?>" 
              href="inicio.php?menu_lat=<?php echo $id_lat ?>&<?php echo $acc_btn ?>=<?php echo $id ?>" 
              class="boton"
            >
              <?php echo $name_btn ?>
            </a>
            <a 
              class="red_btn editar" 
              href="inicio.php?menu_lat=<?php echo $id_lat ?>&edit=<?php echo $id ?>" 
              class="boton"
          >Editar</a>
          </div>  
        </div>
            <?php
        }
    } else {
        ?>
    <div class="vacio">
        <p>No hay usuarios registrados</p>
    </div>    
        <?php
    }
}

function edit_red($edit, $id_lat)
{
    $conf = "";
    if (isset($_POST['hdn_conf'])) {
        $conf = $_POST['hdn_conf'];
        if ($conf == "accion") {
            $ruta = $_POST['txt_ruta'];
            $query = "UPDATE redes SET link='$ruta' WHERE id='$edit'";
            $resultado = actualizar_registro($query);
            if ($resultado) {
                $msj = "Red actualizada correctamente";
            } else {
                $msj = "Error al actualizar los datos";
            }
            $retorno = "inicio.php?menu_lat=$id_lat";

            retorno($retorno, $msj);
        }
    } else {
        $query_red = "SELECT * FROM redes WHERE id='$edit'";
        $red = obtener_linea($query_red);
        $nombre_red = $red['name'];
        $ruta_red = $red['link'];
        ?>
    <div class="titulo_form">Editar Link de <?php echo $nombre_red ?></div>
        <?php
        $link_action = "inicio.php?menu_lat=$id_lat&edit=$edit";
        $id_form = "form_editar_redes";
        form_header($link_action, $id_form);
        item_form(
            'Link Actual :',
            '',
            '',
            '',
            $ruta_red,
            '',
            ''
        );
        item_form(
            'Nueva ruta* :',
            'input',
            'txt_ruta',
            'text',
            $ruta_red,
            '',
            'required'
        );
        item_form(
            '',
            'input',
            'hdn_conf',
            'hidden',
            'accion',
            '',
            ''
        );
        $btn_acc = "Actualizar Red";
        $btn01_link = "inicio.php?menu_lat=$id_lat";
        $btn_a_list = [[$btn01_link, "Cancelar"]];
        botonera($btn_acc, $btn_a_list);
        ?>
    <script src="./js/form_redes.js"></script>
        <?php
    }
}

function suspender_red($sus, $id_lat)
{
    $query = "UPDATE redes SET 
      active = 0
      WHERE 
      id = $sus";
    $resultado = actualizar_registro($query);
    if ($resultado) {
        $msj = "Red Desactivada";
    } else {
        $msj = "Error al actualizar los datos";
    }
    $retorno = "inicio.php?menu_lat=$id_lat";

    retorno($retorno, $msj);
}

function activar_red($act, $id_lat)
{
    $query = "UPDATE redes SET 
      active = 1
      WHERE 
      id = $act";
    $resultado = actualizar_registro($query);
    if ($resultado) {
        $msj = "Red Activada";
    } else {
        $msj = "Error al actualizar los datos";
    }
    $retorno = "inicio.php?menu_lat=$id_lat";

    retorno($retorno, $msj);
}
