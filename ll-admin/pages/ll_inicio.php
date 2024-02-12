<?php

include_once "inicio/inicio_fnc.php";
$menu_top = 1;
$menu_lat = 1;

if (isset($_GET["menu_lat"])) {
    $menu_lat = $_GET["menu_lat"];
}

$query_menu_top = "SELECT * FROM menu_top WHERE id = $menu_top";
$menu_top_data = obtener_linea($query_menu_top);
$name_top = $menu_top_data["name"];

$query_menu_lat = "SELECT * FROM menu_lat WHERE id = $menu_lat";
$menu_lat_data = obtener_linea($query_menu_lat);
$name_lat = $menu_lat_data["name"];
$id_lat = $menu_lat_data["id"];

?>
<div class="container con_open">
  <h1 class="titulo_h1"><?php echo $config['name'] . " - " . $name_lat; ?></h1>
  <div class="wrap">
    <?php
    if ($id_lat == 1) {
        informacion_personal($config, $id_lat);
    } elseif ($id_lat == 2) {
        usuarios($config, $id_lat);
    } elseif ($id_lat == 3) {
        redes($config, $id_lat);
    } elseif ($id_lat == 4) {
        whatsapp($config, $id_lat);
    } elseif ($id_lat == 5) {
        logo($config, $id_lat);
    } elseif ($id_lat == 6) {
        tickets();
    }
    ?>
  </div>
</div>
