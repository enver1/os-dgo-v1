<?php
session_start();
include_once "../../../fpdf/fpdf.php";
include_once '../../../funciones/clasePDF.php';
include_once '../../../funciones/funcion_select.php';
include_once '../../../clases/autoload.php';

$tr         = (isset($_GET['tr']) ? $_GET['tr'] : 0);
$tj         = $_GET['tj'];
$fechaParte = $_GET['fp'];

$informe = new RepParteDiario;

if ($_GET['tj'] == 'I') {
    $tipoJornada = 'INICIO JORNADA';
} else {
    $tipoJornada = 'FIN JORNADA';
}
$parteDiairo = 'PARTE DIARIO - ' . $tipoJornada;
$dt          = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$hoy         = $dt->format('Y-m-d');
ob_end_clean();
$fechaImpresoDia = Fecha::getFormatoFecha($hoy);
$r0              = $informe->getPartesRegistradosPdf($tj, $fechaParte);
$totalReportados = $r0['cuantos'];

$r2                = $informe->getPartesNoRegistradosPdf($tj, $fechaParte);
$totalNoReportados = $r2['cuantos'];
$rF                = $informe->sumDispositivosNoReportados($fechaParte, $tj);
$totalNo           = $rF['cuantos'];

$r1            = $informe->getTotalPersonalDisponible();
$totalPersonal = $r1['cuantos'];

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
$pdf->WriteHTML('<br> FECHA DE IMPRESIÓN:    ' . $fechaImpresoDia);
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 9);
$pdf->WriteHTML('<b>NÚMERICO DISPOSITIVOS DE SEGURIDAD</b>');
$pdf->Ln(5);
$pdf->MultiCell(165, 5, '       Dispositivos de Seguridad Reportados: ' . $totalReportados);
$pdf->MultiCell(165, 5, '                               Total de Personal: ' . ($totalPersonal - $totalNo));
$pdf->Ln(3);
$pdf->MultiCell(165, 5, '       Dispositivos de Seguridad No Reportados: ' . $totalNoReportados);
$pdf->MultiCell(165, 5, '                               Total de Personal: ' . $totalNo);
$pdf->Ln(4);
$pdf->WriteHTML('<b>TOTAL DISPOSITIVOS DE SEGURIDAD:  </b>' . ($totalReportados + $totalNoReportados));
$pdf->Ln(6);
$pdf->WriteHTML('<b>TOTAL DE PERSONAL EN TODOS LOS DISPOSITIVOS:         </b>' . ($totalPersonal));
$pdf->Ln(3);
$pdf->MultiCell(165, 5, '----------------------------------------------------------------------------------------------------------', 0, 'J');
$pdf->Ln(3);
if ($tr == "L") {
    $pdf->WriteHTML('<b>DETALLE NOVEDADES DISPOSITIVOS DE SEGURIDAD REPORTADOS</b>');
    $pdf->Ln(5);
    $rowF = $informe->getDispositivosRepGrupo($fechaParte, $tj);
    if (empty($rowF)) {
        $pdf->Ln(2);
        $pdf->WriteHTML('<b>No se encuentra Asiganado Personal para este Dispositivo de Seguridad</b>');
        $pdf->Ln(5);
        $pdf->MultiCell(165, 5, '--------------------------------------------------------------------------------------------------', 0, 'J');
    } else {
        $pdf->Ln(2);
        $columnas       = 2;
        $anchoColumnas  = '140,40';
        $tituloColumnas = array('OBSERVACION', 'NUMERICO');
        $header         = $tituloColumnas;
        $pdf->FancyTable($header, $rowF, 200, 220, 255, 0, $columnas, $anchoColumnas);
        $pdf->Ln(2);
    }
    $pdf->WriteHTML('<b>TOTAL DE PERSONAL DISPOSITIVOS  REPORTADOS:   </b>' . ($totalPersonal - $totalNo));
    $pdf->Ln(2);
    $pdf->MultiCell(165, 5, '------------------------------------------------------------------------------------------------------', 0, 'J');
    $pdf->Ln(5);
    $pdf->WriteHTML('<b>DETALLE NOVEDADES DISPOSITIVOS DE SEGURIDAD NO REPORTADOS</b>');
    $pdf->Ln(5);
    $rowF = $informe->getDispositivosNoReportados($fechaParte, $tj);
    if (empty($rowF)) {
        $pdf->Ln(2);
        $pdf->WriteHTML('<b>No se encuentra Asiganado Personal para este Dispositivo de Seguridad</b>');
        $pdf->Ln(5);
        $pdf->MultiCell(165, 5, '--------------------------------------------------------------------------------------------------', 0, 'J');
    } else {
        $pdf->Ln(2);
        $columnas       = 2;
        $anchoColumnas  = '140,40';
        $tituloColumnas = array('OBSERVACION', 'NUMERICO');
        $header         = $tituloColumnas;
        $pdf->FancyTable($header, $rowF, 200, 220, 255, 0, $columnas, $anchoColumnas);
        $pdf->Ln(2);
    }
    $pdf->Ln(5);
    $pdf->WriteHTML('<b>TOTAL DE PERSONAL DISPOSITIVOS NO REPORTADOS:  </b>' . ($totalNo));
    $pdf->Ln(5);
    $pdf->MultiCell(165, 5, '------------------------------------------------------------------------------------------------------', 0, 'J');
    $pdf->Ln(6);
    $pdf->WriteHTML('<b>TOTAL DE PERSONAL DISPOSITIVOS DE SEGURIDAD:   </b>' . ($totalPersonal));
}
if ($tr == "D") {
    $pdf->WriteHTML('<b>DETALLE NOVEDADES DISPOSITIVOS DE SEGURIDAD REPORTADOS</b>');
    $pdf->Ln(5);
    $rowP = $informe->getDispositivosRep($fechaParte, $tj);
    foreach ($rowP as $dato => $keyfa) {

        $pdf->WriteHTML('<b>CARGO:  </b>' . $keyfa['dos']);
        $pdf->Ln(6);
        $pdf->WriteHTML('<b>PERSONA IMPORTANTE:     </b>' . $keyfa['uno']);
        $pdf->Ln(6);
        $pdf->WriteHTML('<b>PARTE REGISTRADO EN :  </b>' . $keyfa['trece']);
        $pdf->Ln(6);
        $pdf->WriteHTML('<b>LATITUD:  </b>' . $keyfa['once'] . '    <b>LONGITUD:  </b>' . $keyfa['doce']);
        $pdf->Ln(6);
        $pdf->WriteHTML('<b>FECHA PARTE:  </b>' . $keyfa['cinco'] . '<b>   REGISTRADO:  </b>' . $keyfa['diez']);
        $pdf->Ln(10);
        $pdf->WriteHTML('<b>NOVEDADES DE SERVIDORES POLICIALES PERTENECIENTES Al DISPOSITIVO</b>');
        $pdf->Ln(5);
        $rowF = $informe->getDispositivosRepObservacion($keyfa['siete']);
        if (empty($rowF)) {
            $pdf->Ln(2);
            $pdf->WriteHTML('<b>No se encuentra Asiganado Personal para este Dispositivo de Seguridad</b>');
            $pdf->Ln(5);
            $pdf->MultiCell(165, 5, '--------------------------------------------------------------------------------------------------', 0, 'J');
        } else {
            $pdf->Ln(2);
            $columnas       = 2;
            $anchoColumnas  = '100,80';
            $tituloColumnas = array('OBSERVACION', 'NUMERICO');
            $header         = $tituloColumnas;
            $pdf->FancyTable($header, $rowF, 200, 220, 255, 0, $columnas, $anchoColumnas);
            $pdf->Ln(2);
            $pdf->MultiCell(165, 5, '------------------------------------------------------------------------------------------------------', 0, 'J');
            $totalP = $informe->getTotalPersonalDispositivoiInd($keyfa['cero']);
            $pdf->WriteHTML('<b>TOTAL DE PERSONAL DISPOSITIVO: </b>' . ($totalP['cuantos']));
            $pdf->Ln(2);
        }
        $pdf->MultiCell(165, 5, '------------------------------------------------------------------------------------------------------', 0, 'J');
        $pdf->Ln(5);

    }
    $pdf->Ln(5);
    $pdf->WriteHTML('<b>DETALLE NOVEDADES DISPOSITIVOS DE SEGURIDAD NO REPORTADOS</b>');
    $pdf->Ln(5);
    $rowF = $informe->getDispositivosNoReportados($fechaParte, $tj);
    if (empty($rowF)) {
        $pdf->Ln(2);
        $pdf->WriteHTML('<b>No se encuentra Asiganado Personal para este Dispositivo de Seguridad</b>');
        $pdf->Ln(5);
        $pdf->MultiCell(165, 5, '--------------------------------------------------------------------------------------------------', 0, 'J');
    } else {
        $pdf->Ln(2);
        $columnas       = 2;
        $anchoColumnas  = '140,40';
        $tituloColumnas = array('OBSERVACION', 'NUMERICO');
        $header         = $tituloColumnas;
        $pdf->FancyTable($header, $rowF, 200, 220, 255, 0, $columnas, $anchoColumnas);
        $pdf->Ln(2);
    }
    $pdf->Ln(5);
    $pdf->WriteHTML('<b>TOTAL DE PERSONAL DISPOSITIVOS NO REPORTADOS:  </b>' . ($totalNo));
    $pdf->Ln(5);
    $pdf->MultiCell(165, 5, '------------------------------------------------------------------------------------------------------', 0, 'J');
    $pdf->Ln(6);
    $pdf->WriteHTML('<b>TOTAL DE PERSONAL DISPOSITIVOS DE SEGURIDAD:   </b>' . ($totalPersonal));

}

$pdf->Output();

/*FIN INFORME*/
