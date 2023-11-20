<?php
session_start();
include_once "../../../fpdf/fpdf.php";
include_once '../../../funciones/clasePDF.php';
include_once '../../../funciones/writeTag.php';
include_once '../../../qr/qrlib.php';
include_once '../../../clases/autoload.php';

$encriptar      = new Encriptar;
$dt             = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$ClasificacionOrden     = new ClasificacionOrden;
$pdf            = new ImprimePdf;
$datos          = $ClasificacionOrden->getDatosImprimirPdf();
$hoye           = $dt->format('Y-m-d H:i:s');
$hoy            = date($hoye);
$persona        = '';
$tituloColumnas = array('Código', 'Descripción', 'Estado');
$anchoColumnas  = '20,100,60';
$nombreReporte  = 'TIPO DE CALIFICACIÓN DE LA ORDEN';
$pdf->imagen    = '../../../imagenes/logoPN.jpg';
$pdf->AddPage('');
$pdf->SetMargins(10, 28);
$pdf->getCabecera('DIRECCIÓN GENERAL DE SEGURIDAD CIUDADANA Y ORDEN PÚBLICO');
$pdf->getImprimeDatos($datos, $nombreReporte, $tituloColumnas, $anchoColumnas);
ob_end_clean();
$pdf->Output();
