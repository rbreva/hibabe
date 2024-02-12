<?php

require_once "menus/menus_fnc.php";
$menu_top = 5;

$query_menu_top = "SELECT * FROM menu_top WHERE id = $menu_top";
$menu_top_data = obtener_linea($query_menu_top);
$name_top = $menu_top_data["name"];

$name_lat = "Lista de Menus";

$id_menu = "";
if (isset($_GET['id'])) {
    $id_menu = $_GET['id'];
}

?>
<div class="container con_open">
    <h1 class="titulo_h1"><?php echo $config['name'] . " - " . $name_lat; ?></h1>
    <div class="wrap">
        <?php
        if ($id_menu) {
            list_secciones($id_menu);
        } else {
            list_menus();
        }
        ?>
  </div>
</div>
