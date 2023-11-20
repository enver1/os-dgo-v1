<?php
session_start();
include_once('../../../funciones/db_connect.inc.php');
include_once("../../../fpdf/fpdf.php");
include_once('../../../funciones/clasePDF.php');
$nombreReporte='CATALOGO DE DIVISION SENPLADES';
/* Contiene la instruccion select que trae los datos de la tabla */
$sql="SELECT 
	hijo.idGenGeoSenplades cero, 
	hijo.descripcion uno, 
	padre.descripcion dos, 
	tipo.descripcion tres, 
	hijo.siglasGeoSenplades cuatro, 
	hijo.codigoSenplades cinco
FROM
	genGeoSenplades padre,
	genGeoSenplades hijo,
	genTipoGeoSenplades tipo
WHERE
	padre.idGenGeoSenplades=hijo.gen_idGenGeoSenplades
AND
	hijo.idGenTipoGeoSenplades=tipo.idGenTipoGeoSenplades order by 5,4,3,2 ";


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

$header=array('Codigo','Descripcion','Padre','Tipo','Siglas','Código');
$pdf->FancyTable($header,$row,200,220,255,0,6,15,45,45,20,45,20);



$pdf->Output();


 ?>



