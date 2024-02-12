<?php

function cantidadprod()
{
    ?>
<div class="barra_titulo">
    <h2 class="titulo_h2">Productos Inicio</h2>
    <a class="nuevo_btn" href="destacados.php?sec=ordenar_productos">Ordenar imagenes</a>
</div>
<div class="destacados">
    <div class="nombre"><span class="titulo_tabla">Nombre</span></div>
    <div class="imagen"><span class="titulo_tabla">Imagen</span></div>
    <div class="imagen"><span class="titulo_tabla">Producto Inicio</span></div>
</div>
    <?php
    $query = "SELECT * FROM productos WHERE active = 1";
    $productos = obtener_todo($query);
    if ($productos) {
        foreach ($productos as $row) {
            $id_producto = $row['id'];
            $nombre_producto = $row['name'];
            $inicio = $row['inicio'];

            $query_fotos = "SELECT f.* 
                FROM productos p 
                JOIN colors c ON p.id = c.id_producto 
                JOIN fotos f ON c.id = f.id_color 
                WHERE p.id = $id_producto
                ORDER BY inicio DESC";

            $fotos = obtener_todo($query_fotos);
            $primera = $fotos[0]['name'];
            $link = $fotos[0]['link'];
            if ($link == 0) {
                $fotosrc = "../images/productos/$primera";
            } else {
                $fotosrc = $primera;
            }
            $checked = "";
            if ($inicio == 1) {
                $checked = "checked";
            }
            ?>
<div class="destacados">
    <div class="nombre"><?php echo $nombre_producto ?></div>
    <div class="imagen"><img src="<?php echo $fotosrc ?>"></div>
    <div class="imagen">
        <input 
            type="checkbox" <?php echo $checked ?> 
            id="checksel<?php echo $id_producto ?>" 
            class="<?php echo $id_producto ?>"
        >
    </div>
</div>
<script>
    $(document).ready(function() {
        //alert($("#checksel<?php echo $id_producto ?>").val());
        $("#checksel<?php echo $id_producto ?>").on("change", function() {
            var idsel = $(this).attr("class");
            if ($(this).is(":checked")) {
                var selecc = "1";
            } else {
                var selecc = "0";
            }
            $.ajax({
                    url: 'validar_cantidad.php',
                    type: 'post',
                    data: {
                        'seleccionado': idsel,
                        'nrosql': selecc
                    },
                    success: function(response) {
                        // La llamada AJAX se completó con éxito
                        // console.log('Respuesta del servidor:', response);
                    },
                })
                .done(function(res) {
                    //console.log(res);
                })
                .fail(function(res) {
                    console.log(res);
                })
        })

    })
</script>
            <?php
        }
    }
}

function ordenar_productos()
{
    $query = "SELECT * FROM productos WHERE inicio = 1 ORDER BY orden_inicio ASC";
    $producto = obtener_todo($query);
    ?>
<script src="js/dragdrovejs/jquery-2.2.0.min.js"></script>
<script src="js/dragdrovejs/bootstrap.min.js"></script>
<script src="js/dragdrovejs/jquery-ui.min.js"></script>    
<div class="producto">
    <div class="datos">
        <div id="fotos">
            <div id="muestra">
                <div id="imgSlide" >
                    <ul id="columnasSlideinicio">
    <?php
    foreach ($producto as $itemprod) {
        $id_producto = $itemprod['id'];

        $query_fotos = "SELECT f.* 
        FROM productos p 
        JOIN colors c ON p.id = c.id_producto 
        JOIN fotos f ON c.id = f.id_color 
        WHERE p.id = $id_producto
        ORDER BY inicio DESC";

        $fotos = obtener_todo($query_fotos);
        $primera = $fotos[0]['name'];
        $link = $fotos[0]['link'];
        if ($link == 0) {
            $fotosrc = "../images/productos/$primera";
        } else {
            $fotosrc = $primera;
        }
        ?>
                        <li id="<?php echo $id_producto ?>" class="bloqueSlideinicio">
                            <img src="<?php echo $fotosrc ?>" class="handleImginicio" width="200">
                        </li>
                    <?php
    }
    ?>
                    </ul>
                    <button id="ordenarSlideinicio" class="btn btn-warning pull-right" style="margin:10px 30px">
                        Ordenar Slides
                    </button>
                    <button 
                    id="guardarSlideinicio" 
                    class="btn btn-primary pull-right" 
                    style="display:none; margin:10px 30px"
                    >
                        Guardar Orden Slides
                    </button>
                </div>
            </div>
        </div>    
    </div>        
</div>
<script src="js/dragdrovejs/gestorSlide.js"></script>
    <?php
}
