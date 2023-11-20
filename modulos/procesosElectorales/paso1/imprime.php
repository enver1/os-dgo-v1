<?php
session_start();
include_once '../../../../clases/autoload.php';

$encriptar           = new Encriptar;
$dt                  = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$ProcesosElectorales = new ProcesosElectorales;
$pdf                 = new ImprimePdf;
$datos               = $ProcesosElectorales->getDatosImprimirPdf();
$hoye                = $dt->format('Y-m-d H:i:s');
$hoy                 = date($hoye);
$persona             = '';
$tituloColumnas      = array('Cod.', 'Tipo Evento', 'Lugar Evento', 'Descripción', 'Fecha Inicio', 'Fehca Fin', 'Estado');
$anchoColumnas       = '10,25,25,60,25,25,20';
$nombreReporte       = 'CATÁLOGO DE PROCESOS REGISTRADOS';
$pdf->imagen         = '../../../../imagenes/logoPN.jpg';
$pdf->AddPage('');
$pdf->SetMargins(10, 28);
$pdf->getCabecera('DIRECCIÓN GENERAL DE SEGURIDAD CIUDADANA Y ÓRDEN PÚBLICO');
$pdf->getImprimeDatos($datos, $nombreReporte, $tituloColumnas, $anchoColumnas);
ob_end_clean();
$pdf->Output();
