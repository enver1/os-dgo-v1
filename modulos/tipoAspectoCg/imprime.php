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
$tipoAspectoCg     = new TipoAspectoCg;
$pdf            = new ImprimePdf;
$datos          = $tipoAspectoCg->getDatosImprimirPdf();
$hoye           = $dt->format('Y-m-d H:i:s');
$hoy            = date($hoye);
$persona        = '';
$tituloColumnas = array('Código',  'Aspectos', 'Tipo de Aspectos', 'Estado');
$anchoColumnas  = '20,65,75,30';
$nombreReporte  = 'CATÁLOGO DE TIPOS DE ASPECTOS';
$pdf->imagen    = '../../../imagenes/logoPN.jpg';
$pdf->AddPage('');
$pdf->SetMargins(10, 28);
$pdf->getCabecera('COMANDO GENERAL');
$pdf->getImprimeDatos($datos, $nombreReporte, $tituloColumnas, $anchoColumnas, 9);
ob_end_clean();
$pdf->Output();
