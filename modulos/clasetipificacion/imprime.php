<?php
session_start();
include_once "../../../fpdf/fpdf.php";
include_once '../../../funciones/db_connect.inc.php';
include_once '../../../funciones/clasePDF.php';
include_once '../../../funciones/writeTag.php';
include_once '../../../qr/qrlib.php';
include_once '../../../clases/autoload.php';
ob_end_clean();
$encriptar        = new Encriptar;
$dt               = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$TipoTipificacion = new TipoTipificacion;
$pdf              = new ImprimePdf;
$datos            = $TipoTipificacion->getDatosImprimirPdf();
$hoye             = $dt->format('Y-m-d H:i:s');
$hoy              = date($hoye);
$persona          = '';
$tituloColumnas   = array('Código', 'Tipo Tipificación', 'Descripción', 'Detalle', 'Servicio', 'Siglas');
$anchoColumnas    = '15,35,35,35,30,30';
$nombreReporte    = 'TIPO TIPIFICACIÓN';
$pdf->imagen      = '../../../imagenes/logoPN.jpg';
$pdf->AddPage('');
$pdf->SetMargins(10, 28);
$pdf->getCabecera('DIRECCIÓN GENERAL DE SEGURIDAD CIUDADANA Y ORDEN PÚBLICO');
$pdf->getImprimeDatos($datos, $nombreReporte, $tituloColumnas, $anchoColumnas);
$pdf->Output();
