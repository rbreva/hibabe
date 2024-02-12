<?php

function nuevo_prod()
{
    if (isset($_POST['crear'])) {
        crear_producto_paso01();
    } else {
        crear_producto_form();
    }
}

function crear_producto_form()
{
    $tiny = "https://cdn.tiny.cloud/1/jrpahjfkukmd5c3xtic4mkbttepp9135rfkn4lzjwwlplc7y/tinymce/5/tinymce.min.js";
    ?>
  <form 
    class="form_producto" 
    action="productos.php?acc=newprod"
     method="post" 
    enctype="multipart/form-data"
  >
    <script src="<?php echo $tiny ?>" referrerpolicy="origin"></script>
    <div class="datos">
      <div class="linea">
        <label class="linea_tit" for="nombre">Nombre del Producto:</label>
        <input id="nombre" name="nombre_txt" type="text" value="" maxlength="100" required>
      </div>
    </div>
    <div class="datos">
      <div class="linea">
        <div class="linea_tit">Descripción:</div>
      </div>
      <textarea 
        id="mytextarea" 
        class="linea_txtarea" 
        name="desc_txt_area" 
        cols="" 
        rows=""
      >
      </textarea>
      <script>
        let selectorName = '#mytextarea';
      </script>
      <script src="js/tiny_config.js"></script>
    </div>
    <div class="datos">
      <div class="linea">
        <div class="linea_tit">Características:</div>
      </div>
      <textarea 
        id="mytextareaDetail" 
        class="linea_txtarea" 
        name="detail_txt_area" 
        cols="" 
        rows=""
      >
      </textarea>
      <script>
        let selectorDetail = '#mytextareaDetail';
      </script>
      <script src="js/tiny_detail_config.js"></script>
    </div>
    <!-----menu categorias-------------->
    <?php
    $query_menu = "SELECT * FROM menus WHERE active = 1";
    $menus = obtener_todo($query_menu);
    ?>
    <div class="datos">
      <?php
        if ($menus) {
            foreach ($menus as $rowmenu) {
                $id_menu = $rowmenu['id'];
                $nombre_menu = $rowmenu['name'];

                $query_secciones  = "SELECT s.* 
                FROM secciones s 
                JOIN menu_seccion ms 
                ON s.id = ms.seccion_id 
                WHERE ms.menu_id = $id_menu";
                $secciones = obtener_todo($query_secciones);
                if ($secciones) {
                    $arrow = "<img class='icon_arrow' src='images/svg/icons/arrow.svg'>";
                    ?>
          <div class="men_item">
            <div class="men_item_tit"><?php echo $arrow . $nombre_menu ?></div>
            <ul class="men_item_ul">
                    <?php
                    foreach ($secciones as $rowseccion) {
                        $id_seccion = $rowseccion['id'];
                        $nombre_seccion = $rowseccion['name'];
                        ?>
                <li class="men_item_ul_li">
                  <label for="<?php echo $id_seccion ?>"><?php echo $nombre_seccion ?>: </label>
                  <input 
                    id="<?php echo $id_seccion ?>" 
                    type="checkbox" 
                    name="sec_selec[]" 
                    value="<?php echo $id_seccion ?>"
                  >
                </li>
                        <?php
                    }
                    ?>
            </ul>
          </div>
                    <?php
                }
            }
        } else {
            ?>
        <div class="vacio">
            <h2 class="vacio_h2">No hay menus</h2>
            <p class="vacio_p">Empieza creando uno</p>
            <a href="menus.php?acc=create_menu" class="vacio_btn">
                <img class="nav_bar_lat_img" src="images/svg/icons/add.svg" alt="Agregar" />
                <span>Agregar Menu</span>
            </a>
        </div>
            <?php
        }
        ?>
    </div>
    <!-------otras opciones--------------->
    <div class="datos">
      <div class="men_item">
        <div class="men_item_tit">Menu Estático "Nuevo"</div>
        <ul class="men_item_ul">
          <li class="men_item_ul_li">
            <label for="nuevo">Nuevo: </label>
            <input id="nuevo" type="checkbox" name="nuevo_chk" value="1">
          </li>
        </ul>
      </div>
    </div>
    <div class="botonera">
      <input type="hidden" value="proceder" name="crear">
      <button id="acc_btn" class="acc_btn" type="submit">Crear Producto</button>
      <a class="btn_a" href="productos.php">Regresar</a>
    </div>
  </form>
    <?php
}

function crear_producto_paso01()
{
    $nombre = $_POST['nombre_txt'];
    $descripcion = addslashes($_POST['desc_txt_area']);
    $details = addslashes($_POST['detail_txt_area']);
    $secciones = [];
    if (isset($_POST['sec_selec'])) {
        $secciones = $_POST['sec_selec'];
    }
    $nuevo = 0;
    if (isset($_POST['nuevo_chk'])) {
        $nuevo = $_POST['nuevo_chk'];
    }

    // agregar producto
    $query_producto = "INSERT INTO productos (
      name, 
      description,
      details,
      new
      ) VALUE (
      '$nombre', 
      '$descripcion',
      '$details', 
      $nuevo
    )";

    // obtener id del producto
    $id_producto = actualizar_registro_id($query_producto);
    // echo "query_producto: " . $query_producto . "<br>";
    // $id_producto = 7;

    // agregar secciones seleccinadas al id del producto
    $query_transaccion = [];
    if ($id_producto) {
        foreach ($secciones as $seccion) {
            $query_seccion = "INSERT INTO seccion_producto (
              seccion_id,
              producto_id 
              ) VALUE (
              $seccion,
              $id_producto 
            )";
            array_push($query_transaccion, $query_seccion);
        }
        if (actualizar_transaccion($query_transaccion)) {
            $msj = "Producto Creado con éxito. Vamos a crear colores y modelos";
            $ruta = "productos.php?editcolors=$id_producto";
            $boton = "Agregar Modelos/Colores";
        } else {
            $msj = "Error al agregar las secciones al producto.";
            $ruta = "productos.php?acc=newprod";
            $boton = "Regresar";
        }
    } else {
        $msj = "Error al crear el producto";
        $ruta = "productos.php?acc=newprod";
        $boton = "Regresar";
    }
    mensaje_generico($msj, $ruta, $boton);
    // redireccionar a la pagina de agregar modelos/colores

    // foreach ($secciones as $seccion) {
    //     echo $seccion . "<br>";
    // }



    // if (actualizar_registro($query_producto)) {
    //     $query_ultimo_id = "SELECT MAX(id_producto) AS id FROM productos";
    //     $ultimo_id = obtener_linea($query_ultimo_id);
    //     $id = $ultimo_id['id'];
    //     $msj = "Producto agregado con éxito";
    //     $ruta = "productos.php?editcs=" . $id;
    //     $boton = "Agregar Modelos/Colores";
    //     mensaje_generico($msj, $ruta, $boton);
    // } else {
    //     $msj = "Error en el Servidor, por favor intente de nuevo";
    //     $ruta = "productos.php?acc=newprod";
    //     $boton = "Regresar";
    //     mensaje_generico($msj, $ruta, $boton);
    // }
}
