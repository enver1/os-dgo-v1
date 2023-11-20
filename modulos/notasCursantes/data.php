<?php
set_time_limit(1800);

include '../../../clases/autoload.php';
$conn = DB::getConexionDB();
include('clases/calificacion.php');

$calificacion = new calificacion;


$anio = 2019;
$idGenGeoSenplades = 2805;

echo '<pre>';

$data = $calificacion->obtenerCalificacionesCursantes($conn, $anio, $idGenGeoSenplades);

echo 'Memoria final: ' . memory_get_usage() . '
';


echo '</pre>';
die();
