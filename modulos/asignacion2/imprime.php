<?php

include_once "../../../fpdf/fpdf.php";
include_once '../../../funciones/clasePDF.php';
include_once '../../../funciones/writeTag.php';
include_once '../../../qr/qrlib.php';
include_once '../../../clases/autoload.php';
$conn = DB::getConexionDB();
$encriptar        = new Encriptar;
$dt               = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$AmbitoGestionPolco = new AmbitoGestionPolco;
$pdf              = new ImprimePdf;
$id        = isset($_POST['usuario']) ? $_POST['usuario']  : 0;
if ($id > 0) {
    $datos            = $AmbitoGestionPolco->getDatosImprimirAmbitoGestionPolcoPdf($_POST['usuario']);
} else {
    $pdf->WriteHTML('<b>No existe Datos</b>');
    ob_end_clean();
    $pdf->Output();
}

$hoye             = $dt->format('Y-m-d H:i:s');
$hoy              = date($hoye);
$tituloColumnas = array('Código', 'POLCO', 'Distrito', 'Circuito', 'Subcircuito', 'Estado', 'Fecha');
$anchoColumnas  = '15,40,30,30,35,20,20';
$nombreReporte  = 'Reporte Ambito de Policias Comunitarios';
$pdf->imagen      = '../../../../imagenes/logoPN.jpg';
$pdf->AddPage('');
$pdf->SetMargins(10, 28);
$pdf->getCabecera('Dirección Nacional de Policia Preventiva y Comunitaria');
$pdf->getImprimeDatos($datos, $nombreReporte, $tituloColumnas, $anchoColumnas, 8);
ob_end_clean();
$pdf->Output();
