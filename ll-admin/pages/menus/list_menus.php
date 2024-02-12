<?php

function list_menus()
{
    $query_menus  = "SELECT * FROM menus";
    $menus = obtener_todo($query_menus);

    $acc = "";
    if (isset($_GET['acc'])) {
        $acc = $_GET['acc'];
    }

    if ($acc) {
        switch ($acc) {
            case "create_menu":
                create_menu();
                break;
            case "del_menu":
                $idmendel = $_GET['idmendel'];
                delete_menu($idmendel);
                break;
            case "edit_menu":
                $idmenedit = $_GET['idmenedit'];
                edit_menu($idmenedit);
                break;
            case "dis_menu":
                $idmendis = $_GET['idmendis'];
                disable_menu($idmendis);
                break;
            case "act_menu":
                $idmenact = $_GET['idmenact'];
                enable_menu($idmenact);
                break;
            default:
                show_menus($menus);
        }
    } else {
        show_menus($menus);
    }
}

function show_menus($menus)
{
    if ($menus) {
        ?>
        <div class="lista_menu">
            <div class="lista_menu_linea top">
                <div class="lista_menu_nombre">Menú</div>
                <div class="lista_menu_acciones">Acciones</div>
            </div>
            <?php
            foreach ($menus as $menu) {
                $id_menu = $menu["id"];
                $name = $menu["name"];
                $active = $menu["active"];
                ?>
                <div class="lista_menu_linea">
                    <div class="lista_menu_nombre">
                        <a href="menus.php?id=<?php echo $id_menu ?>"><?php echo $name ?></a>
                    </div>
                    <div class="lista_menu_acciones">
                        <?php
                        if ($active == true) {
                            ?>
                            <a 
                            href="menus.php?acc=dis_menu&idmendis=<?php echo $id_menu ?>" 
                            class="btn_menuacc precaucion"
                            >Desactivar</a>
                            <?php
                        } else {
                            ?>
                            <a 
                            href="menus.php?acc=act_menu&idmenact=<?php echo $id_menu ?>" 
                            class="btn_menuacc alerta"
                            >Activar</a>
                            <?php
                        }
                        ?>
                        <a 
                        href="menus.php?acc=edit_menu&idmenedit=<?php echo $id_menu ?>" 
                        class="btn_menuacc"
                        >Editar</a>
                        <a 
                        href="menus.php?acc=del_menu&idmendel=<?php echo $id_menu ?>" 
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
            <h2 class="vacio_h2">No hay menus</h2>
            <p class="vacio_p">Empieza creando uno</p>
            <a href="menus.php?acc=create_menu" class="vacio_btn">
                <img class="nav_bar_lat_img" src="images/svg/icons/add.svg" alt="Agregar" />
                <span>Agregar Menu</span>
            </a>
        </div>
        <?php
    }
}
