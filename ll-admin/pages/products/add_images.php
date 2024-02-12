<?php

function add_images()
{
    $id_color = $_GET['add_fotos'];

    if (isset($_GET['idfoto'])) {
        $idfoto = $_GET['idfoto'];
        $accion = $_GET['accion'];
        if ($accion == "desactiva") {
            $query_desactivar = "UPDATE fotos SET active = '0' WHERE id = '$idfoto'";
            actualizar_registro($query_desactivar);
        } elseif ($accion == "activa") {
            $query_activar = "UPDATE fotos SET active = '1' WHERE id = '$idfoto'";
            actualizar_registro($query_activar);
        }
    }

    if (isset($_POST['acciones_color'])) {
        agregar_fotos();
    } else {
        mostrar_fotos($id_color);

        $query_color = "SELECT * FROM colors WHERE id = '$id_color'";
        $color = obtener_linea($query_color);
        $color_nombre = $color['name'];
        $id_producto_color = $color['id_producto'];

        $query_producto = "SELECT * FROM productos WHERE id = '$id_producto_color'";
        $producto = obtener_linea($query_producto);
        $producto_nombre = $producto['name'];

        fotos_inicio($id_color, $color_nombre, $producto_nombre);
    }
}

function fotos_inicio($id_color, $color_nombre, $producto_nombre)
{
    ?>
  <div class="colores">
    <div class="color">
      <div class="titulo_color">
        Agregar Foto: <?php echo $producto_nombre ?> - <?php echo $color_nombre ?>
      </div>
      <form action="productos.php?add_fotos=<?php echo $id_color ?>" method="post" enctype="multipart/form-data">
        <div class="agregar_color">
          La imagen debe tener un tamaño mínimo recomendado de 800px de ancho por 1200px de alto.
        </div>
        <div class="dato">
          <input type="file" name="fotocolor[]" multiple="multiple" required>
        </div>
        <div class="dato">
          <input type="hidden" value="nuevas_fotos" name="acciones_color">
          <input type="hidden" value="<?php echo $id_color ?>" name="id_color">
          <button type="submit" class="colores_btn">Agregar Nuevas Fotos</button>
        </div>
      </form>
    </div>
    <div class="botonera">
      <button id="botonRegreso" class="btn_a">Regresar</button>
      <script src="js/retorno.js"></script>
    </div>
  </div>
    <?php
}

function agregar_fotos()
{
    if (isset($_POST['acciones_color'])) {
        $id_color = $_POST['id_color'];
        $accion_color = $_POST['acciones_color'];
        if ($accion_color == "nuevas_fotos") {
            $cantidad = count($_FILES['fotocolor']['tmp_name']);
            if ($cantidad > '5') {
                $ruta = "productos.php?add_fotos=$id_color";
                $msj = "Por favor seleccionar máximo 5 Fotografias, con extenciones 
                .jpg o .png, no se permiten otras extensiones";
                $boton = "Regresar";
                mensaje_generico($msj, $ruta, $boton);
            } else {
                $msj = "";
                foreach ($_FILES["fotocolor"]['tmp_name'] as $key => $tmp_name) {
                    $imagen = trim($_FILES['fotocolor']['name'][$key]);
                    $temporal = $_FILES['fotocolor']['tmp_name'][$key];
                    $imagen_size = $_FILES['fotocolor']['size'][$key];
                    $imagen_type = $_FILES['fotocolor']['type'][$key];
                    $nombre_tipo = '';
                    if ($imagen_type == 'image/jpeg') {
                        $nombre_tipo = '.jpg';
                    } elseif ($imagen_type == 'image/png') {
                        $nombre_tipo = '.png';
                    }
                    $nombrerand = time()
                    . rand(0, 9)
                    . rand(100, 9999)
                    . rand(100, 9999)
                    . rand(1000, 99999)
                    . $nombre_tipo;
                    if ($imagen_type == 'image/jpeg' || $imagen_type == 'image/png') {
                        if ($imagen_size < 2000000) {
                            agregar_imagenes($temporal, $imagen_type, $nombrerand);
                            $query_nueva_foto = "INSERT INTO fotos (
                              name, 
                              id_color
                              ) VALUES (
                              '$nombrerand', 
                              '$id_color')";
                            if (actualizar_registro($query_nueva_foto)) {
                                $msj .= "Imagen: " . $imagen . ", agregada con éxito.<br>";
                            } else {
                                $msj .= "Error al subir la imagen: " . $imagen .
                                ", por favor intentar nuevamente.";
                            }
                        } else {
                            $msj .= "La Imagen: " . $imagen . ", tiene un peso mayor al permitido: 2 megas";
                        }
                    } else {
                        $msj .= "El Archivo: " . $imagen . ", no es de un formato permitido: jpg o png.";
                    }
                }
                $ruta = "productos.php?add_fotos=$id_color";
                $boton = "Regresar";
                retorno_back($msj, $boton);
            }
        }
    }
}

function mostrar_fotos($id_color)
{
    $query_fotos_color = "SELECT * FROM fotos 
      WHERE id_color = '$id_color'";
    $fotos_color = obtener_todo($query_fotos_color);
    ?>
  <div class="muestra">
    <?php
    if (!$fotos_color) {
        ?>
      <div class="vacio">Aún no hay fotos</div>
        <?php
    } else {
        listar_fotos($id_color, $fotos_color);
    }
    ?>
  </div>
    <?php
}

function listar_fotos($id_color, $fotos_color)
{
    $cont = 1;
    $conta = 1;
    $contad = 1;
    foreach ($fotos_color as $row) {
        $id_foto = $row['id'];
        $nombre = $row['name'];
        $activo = $row['active'];
        $foto = "../images/productos/small/$nombre";
        $link = $row['link'];
        if ($link == 1) {
            $foto = $nombre;
        }
        ?>
    <div class="fotoedit">
      <div class="foto">
        <img src="<?php echo $foto ?>" />
        <input type="hidden" value="<?php echo $id_foto ?>" class="<?php echo $contad++ ?>">
        <input type="hidden" value="<?php echo $nombre ?>" class="xd" id="<?php echo $cont ?>">
      </div>
      <div class="actdes">
        <?php
        $btn_activo = "activo.svg";
        $acc = "desactiva";
        $btn_acc = "Desactivar";
        if ($activo == false) {
            $btn_activo = "inactivo.svg";
            $acc = "activa";
            $btn_acc = "Activar";
        }
        ?>
        <div class="act_des_btn">
          <img src="images/svg/icons/<?php echo $btn_activo ?>">
          <a 
            href="productos.php?add_fotos=<?php echo $id_color ?>
&idfoto=<?php echo $id_foto ?>
&accion=<?php echo $acc ?>" 
            class="btn_a"
          >
          <?php echo $btn_acc ?>
          </a>
        </div>
        <div class="act_des_btn">
          <img src="images/svg/icons/inactivo.svg" width="12">
          <button class="btn_a btn_del nom<?php echo $conta++ ?>">
            Eliminar
          </button>
        </div>
      </div>
    </div>
    <script>
      $(document).ready(function() {
        var arraynom = [];
        $(".xd").each(function() {
          var s = $(this).attr('id');
          $(".nom" + s).click(function() {
            var e = $("#" + s).val();
            var idfoto = $("." + s).val();
            console.log(e);
            console.log(idfoto);
            $.ajax({
              url: 'elimina_foto.php',
              type: 'post',
              data: {
                'nomfoto': e,
                'idfoto': idfoto
              },
              success: function(res) {
                console.log("asd");
                location.reload();
              },
              error: function(resp) {
                console.log(resp);
              }
            })

          })
        })
      });
    </script>
        <?php
        $cont++;
    }
}
