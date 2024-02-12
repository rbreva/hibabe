<?php

require './pages/upload/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Agregar encabezados
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Nombre');
$sheet->setCellValue('C1', 'Apellidos');
$sheet->setCellValue('D1', 'DNI');
$sheet->setCellValue('E1', 'Email');
$sheet->setCellValue('F1', 'Celular');

$query_clientes = "SELECT * FROM clientes";
$clientes = obtener_todo($query_clientes);

// Agregar datos de los clientes
$row = 2;
foreach ($clientes as $cliente) {
    $sheet->setCellValue('A' . $row, $cliente['id']);
    $sheet->setCellValue('B' . $row, $cliente['nombres']);
    $sheet->setCellValue('C' . $row, $cliente['paterno'] . ' ' . $cliente['materno']);
    $sheet->setCellValue('D' . $row, $cliente['dni']);
    $sheet->setCellValue('E' . $row, $cliente['email']);
    $sheet->setCellValue('F' . $row, $cliente['celular']);
    $row++;
}

$spreadsheet->getActiveSheet()->setTitle('Hoja 1');

// Guardar el archivo Excel
$writer = new Xlsx($spreadsheet);
$excelFileName = 'clientes.xlsx';
$writer->save($excelFileName);

require_once "clientes/clientes_fnc.php";
$menu_top = 7;

$query_menu_top = "SELECT * FROM menu_top WHERE id = $menu_top";
$menu_top_data = obtener_linea($query_menu_top);
$name_top = $menu_top_data["name"];

$name_lat = "Clientes";

$id_lat = 22;

?>
<div class="container con_open">
  <h1 class="titulo_h1"><?php echo $config['name'] . " - " . $name_lat; ?></h1>
  <div class="wrap">
    <?php
        lista_clientes($clientes);
    ?>
  </div>
</div>
