<?php

function list_secciones($id_menu)
{
    $query_menu  = "SELECT * FROM menus WHERE id = $id_menu";
    $menu = obtener_linea($query_menu);

    $query_secciones  = "SELECT s.* 
        FROM 
        secciones s 
        JOIN 
        menu_seccion ms 
        ON 
        s.id = ms.seccion_id 
        WHERE 
        ms.menu_id = $id_menu";
    $secciones = obtener_todo($query_secciones);

    $acc = "";
    if (isset($_GET['acc'])) {
        $acc = $_GET['acc'];
    }

    if ($acc) {
        switch ($acc) {
            case "create_seccion":
                create_seccion($menu);
                break;
            case "del_seccion":
                $idsecdel = $_GET['idsecdel'];
                delete_seccion($id_menu, $idsecdel);
                break;
            case "edit_seccion":
                $idsecedit = $_GET['idsecedit'];
                edit_seccion($menu, $idsecedit);
                break;
            case "dis_seccion":
                $idsecdis = $_GET['idsecdis'];
                disable_seccion($id_menu, $idsecdis);
                break;
            case "act_seccion":
                $idsecact = $_GET['idsecact'];
                enable_seccion($id_menu, $idsecact);
                break;
            default:
                show_secciones($id_menu, $menu, $secciones);
        }
    } else {
        show_secciones($id_menu, $menu, $secciones);
    }
}

function show_secciones($id_menu, $menu, $secciones)
{
    $nombre_menu = $menu["name"];
    ?>
    <div class="barra_titulo">
        <h2 class="titulo_h2">Secciónes de Menú: <?php echo $nombre_menu ?></h2>
        <a class="nuevo_btn" href="menus.php?id=<?php echo $id_menu ?>&acc=create_seccion">
            Agregar Nueva Sección
        </a>
    </div>
    <?php
    if ($secciones) {
        ?>
        <div class="lista_menu">
            <div class="lista_menu_linea top">
                <div class="lista_menu_nombre">Sección</div>
                <div class="lista_menu_acciones">Acciones</div>
            </div>
            <?php
            foreach ($secciones as $seccion) {
                $id_seccion = $seccion["id"];
                $name_seccion = $seccion["name"];
                $active = $seccion["active"];
                ?>
                <div class="lista_menu_linea">
                    <div class="lista_menu_nombre">
                        <?php echo $name_seccion ?>
                    </div>
                    <div class="lista_menu_acciones">    
                    <?php
                    if ($active == true) {
                        ?>
                        <a 
                        href="menus.php?id=<?php echo $id_menu ?>&acc=dis_seccion&idsecdis=<?php echo $id_seccion ?>" 
                        class="btn_menuacc precaucion"
                        >Desactivar</a>
                        <?php
                    } else {
                        ?>
                        <a 
                        href="menus.php?id=<?php echo $id_menu ?>&acc=act_seccion&idsecact=<?php echo $id_seccion ?>" 
                        class="btn_menuacc alerta"
                        >Activar</a>
                        <?php
                    }
                    ?>
                    <a 
                    href="menus.php?id=<?php echo $id_menu ?>&acc=edit_seccion&idsecedit=<?php echo $id_seccion ?>" 
                    class="btn_menuacc"
                    >Editar</a>
                    <a 
                    href="menus.php?id=<?php echo $id_menu ?>&acc=del_seccion&idsecdel=<?php echo $id_seccion ?>" 
                    class="btn_menuacc alerta"
                    >Eliminar</a>
                </div>
            </div>
                <?php
            }
            ?>
        </div>
        <?php
    } else {
        ?>
        <div class="vacio">
            <h2 class="vacio_h2">No hay Secciones</h2>
            <p class="vacio_p">Empieza creando una</p>
            <a href="menus.php?id=<?php echo $id_menu ?>&acc=create_seccion" class="vacio_btn">
                <img class="nav_bar_lat_img" src="images/svg/icons/add.svg" alt="Agregar" />
                <span>Agregar Sección</span>
            </a>
        </div>
        <?php
    }
}
