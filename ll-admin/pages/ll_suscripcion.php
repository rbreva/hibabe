<?php

require './pages/upload/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Agregar encabezados
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Email');
$sheet->setCellValue('C1', 'Celular');

$query_suscripcion = "SELECT * FROM suscripcion";
$suscripcion = obtener_todo($query_suscripcion);

// Agregar datos de los clientes
$row = 2;
if ($suscripcion) {
    foreach ($suscripcion as $suscriptor) {
        $sheet->setCellValue('A' . $row, $suscriptor['id']);
        $sheet->setCellValue('B' . $row, $suscriptor['email']);
        $sheet->setCellValue('C' . $row, $suscriptor['celular']);
        $row++;
    }
}

$spreadsheet->getActiveSheet()->setTitle('Hoja 1');

// Guardar el archivo Excel
$writer = new Xlsx($spreadsheet);
$excelFileName = 'suscripcion.xlsx';
$writer->save($excelFileName);

require_once "suscripcion/suscripcion_fnc.php";
require_once "suscripcion/img_suscripcion_fnc.php";
require_once "suscripcion/conf_suscripcion_fnc.php";
$menu_top = 8;

$query_menu_top = "SELECT * FROM menu_top WHERE id = $menu_top";
$menu_top_data = obtener_linea($query_menu_top);
$name_top = $menu_top_data["name"];

$name_lat = "Suscripción";

$id_lat = 23;

?>
<div class="container con_open">
  <h1 class="titulo_h1"><?php echo $config['name'] . " - " . $name_lat; ?></h1>
  <div class="wrap">
    <?php
    if (isset($_GET['menu_lat'])) {
        $id_lat = $_GET['menu_lat'];
    }

    if ($id_lat == 23) {
        lista_suscriptores();
    } elseif ($id_lat == 33) {
        img_suscriptores();
    } elseif ($id_lat == 34) {
        conf_suscriptores();
    }
    ?>
  </div>
</div>
