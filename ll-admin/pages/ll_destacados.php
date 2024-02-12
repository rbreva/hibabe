<?php

require_once "destacados/destacados_fnc.php";
$menu_top = 9;

$query_menu_top = "SELECT * FROM menu_top WHERE id = $menu_top";
$menu_top_data = obtener_linea($query_menu_top);
$name_top = $menu_top_data["name"];

$name_lat = "Productos Destacados";

?>
<div class="container con_open">
    <h1 class="titulo_h1"><?php echo $config['name'] . " - " . $name_lat; ?></h1>
    <div class="wrap">
        <?php
        $sec = "";
        if (isset($_GET['sec'])) {
            $sec = $_GET['sec'];
        }

        if ($sec == "ordenar_productos") {
            ordenar_productos();
        } else {
            cantidadprod();
        }
        ?>
  </div>
</div>
