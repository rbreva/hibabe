<?php

require_once "products/products_fnc.php";
$menu_top = 2;

$query_menu_top = "SELECT * FROM menu_top WHERE id = $menu_top";
$menu_top_data = obtener_linea($query_menu_top);
$name_top = $menu_top_data["name"];

$name_lat = "Lista de Productos";

?>
<div class="container con_open">
    <h1 class="titulo_h1"><?php echo $config['name'] . " - " . $name_lat; ?></h1>
    <div class="wrap">
        <?php
        products($config);
        ?>
  </div>
</div>
