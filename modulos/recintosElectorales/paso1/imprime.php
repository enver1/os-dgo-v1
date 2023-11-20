<?php
session_start();


include_once '../../../../clases/autoload.php';

$encriptar           = new Encriptar;
$dt                  = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$RecintosElectorales = new RecintoElectoral;
$pdf                 = new ImprimePdf;
$datos               = $RecintosElectorales->getDatosImprimirPdf();
$hoye                = $dt->format('Y-m-d H:i:s');
$hoy                 = date($hoye);
$persona             = '';
$tituloColumnas      = array('Código', 'Nombre Recinto', 'Dirección', ' Senplades', 'Provincia', 'Estado');
$anchoColumnas       = '15,50,40,40,20,20';
$nombreReporte       = 'RECINTOS ELECTORALES';
$pdf->imagen         = '../../../../imagenes/logoPN.jpg';
$pdf->AddPage('');
$pdf->SetMargins(10, 28);
$pdf->getCabecera('DIRECCIÓN GENERAL DE SEGURIDAD CIUDADANA Y ÓRDEN PÚBLICO');
$pdf->getImprimeDatos($datos, $nombreReporte, $tituloColumnas, $anchoColumnas);
ob_end_clean();
$pdf->Output();