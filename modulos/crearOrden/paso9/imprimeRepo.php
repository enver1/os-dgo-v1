<?php
session_start();
error_reporting(1);
//include_once "../../../../fpdf/fpdf.php";
include_once '../../../../clases/autoload.php';
//include_once '../../../../funciones/clasePDF.php';
include_once '../../../../funciones/funcion_select.php';
include_once '../../../clases/claseInforme.php';
include_once "config.php";
$crearOrdenServicio = new CrearOrdenServicio;
$dgoTalentoHumanoOrden = new DgoTalentoHumanoOrden;
$dgoAnexosOrden = new DgoAnexosOrden;
$dgoEjemplaresOrden = new DgoEjemplarOrden;
$ambitoGestionOrden      = new AmbitoGestionOrden;
$idDgoOrdenServicio       = $_GET['id'];
// $dt              = new DateTime('now', new DateTimeZone('America/Guayaquil'));
// $fechaHoy        = $dt->format('Y-m-d');
// $anio = explode("-", $fechaHoy);
// $anioHoy = $anio[0];
$datosUsuario =    $ambitoGestionOrden->getDatosUsuariosSenplades($_SESSION['usuarioAuditar']);
$datosOrden = $crearOrdenServicio->getEditCrearOrdenServicio($idDgoOrdenServicio);
$consultaOrdinalOrden = $crearOrdenServicio->consultaOrdinalOrden($idDgoOrdenServicio);
$ejemplares = $dgoEjemplaresOrden->getDgoEjemplarOrden($idDgoOrdenServicio);
$nroEjemplares = 0;
for ($i = 0; $i < COUNT($ejemplares); $i++) {
    $nroEjemplares = $nroEjemplares + 1;
}
ob_end_clean();

$calificacion = $datosOrden['calificacion'];

$pdf            = new PDF();
$pdf->imagen    = "includes/logoPN.jpg";
$pdf->watermark = '../../../../imagenes/novalido.jpg';
/////////////////////////ENCABEZADO DERECHA
$ejemplar = 'EJEMPLAR No 1 DE ' . $nroEjemplares;
$policia = 'POLICíA NACIONAL DEL ECUADOR';
$distrito = $datosOrden['Distrito'];
$ciudad = $datosOrden['ciudad'] . ' ' . '(PROV. ' . $datosOrden['provincia'] . ')';
$fechaT = $crearOrdenServicio->formatoFecha($datosOrden['fechaOrden'], 2);
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
$fechaO = $crearOrdenServicio->formatoFecha($datosOrden['fechaOrden'], 1);
$hora = $datosOrden['horaOrden'];
$horaF = $datosOrden['horaFormacion'];
$orden = 'ORDEN DE SERVICIO NO.' . $numeroOrden . ' PARA ' . $nombreOperativo . ',  A REALIZARSE EL DIA ' . $fechaO . ' EN LA JURISDICCION DEL ' . $distrito . ',  A PARTIR DE LAS ' . $hora . '.';
/////////////////////////////////////////////////////////////////////////////////
/*********************INICIO INFORME******************************************/
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
$antecedentes = $crearOrdenServicio->verificaAntecedente($idDgoOrdenServicio);
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
$mision = $crearOrdenServicio->verificaMision($idDgoOrdenServicio);
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
$instrucciones = $crearOrdenServicio->verificaInstruccionesDetalle($idDgoOrdenServicio, "G", "ANTES");
$pdf->SetFont('Arial', '', 11);
foreach ($instrucciones as $row => $keyf) {
    $pdf->Multicell(185, 5, '       2.' . $a . '  ' . $keyf['descripcion'], 0, 'J', 0);
    $a++;
    $pdf->Ln(4);
}
$pdf->SetFont('Arial', '', 12);
$pdf->WriteHTML('   Durante:');
$pdf->Ln(1);
$pdf->WriteHTML('   _______');
$pdf->Ln(6);
$instrucciones = $crearOrdenServicio->verificaInstruccionesDetalle($idDgoOrdenServicio, "G", "DURANTE");
$pdf->SetFont('Arial', '', 11);
foreach ($instrucciones as $row => $keyf) {
    $pdf->Multicell(185, 5, '       2.' . $a . '  ' . $keyf['descripcion'], 0, 'J', 0);
    $a++;
    $pdf->Ln(4);
}
$pdf->SetFont('Arial', '', 12);
$pdf->WriteHTML('   Después:');
$pdf->Ln(1);
$pdf->WriteHTML('   ________');
$pdf->Ln(6);
$instrucciones = $crearOrdenServicio->verificaInstruccionesDetalle($idDgoOrdenServicio, "G", "DESPUÉS");
$pdf->SetFont('Arial', '', 11);
foreach ($instrucciones as $row => $keyf) {
    $pdf->Multicell(185, 5, '       2.' . $a . '  ' . $keyf['descripcion'], 0, 'J', 0);
    $a++;
    $pdf->Ln(4);
}

$pdf->SetFont('Arial', 'B', 12);
$pdf->WriteHTML('<b>3. INSTRUCCIONES PARTICULARES</b>');
$pdf->Ln(1);
$pdf->WriteHTML('    ____________________________');
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 12);
$pdf->WriteHTML('   Antes:');
$pdf->Ln(1);
$pdf->WriteHTML('   _____');
$pdf->Ln(6);
$a = 1;
$instrucciones = $crearOrdenServicio->verificaInstruccionesDetalle($idDgoOrdenServicio, "P", "ANTES");
$pdf->SetFont('Arial', '', 11);
foreach ($instrucciones as $row => $keyf) {
    $pdf->Multicell(185, 5, '       3.' . $a . '  ' . $keyf['descripcion'], 0, 'J', 0);
    $a++;
    $pdf->Ln(4);
}
$pdf->SetFont('Arial', '', 12);
$pdf->WriteHTML('   Durante:');
$pdf->Ln(1);
$pdf->WriteHTML('   _______');
$pdf->Ln(6);
$instrucciones = $crearOrdenServicio->verificaInstruccionesDetalle($idDgoOrdenServicio, "P", "DURANTE");
$pdf->SetFont('Arial', '', 11);
foreach ($instrucciones as $row => $keyf) {
    $pdf->Multicell(185, 5, '       3.' . $a . '  ' . $keyf['descripcion'], 0, 'J', 0);
    $a++;
    $pdf->Ln(4);
}
$pdf->SetFont('Arial', '', 12);
$pdf->WriteHTML('   Después:');
$pdf->Ln(1);
$pdf->WriteHTML('   ________');
$pdf->Ln(6);
$instrucciones = $crearOrdenServicio->verificaInstruccionesDetalle($idDgoOrdenServicio, "P", "DESPUÉS");
$pdf->SetFont('Arial', '', 11);
foreach ($instrucciones as $row => $keyf) {
    $pdf->Multicell(185, 5, '       3.' . $a . '  ' . $keyf['descripcion'], 0, 'J', 0);
    $a++;
    $pdf->Ln(4);
}



$pdf->SetFont('Arial', 'B', 12);
$pdf->WriteHTML('<b>4.	DISTRIBUTIVO DEL TALENTO HUMANO Y MEDIOS LOGÍSTICOS.</b>');
$pdf->Ln(1);
$pdf->WriteHTML('<b>___________________________________________________________</b>');
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 10);
$pdf->WriteHTML('       <B>LUGAR:</B>' . '       ' . $distrito . '<br></br>');
$pdf->WriteHTML('       <B>FECHA:</B>' . '       ' . $fechaO . '<br></br>');
$pdf->WriteHTML('       <B>HORA:</B>' . '        ' . $hora . '<br></br>');
$pdf->WriteHTML('       <B>HORA FORMACIÓN:</B>' . $horaF . '<br></br>');
$pdf->Ln(6);

$pdf->SetFont('Arial', 'B', 10);
$pdf->WriteHTML('   a. Talento Humano:');
$pdf->Ln(1);
$pdf->WriteHTML('   __________________');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$columnas       = 4;
$anchoColumnas  = '85,30,30,30';
$tituloColumnas = array('UNIDAD', 'OF. SUPERIORES', 'OF. SUBALTERNOS', 'CLASES Y POLICIAS');
$fuerzasPropias = $crearOrdenServicio->getDatosTalentoHumanoPorUnidad($idDgoOrdenServicio);
$header = $tituloColumnas;
$pdf->FancyTable($header, $fuerzasPropias, 200, 220, 255, 0, $columnas, $anchoColumnas);

$columnas       = 4;
$anchoColumnas  = '85,30,30,30';
$tituloColumnas = array();
$pdf->SetFont('Arial', 'B', 8);
$header = $tituloColumnas;
$fuerzasPropiasT = $crearOrdenServicio->getTotalTalentoHumano($idDgoOrdenServicio);
$pdf->FancyTable($header, $fuerzasPropiasT, 200, 220, 255, 0, $columnas, $anchoColumnas);
$pdf->Ln(6);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Multicell(185, 5, 'Listado de Talento Humano', 0, 'C', 0);
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$columnas       = 3;
$anchoColumnas  = '65,60,55';
$tituloColumnas = array('Nombres y Apellidos', 'Unidad', 'Designación');
$header = $tituloColumnas;
$fuerzasAgregadasT = $crearOrdenServicio->getDatosListaTalentoHumanoOrden($idDgoOrdenServicio);
$pdf->FancyTable($header, $fuerzasAgregadasT, 200, 220, 255, 0, $columnas, $anchoColumnas);
$pdf->Ln(6);

$pdf->SetFont('Arial', 'B', 10);
$pdf->WriteHTML('   b. Agregaciones:');
$pdf->Ln(1);
$pdf->WriteHTML('   __________________');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$columnas       = 3;
$anchoColumnas  = '100,40,40';
$tituloColumnas = array('UNIDAD', 'JEFES', 'SUBALTERNOS');
$fuerzasAgregadas = $crearOrdenServicio->verificaFuerzasAgregadas($idDgoOrdenServicio);
$header = $tituloColumnas;
$pdf->FancyTable($header, $fuerzasAgregadas, 200, 220, 255, 0, $columnas, $anchoColumnas);
$columnas       = 3;
$anchoColumnas  = '100,40,40';
$tituloColumnas = array();
$header = $tituloColumnas;
$pdf->SetFont('Arial', 'B', 8);
$fuerzasAgregadasT = $crearOrdenServicio->getTotalFuerzasA($idDgoOrdenServicio);
$pdf->FancyTable($header, $fuerzasAgregadasT, 200, 220, 255, 0, $columnas, $anchoColumnas);
$pdf->Ln(6);

$pdf->SetFont('Arial', 'B', 10);
$pdf->WriteHTML('   c. Medios Logísticos:');
$pdf->Ln(1);
$pdf->WriteHTML('   __________________');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$columnas       = 2;
$anchoColumnas  = '100,80';
$tituloColumnas = array('MEDIOS LOGÍSTICOS', 'CANTIDAD');
$mediosLogistico = $crearOrdenServicio->verificaMediosLogísticos($idDgoOrdenServicio);
$header = $tituloColumnas;
$pdf->FancyTable($header, $mediosLogistico, 200, 220, 255, 0, $columnas, $anchoColumnas);
$pdf->Ln(12);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Multicell(185, 5, 'ANEXOS.', 0, 'L', 0);
$pdf->Ln(6);
$anexos = $crearOrdenServicio->verificaAnexos($idDgoOrdenServicio);
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
$ejemplares = $crearOrdenServicio->verificaEjemplaresTipo($idDgoOrdenServicio, "PARA INFORMACIÓN");
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
$ejemplares = $crearOrdenServicio->verificaEjemplaresTipo($idDgoOrdenServicio, "PARA EJECUCIÓN");
foreach ($ejemplares as $row => $keyf) {
    $pdf->Multicell(185, 5, '       Ejemplar ' . $a . '.  ' . $keyf['descripcion'], 0, 'J', 0);
    $a++;
    $pdf->Ln(3);
}
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
$formatoGrado = $crearOrdenServicio->formatoGrado($elaboraO[0]);
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
$formatoGrado = $crearOrdenServicio->formatoGrado($siglasComan);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Multicell(185, 5, $formatoGrado, 0, 'C', 0);
$pdf->InHeader   = true;
$pdf->Output();
/*FIN INFORME*/
