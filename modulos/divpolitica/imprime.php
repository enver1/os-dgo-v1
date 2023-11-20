<?php
session_start();
include_once('../../../funciones/db_connect.inc.php');
include_once("../../../fpdf/fpdf.php");
include_once('../../../funciones/clasePDF.php');
$nombreReporte='CATALOGO DE DIVISION POLITICA';
/* Contiene la instruccion select que trae los datos de la tabla */
$sql="select 
	a.idGenDivPolitica cero,
	a.descripcion uno,
	b.descripcion dos,
	c.descripcion tres
	from genDivPolitica a,genDivPolitica b,genTipoDivision c where b.idGenDivPolitica=a.gen_idGenDivPolitica and a.idGenTipoDivision=c.idGenTipoDivision order by 4,3,2 ";
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

$header=array('Codigo','Descripcion','Division','Tipo Division');
$pdf->FancyTable($header,$row,200,220,255,0,4,15,100,30,30);



$pdf->Output();


 ?>



