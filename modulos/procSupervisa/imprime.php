<?php
session_start();
include_once '../../../clases/autoload.php';
include_once("../../../fpdf/fpdf.php");
include_once('../../../funciones/clasePDF.php');
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
/* Parametros que se envian : 
	$header array con las cabeceras de las columnas
	$row array con los registros (filas)
	$n1, n2, n3 enteros con los parametros de los valores RGB  para el color de fondo de la cabecera 
	$n4 entero con el valor del color del texto 0=negro
	-----------------------------------------| a partir de esta columna se cambia los parametros   */

$pdf->FancyTable($header, $row, 200, 220, 255, 0, $columnas, $anchoColumnas);
//$anchoColumnas);
/*-------------------------------------------------------*/
$pdf->Output();
