<?php

require_once "promocion/promocion_inc.php";
$menu_top = 6;

$query_menu_top = "SELECT * FROM menu_top WHERE id = $menu_top";
$menu_top_data = obtener_linea($query_menu_top);
$name_top = $menu_top_data["name"];

$name_lat = "Promoción";

$id_lat = 7;
if (isset($_GET['menu_lat'])) {
    $id_lat = $_GET['menu_lat'];
}

?>
<div class="container con_open">
  <h1 class="titulo_h1"><?php echo $config['name'] . " - " . $name_lat; ?></h1>
  <div class="wrap">
    <?php
    if ($id_lat == 7) {
        cupones();
    } elseif ($id_lat == 8) {
        marquesinas();
    } elseif ($id_lat == 20) {
        fondocolor();
    } elseif ($id_lat == 21) {
        montominimo();
    } elseif ($id_lat == 31) {
        promociones();
    } elseif ($id_lat == 32) {
        etiquetas($config);
    } elseif ($id_lat == 35) {
        cronometro();
    } elseif ($id_lat == 36) {
        onlyyou();
    }
    ?>
  </div>
</div>

