<?php
ob_start("ob_gzhandler");
if (!isset($_SESSION)) {session_start();}

include_once '../../../clases/autoload.php';

//Instanciacion de clases
$dt          = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$hdrEveResDis = new HdrEveResDis;
$excel       = new Excel;
$conn        = DB::getConexionDB();


$titulo      = 'Registro Personas Sancionadas Por Error';
$fechaHoy    = $dt->format('Y-m-d');
$nArchivo    = "registros_" . $fechaHoy . ".xls";

$headers = array('Nro. Operativo', 'Fecha Operativo', 'Tipo Operativo', 'Nro. Parte Web', 'Servidor Policial Que Solicita El Registro', 'Fecha y Hora Registro','Cedula Persona Sancionada', 'Nombre Persona Sancionada', 'Tipo Sancion',  'Sancion Por', 'Usuario Que Registra Error De Sancion');

$column = array('cero', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve', 'diez');

//Cabeceras para la generacion del excel
header('Content-type: application/vnd.ms-excel charset=utf-8');
header("Content-Disposition: attachment;filename=" . $nArchivo);
header("Pragma: no-cache");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);

$sql = $hdrEveResDis->getSqlDiscriminacionesRegistros();

echo $excel->getImprimeExcel($conn, $sql, $titulo, $headers, $column);

ob_end_flush();