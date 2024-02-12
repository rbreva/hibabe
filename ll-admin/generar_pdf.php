<?php

require 'lib/fpdf/fpdf.php';

require_once 'functions/lla_admin.php';

$id = "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM pedidos WHERE id = '$id'";
    $pedido = obtener_linea($query);
    $codigo = $pedido['codigo'];
    $descripcion = $pedido['descripcion'];
    $total = $pedido['total'];
    $fecha = $pedido['fecha'];
} else {
    $salida = "NO se ha seleccionado Pedido";
}

$pdf = new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 10, $codigo);
$pdf->Output();
?>

// $pdf = new FPDF();
// $pdf->AddPage();

// $pdf->SetFont('Arial', 'B', 16);
// $pdf->Cell(40, 10, 'Título del PDF');

// $pdf->Ln(10);

// // Agrega los datos de la base de datos al PDF
// foreach ($data as $row) {
//     $pdf->Cell(40, 10, $row['id']);
//     $pdf->Cell(40, 10, $row['codigo']);
//     $pdf->Cell(40, 10, $row['total']);
//     $pdf->Ln();
// }

// $pdf->Output();
