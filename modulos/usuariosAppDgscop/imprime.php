<?php
session_start();
include_once "../../../fpdf/fpdf.php";
include_once '../../../funciones/clasePDF.php';
include_once '../../../funciones/writeTag.php';
include_once '../../../qr/qrlib.php';
include_once '../../../clases/autoload.php';

$encriptar      = new Encriptar;
$dt             = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$UsuariosAppDgscop   = new UsuariosAppDgscop;
$pdf            = new ImprimePdf;
$datos          = $UsuariosAppDgscop->getDatosImprimirUsuariosAppPdfDgscop('APP_DGSCOP');
$hoye           = $dt->format('Y-m-d H:i:s');
$hoy            = date($hoye);
$persona        = '';
$tituloColumnas = array('Código', 'Servidor Policial', 'Módulo Unidad', 'Tipo Permiso', 'Estado');
$anchoColumnas  = '15,70,50,30,20';
$nombreReporte  = 'Módulos y Permisos de los Servidores Policiales a la APP';
$pdf->imagen    = '../../../imagenes/logoPN.jpg';
$pdf->AddPage('');
$pdf->SetMargins(10, 28);
$pdf->getCabecera('DIRECCIÓN GENERAL DE SEGURIDAD CIUDADANA Y ORDEN PÚBLICO');
$pdf->getImprimeDatos($datos, $nombreReporte, $tituloColumnas, $anchoColumnas);
ob_end_clean();
$pdf->Output();
