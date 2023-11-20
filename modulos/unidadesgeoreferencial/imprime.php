<?php
session_start();
include '../../../clases/autoload.php';
$conn = DB::getConexionDB();
include_once("../../../fpdf/fpdf.php");
include_once('../../../funciones/clasePDF.php');

$sql = "SELECT a.idGenUnidadesGeoreferencial cero, d.descGenTipoActividad uno, c.descripcion dos
FROM genUnidadesGeoreferencial a, genActividadGA b, genGeoSenplades c, genTipoActividad d
WHERE a.idGenActividadGA=b.idGenActividadGA AND a.idGenGeoSenplades=c.idGenGeoSenplades AND b.idGenTipoActividad=d.idGenTipoActividad ORDER BY 2";
$rs = $conn->query($sql);
$row = $rs->fetchAll();

$title = 'www.policiaecuador.gob.ec/siipne3';
$orientacion = 'L';
$nombreReporte = 'CATÁLOGO DE ACTIVIDADES DE LA GESTIÓN ADMINISTRATIVA POR SECTOR GEO SEMPLADES';
$tituloColumnas = array('Código', 'Actividad GA', 'Sector Geo Semplades');
$columnas = 3;
$anchoColumnas = '20,100,100';

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
