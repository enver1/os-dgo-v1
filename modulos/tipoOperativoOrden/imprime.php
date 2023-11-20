<?php
session_start();
include_once "../../../fpdf/fpdf.php";
include_once '../../../funciones/db_connect.inc.php';
include_once '../../../funciones/clasePDF.php';
include_once '../../../funciones/writeTag.php';
include_once '../../../qr/qrlib.php';
include_once '../../../clases/autoload.php';

$encriptar      = new Encriptar;
$dt             = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$TipoOperativoOrden     = new TipoOperativoOrden;
$pdf            = new ImprimePdf;
$datos          = $TipoOperativoOrden->getDatosImprimirPdf();
$hoye           = $dt->format('Y-m-d H:i:s');
$hoy            = date($hoye);
$persona        = '';
$tituloColumnas = array('Código',  'Operativo', 'Tipo de Operativo', 'Estado');
$anchoColumnas  = '20,65,75,30';
$nombreReporte  = 'CATÁLOGO DE TIPOS DE OPERATIVO';
$pdf->imagen    = '../../../imagenes/logoPN.jpg';
$pdf->AddPage('');
$pdf->SetMargins(10, 28);
$pdf->getCabecera('DIRECCIÓN GENERAL DE SEGURIDAD CIUDADANA Y ORDEN PÚBLICO');
$pdf->getImprimeDatos($datos, $nombreReporte, $tituloColumnas, $anchoColumnas, 9);
ob_end_clean();
$pdf->Output();
