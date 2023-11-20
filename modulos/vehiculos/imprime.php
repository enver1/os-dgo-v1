<?php
session_start();
include_once('../../../funciones/db_connect.inc.php');
include_once("../../../fpdf/fpdf.php");
include_once('../../../funciones/clasePDF.php');
$nombreReporte = 'CATALOGO DE VEHÍCULOS'; // *** CAMBIAR *** TITULO DEL REPORTE
/* Contiene la instruccion select que trae los datos de la tabla */
// *** CAMBIAR ***/
$sql = "SELECT hdrVehiculo.idHdrVehiculo AS cero,
genVehiculo.placa AS dos,
dgpUnidad.nomenclatura AS uno,
genMarca.descripcion AS tres,
genEstado.descripcion AS cuatro
FROM
  hdrVehiculo 
  INNER JOIN dgpUnidad 
    ON hdrVehiculo.idDgpUnidad = dgpUnidad.idDgpUnidad 
  INNER JOIN genVehiculo 
    ON genVehiculo.idGenVehiculo = hdrVehiculo.idGenVehiculo 
  INNER JOIN genEstado 
    ON hdrVehiculo.idGenEstado = genEstado.idGenEstado 
  INNER JOIN genModelo 
    ON genVehiculo.idGenModelo = genModelo.idGenModelo 
  INNER JOIN genMarca 
    ON genModelo.idGenMarca = genMarca.idGenMarca";
//echo $sql;
$rs = $conn->query($sql);
$row = $rs->fetchAll();

$title = 'www.policiaecuador.gob.ec/siipne3';

$pdf = new PDF();
//$pdf->AddPage('L'); //si Queremos tipo landscape horizontal
$pdf->AddPage();
$pdf->SetFont('Arial', '', 14);
$pdf->Ln();
//$pdf->WriteHTML('');
$pdf->titulo('SISTEMA INFORMATICO INTEGRADO SIIPNE 3w', 14, 255, 255, 255);
$pdf->titulo($nombreReporte, 12, 120, 50, 50, 'C');
$pdf->SetFont('Arial', '', 10);

//*** CAMBIAR *** cabeceras de las columnas del reporte
$header = array('Codigo', 'Unidad Policial', 'Placa', 'Marca');
//*** CAMBIAR *** 
/* Parametros que se envian : 
	$header array con las cabeceras de las columnas
	$row array con los registros (filas)
	$n1, n2, n3 enteros con los parametros de los valores RGB  para el color de fondo de la cabecera 
	$n4 entero con el valor del color del texto 0=negro
	$n5,...,nn entero con el ancho de cada columna a mostrar*/
$pdf->FancyTable($header, $row, 200, 220, 255, 0, 4, 15, 120, 20, 25);
/*-------------------------------------------------------*/
$pdf->Output();