<?php
ob_start("ob_gzhandler");
if (!isset($_SESSION)) {
	session_start();
}
$filename = "Notas_SubCircuitos";
include '../../../clases/autoload.php';
include('../notasCursantes/clases/calificacion.php');
$conn = DB::getConexionDB();

$calificacion = new calificacion;
function specialChars($texto = '')
{
	$p = array('/á/', '/é/', '/í/', '/ó/', '/ú/', '/Á/', '/É/', '/Í/', '/Ó/', '/Ú/', '/à/', '/è/', '/ì/', '/ò/', '/ù/', '/ñ/', '/Ñ/');
	$r = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'n', 'N');
	$x = preg_replace($p, $r, $texto);
	return $x;
}
function imprimeTabla($rowT)
{

	$notas = array();
	for ($i = 0; $i < count($rowT); $i++) {
		$sumaVioDelin = 0;
		$sumaProduc = 0;
		$totalVioDelin = 0;
		$totalProduc = 0;

		$m = 1;
		for ($j = 0; $j < count($rowT[$i]); $j++) {

			if (!empty($rowT[$i][$j]['resultVioDelin'])) {
				$totalVioDelin++;
				$sumaVioDelin += $rowT[$i][$j]['resultVioDelin'];
			}

			if ($j == 0) {
				$notas[$i]['codigoSenplades'] = $rowT[$i][$j]['codigoSenplades'];
				$notas[$i]['mesVD' . $m] = number_format($rowT[$i][$j]['resultVioDelin'], 3);
			} else {
				$notas[$i]['mesVD' . $m] = number_format($rowT[$i][$j]['resultVioDelin'], 3);
			}

			if ($j == count($rowT[$i]) - 1) {
				$notas[$i]['promedioVD'] = number_format($sumaVioDelin / $totalVioDelin, 3);
			}
			$m++;
		}

		$m = 1;
		for ($j = 0; $j < count($rowT[$i]); $j++) {
			if (!empty($rowT[$i][$j]['resultProduc'])) {
				$totalProduc++;
				$sumaProduc += $rowT[$i][$j]['resultProduc'];
			}

			$notas[$i]['mesP' . $m] = number_format($rowT[$i][$j]['resultProduc'], 3);

			if ($j == count($rowT[$i]) - 1) {
				$notas[$i]['promedioP'] = number_format($sumaProduc / $totalProduc, 3);
			}
			$m++;
		}
	}

	return $notas;
}

if (!empty($_GET['anio'])) {
	$dt = new DateTime('now', new DateTimeZone('America/Guayaquil'));
	$fechaHoy           = $dt->format('Y-m-d H:i:s');

	$ini = '01/01/' . $_GET['anio'];
	$fin = '31/12/' . $_GET['anio'];
	$fini = $ini . " " . "00:00:01";
	$ffin = $fin . ' 23:59:59';
	$geo = isset($ini['geo']) ? $ini['geo'] : 0;
	$datos = array();
	$datos = $calificacion->obtenerCalificacionesSubCircutos($conn, $_GET['anio']);
	$fecha = "";
	$funcion = "FUNCION";
	$tCuadro = 'TRASLADO DE VALORES DESDE ' . $ini . ' HASTA ' . $fin;
	$estructura = array('Codigo Senplades', 'Enero V.D.', 'Febrero V.D.', 'Marzo V.D.', 'Abril V.D.', 'Mayo V.D.', 'Junio V.D.', 'Julio V.D.', 'Agosto V.D.', 'Septiembre V.D.', 'Octubre V.D.', 'Noviembre V.D.', 'Diciembre V.D.', 'Promedio V.D.', 'Enero P.', 'Febrero P.', 'Marzo P.', 'Abril P.', 'Mayo P.', 'Junio P.', 'Julio P.', 'Agosto P.', 'Septiembre P.', 'Octubre P.', 'Noviembre P.', 'Diciembre P.', 'Promedio P.');
	$aFilas = imprimeTabla($datos);
	try {
		$filename = tempnam(sys_get_temp_dir(), "csv");
		$file = fopen($filename, "w");
		foreach ($aFilas as $line) {
			fputcsv($file, $line, ';');
		}
		fclose($file);
		header("Content-Type: application/csv");
		$nArchivo = "matriz_GestCalidad_" . str_replace('-', '_', $fechaHoy) . ".csv";
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
