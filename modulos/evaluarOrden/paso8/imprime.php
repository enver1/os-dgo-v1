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
$datosOrden = $DgoInfOrdenServicio->getEditDgoInfOrdenServicio($idDgoInfOrdenServicio);
$consultaOrdinalOrden = $DgoInfOrdenServicio->consultaOrdinalInforme($idDgoInfOrdenServicio);
$ejemplares = $dgoEjemplaresInforme->getDgoEjemplarInforme($idDgoInfOrdenServicio);
$nroEjemplares = 0;
for ($i = 0; $i < COUNT($ejemplares); $i++) {
	$nroEjemplares = $nroEjemplares + 1;
}
ob_end_clean();

$calificacion = $datosOrden['calificacion'];

$pdf            = new PDF();
$pdf->imagen    = "includes/logoPN.jpg";
//$pdf->watermark = '../../../../imagenes/novalido.jpg';
/////////////////////////ENCABEZADO DERECHA
$ejemplar = 'EJEMPLAR No 1 DE ' . $nroEjemplares;
$policia = 'POLICíA NACIONAL DEL ECUADOR';
$distrito = $datosOrden['Distrito'];
$ciudad = $datosOrden['ciudad'] . ' ' . '(PROV. ' . $datosOrden['provincia'] . ')';
$fechaT = $DgoInfOrdenServicio->formatoFecha($datosOrden['fechaOrden'], 2);
$fechOrden = $datosOrden['fechaOrden'];
$fOrden = explode('-', $fechOrden);
$fechaOrden = $fOrden[2] . '-' . $fOrden[1] . '-' . $fOrden[0];
$siglasDistrito = $datosOrden['siglasGeoSenplades'];
$jefeOperativo = $datosOrden['jefeOperativo'];
$funcionJefeOperativo = $datosOrden['funcion'];
$comandanteOperativo = $datosOrden['coman'];
$siglasComan = $datosOrden['siglasComan'];
$elaboraOrden = $datosOrden['nombreElabora'];
$numeroOrden = $consultaOrdinalOrden['anio'] . '-' . $consultaOrdinalOrden['descripcion'] . '-' . $consultaOrdinalOrden['numerico'];
////////////////////////////TITULO ORDEN////////////////////////////////////////////////
$nombreOperativo =  $datosOrden['nombreOperativo'] . ' ' . $datosOrden['detalleOperativo'];
$fechaO = $DgoInfOrdenServicio->formatoFecha($datosOrden['fechaOrden'], 1);
$hora = $datosOrden['horaOrden'];
$horaF = $datosOrden['horaFormacion'];
$orden = 'ORDEN DE SERVICIO NO.' . $numeroOrden . ' PARA ' . $nombreOperativo . ',  A REALIZARSE EL DÍA ' . $fechaO . ',  A PARTIR DE LAS ' . $hora . '.';
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
$pdf->WriteHTML('                                                                                                                ' . $fechaOrden);
$pdf->Ln(4);
$pdf->WriteHTML('                                                                                                                ' . $hora);
$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Multicell(185, 5, $orden, 0, 'J', 0);
$pdf->Ln(1);
$pdf->Multicell(185, 5, '__________________________________________________________________________________', 0, 'J', 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Ln(5);
$pdf->WriteHTML('<B>JEFE DEL OPERATIVO:   </B>' . $jefeOperativo);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->WriteHTML('                                                ' . $funcionJefeOperativo);
$pdf->Ln(8);
$pdf->WriteHTML('<b>Referencias:</b>');
$pdf->Ln(8);
$pdf->WriteHTML('<b>a.          Antecedentes:</b>');
$pdf->Ln(1);
$pdf->WriteHTML('             ___________');
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
$pdf->WriteHTML('<b>b.          Sistema Informático de Georreferencia:</b>');
$pdf->Ln(1);
$pdf->WriteHTML('             __________________________________');
$pdf->Ln(12);
$pdf->SetFont('Arial', 'B', 12);
$pdf->WriteHTML('<b>1. MISIÓN:</b>');
$pdf->Ln(1);
$pdf->WriteHTML('    _______');
$pdf->Ln(6);
$i = 1;
$pdf->SetFont('Arial', '', 11);
$mision = $DgoInfOrdenServicio->verificaEvaluacion($idDgoInfOrdenServicio);
foreach ($mision as $row => $keyf) {
	$pdf->Multicell(185, 5, '    1.' . $i . ')  ' . $keyf['descripcion'], 0, 'J', 0);
	$i++;
	$pdf->Ln(6);
}

$pdf->SetFont('Arial', 'B', 12);
$pdf->WriteHTML('<b>2. INSTRUCCIONES GENERALES</b>');
$pdf->Ln(1);
$pdf->WriteHTML('    ____________________________');
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 12);
$pdf->WriteHTML('   Antes:');
$pdf->Ln(1);
$pdf->WriteHTML('   _____');
$pdf->Ln(6);
$a = 1;
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Multicell(185, 5, 'RESPONSABLE DE LA ELABORACIÓN:', 0, 'L', 0);
$pdf->Ln(6);
$pdf->Multicell(185, 5, 'JEFE DE OPERACIONES DEL ' . $distrito, 0, 'C', 0);
$pdf->Ln(20);
$pdf->SetFont('Arial', '', 10);
$pdf->Multicell(185, 5, '_____________________________________________', 0, 'C', 0);
$pdf->Ln(6);
$elaboraO = explode('.', $elaboraOrden);
$pdf->Multicell(185, 5, $elaboraO[1], 0, 'C', 0);
$formatoGrado = $DgoInfOrdenServicio->formatoGrado($elaboraO[0]);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Multicell(185, 5, $formatoGrado, 0, 'C', 0);
$pdf->Ln(6);
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



$pdf->Output();
/*FIN INFORME*/
