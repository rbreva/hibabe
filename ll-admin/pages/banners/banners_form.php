<?php

function form_banner($link, $type, $id_banner, $id_lat)
{
    if ($id_banner) {
        $query_banner = "SELECT * FROM banners WHERE id = $id_banner";
        $banner = obtener_linea($query_banner);
        $nombre_txt = $banner['name'];
        $link_url = $banner['link'];
        $image = $banner['image'];
        $btntxt = "Editar Banner";
        $accion = "editar";
    } else {
        $nombre_txt = "";
        $link_url = "";
        if ($type == "desktop") {
            $image = "sin_banner.jpg";
        } elseif ($type == "mobile") {
            $image = "sin_banner_mobile.jpg";
        }
        $btntxt = "Agregar Nuevo Banner";
        $accion = "nuevo";
    }
    // echo $link . "<br>";
    ?>
    <form action="<?php echo $link ?>" method="post" enctype="multipart/form-data">
        <div class="banner">
            <div class="linea">
                <label for="name">Nombre*: </label>
                <input id="name" name="nombre_txt" type="text" maxlength="50" value="<?php echo $nombre_txt ?>"required>
            </div>
            <div class="linea">
                <label for="link">Link: </label>
                <input id="link" name="link_url" type="url" value="<?php echo $link_url ?>" maxlength="100">
            </div>
            <div class="linea">
                <input 
                    type="file" 
                    id="fileInput" 
                    name="fileInput" 
                    accept="image/*,video/*" 
                    onchange="previewFile()" 
                    required
                >
            </div>
            <?php
            if ($type == "desktop") {
                ?>
                <div class="imagen" id="preview">
                    <img src="../images/banners/<?php echo $image ?>" alt="Imagen">
                </div>
                <?php
            } elseif ($type == "mobile" || $type == "seccion") {
                ?>
                <div class="imagen_mobile" id="preview">
                    <img src="../images/banners/<?php echo $image ?>" alt="Imagen">
                </div>
                <?php
            }
            ?>
            <script>
                function previewFile() {
                    var fileInput = document.getElementById('fileInput');
                    var preview = document.getElementById('preview');

                    while (preview.firstChild) {
                        preview.removeChild(preview.firstChild);
                    }

                    var file = fileInput.files[0];
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        if (file.type.startsWith('image')) {
                            var img = document.createElement('img');
                            img.src = e.target.result;
                            // img.style.maxWidth = '100%';
                            // img.style.maxHeight = '600px';
                            preview.appendChild(img);
                        } else if (file.type.startsWith('video')) {
                            var video = document.createElement('video');
                            video.src = e.target.result;
                            video.controls = true;
                            // video.style.maxWidth = '100%';
                            // video.style.maxHeight = '600px';
                            preview.appendChild(video);
                        }
                    };

                    reader.readAsDataURL(file);
                }
            </script>
            <div class="botonera">
                <input name="<?php echo $accion ?>" value="<?php echo $accion ?>" type="hidden">
                <button type="submit" class="acc_btn"><?php echo $btntxt ?></button>
                <a class="btn_a" href="banners.php?menu_lat=<?php echo $id_lat ?>" class="boton">Regresar</a>
            </div>
        </div>
    </form>
    <?php
}

function form_banner_del($id_lat, $id_banner)
{
    ?>
<div class="del_conf">
    <div class="del_msj">¿Realmente desea eliminar el Banner?</div>
    <div class="linea">
        <a href="banners.php?menu_lat=<?php echo $id_lat ?>" class="retorno_btn">Regresar</a>
        <a 
            href="banners.php?menu_lat=<?php echo $id_lat ?>&acc=del&id=<?php echo $id_banner ?>&eliminar=borralo" 
            class="del_btn"
        >
            Si, Eliminar Banner
        </a>
    </div>
</div>
    <?php
}
