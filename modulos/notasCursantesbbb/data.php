<?php
set_time_limit(1800);

include '../../../funciones/db_connect.inc.php';
include('clases/calificacion.php');

$calificacion = new calificacion;


$anio=2019;
$idGenGeoSenplades = 2805;

echo '<pre>';
//$data = $calificacion->obtenerCursantes($conn,$anio);

//echo $sqlNC=$calificacion->generarSqlCalificaciones($conn,$anio);

//$data=$calificacion->consultaMatriz($conn,$sqlNC);

$data=$calificacion->obtenerCalificacionesCursantes($conn,$anio,$idGenGeoSenplades);

//echo count($data);

echo 'Memoria final: ' . memory_get_usage() . '
';

//print_r($data);
echo '</pre>';
die();