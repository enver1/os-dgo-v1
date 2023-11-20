<?php


session_start();
if (!isset($_SESSION['usuarioAuditar'])) {
	header('Location: indexSiipne.php');
	exit();
}
include_once '../../../clases/autoload.php';

$dpjMtEstaCaso = new GenMarca;

$row = $dpjMtEstaCaso->getGenMarcaAll();

$columnas      = 2;
$anchoColumnas = '30,150,';
$header        = array('Código', 'Descripción');
$nombreReporte = 'CATALOGO DE MARCAS DE VEHICULOS Y EQUIPO';
$orientacion   = '';



$title = 'www.policiaecuador.gob.ec/siipne3';

$pdf = new PDF();
$pdf->AddPage($orientacion);
$pdf->SetFont('Arial', '', 14);
$pdf->Ln();
$pdf->titulo('SISTEMA INFORMÁTICO INTEGRADO SIIPNE 3w', 14, 255, 255, 255);
$pdf->titulo($nombreReporte, 12, 200, 220, 255, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->FancyTable($header, $row, 200, 220, 255, 0, $columnas, $anchoColumnas);
ob_clean();
$pdf->Output();