<?php
session_start();
include_once '../../../funciones/db_connect.inc.php';
include_once '../../../clases/autoload.php';
//include_once "../../../fpdf/fpdf.php";
//include_once '../../../funciones/clasePDF.php';
//include_once "config.php";
$hdrEveResDis = new HdrEveResDis;

$row = $hdrEveResDis->getDiscriminacionesRegistros();

$title          = 'www.policiaecuador.gob.ec/siipne3';
$columnas       = 11;
$anchoColumnas  = '20,20,20,20,37,30,30,30,20,20,30';
$tituloColumnas = array('Nro. Operativo', 'Fecha Operativo', 'Tipo Operativo', 'Nro. Parte Web', 'Policía Que Solicita El Registro', 'Fecha y Hora Registro','Cédula Del Sancionado', 'Nombre Del Sancionado', 'Tipo Sanción', 'Sanción Por', 'Usuario Que Registra');
$nombreReporte  = 'Registro Personas Sancionadas Por Error';
$orientacion    = 'L';

$pdf = new PDF();
$pdf->AddPage($orientacion);
$pdf->SetFont('Arial', '', 14);
$pdf->Ln();
$pdf->titulo('SISTEMA INFORMÁTICO INTEGRADO SIIPNE 3w', 14, 255, 255, 255);
$pdf->titulo($nombreReporte, 12, 200, 220, 255, 'C');
$pdf->SetFont('Arial', '', 7);
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

ob_end_clean();
$pdf->Output();
