<?php

function stock($stock)
{
    $query_color = "SELECT * FROM colors WHERE id = '$stock'";
    $color = obtener_linea($query_color);
    $color_nombre = $color['name'];
    $id_producto_color = $color['id_producto'];

    $query_producto = "SELECT * FROM productos WHERE id = '$id_producto_color'";
    $producto = obtener_linea($query_producto);
    $nombre_producto = $producto['name'];

    $delcod = "";
    if (isset($_GET['delcod'])) {
        $delcod = $_GET['delcod'];
    }

    $accsus = "";
    if (isset($_GET['accsus'])) {
        $accsus = $_GET['accsus'];
    }

    $accact = "";
    if (isset($_GET['accact'])) {
        $accact = $_GET['accact'];
    }

    if ($delcod) {
        del_codigo($stock, $delcod);
    } elseif ($accsus) {
        sus_codigo($accsus);
    } elseif ($accact) {
        act_codigo($accact);
    } elseif (isset($_POST['act_codigo'])) {
        $act_codigo = $_POST['act_codigo'];
        editar_codigo($act_codigo);
    } elseif (isset($_POST['new_codigo'])) {
        $id_stock = $_POST['new_codigo'];
        codigo_nuevo($id_stock);
    } else {
        $query_codigos = "SELECT * FROM codigos 
          WHERE id_color = $stock";
        $codigos = obtener_todo($query_codigos);
        ?>
<div class="subtitulo_prod">
  Stocks y Códigos de <strong><?php echo $nombre_producto ?> - <?php echo $color_nombre ?></strong>
</div>
        <?php

        if (!$codigos) {
            codigo_nuevo_form($stock);
        } else {
            editar_codigo_form($codigos, $stock);
            codigo_nuevo_form($stock);
        }
        ?>
<div class="botonera">
    <button id="botonRegreso" class="btn_a">Regresar</button>
    <script src="js/retorno.js"></script>
</div>
        <?php
    }
}

function sus_codigo($accsus)
{
    $query_toggle_codigo = "UPDATE codigos SET active = '0' WHERE id = '$accsus'";
    actualizar_registro($query_toggle_codigo);
    $msj = "Código Suspendido";
    $boton = "Regresar";
    retorno_back($msj, $boton);
}

function act_codigo($accact)
{
    $query_toggle_codigo = "UPDATE codigos SET active = '1' WHERE id = '$accact'";
    actualizar_registro($query_toggle_codigo);
    $msj = "Código Activado";
    $boton = "Regresar";
    retorno_back($msj, $boton);
}

function del_codigo($stock, $delcod)
{
    if (isset($_GET['conft'])) {
        $eliminar = "DELETE FROM codigos WHERE id ='$delcod'";
        if (actualizar_registro($eliminar)) {
            $msj = "Código/SKU Eliminado";
        } else {
            $msj = "Error al eliminar Código/SKU";
        }
            $boton = "Regresar";
            retorno_back2($msj, $boton);
    } else {
        ?>
  <div class="del_conf">
    <div class="del_msj">¿Realmente desea eliminar Código/SKU?, NO se va a poder recuperar datos relacionados.</div>
    <div class="linea">
      <a 
        href="productos.php?&stock=<?php echo $stock ?>&delcod=<?php echo $delcod ?>&conft=borralo" 
        class="del_btn"
      >
        Si, Eliminar Stock/Código
      </a>
      <button id="botonRegreso" class="retorno_btn">No, Regreso</button>
      <script src="js/retorno.js"></script>
    </div>
  </div>
        <?php
    }
}

function codigo_nuevo_form($id_stock)
{
    ?>
  <form 
    action="productos.php?&stock=<?php echo $id_stock ?>" 
    method="post" 
    enctype="multipart/form-data"
    class="stock_lin"
  >
    <div class="data">Código/SKU: <input name="sku_txt" type="text" required></div>
    <div class="data">Talla/Modelo: <input name="talla_txt" type="text" required></div>
    <div class="data">Precio: <input name="precio_num" type="number" step="0.01" value="" required></div>
    <div class="data">Stock: <input name="stock_num" type="number" required></div>
    <div class="data">Oferta: <input name="oferta_chk" type="checkbox" value="1"></div>
    <div class="data">Precio Oferta: <input name="precio_oferta_num" type="number" step="0.01" required></div>
    <div class="data">
      <input type="hidden" value="<?php echo $id_stock ?>" name="new_codigo">
      <button class="add_btn" type="submit">Agregar Talla/Modelo</button>
    </div>
  </form>
    <?php
}

function editar_codigo_form($codigos, $id_stock)
{
    foreach ($codigos as $row) {
        $idcodigo = $row['id'];
        $namesku = $row['name'];
        $talla = $row['name_talla'];
        $precio = $row['precio'];
        $stock = $row['stock'];
        $oferta = $row['oferta'];
        $activo = $row['active'];
        $precio_oferta = $row['precio_oferta'];
        ?>
    <form 
      action="productos.php?&stock=<?php echo $id_stock ?>" 
      method="post" 
      enctype="multipart/form-data"
    >
    <div class="stock_lin">    
      <div class="data"> 
        Código/SKU: <input name="sku_txt" type="text" value="<?php echo $namesku ?>" disabled>
      </div>
      <div class="data">
        Talla/Modelo: <input name="talla_txt" type="text" value="<?php echo $talla ?>" required>
      </div>
      <div class="data">
        Precio: <input name="precio_num" type="number" step="0.01" value="<?php echo $precio ?>" required>
      </div>
      <div class="data">
        Stock: <input name="stock_num" type="number" value="<?php echo $stock ?>" required>
      </div>
      <div class="data">
        Oferta: <input name="oferta_chk" type="checkbox" value="1" 
          <?php
            if ($oferta == true) {
                echo " checked ";
            } ?>
        >
      </div>
      <div class="data">
        Precio Oferta: <input 
          name="precio_oferta_num" 
          type="number" 
          step="0.01" 
          value="<?php echo $precio_oferta ?>"
        >
      </div>
      <div class="data">
        <input type="hidden" value="<?php echo $idcodigo ?>" name="act_codigo">
        <button class="add_btn" type="submit">Actualizar Talla/Modelo</button>
      </div>
      <div class="data">
        <?php
        $acc = "accsus";
        $btn_txt = "Suspender";
        if ($activo == 0) {
            $acc = "accact";
            $btn_txt = "Activar";
        }
        ?>
        <a 
          href="productos.php?&stock=<?php echo $id_stock ?>&<?php echo $acc ?>=<?php echo $idcodigo ?>" 
          class="acc_btn destaque"
        >
          <?php echo $btn_txt ?>
        </a>
      </div>
      <div class="data">
        <a 
          href="productos.php?&stock=<?php echo $id_stock ?>&delcod=<?php echo $idcodigo ?>" 
          class="acc_btn alerta"
        >
          Eliminar
        </a>
      </div>
    </div>
  </form>
        <?php
    }
}

function codigo_nuevo($id_stock)
{
    $codigosku = $_POST['sku_txt'];
    $talla = $_POST['talla_txt'];
    $precio = $_POST['precio_num'];
    $stock = $_POST['stock_num'];
    $oferta = "0";
    if (isset($_POST['oferta_chk'])) {
        $oferta = $_POST['oferta_chk'];
    }
    $precio_oferta = $_POST['precio_oferta_num'];

    $query_codigos_comp = "SELECT * FROM codigos WHERE name = '$codigosku'";
    //echo $query_codigos_comp;

    $codigos_comp = obtener_linea($query_codigos_comp);
    //    print_r($codigos_comp);

    if ($codigos_comp) {
        $msj = "El Código/SKU ya existe, por favor use uno diferente.";
        $boton = "Regresar";
        retorno_back($msj, $boton);
    } else {
        $query_codigo_nuevo = "INSERT INTO codigos (
        name, 
        name_talla, 
        precio, 
        oferta, 
        precio_oferta,
        stock,
        id_color
        ) VALUES (
        '$codigosku', 
        '$talla', 
        '$precio', 
        '$oferta', 
        '$precio_oferta', 
        '$stock', 
        '$id_stock')";
        if (actualizar_registro($query_codigo_nuevo)) {
            $msj = "Nuevo Código/SKU creado";
        } else {
            $msj = "Error a Crear e código, por favor intente nuevamente.";
        }
        $boton = "Regresar";
        retorno_back($msj, $boton);
    }
}

function editar_codigo($act_codigo)
{
    $talla = $_POST['talla_txt'];
    $precio = $_POST['precio_num'];
    $stock = $_POST['stock_num'];
    $oferta = "0";
    if (isset($_POST['oferta_chk'])) {
        $oferta = $_POST['oferta_chk'];
    }
    $precio_oferta = $_POST['precio_oferta_num'];

    $query_codigo_editar = "UPDATE codigos SET 
      name_talla = '$talla', 
      precio = '$precio ', 
      oferta = '$oferta', 
      precio_oferta = '$precio_oferta', 
      stock = '$stock' 
      WHERE id='$act_codigo'";

    if (actualizar_registro($query_codigo_editar)) {
        $msj = "Código actualizado";
    } else {
        $msj = "Error a actualizar, por favor intente nuevamente.";
    }
    $boton = "Regresar";
    retorno_back($msj, $boton);
}
