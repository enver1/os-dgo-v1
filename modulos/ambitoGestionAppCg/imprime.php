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
$AmbitoGestionAppCg = new AmbitoGestionAppCg;
$pdf              = new ImprimePdf;
$datos            = $AmbitoGestionAppCg->getDatosImprimirAmbitoGestionAppCgPdf();
$hoye             = $dt->format('Y-m-d H:i:s');
$hoy              = date($hoye);
$persona          = '';
$tituloColumnas        = array('Código', 'Nombres y Apellidos', 'Dirección',  'Asignación', 'Estado');
$anchoColumnas        = '15,55,25,40,50';
$nombreReporte    = 'AMBITO DE GESTIÓN APP CG';
$pdf->imagen      = '../../../imagenes/logoPN.jpg';
$pdf->AddPage('');
$pdf->SetMargins(10, 28);
$pdf->getCabecera('COMANDO GENERAL DE LA POLICÍA NACIONAL');
$pdf->getImprimeDatos($datos, $nombreReporte, $tituloColumnas, $anchoColumnas, 8);
ob_end_clean();
$pdf->Output();
