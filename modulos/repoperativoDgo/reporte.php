<?php

$pages = '1-4';

include '../../clases/php-jasper/Adl/Configuration.php';
include '../../clases/php-jasper/Adl/Config/Parser.php';
include '../../clases/php-jasper/Adl/Config/JasperServer.php';
include '../../clases/php-jasper/Adl/Integration/RequestJasper.php';
try {
	$jasper = new Adl\Integration\RequestJasper();
	/*
	To send output to browser
	*/

	$ini = $_GET['fini'];
	$fin = $_GET['ffin'];
	//$geosem=$_GET['geosem'];
	$op = $_GET['op'];
	$fini = $ini . ' ' . '00:00:01';
	$ffin = $fin . ' ' . '23:59:59';
	switch ($op) {
		case '2':
			header('Content-type: application/pdf');
			header('Content-Disposition: attachment; filename="reporte.pdf";charset=UTF-8');
			echo $jasper->run('/reports/siipne/transito/OperativoMovil', 'PDF', array(
				'fini' => $fini,
				'ffin' => $ffin
			));
			break;

		case '3':
			header('Content-type: application/pdf');
			header('Content-Disposition: attachment; filename="reporte.pdf";charset=UTF-8');
			echo $jasper->run('/reports/siipne/transito/OperativoResultado', 'PDF', array(
				'fini' => $fini,
				'ffin' => $ffin
			));
			break;
		case '4':

			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=reporte.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			echo $jasper->run('/reports/siipne/transito/excelTransito', 'xls', array(
				'fini' => $fini,
				'ffin' => $ffin
			));
			break;
	}
} catch (\Exception $e) {
	echo $e->getMessage();
	die;
}
