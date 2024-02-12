<?php

function banner_new($id_lat, $title, $type)
{
    $id_banner = "";
    ?>
<div class="titulo_banner">Nuevo banner en: <?php echo $title ?></div>
    <?php
    $nuevo = "";
    if (isset($_POST['nuevo'])) {
        $nuevo = $_POST['nuevo'];
    };

    if ($nuevo == "nuevo") {
        add_banner($nuevo, $id_lat);
    } else {
        $link = "banners.php?menu_lat=$id_lat&acc=new";
        form_banner($link, $type, $id_banner, $id_lat);
    }
}

function banner_edit($id_lat, $title, $type, $id_banner)
{
    ?>
<div class="titulo_banner">Editar banner en: <?php echo $title ?></div>
    <?php
    $editar = "";
    if (isset($_POST['editar'])) {
        $editar = $_POST['editar'];
    };

    if ($editar == "editar") {
        edit_banner($editar, $id_lat, $id_banner);
    } else {
        $link = "banners.php?menu_lat=$id_lat&acc=edit&id=$id_banner";
        //echo $id_lat . "<br>";
        form_banner($link, $type, $id_banner, $id_lat);
    }
}

function banner_del($id_lat, $title, $id_banner)
{
    ?>
    <div class="titulo_banner">Eliminar banner en: <?php echo $title ?></div>
        <?php
        $eliminar = "";
        if (isset($_GET['eliminar'])) {
            $eliminar = $_GET['eliminar'];
        };

        if ($eliminar == "borralo") {
            del_banner($id_lat, $id_banner);
        } else {
            form_banner_del($id_lat, $id_banner);
        }
}
