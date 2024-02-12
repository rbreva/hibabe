<?php

function add_banner($nuevo, $id_lat)
{
    if ($nuevo == "nuevo") {
        $nombre_txt = $_POST['nombre_txt'];
        $link_url = "";
        if (isset($_POST['link_url'])) {
            $link_url = $_POST['link_url'];
        }
        $fileInput = $_FILES['fileInput'];
        $file_name = $fileInput['name'];
        $file_size = $fileInput['size'];
        $file_tmp = $fileInput['tmp_name'];
        $file_error = $fileInput['error'];
        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));
        $allowed = array('jpg', 'jpeg', 'png', 'gif', 'mp4', 'webm', 'ogg', 'm4v');
        if (in_array($file_ext, $allowed)) {
            if ($file_error === 0) {
                if ($file_size <= 100097152) {
                    $file_name_new = uniqid('', true) . '.' . $file_ext;
                    $file_destination = '../images/banners/' . $file_name_new;
                    if (move_uploaded_file($file_tmp, $file_destination)) {
                        $query_banner = "INSERT 
                            INTO banners (
                            name,
                            link, 
                            image,
                            id_menu_lat 
                            ) VALUES (
                            '$nombre_txt', 
                            '$link_url', 
                            '$file_name_new',
                            $id_lat
                            )";
                        $result_banner = actualizar_registro($query_banner);
                        if ($result_banner) {
                            $msj = "El banner se ha creado correctamente";
                        } else {
                            $msj = "Error en el sevidor, por favor intente nuevamente";
                        }
                    } else {
                        $msj = "No se pudo agregar al servidor, por favor intente nuevamente";
                    }
                } else {
                    $msj = "El archivo es demasiado grande";
                }
            } else {
                $msj = "Error al subir el archivo mp4";
            }
        } else {
            $msj = "Tipo de archivo no permitido";
        }
        $ruta = "banners.php?menu_lat=$id_lat";
        $boton = "Regresar";
        mensaje_generico($msj, $ruta, $boton);
    }
}

function edit_banner($editar, $id_lat, $id_banner)
{
    if ($editar == "editar") {
        $nombre_txt = $_POST['nombre_txt'];
        $link_url = "";
        if (isset($_POST['link_url'])) {
            $link_url = $_POST['link_url'];
        }
        $fileInput = $_FILES['fileInput'];
        $file_name = $fileInput['name'];
        $file_size = $fileInput['size'];
        $file_tmp = $fileInput['tmp_name'];
        $file_error = $fileInput['error'];
        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));
        $allowed = array('jpg', 'jpeg', 'png', 'gif', 'mp4', 'webm', 'ogg', 'm4v');
        if (in_array($file_ext, $allowed)) {
            if ($file_error === 0) {
                if ($file_size <= 12097152) {
                    $file_name_new = uniqid('', true) . '.' . $file_ext;
                    $file_destination = '../images/banners/' . $file_name_new;
                    if (move_uploaded_file($file_tmp, $file_destination)) {
                        $query_banner = "UPDATE banners SET 
                            name = '$nombre_txt', 
                            link='$link_url', 
                            image='$file_name_new', 
                            id_menu_lat=$id_lat 
                            WHERE id = $id_banner";
                        $result_banner = actualizar_registro($query_banner);
                        if ($result_banner) {
                            $msj = "El banner se ha editado correctamente";
                        } else {
                            $msj = "Error en el sevidor, por favor intente nuevamente";
                        }
                    } else {
                        $msj = "No se pudo agregar al servidor, por favor intente nuevamente";
                    }
                } else {
                    $msj = "El archivo es demasiado grande";
                }
            } else {
                $msj = "Error al subir el archivo";
            }
        } else {
            $msj = "Tipo de archivo no permitido";
        }
        $ruta = "banners.php?menu_lat=$id_lat&acc=edit&id=$id_banner";
        $boton = "Regresar";
        mensaje_generico($msj, $ruta, $boton);
    }
}

function del_banner($id_lat, $id_banner)
{
    $query = "DELETE FROM banners WHERE id = '$id_banner'";
    if (actualizar_registro($query)) {
        $msj = "Banner Eliminado";
    } else {
        $msj = "Error en el Servidor, Intente de Nuevo";
    }
    $ruta = "banners.php?menu_lat=$id_lat";
    $boton = "Regresar";
    mensaje_generico($msj, $ruta, $boton);
}

function banner_sus($id_lat, $id_banner)
{
    $query = "UPDATE banners SET active = 0 WHERE id = '$id_banner'";
    if (actualizar_registro($query)) {
        $msj = "Banner Suspendido";
    } else {
        $msj = "Error en el Servidor, Intente de Nuevo";
    }
    $ruta = "banners.php?menu_lat=$id_lat";
    $boton = "Regresar";
    mensaje_generico($msj, $ruta, $boton);
}

function banner_act($id_lat, $id_banner)
{
    $query = "UPDATE banners SET active = 1 WHERE id = '$id_banner'";
    if (actualizar_registro($query)) {
        $msj = "Banner Activado";
    } else {
        $msj = "Error en el Servidor, Intente de Nuevo";
    }
    $ruta = "banners.php?menu_lat=$id_lat";
    $boton = "Regresar";
    mensaje_generico($msj, $ruta, $boton);
}
