<?php
session_start();
include_once "../../../fpdf/fpdf.php";
include_once '../../../funciones/clasePDF.php';
include_once '../../../funciones/funcion_select.php';
include_once '../../../clases/autoload.php';

$disp = (isset($_GET['d']) ? $_GET['d'] : 0);
$tr   = (isset($_GET['tr']) ? $_GET['tr'] : 0);
$id   = (isset($_GET['id']) ? $_GET['id'] : 0);
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
$parteDiairo = 'PARTE DIARIO POR DISPOSITIVO - ' . $tipoJornada;
$dt          = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$hoy         = $dt->format('Y-m-d');
ob_end_clean();
$fechaImpresoDia = Fecha::getFormatoFecha($hoy);

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
$pdf->WriteHTML('<br> FECHA DE IMPRESIÓN:  ' . $fechaImpresoDia);
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 8);

$pdf->Ln(3);
$pdf->MultiCell(165, 5, '----------------------------------------------------------------------------------------------------------', 0, 'J');
$pdf->Ln(3);

$pdf->WriteHTML('<b> NOVEDADES DISPOSITIVO DE SEGURIDAD </b>');
$pdf->Ln(5);

$rowP = $informe->getDispositivosRepIndividual($id, $fechaParte);
foreach ($rowP as $dato => $keyfa) {
    $pdf->WriteHTML('<b>PERSONA IMPORTANTE:     </b>' . $keyfa['uno']);
    $pdf->Ln(6);
    $pdf->WriteHTML('<b>CARGO:  </b>' . $keyfa['dos']);
    $pdf->Ln(6);
    $pdf->WriteHTML('<b>RIESGO:  </b>' . $keyfa['tres']);
    $pdf->Ln(6);
    $pdf->WriteHTML('<b>PARTE DIARIO REPORTADO POR:  </b>' . $keyfa['cuatro']);
    $pdf->Ln(6);
    $pdf->WriteHTML('<b>FECHA PARTE:  </b>' . $keyfa['cinco']);
    $pdf->Ln(10);
    $pdf->WriteHTML('<b>OBSERVACIONES DE SERVIDORES POLICIALES PERTENECIENTES Al DISPOSITIVO</b>');
    $pdf->Ln(5);
    if ($tr == "L") {
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
        }
        $pdf->MultiCell(165, 5, '------------------------------------------------------------------------------------------------------', 0, 'J');
    } else {
        $rowF = $informe->getDetalleRepConNovedad($keyfa['siete']);
        if (empty($rowF)) {
            $pdf->Ln(2);
            $pdf->WriteHTML('<b>No se encuentra Asiganado Personal para este Dispositivo de Seguridad</b>');
            $pdf->Ln(5);
            $pdf->MultiCell(165, 5, '--------------------------------------------------------------------------------------------------', 0, 'J');
        } else {
            $pdf->Ln(2);
            $columnas       = 4;
            $anchoColumnas  = '15,80,50,45';
            $tituloColumnas = array('PARTE', 'SERVIDOR POLICIAL', 'OBSERVACIÒN', 'DETALLE');
            $header         = $tituloColumnas;
            $pdf->FancyTable($header, $rowF, 200, 220, 255, 0, $columnas, $anchoColumnas);
            $pdf->Ln(2);
        }
        $pdf->MultiCell(165, 5, '------------------------------------------------------------------------------------------------------', 0, 'J');
    }
    $rowP2 = $informe->getObservacion($keyfa['siete']);
    if (!empty($rowP2)) {
        $novedad = $rowP2['novedad'];
    }
    $novedad = "SIN NOVEDAD";
    $pdf->titulo('     OBSERVACIONES', 12, 255, 255, 255, 'C', 4, 2);
    $pdf->WriteHTML('<td colspan="0" ><hr />');
    $pdf->Ln(7);
    $pdf->WriteHTML('<b>NOVEDAD:  </b>' . $novedad);
}

$pdf->Output();

/*FIN INFORME*/
