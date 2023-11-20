<?php

ob_start("ob_gzhandler");
if (!isset($_SESSION)) {
	session_start();
}
$filename = "Linea_Base";
include '../../../clases/autoload.php';
include('clases/lineaBase.php');
$conn = DB::getConexionDB();
$lineaBase = new lineaBase;
function imprimeTabla($rowT, $data)
{
	$notas = array();
	$i = 0;
	foreach ($rowT as $value) {
		foreach ($data as $key => $campo) {

			if (stristr($campo, 'cantidad') === FALSE) {
				$notas[$i][$key] = $value[$campo];
			} else {
				$notas[$i][$key] = number_format($value[$campo], 3);
			}
		}
		$i++;
	}
	return $notas;
}

if (!empty($_GET['anio']) && !empty($_GET['mes'])) {
	$fecha   = "";
	$funcion = "FUNCION";

	$dt = new DateTime('now', new DateTimeZone('America/Guayaquil'));
	$fechaHoy           = $dt->format('Y-m-d H:i:s');
	//$tCuadro = 'TRASLADO DE VALORES DESDE ' . $ini . ' HASTA ' . $fin;
	$header = $lineaBase->obtenerTitulosLineaBase($conn);
	$datos  = $lineaBase->obtenerLineaBase($conn, $_GET['anio'], $_GET['mes']);
	$data   = $lineaBase->obtenerData($conn);
	$aFilas = imprimeTabla($datos, $data);
	$estructura = $header;
	try {

		$filename = tempnam(sys_get_temp_dir(), "csv");
		$file = fopen($filename, "w");
		foreach ($aFilas as $line) {
			fputcsv($file, $line, ';');
		}

		fclose($file);
		header("Content-Type: application/csv");
		$nArchivo = "Linea_Base_Año_" . str_replace('-', '_', $fechaHoy) . ".csv";
		header("Content-Disposition: attachment;Filename=" . $nArchivo);
		readfile($filename);
		unlink($filename);
	} catch (Exception  $e) {
		die('No se pudo pasar a formato csv');
	}
} else {
	echo 'No ha seleccionado opciones';
}
ob_end_flush();
