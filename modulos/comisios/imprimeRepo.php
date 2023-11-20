<?php
session_start();
include_once "../../../fpdf/fpdf.php";
include_once '../../../funciones/clasePDF.php';
include_once '../../../funciones/funcion_select.php';
include_once '../../../clases/autoload.php';

$disp = (isset($_GET['d']) ? $_GET['d'] : 0);
$nov  = (isset($_GET['n']) ? $_GET['n'] : 0);
if ($disp == "TR" || $nov == "TN") {
    $nov = "";
}
$informe    = new RepParteDiario;
$tj         = $_GET['tj'];
$fechaParte = $_GET['fp'];
if ($_GET['tj'] == 'I') {
    $tipoJornada = 'INICIO JORNADA';
} else {
    $tipoJornada = 'FIN JORNADA';
}
$parteDiairo = 'PARTE DIARIO ' . $tipoJornada;
$dt          = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$hoy         = $dt->format('Y-m-d');
ob_end_clean();
$fechaImpresoDia = Fecha::getFormatoFecha($hoy);

$r0              = $informe->getPartesRegistradosPdf($tj, $fechaParte);
$totalReportados = $r0['cuantos'];

$r2                = $informe->getPartesNoRegistradosPdf($tj, $fechaParte);
$totalNoReportados = $r2['cuantos'];

$r          = $informe->getCuantosDispositivosConNovedad($fechaParte, $tj);
$totalRepCN = $r['cuantos'];

$r          = $informe->getCuantosDispositivosSinNovedad($fechaParte, $tj);
$totalRepSN = $r['cuantos'];

$pdf            = new PDF();
$pdf->imagen    = "../../../imagenes/logoPN.jpg";
$pdf->watermark = '../../../imagenes/novalido.jpg';
/*OFICIO INICIO*/
$direccion = 'DIRECCIÓN NACIONAL DE SEGURIDAD Y PROTECCIÓN';
/*********************INICIO INFORME******************************************/

$pdf->AddPage('');
$pdf->SetFont('Arial', '', 12);
$pdf->SetMargins(10, 28);
$pdf->titulo('      POLICÍA NACIONAL DEL ECUADOR', 12, 255, 255, 255, 'C', 4, 2);
$pdf->titulo($direccion, 10, 255, 255, 255, 'C', 4, 4);
$pdf->WriteHTML('<td colspan="2" ><hr />');
$pdf->titulo($parteDiairo, 16, 255, 255, 255, 'C', 4, 2);
$pdf->Ln(2);
$pdf->SetFont('Arial', '', 10);
$pdf->WriteHTML('<br> FECHA DE IMPRESIÓN:  ' . $fechaImpresoDia);
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 9);
$pdf->WriteHTML('<b>I. NÚMERICO DISPOSITIVOS DE SEGURIDAD</b>');
$pdf->Ln(5);

if ($disp == "R" && $nov == "CN") {
    $pdf->MultiCell(165, 5, '       Dispositivos de Seguridad Reportados Con Novedad: ' . $totalRepCN);
}

if ($disp == "R" && $nov == "SN") {
    $pdf->MultiCell(165, 5, '       Dispositivos de Seguridad Reportados Sin Novedad: ' . $totalRepSN);
}

if ($disp == "R" && $nov == "") {
    $pdf->MultiCell(165, 5, '       Dispositivos de Seguridad Reportados: ' . $totalReportados);

}
if ($disp == "NR") {
    $pdf->MultiCell(165, 5, '       Dispositivos de Seguridad No Reportados: ' . $totalNoReportados);

}

if ($disp == "TR") {
    $pdf->MultiCell(165, 5, '       Dispositivos de Seguridad Reportados: ' . $totalReportados);
    $pdf->Ln(3);
    $pdf->MultiCell(165, 5, '       Dispositivos de Seguridad No Reportados: ' . $totalNoReportados);
    $pdf->Ln(3);
    $pdf->WriteHTML('<b>TOTAL DISPOSITIVOS DE SEGURIDAD:</b>' . ($totalReportados + $totalNoReportados));
}

$pdf->Ln(3);
$pdf->MultiCell(165, 5, '----------------------------------------------------------------------------------------------------------', 0, 'J');
$pdf->Ln(3);
if ($disp == "R" && $nov == "") {
    $pdf->WriteHTML('<b>DISPOSITIVOS DE SEGURIDAD REPORTADOS</b>');
    $pdf->Ln(3);
    $rowP1 = $informe->getDetalleDispositivosRepPdf1($tj, $fechaParte);
    if (empty($rowP1)) {
        $pdf->Ln(3);
        $pdf->WriteHTML('<b>No se encuentran registrados Dispositivos de Seguridad</b>');
        $pdf->Ln(2);
        $pdf->MultiCell(165, 5, '------------------------------------------------------------------------------------------------------', 0, 'J');
    } else {
        $pdf->SetFont('Arial', '', 8);
        $columnas       = 7;
        $anchoColumnas  = '15,20,40,40,25,25,25';
        $tituloColumnas = array('ID', 'FECHA', 'PERSONA IMPORTANTE', 'CARGO DISPOSITIVO', 'UBICACIÓN', 'LATITUD', 'LONGITUD');
        $pdf->Ln(3);
        $header = $tituloColumnas;
        $pdf->FancyTable($header, $rowP1, 200, 220, 255, 0, $columnas, $anchoColumnas);
        $pdf->Ln(2);
    }
    $pdf->Ln(2);
    $pdf->MultiCell(165, 5, '----------------------------------------------------------------------------------------------------------', 0, 'J');
    $pdf->Ln(3);
}

if ($disp == "R" && $nov == "CN") {

    $pdf->WriteHTML('<b>DISPOSITIVOS DE SEGURIDAD REPORTADOS CON NOVEDAD</b>');
    $pdf->Ln(3);
    $rowP1 = $informe->getDispositivosRepConNovedad1($fechaParte, $tj);
    if (empty($rowP1)) {
        $pdf->Ln(3);
        $pdf->WriteHTML('<b>No se encuentran registrados Dispositivos de Seguridad</b>');
        $pdf->Ln(2);
        $pdf->MultiCell(165, 5, '------------------------------------------------------------------------------------------------------', 0, 'J');
    } else {
        $pdf->SetFont('Arial', '', 8);
        $columnas       = 8;
        $anchoColumnas  = '10,20,30,30,25,25,25,25';
        $tituloColumnas = array('ID', 'FECHA', 'DISPOSITIVO', 'CARGO DISPOSITIVO', 'S.P. REPORTA', 'LATITUD', 'LONGITUD', 'UBICACIÓN');
        $pdf->Ln(3);
        $header = $tituloColumnas;
        $pdf->FancyTable($header, $rowP1, 200, 220, 255, 0, $columnas, $anchoColumnas);
        $pdf->Ln(2);
    }

}

if ($disp == "R" && $nov == "SN") {

    $pdf->WriteHTML('<b>DISPOSITIVOS DE SEGURIDAD REPORTADOS SIN NOVEDAD</b>');
    $pdf->Ln(3);
    $rowP1 = $informe->getDispositivosRepSinNovedad1($fechaParte, $tj);

    if (empty($rowP1)) {
        $pdf->Ln(3);
        $pdf->WriteHTML('<b>No se encuentran registrados Dispositivos de Seguridad</b>');
        $pdf->Ln(2);
        $pdf->MultiCell(165, 5, '------------------------------------------------------------------------------------------------------', 0, 'J');
    } else {
        $pdf->SetFont('Arial', '', 8);
        $columnas       = 8;
        $anchoColumnas  = '10,20,30,30,25,25,25,25';
        $tituloColumnas = array('ID', 'FECHA', 'DISPOSITIVO', 'CARGO DISPOSITIVO', 'S.P. REPORTA', 'LATITUD', 'LONGITUD', 'UBICACIÓN');
        $pdf->Ln(3);
        $header = $tituloColumnas;
        $pdf->FancyTable($header, $rowP1, 200, 220, 255, 0, $columnas, $anchoColumnas);
        $pdf->Ln(2);
    }

}
if ($disp == "NR") {
    $pdf->Ln(3);
    $pdf->WriteHTML('<b>DISPOSITIVOS DE SEGURIDAD NO REPORTADOS</b>');
    $pdf->Ln(5);
    $rowF = $informe->getDetalleDispositivosNoReportados($fechaParte, $tj);
    if (empty($rowF)) {
        $pdf->Ln(2);
        $pdf->WriteHTML('<b>No se encuentra Asiganado Personal para este Dispositivo de Seguridad</b>');
        $pdf->Ln(5);
        $pdf->MultiCell(165, 5, '--------------------------------------------------------------------------------------------------', 0, 'J');
    } else {
        $pdf->Ln(2);
        $columnas       = 5;
        $anchoColumnas  = '10,60,50,20,40';
        $tituloColumnas = array('ID', 'PERSONA IMPORTANTE', 'CARGO', 'RIESGO', 'FECHA INICIO DISP.');
        $pdf->Ln(3);
        $header = $tituloColumnas;
        $pdf->FancyTable($header, $rowF, 200, 220, 255, 0, $columnas, $anchoColumnas);
        $pdf->Ln(2);
    }
    $pdf->MultiCell(165, 5, '----------------------------------------------------------------------------------------------------------', 0, 'J');
    $pdf->Ln(3);
}

if ($disp == "TR") {
    $pdf->WriteHTML('<b>DISPOSITIVOS DE SEGURIDAD REPORTADOS</b>');
    $pdf->Ln(3);
    $rowP1 = $informe->getDetalleDispositivosRepPdf1($tj, $fechaParte);
    if (empty($rowP1)) {
        $pdf->Ln(3);
        $pdf->WriteHTML('<b>No se encuentran registrados Dispositivos de Seguridad</b>');
        $pdf->Ln(2);
        $pdf->MultiCell(165, 5, '------------------------------------------------------------------------------------------------------', 0, 'J');
    } else {
        $pdf->SetFont('Arial', '', 8);
        $columnas       = 7;
        $anchoColumnas  = '15,20,40,40,25,25,25';
        $tituloColumnas = array('ID', 'FECHA', 'PERSONA IMPORTANTE', 'CARGO DISPOSITIVO', 'UBICACIÓN', 'LATITUD', 'LONGITUD');
        $pdf->Ln(3);
        $header = $tituloColumnas;
        $pdf->FancyTable($header, $rowP1, 200, 220, 255, 0, $columnas, $anchoColumnas);
        $pdf->Ln(2);
    }
    $pdf->Ln(2);
    $pdf->MultiCell(165, 5, '----------------------------------------------------------------------------------------------------------', 0, 'J');
    $pdf->Ln(3);
    $pdf->WriteHTML('<b>DISPOSITIVOS DE SEGURIDAD NO REPORTADOS</b>');
    $pdf->Ln(3);
    $rowF = $informe->getDetalleDispositivosNoReportados($fechaParte, $tj);
    if (empty($rowF)) {
        $pdf->Ln(2);
        $pdf->WriteHTML('<b>No se encuentra Asiganado Personal para este Dispositivo de Seguridad</b>');
        $pdf->Ln(5);
        $pdf->MultiCell(165, 5, '--------------------------------------------------------------------------------------------------', 0, 'J');
    } else {
        $pdf->Ln(2);
        $columnas       = 5;
        $anchoColumnas  = '10,60,50,20,40';
        $tituloColumnas = array('ID', 'PERSONA IMPORTANTE', 'CARGO', 'RIESGO', 'FECHA INICIO DISP.');
        $pdf->Ln(3);
        $header = $tituloColumnas;
        $pdf->FancyTable($header, $rowF, 200, 220, 255, 0, $columnas, $anchoColumnas);
        $pdf->Ln(2);
    }
    $pdf->MultiCell(165, 5, '----------------------------------------------------------------------------------------------------------', 0, 'J');
    $pdf->Ln(3);

}
$pdf->Output();
/*FIN INFORME*/
