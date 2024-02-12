<?php

function usuarios($config, $id_lat)
{
    $create = "";
    $edit = "";
    $delete = "";
    $acc = "";

    if (isset($_GET["create"])) {
        $create = $_GET["create"];
    }
    if (isset($_GET["edit"])) {
        $edit = $_GET["edit"];
    }
    if (isset($_GET["delete"])) {
        $delete = $_GET["delete"];
    }

    if ($create || $edit || $delete) {
        if (isset($_GET["acc"])) {
            $acc = $_GET["acc"];
        }
    }

    $usuario = $_SESSION[$config['session']];
    $query_usuario = "SELECT * FROM users WHERE username = '$usuario'";
    $datos_usuario = obtener_linea($query_usuario);
    $nivel = $datos_usuario['level'];

    $titulo = "Usuarios";
    $btn01_link = "inicio.php?menu_lat=$id_lat&create=newuser";
    $btn_a_list = [[$btn01_link, "Agregar Nuevo Usuario"]];
    barra_titulo($titulo, $nivel, $btn_a_list);

    if ($acc) {
        if ($acc == "create") {
            create_user_action($id_lat);
        }
        if ($acc == "edit") {
            edit_user_action($edit, $id_lat);
        }
        if ($acc == "delete") {
            delete_user_action($delete, $id_lat);
        }
    } elseif ($create) {
        create_user($id_lat, $nivel);
    } elseif ($edit) {
        edit_user($edit, $id_lat);
    } elseif ($delete) {
        delete_user($delete, $id_lat);
    } else {
        lista_usuarios($datos_usuario, $nivel, $edit, $id_lat);
    }
}

function lista_usuarios($datos_usuario, $nivel, $edit, $id_lat)
{
    $id = $datos_usuario['id'];
    $query_usuarios = "SELECT * FROM users WHERE id <> $id AND level >= '$nivel'";
    $usuarios = obtener_todo($query_usuarios);

    if ($usuarios) {
        ?>
    <div class="lista cabecera">
      <div class="user orden">Usuario</div>
      <div class="nombre orden">Nombres</div>
      <div class="apellido orden">Apellidos</div>
      <div class="email orden">Email</div>
      <div class="cargo orden">Cargo</div>
      <div class="nivel orden">Nivel</div>
      <div class="opciones orden">Opciones</div>
    </div>
        <?php
        foreach ($usuarios as $usuario) {
            $id = $usuario['id'];
            $username = $usuario['username'];
            $nombre = $usuario['name'];
            $apellido = $usuario['lastname'];
            $email = $usuario['email'];
            $cargo = $usuario['type'];
            $nivel = $usuario['level'];

            $query_nivel = "SELECT * FROM user_level WHERE id = $nivel";
            $nivel_data = obtener_linea($query_nivel);
            $nivel_nombre = $nivel_data['name'];
            ?>
    <div class="lista">
      <div class="user orden"><?php echo $username ?></div>
      <div class="nombre orden"><?php echo $nombre ?></div>
      <div class="apellido orden"><?php echo $apellido ?></div>
      <div class="email orden"><?php echo $email ?></div>
      <div class="cargo orden"><?php echo $cargo ?></div>
      <div class="nivel orden"><?php echo $nivel_nombre ?></div>
      <div class="opciones orden">
        <a class="opciones_a" href="inicio.php?menu_lat=<?php echo $id_lat ?>&edit=<?php echo $id ?>">Editar</a>
        <a 
          class="opciones_a red_alert" 
          href="inicio.php?menu_lat=<?php echo $id_lat ?>&delete=<?php echo $id ?>"
        >Eliminar</a>
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

function create_user($id_lat)
{
    $link_action = "inicio.php?menu_lat=$id_lat&create=newuser&acc=create";
    $id_form = "form_crear_usuario";
    form_header($link_action, $id_form);

    item_form(
        'Usuario',
        'input',
        'txt_username',
        'text',
        '',
        '(El nombre de usuario es único, no podrá modificarse)',
        ''
    );
    item_form(
        'Nombre',
        'input',
        'txt_name',
        'text',
        '',
        '',
        'required'
    );
    item_form(
        'Apellidos',
        'input',
        'txt_lastname',
        'text',
        '',
        '',
        'required'
    );
    item_form(
        'Email',
        'input',
        'txt_email',
        'email',
        '',
        '(El email es único y no podrá modificarse)',
        ''
    );
    item_form(
        'Cargo',
        'input',
        'txt_type',
        'text',
        '',
        '',
        'required'
    );
    item_form(
        'Categoría',
        'select',
        'slc_level',
        '',
        '',
        '',
        'required'
    );
    item_form(
        'Password',
        'input',
        'pass_txt',
        'password',
        '',
        '',
        'required'
    );
    item_form(
        'Repetir Password',
        'input',
        'rep_pass_txt',
        'password',
        '',
        '',
        'required'
    );

    $btn_acc = "Agregar Nuevo Usuario";
    $btn01_link = "inicio.php?menu_lat=$id_lat";
    $btn_a_list = [[$btn01_link, "Regresar"]];
    botonera($btn_acc, $btn_a_list);
    ?>
    <script src="./js/form_create_user.js"></script>
    <?php
}

function create_user_action($id_lat)
{
    $txt_username = $_POST["txt_username"];
    $txt_name = $_POST["txt_name"];
    $txt_lastname = $_POST["txt_lastname"];
    $txt_email = $_POST["txt_email"];
    $txt_type = $_POST["txt_type"];
    $slc_level = $_POST["slc_level"];
    $pass_txt = $_POST["pass_txt"];
    $rep_pass_txt = $_POST["rep_pass_txt"];

    if ($pass_txt == $rep_pass_txt) {
        $password = password_hash($pass_txt, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (
          username, 
          password, 
          name, 
          lastname, 
          email, 
          type, 
          level
          ) VALUE (
          '$txt_username', 
          '$password', 
          '$txt_name', 
          '$txt_lastname', 
          '$txt_email', 
          '$txt_type',
          '$slc_level')";
        $resultado = actualizar_registro($query);
        if ($resultado) {
            $msj = "Usuario creado correctamente";
        } else {
            $msj = "Error al actualizar los datos";
        }
        $retorno = "inicio.php?menu_lat=$id_lat";

        retorno($retorno, $msj);
    }
}

function edit_user($edit, $id_lat)
{
    $query_usuario = "SELECT * FROM users WHERE id = $edit";
    $datos_usuario = obtener_linea($query_usuario);
    $link_action = "inicio.php?menu_lat=$id_lat&edit=$edit&acc=edit";
    $id_form = "form_crear_usuario";
    form_header($link_action, $id_form);

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
        'input',
        'txt_name',
        'text',
        $datos_usuario['name'],
        '',
        'required'
    );
    item_form(
        'Apellidos :',
        'input',
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
        $datos_usuario['email'],
        '',
        '(El email es único y no puede modificarse)',
        ''
    );
    item_form(
        'Cargo :',
        'input',
        'txt_type',
        'text',
        $datos_usuario['type'],
        '',
        'required'
    );
    item_form(
        'Categoría :',
        'select',
        'slc_level',
        '',
        $datos_usuario['level'],
        '',
        'required'
    );
    item_form(
        'Password :',
        'input',
        'pass_txt',
        'password',
        '',
        '(Dejar en blanco si no se desea cambiar el password)',
        ''
    );
    item_form(
        'Repetir Password :',
        'input',
        'rep_pass_txt',
        'password',
        '',
        '(Dejar en blanco si no se desea cambiar el password)',
        ''
    );

    $btn_acc = "Editar Usuario";
    $btn01_link = "inicio.php?menu_lat=$id_lat";
    $btn_a_list = [[$btn01_link, "Regresar"]];
    botonera($btn_acc, $btn_a_list);
    ?>
    <script src="./js/form_edit_user.js"></script>
    <?php
}

function edit_user_action($edit, $id_lat)
{
    $txt_name = $_POST["txt_name"];
    $txt_lastname = $_POST["txt_lastname"];
    $txt_type = $_POST["txt_type"];
    $slc_level = $_POST["slc_level"];

    if (isset($_POST['pass_txt'])) {
        $pass_txt = $_POST["pass_txt"];
        $rep_pass_txt = $_POST["rep_pass_txt"];

        if ($pass_txt == $rep_pass_txt) {
            $password = password_hash($pass_txt, PASSWORD_DEFAULT);
        }
        $query = "UPDATE users SET 
          password = '$password',
          name = '$txt_name', 
          lastname = '$txt_lastname', 
          type = '$txt_type', 
          level = '$slc_level'
          WHERE 
          id = $edit";
    } else {
        $query = "UPDATE users SET 
          name = '$txt_name', 
          lastname = '$txt_lastname', 
          type = '$txt_type', 
          level = '$slc_level'
          WHERE 
          id = $edit";
    }
    $resultado = actualizar_registro($query);
    if ($resultado) {
        $msj = "Datos actualizados correctamente";
    } else {
        $msj = "Error al actualizar los datos";
    }
    $retorno = "inicio.php?menu_lat=$id_lat";

    retorno($retorno, $msj);
}

function delete_user($delete, $id_lat)
{
    $query_usuario = "SELECT * FROM users WHERE id = $delete";
    $datos_usuario = obtener_linea($query_usuario);
    $username = $datos_usuario['username'];
    ?>
<div class="del_conf">
    <div class="del_msj">Se va a eliminar al usuario: <?php echo $username ?></div>
    <a 
      href="inicio.php?menu_lat=<?php echo $id_lat ?>&delete=<?php echo $delete ?>&acc=delete" 
      class="del_btn btn-danger"
    >Eliminar</a>
</div>
    <?php
}

function delete_user_action($delete, $id_lat)
{
    $query = "DELETE FROM users WHERE id = $delete";
    $resultado = actualizar_registro($query);
    if ($resultado) {
        $msj = "Usuario eliminado correctamente";
    } else {
        $msj = "Error al actualizar los datos";
    }
    $retorno = "inicio.php?menu_lat=$id_lat";

    retorno($retorno, $msj);
}
