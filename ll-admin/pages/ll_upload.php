<?php

require_once "upload/upload_fnc.php";
$menu_top = 11;

$query_menu_top = "SELECT * FROM menu_top WHERE id = $menu_top";
$menu_top_data = obtener_linea($query_menu_top);
$name_top = $menu_top_data["name"];

$name_lat = "Upload";

$id_lat = 9;
if (isset($_GET['menu_lat'])) {
    $id_lat = $_GET['menu_lat'];
}

$download = "";
if (isset($_GET['download'])) {
    $download = $_GET['download'];
}

?>
<div class="container con_open">
    <h1 class="titulo_h1"><?php echo $config['name'] . " - " . $name_lat; ?></h1>
    <div class="wrap">
        <?php
        if ($download) {
            download_excel();
        } elseif ($id_lat == 9) {
            upload();
        } elseif ($id_lat == 10) {
            uploadfotos();
        } elseif ($id_lat == 24) {
            borrartodo();
        } elseif ($id_lat == 38) {
            descargar_productos();
        }
        ?>
  </div>
</div>