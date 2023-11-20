<?php
session_start();
include_once("../../../fpdf/fpdf.php");
include_once('../../../funciones/clasePDF.php');
include_once('../../../clases/autoload.php');
include_once("config.php");
$conn = DB::getConexionDB();
$sql = $sqlP;
$rs = $conn->query($sql);
$row = $rs->fetchAll();

$title = 'www.policiaecuador.gob.ec/siipne3';

$pdf = new PDF();
$pdf->AddPage($orientacion);
$pdf->SetFont('Arial', '', 14);
$pdf->Ln();
$pdf->titulo('SISTEMA INFORMÁTICO INTEGRADO SIIPNE 3w', 14, 255, 255, 255);
$pdf->titulo($nombreReporte, 12, 200, 220, 255, 'C');
$pdf->SetFont('Arial', '', 10);
$header = $tituloColumnas;
$pdf->FancyTable($header, $row, 200, 220, 255, 0, $columnas, $anchoColumnas);
$pdf->Output();
