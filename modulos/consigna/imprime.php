<?php
session_start();
include_once('../../../funciones/db_connect.inc.php');
include_once("../../../fpdf/fpdf.php");
include_once('../../../funciones/clasePDF.php');
$nombreReporte='CATALOGO DE FUNCIONES DE HOJA DE RUTA'; // *** CAMBIAR *** TITULO DEL REPORTE
/* Contiene la instruccion select que trae los datos de la tabla */
// *** CAMBIAR ***/
$sql="SELECT 
  a.idHdrConsigna AS 'cero',
  b.descripcion AS 'uno',
  c.descripcion AS 'dos',
  a.descripcionConsigna AS 'tres',
  a.fechaInicial AS 'cuatro',
  a.fechaCaducidad AS 'cinco',
  a.observacion AS 'seis'
FROM
  hdrConsigna a,
  genGeoSenplades b,
  genEstado c 
WHERE b.idGenGeoSenplades = a.idGenGeoSenplades 
  AND c.idGenEstado = a.idGenEstado";
//echo $sql;
$rs=$conn->query($sql);
$row = $rs->fetchAll();

$title='www.policiaecuador.gob.ec/siipne3';

$pdf=new PDF();
//$pdf->AddPage('L'); //si Queremos tipo landscape horizontal
$pdf->AddPage('L');
$pdf->SetFont('Arial','',14);
$pdf->Ln();
//$pdf->WriteHTML('');
$pdf->titulo('SISTEMA INFORMATICO INTEGRADO SIIPNE 3w',14,255,255,255);
$pdf->titulo($nombreReporte,12,200,220,255,'C');
$pdf->SetFont('Arial','',10);

//*** CAMBIAR *** cabeceras de las columnas del reporte
$header=array('Codigo','Lugar','Estado','Descripcion','Inicio','Fin','Observacion');
//*** CAMBIAR *** 
/* Parametros que se envian : 
	$header array con las cabeceras de las columnas
	$row array con los registros (filas)
	$n1, n2, n3 enteros con los parametros de los valores RGB  para el color de fondo de la cabecera 
	$n4 entero con el valor del color del texto 0=negro
	$n5,...,nn entero con el ancho de cada columna a mostrar*/
$pdf->FancyTable($header,$row,200,220,255,0,3,15,60,25,60,25,25,65,0);
/*-------------------------------------------------------*/
$pdf->Output();


 ?>



