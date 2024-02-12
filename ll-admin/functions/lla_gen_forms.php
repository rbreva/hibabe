<?php

function form_header($link_action, $id_form)
{
    ?>
<form 
  id="<?php echo $id_form ?>"
  action="<?php echo $link_action ?>" 
  method="post" 
  enctype="multipart/form-data"
>
    <?php
}

function item_form($name_field, $input, $id_input, $type, $name_field_data, $alert, $required)
{
    ?>
<div class="item">
  <div class="item_name"><?php echo $name_field ?></div>
  <div class="item_data">
    <?php
    if ($input == 'input') {
        if ($type == 'text' || $type == 'number' || $type == 'email' || $type == 'password' || $type == 'hidden') {
            ?>
    <input 
      id="<?php echo $id_input ?>" 
      name="<?php echo $id_input ?>" 
      type="<?php echo $type ?>" 
      value="<?php echo $name_field_data ?>" 
             <?php echo $required ?>
    >    
            <?php
        } elseif ($type == 'checkbox') {
            ?>
    <input 
      id="<?php echo $id_input; ?>" 
      name="<?php echo $id_input; ?>" 
      type="<?php echo $type; ?>" 
            <?php echo $name_field_data; ?>
            <?php echo $required ?>
    >    
            <?php
        }
    } elseif ($input == 'select') {
        if ($id_input == 'slc_level') {
            $config = store_config();
            $usuario = $_SESSION[$config['session']];
            $query_usuario = "SELECT * FROM users WHERE username = '$usuario'";
            $datos_usuario = obtener_linea($query_usuario);
            $nivel = $datos_usuario['level'];
            $query_niveles = "SELECT * FROM user_level WHERE id >= $nivel";
            $niveles = obtener_todo($query_niveles);
        }
        ?>
        <select 
          id="<?php echo $id_input; ?>"
          name="<?php echo $id_input; ?>"
        >
          <option value="" disable>Seleccione uno</option>  
          <?php
            $selected = "";
            if ($name_field_data) {
                $selected = "selected";
            }
            foreach ($niveles as $row) {
                ?>
          <option value="<?php echo $row['id'] ?>" <?php echo $selected ?>><?php echo $row['name'] ?></option>
                <?php
            }
            ?>
        </select>
        <?php
    } else {
        echo $name_field_data;
    }
    ?>
    <span
      id="<?php echo $id_input; ?>_alert"
      class="alert"
    >
      <?php echo $alert ?>
    </span>
  </div>
</div>
    <?php
}

function botonera($btn_acc, $btn_a_list)
{
    ?>
<div class="botonera">
    <?php
    if ($btn_acc) {
        ?>
  <button id="acc_btn" class="acc_btn"><?php echo $btn_acc ?></button>
        <?php
    }
    foreach ($btn_a_list as $row) {
        ?>
    <a class="btn_a" href="<?php echo $row[0] ?>">
        <?php echo $row[1] ?>
    </a>
        <?php
    }
    ?>
</div>
    <?php
    if ($btn_acc) {
        ?>
</form>
        <?php
    }
}

function retorno($retorno, $msj)
{
    ?>
  <div class="retorno">
    <div class="retorno_msj"><?php echo $msj ?></div>
    <a class="retorno_a" href="<?php echo $retorno ?>">Regresar</a>
  </div>
    <?php
}

function mensaje_generico($msj, $ruta, $boton)
{
    ?>
  <div class="retorno">
    <div class="retorno_msj"><?php echo $msj ?></div>
    <a class="retorno_a" href="<?php echo $ruta ?>"><?php echo $boton ?></a>
  </div>
    <?php
}

function retorno_back($msj, $boton)
{
    ?>
  <div class="retorno">
    <div class="retorno_msj"><?php echo $msj ?></div>
    <button id="botonRegreso" class="retorno_a"><?php echo $boton ?></button>
    <script src="js/retorno.js"></script>
  </div>
    <?php
}

function retorno_back2($msj, $boton)
{
    ?>
  <div class="retorno">
    <div class="retorno_msj"><?php echo $msj ?></div>
    <button id="botonRegreso" class="retorno_a"><?php echo $boton ?></button>
    <script src="js/retorno2.js"></script>
  </div>
    <?php
}

function retorno_back3($msj, $boton)
{
    ?>
  <div class="retorno">
    <div class="retorno_msj"><?php echo $msj ?></div>
    <button id="botonRegreso" class="retorno_a"><?php echo $boton ?></button>
    <script src="js/retorno3.js"></script>
  </div>
    <?php
}