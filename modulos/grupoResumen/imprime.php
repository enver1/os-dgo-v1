<?php
session_start();

include_once '../../../funciones/db_connect.inc.php';

include_once '../../../clases/autoload.php';

$encriptar      = new Encriptar;
$dt             = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$GrupoResumen    = new GrupoResumen;
$pdf            = new ImprimePdf;
$datos          = $GrupoResumen->getDatosImprimirPdf();
$hoye           = $dt->format('Y-m-d H:i:s');
$hoy            = date($hoye);
$persona        = '';
$tituloColumnas = array('Código', 'Descripción','Categorización');
$anchoColumnas  = '20,70,70';
$nombreReporte  = 'GRUPO RESUMEN';
$pdf->imagen    = '../../../imagenes/logoPN.jpg';
$pdf->AddPage('');
$pdf->SetMargins(10, 28);
$pdf->getCabecera('DIRECCIÓN GENERAL DE SEGURIDAD CIUDADANA Y ORDEN PÚBLICO');
$pdf->getImprimeDatos($datos, $nombreReporte, $tituloColumnas, $anchoColumnas);
ob_end_clean();
$pdf->Output();
