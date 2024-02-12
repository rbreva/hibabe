<?php

require_once "informativas/informativas_fnc.php";
$menu_top = 10;

$query_menu_top = "SELECT * FROM menu_top WHERE id = $menu_top";
$menu_top_data = obtener_linea($query_menu_top);
$name_top = $menu_top_data["name"];

$name_lat = "Páginas Informativas";

$query_pag = "SELECT * FROM informativas";
$informativas = obtener_todo($query_pag);

$menu_pag = 1;
if (isset($_GET['pag'])) {
    $menu_pag = $_GET['pag'];
}

?>
<div class="container con_open">
    <h1 class="titulo_h1"><?php echo $config['name'] . " - " . $name_lat; ?></h1>
    <div class="wrap">
<?php
    pagina_informativa($menu_pag);
?>
  </div>
</div>
