<?php
session_start();
include_once "../../../fpdf/fpdf.php";
include_once '../../../funciones/db_connect.inc.php';
include_once '../../../funciones/clasePDF.php';
include_once '../../../funciones/writeTag.php';
include_once '../../../qr/qrlib.php';
include_once '../../../clases/autoload.php';

$encriptar        = new Encriptar;
$dt               = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$DgoInstruccionesOrden  = new DgoInstruccionesOrden;
$pdf              = new ImprimePdf;
$datos            = $DgoInstruccionesOrden->getDatosImprimirPdf($_GET['id']);
$hoye             = $dt->format('Y-m-d H:i:s');
$hoy              = date($hoye);
$persona          = '';
$tituloColumnas   = array('Código', 'Control');
$anchoColumnas    = '20,160';
$nombreReporte    = 'TIPO DE CONTROLES';
$pdf->imagen      = '../../../imagenes/logoPN.jpg';
$pdf->AddPage('');
$pdf->SetMargins(10, 28);
$pdf->getCabecera('Unidad Nacional de Control de Seguridad Privada y Control de Armas Letales y No Letales');
$pdf->getImprimeDatos($datos, $nombreReporte, $tituloColumnas, $anchoColumnas);
ob_end_clean();
$pdf->Output();
