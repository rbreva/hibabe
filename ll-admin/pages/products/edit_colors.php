<?php

function editcolors($edit_colors)
{
    $query_producto = "SELECT * FROM productos WHERE id = $edit_colors";
    $producto = obtener_linea($query_producto);
    $nombre_producto = $producto['name'];

    if (isset($_GET['activar'])) {
        $activar = $_GET['activar'];
        $query_activar = "UPDATE colors SET active = 1 WHERE id = '$activar'";
        actualizar_registro($query_activar);
    }
    if (isset($_GET['desactivar'])) {
        $desactivar = $_GET['desactivar'];
        $query_activar = "UPDATE colors SET active = 0 WHERE id = '$desactivar'";
        actualizar_registro($query_activar);
    }

    $editacc = "";
    if (isset($_POST['editacc'])) {
        $editacc = $_POST['editacc'];
        if ($editacc == "color_new_acc") {
            color_new($edit_colors);
        } elseif ($editacc == "edit_color_acc") {
            editar_color_nombre();
        }
    }
    ?>
<div class="subtitulo_prod">
  Modelos/Colores de <strong><?php echo $nombre_producto ?></strong>
</div>
    <?php
    editar_color_list($edit_colors);
    color_nuevo_form($edit_colors);
    ?>
<div class="botonera">
    <button id="botonRegreso" class="btn_a">Regresar</button>
    <script src="js/retorno.js"></script>
</div>
    <?php
}

function editar_color_list($edit_colors)
{
    $query_colores = "SELECT * FROM colors WHERE id_producto = '$edit_colors'";
    $obtener_colores = obtener_todo($query_colores);
    if ($obtener_colores) {
        ?>
<script type="text/javascript" src="js/picker/colorpicker.js"></script>
<link rel="stylesheet" href="css/picker/colorpicker.css" type="text/css">
        <?php
        foreach ($obtener_colores as $rowcolor) {
            edit_color_form($edit_colors, $rowcolor);
        }
    }
}

function edit_color_form($edit_colors, $color)
{
    $nombre_color = $color['name'];
    $codigo_color = $color['codigo_color'];
    $id_color = $color['id'];
    $active_color = $color['active'];
    ?>
  <form 
    class="form_producto" 
    action="productos.php?editcolors=<?php echo $edit_colors ?>" 
    method="post" 
    enctype="multipart/form-data"
    id="frmedit<?php echo $id_color ?>"
  >
    <div class="datos">
      <div class="linea">
        <label class="linea_tit" for="color_<?php echo $edit_colors ?>">Modelo/Color: </label>
        <input 
          id="color_<?php echo $edit_colors ?>" 
          name="color_txt" 
          type="text" 
          value="<?php echo $nombre_color ?>" 
          required
        >

        <div 
          class="data cambiarcolor<?php echo $id_color ?>" 
          style="
            width: 20px; 
            height: 20px;
            border: 1px solid #ccc;
            background: <?php echo $codigo_color ?>"
        >
        </div>
        <div class="btns">
          <input type="hidden" id="hex_color<?php echo $id_color ?>" name="color_prenda" value="<?php echo $codigo_color ?>">
          <input type="button" class="btn_linea destaque" id="colorSelector<?php echo $id_color ?>" value="Seleccionar Color">
        </div>
        <div class="btns">
          <input type="hidden" value="<?php echo $id_color ?>" name="id_color">
          <input type="hidden" value="edit_color_acc" name="editacc">
          <button type="submit" class="btn_linea">Cambiar Color</button>

          <div class="sep_lin">|</div>

          <!-- Activar/Desactivar -->
          <?php
            $activo_txt = "Desactivar";
            $activo_acc = "desactivar";
            $btn_color = "btn_prendido";
            if ($active_color == false) {
                $activo_txt = "Activar";
                $activo_acc = "activar";
                $btn_color = "btn_apagado";
            }
            ?>
          <div class="data">
            <a 
              id="enlace<?php echo $id_color ?>"
              href="productos.php?editcolors=<?php echo $edit_colors ?>&<?php echo $activo_acc ?>=<?php echo $id_color ?>" 
              class="btn_linea <?php echo $btn_color ?>"
              rel="noopener"
            >
              <?php echo $activo_txt ?>
            </a>
            <script>
                const enlace<?php echo $id_color ?> = document.getElementById('enlace<?php echo $id_color ?>');

                enlace<?php echo $id_color ?>.addEventListener('click', (event) => {
                    event.preventDefault(); // Prevenir el comportamiento predeterminado del enlace
                    window.location.replace(enlace<?php echo $id_color ?>.href); // Cambiar la ubicación sin agregar al historial
                });
            </script>
          </div>
          <!-- Fotos -->
          <div class="data">
            <?php
            $query_fotos = "SELECT * FROM fotos WHERE id_color = '$id_color'";
            $obtener_fotos = obtener_todo($query_fotos);
            if ($obtener_fotos) {
                $fotos = count($obtener_fotos);
            } else {
                $fotos = 0;
            }
            ?>
            <a 
              href="productos.php?add_fotos=<?php echo $id_color ?>" 
              class="btn_linea destaque"
            >
              Fotos (<?php echo $fotos ?>)
            </a>
          </div>
          <!-- Stock -->
          <div class="data">
            <?php
            $query_codigos = "SELECT * FROM codigos WHERE id_color = '$id_color'";
            $obtener_codigos = obtener_todo($query_codigos);
            if ($obtener_codigos) {
                $codigos = count($obtener_codigos);
            } else {
                $codigos = 0;
            }
            ?>
            <a 
              href="productos.php?&stock=<?php echo $id_color ?>" 
              class="btn_linea"
            >
              Stock/SKU (<?php echo $codigos ?>)
            </a>
          </div>
          <!-- Eliminar -->
          <div class="data">
            <a 
              href="productos.php?&del_color=<?php echo $id_color ?>" 
              class="btn_linea alerta"
            >
              Eliminar
            </a>
          </div>
            <!-- Mensaje actualizado -->
          <div style="display: none" class="data" id="rspt<?php echo $id_color ?>">
            Dato actualizado!
          </div>
        </div>
      </div>  
    </div>  
  </form>
  <script>
    $("#frmedit<?php echo $id_color ?>").on("submit",function(e){
      e.preventDefault();
      $.ajax({
        type: $(this).attr("method"),
        url: $(this).attr("action"),
        data: $(this).serialize(),
        success: function(res){
          $("#rspt<?php echo $id_color ?>").show("slow");
          setTimeout(() => {
          $("#rspt<?php echo $id_color ?>").hide();
          }, 3000);
        },
        error: function(res){
          console.log(res);
        }
      })
    })
  </script>
  <script>
    $('#colorSelector<?php echo $id_color ?>').ColorPicker({
        color: '<?php echo $codigo_color ?>',
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {

    //        $('body').css('background', '#' + hex);
            $("#hex_color<?php echo $id_color ?>").val('#'+hex);
            $(".cambiarcolor<?php echo $id_color ?>").attr("style","width: 20px; height: 20px; background: #"+hex);

        }
    });
  </script>
    <?php
}

function color_nuevo_form($edit_colors)
{
    ?>
  <form 
    class="form_producto" 
    action="productos.php?editcolors=<?php echo $edit_colors ?>" 
    method="post" 
    enctype="multipart/form-data"
  >
    <div class="datos">
      <div class="linea">
        <label class="linea_tit" for="color_new">Modelo/Color: </label>
        <input id="color_new" name="color_txt" type="text" required>
        <div class="btns">
          <input type="hidden" value="color_new_acc" name="editacc">
          <button type="submit" class="btn_linea">Agregar Color</button>
        </div>
      </div>  
    </div>  
  </form>
      <?php
}

function color_new($edit_colors)
{
    $name_new_color = $_POST['color_txt'];

    $query_new_color = "INSERT INTO colors ( name, id_producto ) VALUES ( '$name_new_color','$edit_colors')";
    actualizar_registro($query_new_color);
}

function editar_color_nombre()
{
    $nombre_color = $_POST['color_txt'];
    $id_color = $_POST['id_color'];
    $codigo_color = $_POST['color_prenda'];
    $query_codigo_editar = "UPDATE 
      colors SET 
      name = '$nombre_color', 
      codigo_color = '$codigo_color' 
      WHERE id = '$id_color'";
    actualizar_registro($query_codigo_editar);
}
