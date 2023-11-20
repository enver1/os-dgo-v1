<?php
session_start();
include_once "../../../fpdf/fpdf.php";
include_once '../../../funciones/clasePDF.php';
include_once '../../../funciones/writeTag.php';
include_once '../../../qr/qrlib.php';
include_once '../../../clases/autoload.php';

$encriptar      = new Encriptar;
$dt             = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$DetalleInfoAppDgscop   = new DetalleInfoAppDgscop;
$pdf            = new ImprimePdf;
$datos          = $DetalleInfoAppDgscop->getDatosImprimirDetalleInfoAppDgscopPdf('APP_DNIA');
$hoye           = $dt->format('Y-m-d H:i:s');
$hoy            = date($hoye);
$persona        = '';
$tituloColumnas = array('Código', 'M. Unidad', 'Opción', 'Detalle', 'Filtro', 'Información', 'Permiso', 'Estado');
$anchoColumnas  = '15,25,25,25,25,25,25,20';
$nombreReporte  = 'Opciones Generales por Módulo Unidad';
$pdf->imagen    = '../../../imagenes/logoPN.jpg';
$pdf->AddPage('');
$pdf->SetMargins(10, 20);
$pdf->getCabecera('DIRECCIÓN GENERAL DE SEGURIDAD CIUDADANA Y ORDEN PÚBLICO');
$pdf->getImprimeDatos($datos, $nombreReporte, $tituloColumnas, $anchoColumnas, 8);

ob_end_clean();
$pdf->Output();
