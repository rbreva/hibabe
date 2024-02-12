<?php

function products_list()
{
    if (isset($_GET['acc'])) {
        $acc = $_GET['acc'];
        if ($acc == "newprod") {
            nuevo_prod();
        }
    } elseif (isset($_GET['editprod'])) {
        $edit_prod = $_GET['editprod'];
        editprod($edit_prod);
    } elseif (isset($_GET['editcolors'])) {
        $edit_colors = $_GET['editcolors'];
        editcolors($edit_colors);
    } elseif (isset($_GET['show_fotos'])) {
        $fotos = $_GET['show_fotos'];
        show_all_images($fotos);
    } elseif (isset($_GET['add_fotos'])) {
        $fotos = $_GET['add_fotos'];
        add_images($fotos);
    } elseif (isset($_GET['stock'])) {
        $stock = $_GET['stock'];
        stock($stock);
    } elseif (isset($_GET['del_color'])) {
        $delc = $_GET['del_color'];
        del_color($delc);
    } elseif (isset($_GET['sus'])) {
        $sus = $_GET['sus'];
        sus_prod($sus);
    } elseif (isset($_GET['act'])) {
        $act = $_GET['act'];
        act_prod($act);
    } elseif (isset($_GET['agotar'])) {
        $agotar = $_GET['agotar'];
        agotar_prod($agotar);
    } elseif (isset($_GET['del'])) {
        $del = $_GET['del'];
        del_prod($del);
    } else {
        if (isset($_POST['search'])) {
            $search = $_POST['search'];
            $titulo = "Búsqueda: " . $search;
            $query = "SELECT * FROM productos 
                WHERE name LIKE '%$search%' 
                OR description LIKE '%$search%'";
        } elseif (isset($_GET['idsec'])) {
            $idsec = $_GET['idsec'];
            $query_seccion = "SELECT * 
                FROM secciones 
                WHERE id = '$idsec'";
            $seccion = obtener_linea($query_seccion);
            $nombre_seccion = $seccion['name'];

            $id_menu = $_GET['id'];
            $query_menu = "SELECT * 
                FROM menus 
                WHERE id = '$id_menu'";
            $menu = obtener_linea($query_menu);
            $nombre_menu = $menu['name'];

            $arrow = "<img class='icon_arrow' src='images/svg/icons/arrow.svg'>";

            $titulo = "Menú: $nombre_menu $arrow Sección: <strong> $nombre_seccion </strong>";
            $query = "SELECT p.* 
                FROM productos p 
                JOIN seccion_producto sp 
                ON p.id = sp.producto_id 
                WHERE sp.seccion_id = $idsec";
        } elseif (isset($_GET['id'])) {
            $id_menu = $_GET['id'];
            $query_menu = "SELECT * 
                FROM menus 
                WHERE id = '$id_menu'";
                $menu = obtener_linea($query_menu);
                $nombre_menu = $menu['name'];
                $titulo = "Menú: <strong>" . $nombre_menu . "</strong>";
                $query_secciones  = "SELECT s.* FROM 
                secciones s 
                JOIN menu_seccion ms 
                ON s.id = ms.seccion_id 
                WHERE ms.menu_id = $id_menu";
        } else {
            $query = "SELECT * 
                FROM productos 
                ORDER BY id 
                DESC";
                $titulo = "Todos Los productos";
        }

        if (isset($query)) {
            //$productos = obtener_todo($query);
            listar_productos($query, $titulo);
        } else {
            $secciones = obtener_todo($query_secciones);
            // print_r($secciones);
            listar_secciones($secciones, $titulo);
        }
    }
}
