<?php

require_once "banners/banners_inc.php";
$menu_top = 3;

$query_menu_top = "SELECT * FROM menu_top WHERE id = $menu_top";
$menu_top_data = obtener_linea($query_menu_top);
$name_top = $menu_top_data["name"];

$name_lat = "Banners";

$id_lat = 11;
if (isset($_GET['menu_lat'])) {
    $id_lat = $_GET['menu_lat'];
}
if ($id_lat == 11) {
    $title = "Banner Principal";
    $medidas = "2000*1100";
    $type = "desktop";
} elseif ($id_lat == 12) {
    $title = "Banner Principal Mobile";
    $medidas = "1200*800";
    $type = "mobile";
} elseif ($id_lat == 13) {
    $title = "Banner Seccion";
    $medidas = "1000*1000";
    $type = "seccion";
} elseif ($id_lat == 14) {
    $title = "Banner Seccion Mobile";
    $medidas = "1000*1000";
    $type = "mobile";
} elseif ($id_lat == 27) {
    $title = "Banner 02";
    $medidas = "2000*1100";
    $type = "desktop";
} elseif ($id_lat == 28) {
    $title = "Banner 02 Mobile";
    $medidas = "1200*800";
    $type = "mobile";
} elseif ($id_lat == 29) {
    $title = "Banner 03";
    $medidas = "2000*1100";
    $type = "desktop";
} elseif ($id_lat == 30) {
    $title = "Banner 03 Mobile";
    $medidas = "1200*800";
    $type = "mobile";
}

?>
<div class="container con_open">
  <h1 class="titulo_h1"><?php echo $config['name'] . " - " . $name_lat; ?></h1>
  <div class="wrap">
    <?php
        // echo "inicio: " . $id_lat . "<br>";
        banners($id_lat, $title, $medidas, $type);
    ?>
  </div>
</div>
