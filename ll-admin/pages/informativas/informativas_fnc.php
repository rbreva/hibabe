<?php

function pagina_informativa($menu_pag)
{
    $actualizar = isset($_POST['accion']) ? $_POST['accion'] : null ;
    $query = "SELECT * FROM informativas WHERE id = $menu_pag";
    $pagina = obtener_linea($query);

    $contenido = $pagina['contenido'];
    $contenido = htmlentities($contenido);
    $name = $pagina['name'];

    if ($actualizar == "actualizar") {
        $titulo = isset($_POST['titulo_txt']) ? $_POST['titulo_txt'] : null ;
        $contenido_new = isset($_POST['contenido_txt']) ? $_POST['contenido_txt'] : null ;
        $query_pagint = "UPDATE 
            informativas 
            SET 
            name = '$titulo', 
            contenido = '$contenido_new' 
            WHERE id = '$menu_pag'";
        if (actualizar_registro($query_pagint)) {
            $msj = "Página Actualizada Correctamente";
        } else {
            $msj = "Ha habido un problema en el servidor por favor intentar nuevamente";
        }
        $ruta = "informativas.php?pag=" . $menu_pag;
        $boton = "Regresar";
        mensaje_generico($msj, $ruta, $boton);
    } else {
        $tiny = "jrpahjfkukmd5c3xtic4mkbttepp9135rfkn4lzjwwlplc7y/tinymce/5/tinymce.min.js";
        ?>
    <div class="formulario">
        <form 
            enctype="application/x-www-form-urlencoded" 
            action="informativas.php?pag=<?php echo $menu_pag ?>" 
            method="post"
        >
            <div class="linea"> 
                <div class="titulo_lin">Título: </div>
                <div class="dato_lin"><input name="titulo_txt" type="text" value="<?php echo $name ?>"></div>
            </div>
            <div class="linea">
                <div class="titulo_lin"> Contenido: </div>
                <div class="dato_text">
                <textarea id="mytextarea" name="contenido_txt"><?php echo $contenido ?></textarea>
                <script src="https://cdn.tiny.cloud/1/<?php echo $tiny; ?>" referrerpolicy="origin"></script>
                <script>
                tinymce.init({
                  selector: '#mytextarea',
                  language: 'es',
                  content_style: 'body { font-size:14px }',
                  menubar: false,
                  plugins: [
                      'autoresize',
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                  ],
                  toolbar: 'undo redo | formatselect | ' +
                  'bold italic backcolor | alignleft aligncenter ' +
                  'alignright alignjustify | bullist numlist outdent indent | ' +
                  'removeformat |',
                });
                </script>
                </div>
            </div>    
        <div class="linea">    
            <input type="hidden" name="accion" value="actualizar"  />
            <button class="btn_linea" type="submit">Actualizar</button>
        </div>    
        </form>
    </div>
        <?php
    }
}
