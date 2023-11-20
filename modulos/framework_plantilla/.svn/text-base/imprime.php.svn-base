<?php
session_start();
include_once('../../../funciones/db_connect.inc.php');
include_once("../../../fpdf/fpdf.php");
include_once('../../../funciones/clasePDF.php');
$nombreReporte='CATALOGO DE MATERIAS'; // *** CAMBIAR *** TITULO DEL REPORTE
/* Contiene la instruccion select que trae los datos de la tabla */
// *** CAMBIAR ***/
$sql="select 
	a.idDneMateria cero,
	a.descripcion uno,
	b.descripcion dos,
	c.descripcion tres
	from dneMateria a,genEstado b,dneTipoPrueba c where a.idGenEstado=b.idGenEstado and a.idDneTipoPrueba=c.idDneTipoPrueba
	order by 4,3,2 ";

$rs=$conn->query($sql);
$row = $rs->fetchAll();

$title='www.policiaecuador.gob.ec/siipne3';

$pdf=new PDF();
//$pdf->AddPage('L'); //si Queremos tipo landscape horizontal
$pdf->AddPage();
$pdf->SetFont('Arial','',14);
$pdf->Ln();
//$pdf->WriteHTML('');
$pdf->titulo('SISTEMA INFORMATICO INTEGRADO SIIPNE 3w',14,255,255,255);
$pdf->titulo($nombreReporte,12,200,220,255,'C');
$pdf->SetFont('Arial','',10);

//*** CAMBIAR *** cabeceras de las columnas del reporte
$header=array('Codigo','Descripcion','Estado','Tipo Prueba');
//*** CAMBIAR *** 
/* Parametros que se envian : 
	$header array con las cabeceras de las columnas
	$row array con los registros (filas)
	$n1, n2, n3 enteros con los parametros de los valores RGB  para el color de fondo de la cabecera 
	$n4 entero con el valor del color del texto 0=negro
	$n5,...,nn entero con el ancho de cada columna a mostrar*/
$pdf->FancyTable($header,$row,200,220,255,0,4,15,100,30,30);
/*-------------------------------------------------------*/
$pdf->Output();


 ?>



