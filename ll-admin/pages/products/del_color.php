<?php

function del_color($delc)
{
    if (isset($_GET['conft'])) {
        $query_fotos = "SELECT * FROM fotos WHERE id_color = $delc";
        $fotos = obtener_todo($query_fotos);
        $query_codigos = "SELECT * FROM codigos WHERE id_color = $delc";
        $codigos = obtener_todo($query_codigos);

        $query_transaccion = [];
        if ($fotos) {
            foreach ($fotos as $foto) {
                $id_foto = $foto['id'];
                $query_del_foto = "DELETE FROM fotos WHERE id = $id_foto";
                array_push($query_transaccion, $query_del_foto);
            }
        }

        if ($codigos) {
            foreach ($codigos as $codigo) {
                $id_codigo = $codigo['id'];
                $query_del_codigo = "DELETE FROM codigos WHERE id = $id_codigo";
                array_push($query_transaccion, $query_del_codigo);
            }
        }

        $query_del_color = "DELETE FROM colors WHERE id = $delc";
        array_push($query_transaccion, $query_del_color);

        // foreach ($query_transaccion as $query) {
        //     echo $query . "<br>";
        // }

        if (actualizar_transaccion($query_transaccion)) {
            $msj = "<p>Color Eliminado</p>";
        } else {
            $msj = "<p>Error en el servidor intente nuevamente por favor</p>";
        }
        $boton = "Regresar";
        retorno_back3($msj, $boton);
    } else {
        ?>
<div class="del_conf">
<div class="del_msj">¿Realmente desea eliminar Color?, NO se va a poder recuperar datos relacionados.</div>
<div class="del_msj">Se Elimarán las Fotografías Agregadas a este color.</div>
<div class="del_msj">Se eliminarán todos los Códigos/SKU relacionados al Color.</div>
<div class="linea">
  <a 
    href="productos.php?&del_color=<?php echo $delc ?>&conft=borralo" 
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
