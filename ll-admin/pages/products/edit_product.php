<?php

function editprod($edit_prod)
{
    if (isset($_POST['crear'])) {
        edit_product_paso01($edit_prod);
    } else {
        edit_product_form($edit_prod);
    }
}

function edit_product_form($edit_prod)
{
    $query_producto = "SELECT * FROM productos WHERE id = $edit_prod";
    $producto = obtener_linea($query_producto);
    $nombre_producto = $producto['name'];
    $descripcion_producto = $producto['description'];
    $detail_producto = $producto['details'];
    $nuevo_producto = $producto['new'];

    $tiny = "https://cdn.tiny.cloud/1/jrpahjfkukmd5c3xtic4mkbttepp9135rfkn4lzjwwlplc7y/tinymce/5/tinymce.min.js";
    ?>
<form 
  class="form_producto" 
  action="productos.php?editprod=<?php echo $edit_prod ?>" 
  method="post" 
  enctype="multipart/form-data"
  >
  <script src="<?php echo $tiny ?>" referrerpolicy="origin"></script>
  <div class="datos">
    <div class="linea">
      <label class="linea_tit" for="nombre">Nombre del Producto:</label>
      <input id="nombre" name="nombre_txt" type="text" value="<?php echo $nombre_producto ?>" maxlength="100" required>
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
      <?php echo $descripcion_producto ?>
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
      <?php echo $detail_producto ?>
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

    $query_secciones_sel = "SELECT s.* 
      FROM secciones s 
      JOIN seccion_producto sp 
      ON s.id = sp.seccion_id 
      WHERE sp.producto_id = $edit_prod";
    $secciones_sel = obtener_todo($query_secciones_sel);
    // print_r($secciones_sel);
    $sec_sel_id = [];
    if ($secciones_sel) {
        foreach ($secciones_sel as $row_sel) {
            array_push($sec_sel_id, $row_sel['id']);
        }
    }
    // print_r($sec_sel_id);
    ?>
  <div class="datos">
    <?php
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
                    $checked = (in_array($id_seccion, $sec_sel_id)) ? "checked" : "";
                    ?>
              <li class="men_item_ul_li">
                <label for="<?php echo $id_seccion ?>"><?php echo $nombre_seccion ?>: </label>
                <input 
                  id="<?php echo $id_seccion ?>" 
                  type="checkbox" 
                  name="sec_selec[]" 
                  value="<?php echo $id_seccion ?>"
                    <?php echo $checked ?>
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
    ?>
  </div>
  <!-------otras opciones--------------->
    <?php
    $cheched = ($nuevo_producto == 1) ? "checked" : "";
    ?>
  <div class="datos">
    <div class="men_item">
      <div class="men_item_tit">Menu Estático "Nuevo"</div>
      <ul class="men_item_ul">
        <li class="men_item_ul_li">
          <label for="nuevo">Nuevo: </label>
          <input id="nuevo" type="checkbox" name="nuevo_chk" value="1" <?php echo $cheched ?>>
        </li>
      </ul>
    </div>
  </div>
  <div class="botonera">
    <input type="hidden" value="proceder" name="crear">
    <button id="acc_btn" class="acc_btn" type="submit">Editar Producto</button>
    <button id="botonRegreso" class="btn_a">Regresar</button>
    <script src="js/retorno.js"></script>
    <!-- <a class="btn_a" href="productos.php">Regresar</a> -->
  </div>
</form>
    <?php
}

function edit_product_paso01($edit_prod)
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
    $query_producto = "UPDATE productos SET 
      name = '$nombre', 
      description = '$descripcion',
      details = '$details',
      new = $nuevo 
      WHERE id = $edit_prod";

    $query_transaccion = [];
    if (actualizar_registro($query_producto)) {
        $deleteQuery = "DELETE FROM seccion_producto WHERE producto_id = $edit_prod";
        array_push($query_transaccion, $deleteQuery);

        foreach ($secciones as $seccion) {
            $query_seccion = "INSERT INTO seccion_producto (
              seccion_id,
              producto_id 
              ) VALUE (
              $seccion,
              $edit_prod 
            )";
            array_push($query_transaccion, $query_seccion);
        }
        if (actualizar_transaccion($query_transaccion)) {
            $msj = "Datos Actualizados correctamente";
            $boton = "Regresar";
        } else {
            $msj = "Error al agregar las seccines al producto";
            $boton = "Regresar";
        }
    } else {
        $msj = "Error al crear el producto";
        $boton = "Regresar";
    }
    retorno_back($msj, $boton);
}

function act_prod($id)
{
    $query = "UPDATE productos SET active='1' WHERE id='$id'";
    if (actualizar_registro($query)) {
        $msj = "Producto Activado";
    } else {
        $msj = "Error en el Servidor, por favor intente de nuevo";
    }
      $boton = "Regresar";
      retorno_back($msj, $boton);
}

function sus_prod($id)
{
    $query = "UPDATE productos SET active='0' WHERE id='$id'";
    if (actualizar_registro($query)) {
        $msj = "Producto Suspendido";
    } else {
        $msj = "Error en el Servidor, por favor intente de nuevo";
    }
      $boton = "Regresar";
      retorno_back($msj, $boton);
}

function agotar_prod($producto)
{
    $conf = "";
    if (isset($_GET['conf'])) {
        $conf = $_GET['conf'];
    }

    if (!$conf) {
        ?>
  <div class="del_conf">
    <div class="del_msj">¿Realmente desea Agotar el Producto?, NO se Puede revertir.</div>
    <div class="linea">
      <a class="del_btn" href="productos.php?agotar=<?php echo $producto; ?>&conf=borralo" class="boton">
        Si, Agotar Producto
      </a>
      <div class="retorno_btn"><a href="productos.php" class="boton">Regresar</a></div>
    </div>
  </div>
        <?php
    } else {
        $query_agotar = "SELECT cod.*
          FROM productos p
          JOIN colors c ON p.id = c.id_producto
          JOIN codigos cod ON c.id = cod.id_color
          WHERE p.id = $producto";
        $codigos = obtener_todo($query_agotar);

        $query_transaccion = [];
        foreach ($codigos as $row) {
            $id_codigo = $row['id'];
            $query_agotar = "UPDATE codigos 
              SET stock = 0 
              WHERE id = $id_codigo";
              array_push($query_transaccion, $query_agotar);
        };
        //echo $query_agotar;
        if (actualizar_transaccion($query_transaccion)) {
            $msj = "<p>Producto Agotado</p>";
        } else {
            $msj = "<p>Error en el servidor intente nuevamente por favor</p>";
        }
        $boton = "Regresar";
        retorno_back2($msj, $boton);
    }
}

function del_prod($producto)
{
    $producto = $_GET['del'];
    $conf = "";
    if (isset($_GET['conf'])) {
        $conf = $_GET['conf'];
    }

    if (!$conf) {
        ?>
  <div class="del_conf">
    <div class="del_msj">¿Realmente desea eliminar el Producto?, NO se va a poder recuperar datos relacionados.</div>
    <div class="del_msj">Se Elimarán los Colores Agregados a este producto.</div>
    <div class="del_msj">Se Elimarán las Fotografías Agregadas a cada color.</div>
    <div class="del_msj">Se eliminarán todos los Códigos/SKU relacionados al Color.</div>
    <div class="linea">
      <a class="del_btn" href="productos.php?del=<?php echo $producto; ?>&conf=borralo">
        Si, Eliminar Producto
      </a>
    </div>
    <button id="botonRegreso" class="retorno_btn">No, Regreso</button>
    <script src="js/retorno.js"></script>
  </div>
        <?php
    } else {
        $query_colors = "SELECT * FROM colors WHERE id_producto = '$producto'";
        $colors = obtener_todo($query_colors);
        $query_transaccion = [];
        if ($colors) {
            foreach ($colors as $col) {
                $id_color = $col['id'];
                $query_fotos = "SELECT * FROM fotos WHERE id_color = '$id_color'";
                $fotos = obtener_todo($query_fotos);
                if ($fotos) {
                    foreach ($fotos as $foto) {
                        $id_foto = $foto['id'];
                        $query_del_foto = "DELETE FROM fotos WHERE id = $id_foto";
                        array_push($query_transaccion, $query_del_foto);
                    }
                }
                $query_codigos = "SELECT * FROM codigos WHERE id_color = '$id_color'";
                $codigos = obtener_todo($query_codigos);
                if ($codigos) {
                    foreach ($codigos as $codigo) {
                        $id_codigo = $codigo['id'];
                        $query_del_codigo = "DELETE FROM codigos WHERE id = $id_codigo";
                        array_push($query_transaccion, $query_del_codigo);
                    }
                }
                $query_del_color = "DELETE FROM colors WHERE id = $id_color";
                array_push($query_transaccion, $query_del_color);
            }
        }

        $query_producto_secciones = "SELECT * FROM seccion_producto WHERE producto_id = $producto";
        $producto_secciones = obtener_todo($query_producto_secciones);
        if ($producto_secciones) {
            foreach ($producto_secciones as $producto_sec) {
                $producto_sec_id = $producto_sec['producto_id'];
                $query_del_producto_seccion = "DELETE FROM seccion_producto WHERE producto_id = $producto_sec_id";
                array_push($query_transaccion, $query_del_producto_seccion);
            }
        }

        $query_del_producto = "DELETE FROM productos WHERE id = $producto";
        array_push($query_transaccion, $query_del_producto);

        // foreach ($query_transaccion as $query) {
        //     echo $query . "<br>";
        // }
        if (actualizar_transaccion($query_transaccion)) {
            $msj = "<p>Producto Eliminado</p>";
        } else {
            $msj = "<p>Error en el servidor intente nuevamente por favor</p>";
        }
        $boton = "Regresar";
        retorno_back2($msj, $boton);
    }
}
