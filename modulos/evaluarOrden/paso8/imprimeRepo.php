<?php
session_start();
error_reporting(1);
include_once "../../../../fpdf/fpdf.php";
include_once '../../../../clases/autoload.php';
include_once '../../../../funciones/clasePDF.php';
include_once '../../../../funciones/funcion_select.php';
include_once '../../../clases/claseInforme.php';
include_once "config.php";
$DgoInfOrdenServicio = new DgoInfOrdenServicio;
$dgoAnexosInforme = new DgoAnexosInforme;
$dgoEjemplaresInforme = new DgoEjemplarInforme;
$ambitoGestionOrden      = new AmbitoGestionOrden;
$idDgoInfOrdenServicio       = $_GET['id'];
// $dt              = new DateTime('now', new DateTimeZone('America/Guayaquil'));
// $fechaHoy        = $dt->format('Y-m-d');
// $anio = explode("-", $fechaHoy);
// $anioHoy = $anio[0];
$datosUsuario =    $ambitoGestionOrden->getDatosUsuariosSenplades($_SESSION['usuarioAuditar']);
$datosInforme = $DgoInfOrdenServicio->getEditDgoInfOrdenServicio($idDgoInfOrdenServicio);
$consultaOrdinalOrden = $DgoInfOrdenServicio->consultaOrdinalInforme($idDgoInfOrdenServicio);
$ejemplares = $dgoEjemplaresInforme->getDgoEjemplarInforme($idDgoInfOrdenServicio);
$nroEjemplares = 0;
for ($i = 0; $i < COUNT($ejemplares); $i++) {
    $nroEjemplares = $nroEjemplares + 1;
}
ob_end_clean();

$calificacion = $datosInforme['calificacion'];

$pdf            = new PDF();
$pdf->imagen    = "includes/logoPN.jpg";
//$pdf->watermark = '../../../../imagenes/novalido.jpg';
/////////////////////////ENCABEZADO DERECHA
$ejemplar = 'EJEMPLAR No 1 DE ' . $nroEjemplares;
$policia = 'POLICíA NACIONAL DEL ECUADOR';
$distrito = $datosInforme['Distrito'];
$ciudad = $datosInforme['ciudad'] . ' ' . '(PROV. ' . $datosInforme['provincia'] . ')';
$fechaT = $DgoInfOrdenServicio->formatoFecha($datosInforme['fechaInforme'], 2);
$fechOrden = $datosInforme['fechaInforme'];
$fOrden = explode('-', $fechOrden);
$fechaInforme = $fOrden[2] . '-' . $fOrden[1] . '-' . $fOrden[0];
$siglasDistrito = $datosInforme['siglasGeoSenplades'];
$jefeOperativo = $datosInforme['jefeOperativo'];
$funcionJefeOperativo = $datosInforme['funcion'];
$comandanteOperativo = $datosInforme['coman'];
$siglasComan = $datosInforme['siglasComan'];
$elaboraOrden = $datosInforme['nombreElabora'];
$analistaInforme = $datosInforme['nombrePersonaR'];
$numeroOrden = $consultaOrdinalOrden['anio'] . '-' . $consultaOrdinalOrden['descripcion'] . '-' . $consultaOrdinalOrden['numerico'];
////////////////////////////TITULO ORDEN////////////////////////////////////////////////
$nombreOperativo =  $datosInforme['nombreOperativo'] . ' ' . $datosInforme['detalleOperativo'];
$fechaO = $DgoInfOrdenServicio->formatoFecha($datosInforme['fechaInforme'], 1);
$hora = $datosInforme['horaInforme'];
$orden = 'INFORME DE LA EVALUACIÓN A LA ORDEN DE SERVICIO NO.' . $numeroOrden . ' PARA ' . $nombreOperativo . ',  REALIZADA EL DÍA ' . $fechaO . ',  A PARTIR DE LAS ' . $hora . '.';
/////////////////////////////////////////////////////////////////////////////////
/*********************INICIO INFORME*****************************************/
$pdf->AddPage('');
$pdf->SetMargins(20, 28);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Ln(1);
$pdf->WriteHTML('                                                              ' . $calificacion);
$pdf->Ln(6);
$pdf->Ln(2);
$pdf->SetFont('Arial', '', 9);
$pdf->WriteHTML('                                                                                                                ' . $ejemplar);
$pdf->Ln(4);
$pdf->WriteHTML('                                                                                                                ' . $policia);
$pdf->Ln(4);
$pdf->WriteHTML('                                                                                                                ' . $distrito);
$pdf->Ln(4);
$pdf->WriteHTML('                                                                                                                ' . $ciudad);
$pdf->Ln(4);
$pdf->WriteHTML('                                                                                                                ' . $fechaInforme);
$pdf->Ln(4);
$pdf->WriteHTML('                                                                                                                ' . $hora);
$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Multicell(185, 5, $orden, 0, 'J', 0);
$pdf->Ln(1);
$pdf->Multicell(185, 5, '__________________________________________________________________________________', 0, 'J', 0);
$pdf->Ln(8);
$pdf->WriteHTML('<b>Referencias:</b>');
$pdf->Ln(8);
$pdf->WriteHTML('<b>    a.          Antecedentes:</b>');
$pdf->Ln(1);
$pdf->WriteHTML('<b>                 _____________</b>');
$pdf->Ln(6);
$i = 1;
$antecedentes = $DgoInfOrdenServicio->verificaAntecedente($idDgoInfOrdenServicio);
foreach ($antecedentes as $row => $keyf) {
    // $pdf->WriteHTML('       1.' . $i . '  ' . $keyf['descripcion']);
    $pdf->Multicell(185, 5, '             ' . $i . ')  ' . $keyf['descripcion'], 0, 'J', 0);
    $i++;
    $pdf->Ln(4);
}
$pdf->Ln(4);
$pdf->WriteHTML('<b>1. OPERACIONES REALIZADAS:</b>');
$pdf->Ln(1);
$pdf->WriteHTML('<b>    __________________________</b>');
$pdf->Ln(6);
$pdf->WriteHTML('<b>        a. Organización de Fuerzas Propias:</b>');
$pdf->Ln(1);
$pdf->WriteHTML('<b>            _____________________________</b>');
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$columnas       = 4;
$anchoColumnas  = '85,30,30,30';
$tituloColumnas = array('UNIDAD', 'OF. SUPERIORES', 'OF. SUBALTERNOS', 'CLASES Y POLICIAS');
$fuerzasPropias = $DgoInfOrdenServicio->verificaFuerzasPropias($idDgoInfOrdenServicio);
$header = $tituloColumnas;
$pdf->FancyTable($header, $fuerzasPropias, 200, 220, 255, 0, $columnas, $anchoColumnas);
$columnas       = 4;
$anchoColumnas  = '85,30,30,30';
$tituloColumnas = array();
$pdf->SetFont('Arial', 'B', 8);
$header = $tituloColumnas;
$fuerzasPropiasT = $DgoInfOrdenServicio->getTotalFuerzasP($idDgoInfOrdenServicio);
$pdf->FancyTable($header, $fuerzasPropiasT, 200, 220, 255, 0, $columnas, $anchoColumnas);
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 11);
$pdf->WriteHTML('<b>        b. Medios Logísticos:</b>');
$pdf->Ln(1);
$pdf->WriteHTML('<b>            _________________</b>');
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$columnas       = 2;
$anchoColumnas  = '95,80';
$tituloColumnas = array('MEDIOS LOGÍSTICOS', 'CANTIDAD');
$mediosLogistico = $DgoInfOrdenServicio->verificaMediosLogísticos($idDgoInfOrdenServicio);
$header = $tituloColumnas;
$pdf->FancyTable($header, $mediosLogistico, 200, 220, 255, 0, $columnas, $anchoColumnas);
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 11);
$pdf->WriteHTML('<b>        c. Operaciones Realizadas:</b>');
$pdf->Ln(1);
$pdf->WriteHTML('<b>            ______________________</b>');
$pdf->Ln(6);
$i = 1;
$operaciones = $DgoInfOrdenServicio->verificaOperaciones($idDgoInfOrdenServicio);
foreach ($operaciones as $row => $keyf) {
    $letra = $DgoInfOrdenServicio->consultaLetra($i);
    $pdf->Multicell(185, 5, '            ' . $i . '  ' . $keyf['descripcion'], 0, 'J', 0);
    $i++;
    $pdf->Ln(4);
}
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 12);
$pdf->WriteHTML('<b>2. EVALUACIÓN DE LAS OPERACIONES REALIZADAS. AÑADIR EN EL SISTEMA:</b>');
$pdf->Ln(1);
$pdf->WriteHTML('<b>    ___________________________________________________________________</b>');
$pdf->Ln(6);
$i = 1;

$getTipoEvaluacion = $DgoInfOrdenServicio->getTipoEvaluacion();
$verificaEvaluacion = $DgoInfOrdenServicio->verificaEvaluacion($idDgoInfOrdenServicio);
foreach ($getTipoEvaluacion as $row => $keyf) {
    $pdf->SetFont('Arial', 'B', 11);
    $letra = $DgoInfOrdenServicio->consultaLetra($i);
    $pdf->Multicell(185, 5, '             ' . $letra . '   ' . $keyf['descripcion'], 0, 'J', 0);
    $i++;

    $verificaEvaluacionDetalle = $DgoInfOrdenServicio->verificaEvaluacionDetalle($idDgoInfOrdenServicio, $keyf['idDgoTipoEvaluacionInf']);

    $pdf->Ln(4);
    foreach ($verificaEvaluacionDetalle as $rowV => $keyV) {
        $pdf->SetFont('Arial', '', 11);
        $pdf->Multicell(185, 5, '                 -   ' . $keyV['descripcion'], 0, 'J', 0);

        $pdf->Ln(4);
    }
    $pdf->Ln(4);
}
$pdf->Ln(4);
$pdf->WriteHTML('<b>3. OPORTUNIDADES DE MEJORA. AÑADIR EN EL SISTEMA:</b>');
$pdf->Ln(1);
$pdf->WriteHTML('<b>    __________________________________________________</b>');
$pdf->Ln(6);
$i = 1;
$verificaOportunidades = $DgoInfOrdenServicio->verificaOportunidades($idDgoInfOrdenServicio);
foreach ($verificaOportunidades as $row => $keyf) {
    $pdf->Multicell(185, 5, '            3.' . $i . '.  ' . $keyf['descripcion'], 0, 'J', 0);
    $i++;
    $pdf->Ln(4);
}
$pdf->Ln(6);



$pdf->SetFont('Arial', 'B', 12);
$pdf->Multicell(185, 5, 'ANEXOS.', 0, 'L', 0);
$pdf->Ln(6);
$anexos = $DgoInfOrdenServicio->verificaAnexos($idDgoInfOrdenServicio);
$pdf->SetFont('Arial', '', 11);
$a = 1;
foreach ($anexos as $row => $keyf) {
    $pdf->Multicell(185, 5, '       ANEXO ' . $a . '.  ' . $keyf['descripcion'], 0, 'J', 0);
    $a++;
    $pdf->Ln(3);
}
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Multicell(185, 5, 'DISTRIBUCIÓN.', 0, 'L', 0);
$pdf->Ln(4);
$ejemplares = $DgoInfOrdenServicio->verificaEjemplaresTipo($idDgoInfOrdenServicio, "PARA INFORMACIÓN");
$pdf->SetFont('Arial', 'B', 11);
$pdf->Multicell(185, 5, '   PARA INFORMACIÓN', 0, 'L', 0);
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 10);
$a = 1;
foreach ($ejemplares as $row => $keyf) {
    $pdf->Multicell(185, 5, '       Ejemplar ' . $a . '.  ' . $keyf['descripcion'], 0, 'J', 0);
    $a++;
    $pdf->Ln(3);
}
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Multicell(185, 5, '   PARA EJECUCIÓN', 0, 'L', 0);
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 10);
$ejemplares = $DgoInfOrdenServicio->verificaEjemplaresTipo($idDgoInfOrdenServicio, "PARA EJECUCIÓN");
foreach ($ejemplares as $row => $keyf) {
    $pdf->Multicell(185, 5, '       Ejemplar ' . $a . '.  ' . $keyf['descripcion'], 0, 'J', 0);
    $a++;
    $pdf->Ln(3);
}
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Multicell(185, 5, 'RESPONSABLE DE LA ELABORACIÓN:', 0, 'L', 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Multicell(185, 5, 'ANALISTA DE OPERACIONES DEL ' . $distrito, 0, 'C', 0);
$pdf->Ln(18);
$pdf->SetFont('Arial', '', 10);
$pdf->Multicell(185, 5, '_____________________________________________', 0, 'C', 0);
$pdf->Ln(4);
$analistaInf = explode('.', $analistaInforme);
$pdf->Multicell(185, 5, $analistaInf[1], 0, 'C', 0);
$formatoGrado = $DgoInfOrdenServicio->formatoGrado($analistaInf[0]);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Multicell(185, 5, $formatoGrado, 0, 'C', 0);
$pdf->Ln(12);
$pdf->Multicell(185, 5, 'JEFE DE OPERACIONES DEL ' . $distrito, 0, 'C', 0);
$pdf->Ln(18);
$pdf->SetFont('Arial', '', 10);
$pdf->Multicell(185, 5, '_____________________________________________', 0, 'C', 0);
$pdf->Ln(4);
$elaboraO = explode('.', $elaboraOrden);
$pdf->Multicell(185, 5, $elaboraO[1], 0, 'C', 0);
$formatoGrado = $DgoInfOrdenServicio->formatoGrado($elaboraO[0]);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Multicell(185, 5, $formatoGrado, 0, 'C', 0);
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Multicell(185, 5, 'APROBACIÓN:', 0, 'L', 0);
$pdf->Ln(6);
$pdf->Multicell(185, 5, 'EL SR. COMANDANTE DEL ' . $distrito, 0, 'C', 0);
$pdf->Ln(20);
$pdf->SetFont('Arial', '', 10);
$pdf->Multicell(185, 5, '_____________________________________________', 0, 'C', 0);
$pdf->Ln(6);
$pdf->Multicell(185, 5, $comandanteOperativo, 0, 'C', 0);
$formatoGrado = $DgoInfOrdenServicio->formatoGrado($siglasComan);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Multicell(185, 5, $formatoGrado, 0, 'C', 0);
$pdf->InHeader   = true;
$pdf->Output();
/*FIN INFORME*/
