<?php

// Incluye las bibliotecas necesarias de PhpSpreadsheet
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Conecta a la base de datos MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trekkinghouseperu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Realiza la consulta para obtener los datos de la base de datos
$sqlproductos = "SELECT * FROM productos";
$sqlcodigos = "SELECT * FROM codigos";
$sqlcolors = "SELECT * FROM colors";
$result = $conn->query($sql);

// Crea un nuevo objeto PhpSpreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Llena el archivo Excel con los datos de la consulta
if ($result->num_rows > 0) {
    $rowIndex = 1;
    while ($row = $result->fetch_assoc()) {
        $colIndex = 1;
        foreach ($row as $key => $value) {
            $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, $value);
            $colIndex++;
        }
        $rowIndex++;
    }
}

// Guarda el archivo Excel en el servidor
$writer = new Xlsx($spreadsheet);
$excelFileName = 'descargas/archivo_excel.xlsx';
$writer->save($excelFileName);

// Cierra la conexión a la base de datos
$conn->close();

// Genera un enlace de descarga para el archivo Excel
echo '<a href="' . $excelFileName . '" download>Descargar Excel</a>';
