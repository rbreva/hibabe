<?php

require_once "pedidos/pedidos_fnc.php";
require_once "pedidos/envio_fnc.php";
require_once "pedidos/pedidos_antiguo_fnc.php";
$menu_top = 4;

$query_menu_top = "SELECT * FROM menu_top WHERE id = $menu_top";
$menu_top_data = obtener_linea($query_menu_top);
$name_top = $menu_top_data["name"];

$id_lat = 16;
if (isset($_GET['menu_lat'])) {
    $id_lat = $_GET['menu_lat'];
}

$query_menu_lat = "SELECT * FROM menu_lat WHERE id = $id_lat";
$menu_lat_data = obtener_linea($query_menu_lat);
$name_lat = $menu_lat_data["name"];

?>
<div class="container con_open">
    <h1 class="titulo_h1"><?php echo $config['name'] . " - " . $name_lat; ?></h1>
    <div class="wrap">
<?php
if ($id_lat == 16) {
    pedidos('pagado');
} elseif ($id_lat == 17) {
    pedidos('transferencia');
} elseif ($id_lat == 18) {
    pedidos(0);
} elseif ($id_lat == 19) {
    envio_lima();
} elseif ($id_lat == 25) {
    envio_provincias();
} elseif ($id_lat == 26) {
    envio_express();
} elseif ($id_lat == 33) {
    pedidos_antiguo($id_lat);
}
?>
  </div>
</div>
