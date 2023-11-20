<?php
ob_start("ob_gzhandler");
if (!isset($_SESSION)) {
    session_start();
}
include_once '../../../clases/autoload.php';
$conn = DB::getConexionDB();
//Tratamiento de variables
$fd = strip_tags(trim($_GET['fd']));
$fh = strip_tags(trim($_GET['fh']));
$id = strip_tags(trim($_GET['id']));
$tipo = strip_tags(trim($_GET['tipo']));
$dt            = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$repCasosExcel = new RepPersonalComisios;
$reporteExcel  = new ReporteExcelDgo;
$valida        = new ValidaDgo;

//Variables
$rangoFechas = (!empty($fd) && !empty($fh)) ? '- DESDE ' . $fd . ' HASTA ' . $fh : '';
$titulo      = 'PERSONAL_COMISIOS ' . $rangoFechas;
$fechaHoy    = $dt->format('Y-m-d');
$nArchivo    = "reportePersonal_" . $fechaHoy . ".xls";

$headers     = array('ZONA', 'SUBZONA', 'DISTRITO', 'CIRCUITO', 'SUBCIRCUITO', 'OPERATIVO', 'CEDULA', 'GRADO', 'NOMBRES', 'CARGO', 'EJE', 'TIPO_EJE',  'UNIDAD', 'CODIGO RECINTO', 'TIPO_RECINTO', 'OPERATIVO', 'UNIDAD');

$column = array('ZONA', 'SUBZONA', 'DISTRITO', 'CIRCUITO', 'SUBCIRCUITO', 'OPERATIVO', 'CEDULA', 'GRADO', 'NOMBRES', 'CARGO', 'EJE', 'TIPO_EJE',  'UNIDAD', 'CODIGO', 'TIPO_RECINTO', 'NUMERO', 'UNIDAD');

//Validaciones de varibles
if ($valida->validate_fecha($fd) && $valida->validate_fecha($fh)) {
    $fechaInicio = $fd;
    $fechaFin    = $fh;
} else {
    $fechaInicio = '';
    $fechaFin    = '';
}
if ($valida->validate_fecha($fechaInicio) && $valida->validate_fecha($fechaFin)) {

    //Cabeceras para la generacion del excel
    header('Content-type: application/vnd.ms-excel charset=utf-8');
    header("Content-Disposition: attachment;filename=" . $nArchivo);
    header("Pragma: no-cache");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", false);

    $datos = $repCasosExcel->getRepPersonalComisios($fd, $fh, $id, $tipo);

    $reporteExcel->getImprimeExcel($datos, $titulo, $fechaHoy, $headers, $column);
} else {
    die('ERROR AL ENVIAR VARIABLES DEL REPORTE');
}
ob_end_flush();
