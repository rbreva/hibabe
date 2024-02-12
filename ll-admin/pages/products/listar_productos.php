<?php

function listar_productos($query, $titulo)
{
    $productos = obtener_todo($query);
    ?>
<div class="titulo_prod"><?php echo $titulo; ?></div>
    <?php
    if (!$productos) {
        ?>
        <div class='vacio'>Aun no se han ingresado Productos</div>
        <?php
    } else {
        $id_menu = isset($_GET['id']) ? $_GET['id'] : "";
        $id_seccion = isset($_GET['idsec']) ? $_GET['idsec'] : "";
        todos_los_productos($productos, $id_menu, $id_seccion);
    }
}

function todos_los_productos($productos)
{
    $cantidadxpag = 15;
    $cantidad_prod = count($productos);
    $paginacion = isset($_GET["pag"]) ? $_GET["pag"] : 1;

    ?>
  <div class="productos">
    <div class="color_stock_col">Colores</div>
    <div class="color_stock_col">Stock</div>
    <div class="menu_col">Secciones</div>
    <div class="nombre_col">Nombre</div>
    <div class="imagen_col">Imagen</div>
    <div class="opcion_col">Agotar</div>
    <div class="opcion_col">Estado</div>
    <div class="opcion_col">Editar</div>
    <div class="opcion_col">Eliminar</div>
  </div>
    <?php
    $i = 0;
    $medidacantxpag = intval($paginacion * $cantidadxpag);
    $cantuno = ($medidacantxpag - $cantidadxpag);

    foreach ($productos as $row) {
        $cantidad_prod = count($productos);

        if ($i >= $cantuno && $i <= $medidacantxpag) {
            $id_producto = $row['id'];
            $nombre_producto = $row['name'];
            $activo_producto = $row['active'];

            $colores = [];
            $query_colores = "SELECT * FROM colors
              WHERE id_producto = '$id_producto'";
            $colores = obtener_todo($query_colores);
            ?>
<div class="productos">
  <!-- Colores -->
  <div class="color_stock_col">
            <?php
            if ($colores) {
                foreach ($colores as $rowcod) {
                    $nombre_color = $rowcod['name'];
                    ?>
    <div class="nombre_cs"><?php echo $nombre_color ?></div>
                    <?php
                }
                ?>
    <div class="nombre_cs">
      <a class="nombre_cs_a" href='productos.php?editcolors=<?php echo $id_producto ?>'>
        Editar Colores
      </a>
    </div>
                <?php
            } else {
                ?>
    <div class="nombre_cs">
      <a class="nombre_cs_a" href='productos.php?editcolors=<?php echo $id_producto ?>'>
        Agregar Colores
      </a>
    </div>
                <?php
            }
            ?>
  </div>
  <!-- Stock -->
  <div class="color_stock_col">
            <?php
            if ($colores) {
                foreach ($colores as $row_colores) {
                    $id_color = $row_colores['id'];
                    $nombre_color = $row_colores['name'];
                    $query_codigos = "SELECT * 
                      FROM codigos 
                      WHERE id_color = '$id_color'";
                    $codigos = obtener_todo($query_codigos);
                    ?>
    <div class="nombre_color"><?php echo $nombre_color ?></div>
                    <?php
                    if ($codigos) {
                        foreach ($codigos as $cod_row) {
                            $name_talla = $cod_row['name_talla'];
                            $stock = $cod_row['stock'];
                            $out_of_stock = "";
                            if ($stock <= 0) {
                                $out_of_stock = "out_of_stock";
                            }
                            ?>
    <div class="stock_gen <?php echo $out_of_stock ?>">
      <div class="stock_talla"><?php echo $name_talla ?></div>
      <div class="stock_cant"><?php echo $stock ?></div>
    </div>
                            <?php
                        }
                    } else {
                        ?>
    <div class="alerta">Color sin códigos activos</div>
                        <?php
                    }
                }
            } else {
                ?>
    <div class="nombre_cs">
      <a class="nombre_cs_a" href='productos.php?editcs=<?php echo $id_producto ?>'>
        Agregar Colores
      </a>
    </div>
                <?php
            }
            ?>
  </div>
  <!-- Secciones -->
  <div class="menu_col">
            <?php
                $query_secciones = "SELECT s.* 
                FROM secciones s 
                JOIN seccion_producto sp 
                ON s.id = sp.seccion_id 
                WHERE sp.producto_id = $id_producto";
              $secciones = obtener_todo($query_secciones);
            ?>
    <div class="lista_sec">
            <?php
            if ($secciones) {
                foreach ($secciones as $row_secciones) {
                    $nombre_seccion = $row_secciones['name'];
                    ?>
      <div class="nome_sec"><?php echo $nombre_seccion ?></div>
                    <?php
                }
            } else {
                ?>
      <div class="nome_sec alerta">-> Sin Secciones <-</div>
                <?php
            }
            ?>
    </div>
  </div>
  <!-- Nombre -->
  <div class="nombre_col">
    <a href="productos.php?edit=<?php echo $id_producto ?>">
                <?php echo $nombre_producto ?>
    </a>
  </div>
  <!-- Imagen -->
  <div class="imagen_col">
                <?php
                $query_fotos = "SELECT f.* 
                  FROM productos p 
                  JOIN colors c ON p.id = c.id_producto 
                  JOIN fotos f ON c.id = f.id_color 
                  WHERE p.id = $id_producto
                  ORDER BY inicio DESC";

                $fotos = obtener_todo($query_fotos);

                $primera = "";
                if ($fotos) {
                    $link = $fotos[0]['link'];
                    $primera = $fotos[0]['name'];
                    $primera_foto = "../images/productos/$primera";
                    if ($link == 1) {
                        $primera_foto = $primera;
                    }
                }

                if (!$primera) {
                    ?>
    <div>Sin Fotos</div>
                    <?php
                } else {
                    ?>
                    <a class="link_a" href="productos.php?show_fotos=<?php echo $id_producto ?>">
                        <?php
                        $file_info = pathinfo($primera_foto);
                        $extension = $file_info['extension'];
                        $extensiones_permitidas = ["mp4", "webm", "ogg", "mov", "m4v"];
                  // print_r($extension);
                        if (in_array($extension, $extensiones_permitidas)) {
                            ?>
                        <video height="100" autoplay muted loop>
                            <source src="<?php echo $primera_foto ?>" type="video/mp4">
                            Tu navegador no soporta el elemento de video.
                        </video>
                            <?php
                        } else {
                            ?>    
                        <img src="<?php echo $primera_foto ?>">
                            <?php
                        }
                        ?>
                    </a>
                    <?php
                }
                ?>
  </div>
  <!-- Agotar -->
  <div class="opcion_col">
    <a  class="btn_opciones alerta" href="productos.php?agotar=<?php echo $id_producto ?>" class="boton_agotar">
      Agotar Stock
    </a>
  </div>
  <!-- Estado -->
  <div class="opcion_col">
                <?php
                if ($activo_producto == 1) {
                    ?>
    <a class="btn_opciones desactivar" href="productos.php?sus=<?php echo $id_producto ?>" class="boton">
      <img src="images/svg/icons/activo.svg"> Suspender
    </a>            
                    <?php
                } else {
                    if (!$primera) {
                        ?>
    <a class="btn_opciones bloqueado" href="#" class="boton" >Bloqueado</a>                
                        <?php
                    } else {
                        ?>
    <a class="btn_opciones activar" href="productos.php?act=<?php echo $id_producto ?>" class="boton">
      <img src="images/svg/icons/inactivo.svg"> Activar
    </a> 
                        <?php
                    }
                }
                ?>
  </div>
  <!-- Editar -->
  <div class="opcion_col">
    <a 
      class="btn_opciones" 
      href="productos.php?editprod=<?php echo $id_producto ?>" 
    >
    Editar
    </a>
  </div>
  <!-- Eliminar -->
  <div class="opcion_col">
    <a class="btn_opciones alerta" href="productos.php?del=<?php echo $id_producto ?>" >
      Eliminar
    </a>
  </div>
</div>
                <?php
        }
            $i++;
    }
        paginacion_inferior($cantidad_prod, $paginacion, $cantidadxpag);
}

function paginacion_inferior($cantidad_prod, $paginacion, $cantidadxpag)
{
    $paginas = ceil($cantidad_prod / $cantidadxpag);

    $seccion = "";
    $ruta = "productos.php?pag=";
    if (isset($_GET['seccion'])) {
        $seccion = $_GET['seccion'];
        $ruta = "productos.php?seccion=" . $seccion . "&pag=";
    }

    $menu = "";
    if (isset($_GET['menu'])) {
        $menu = $_GET['menu'];
        $ruta = "productos.php?menu=" . $menu . "&pag=";
    }
    ?>
  <div class="paginacion">
    <?php
    $p = 1;
    while ($p <= $paginas) {
        $seleccionada = "";
        if ($p == $paginacion) {
              $seleccionada = "activa";
        }
        ?>
  <div class="pagina <?php echo $seleccionada ?>"><a href="<?php echo $ruta . $p ?>"><?php echo $p; ?></a></div>
            <?php
            $p++;
    }
    ?>
  </div>
    <?php
}
