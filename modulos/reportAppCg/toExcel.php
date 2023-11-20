<?php
include '../../../funciones/db_connect.inc.php';
include_once '../../../clases/autoload.php';
ob_start("ob_gzhandler");
if (!isset($_SESSION)) {
    session_start();
}
$registroAspectoAppCg  = new RegistroAspectoAppCg;
$reporteExcel = new ReporteExcelDgo;
$valida       = new ValidaDgo;
//Tratamiento de variables
$fd = strip_tags(trim($_GET['fd']));
$fh = strip_tags(trim($_GET['fh']));
$gs = (empty($_GET['gs'])) ? 0 : strip_tags(trim($_GET['gs']));

//Instanciacion de clases
$dt           = new DateTime('now', new DateTimeZone('America/Guayaquil'));
//Variables
$rangoFechas = (!empty($fd) && !empty($fh)) ? '- DESDE ' . $fd . ' HASTA ' . $fh : '';
$titulo      = 'Registro Aspectos ' . $rangoFechas;
$fechaHoy    = $dt->format('Y-m-d');
$nArchivo    = "reporteAspectos_" . $fechaHoy . ".xls";
header('Content-Type: text/html; charset=UTF-8');
$headers     = array('CÓDIGO', 'SERVIDOR_POLICIAL_OBSERVADOR', 'UNIDAD', 'FUNCIÓN', 'SERVIDOR_POLICIAL_SANCIONADO', 'DOCUMENTO', 'UNIDAD_PER', 'FUNCIÓN_PER', 'TIPO_ASPECTO', 'DETALLE_ASPECTO', 'ASPECTO', 'MOTIVO');
$column      = array('idCgRegistroAspecto', 'nombrePersonaJefe', 'unidad', 'funcion', 'nombrePersona', 'cedulaPersona', 'unidadPer', 'funcionPer', 'tipo', 'detalle', 'aspecto', 'motivo');

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
    header('Content-Type: text/html; charset=UTF-8');
    $sql = $registroAspectoAppCg->getDatosReporte($fechaInicio, $fechaFin);

    $reporteExcel->getImprimeExcel($sql, $titulo, $fechaHoy, $headers, $column);
} else {
    die('ERROR AL ENVIAR VARIABLES DEL REPORTE');
}
ob_end_flush();
