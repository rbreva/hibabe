<?php

function show_all_images($fotos)
{
    $query_producto = "SELECT * FROM productos WHERE id = $fotos";
    $producto = obtener_linea($query_producto);
    $name_producto = $producto['name'];

    $query_fotos = "SELECT f.* 
                  FROM productos p 
                  JOIN colors c ON p.id = c.id_producto 
                  JOIN fotos f ON c.id = f.id_color 
                  WHERE p.id = $fotos
                  ORDER BY orden ASC";
    $fotos_lista = obtener_todo($query_fotos);

    $extensiones_permitidas = ["mp4", "webm", "ogg", "mov", "m4v"];
    ?>

<div class="titulo_prod">Fotos de Producto: <?php echo $name_producto ?></div>
<div class="producto">
  <div class="fotos">
    <div class="muestra">
    <?php
    if (!$fotos_lista) {
        ?>
        <p>Aún no hay fotos relacionadas</p>
        <p>Mientras el producto no tenga fotografías relacionadas no puede ser activado.</p>
        <?php
    } else {
        foreach ($fotos_lista as $row) {
            $id_foto = $row['id'];
            $nombre_foto = $row['name'];
            $foto_inicio = $row['inicio'];
            $foto_show = "../images/productos/small/$nombre_foto";
            $foto_link = $row['link'];
            if ($foto_link == 1) {
                $foto_show = $nombre_foto;
            }
            $file_info = pathinfo($foto_show);
            $extension = $file_info['extension'];
            ?>
        <div class="fotoedit">
            <div class="foto">
                <?php
                if (in_array($extension, $extensiones_permitidas)) {
                    ?>
                <video width="100%" autoplay muted loop>
                    <source src="<?php echo $foto_show ?>" type="video/mp4">
                    Tu navegador no soporta el elemento de video.
                </video>
                    <?php
                } else {
                    ?>    
                <img src="<?php echo $foto_show ?>">
                    <?php
                }
                ?>
            </div>
            <div class="actdes">
            <?php
            if ($foto_inicio == 1) {
                $check = "checked";
            } else {
                $check = "";
            }
            ?>
                <input type="radio" name="checkfoto" attr-idfoto="<?php echo $id_foto ?>" <?php echo $check ?>>
            </div>
        </div>
        <script>
            $("input[name=checkfoto]").on("change",function(){
            var idfoto = $(this).attr("attr-idfoto");
            var idpro = "<?php echo $fotos ?>";
            console.log(idfoto);
            console.log(idpro);
            $.ajax({
                url: 'primera_foto.php',
                type: 'post',
                data: {"idfoto": idfoto,"idpro":idpro},
                })
                .done(function(res) {
                console.log(res);
                })
                .fail(function() {
                console.log("error");
                })
            })
        </script>
            <?php
        }
    }
    ?>
    </div>
  </div>
  <div class="botonera">
    <button id="botonRegreso" class="btn_a">Regresar</button>
    <script src="js/retorno.js"></script>
  </div> 
</div>        
    <?php
}
