<?php

require('fpdf.php');
require './Producto.php';
require_once("./Cesta.php");

class PDF extends FPDF {

// Cabecera de página
    function Header() {
        // $saluda = "  Bienvenido";
        // Logo

        $this->Image('carrito.jpg', 10, 8, 40, 40);

        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Movernos a la derecha
        $this->Cell(50);
        //setlocale(LC_ALL, "es_ES.UTF-8");
        // Título
        //$date = strftime("%A, dia %d de %B de %Y");
        //$dato = utf8_decode($date);
        $this->SetX(80);
        $this->Cell(70, 10, 'Factura Usuario', 1, 0, 'C');
        $this->SetTextColor(200, 50, 50);
        $this->SetXY(135, 15);
        $this->Cell(0, 0, $_SESSION['usuario']['nombre'], 0, 20);
        // Salto de línea
        $this->Ln(20);
    }

// Pie de página
    function Footer() {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

//    function BasicTable($header, $data) {
//        // Header
//        foreach ($header as $col) {
//            $this->Cell(40, 7, $col, 1);
//        }
//        $this->Ln();
//        // Data
//        foreach ($data as $row) {
//            foreach ($row as $col) {
//                $this->Cell(40, 6, $col, 1);
//            }
//            $this->Ln();
//        }
//    }
}

// Creación del objeto de la clase heredada
session_start();
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$cesta = $_SESSION['cesta'];

$productoCesta = $cesta->getProductos();
$unidades = $cesta->getUnidades();
$pdf->SetTextColor(23, 165, 137);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln(20);
$pdf->Cell(10);
$pdf->Cell(40, 10, "Descripcion", 1, 0, 'C');
$pdf->Cell(70, 10, "Nombre Corto", 1, 0, 'C');
$pdf->Cell(40, 10, "Precio", 1, 0, 'C');
$pdf->Cell(30, 10, "Cantidad", 1, 0, 'C');
$pdf->Ln(10);
$header = array('codigo', 'Nombre corto', 'Precio');
//$pdf->BasicTable($header, $productoCesta);
$pdf->SetTextColor(23, 165, 137);
$pdf->SetFont('Arial', 'B', 10);

foreach ($productoCesta as $producto) {
    $pdf->SetTextColor(243, 156, 18);
    $pdf->Cell(10);
    $pdf->Cell(40, 10, $producto->getCod(), 1, 0, 'C');
    $pdf->Cell(70, 10, $producto->getNombre_corto(), 1, 0, 'C');
    $pdf->Cell(40, 10, $producto->getPvp(), 1, 0, 'C');
    foreach ($unidades as $cod => $unid) {
        if ($cod == $producto->getCod()) {
            $pdf->Cell(30, 10, $unid, 1, 0, 'C');
        }
    }
    $pdf->Ln(10);
}
$coste = $cesta->getCoste();
$costeIVA = round(($coste * 0.21), 2);
$total = round(($coste + $costeIVA), 2);
$pdf->Cell(160);
$pdf->Cell(30, 10, "Total :" . $total, 1, 1);
//."...... ".$producto->getNombre_corto()."...".$producto->getPvp()
//$pdf->Cell($w, $h, $txt, $border, $ln)
$pdf->Output();
?>