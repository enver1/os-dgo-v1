<?php
error_reporting(-1);

	$pages = '1-4';

	include '../../clases/php-jasper/Adl/Configuration.php';
	include '../../clases/php-jasper/Adl/Config/Parser.php';
	include '../../clases/php-jasper/Adl/Config/JasperServer.php';
	include '../../clases/php-jasper/Adl/Integration/RequestJasper.php';
    try {
	$jasper = new Adl\Integration\RequestJasper();

	/*
	To send output to browser
	*///fini=2017-11-30&ffin=2017-11-30&op=3&geosem=2805

	$ini=$_GET['fini'];
	$fin=$_GET['ffin'];
	$geosem=$_GET['geosem'];
	$op=$_GET['op'];
	$fini=$ini.' '.'00:00:01';
	$ffin=$fin.' '.'23:59:59';
	switch ($op) {
		case '2':
						header('Content-type: application/pdf');
						header('Content-Disposition: attachment; filename="reporte.pdf";charset=UTF-8');
						echo $jasper->run('/reports/siipne/polco/OperativoMovil','PDF', array(
							'fini' => $fini,
							'ffin' => $ffin,
							'geosem'=> $geosem
							));
			break;

		case '3':
						header('Content-type: application/pdf');
						header('Content-Disposition: attachment; filename="reporte.pdf";charset=UTF-8');
						echo $jasper->run('/reports/siipne/polco/OperativoResultado','PDF', array(
							'fini' => $fini,
							'ffin' => $ffin,
							'geosem'=> $geosem
            ));
			break;
		case '4':

                       // header('Content-type: application/vnd.ms-excel');
                       //header("Content-Disposition: attachment;filename=".$nArchivo);
                       // header("Pragma: no-cache");
                       // header("Content-Disposition: attachment; filename=reporte.xls");
                       // header("Expires: 0");


						header("Content-type: application/vnd.ms-excel");
						header("Content-Disposition: attachment; filename=reporte.xls");
						header("Pragma: no-cache");
						header("Expires: 0");



						//header("Pragma: no-cache");
						//header("Expires: 0");
						//header("Cache-Control: private");

						//header('Content-type: application/pdf');
						//header('Content-Disposition: attachment; filename="reporte.pdf";charset=UTF-8');
						echo $jasper->run('/reports/siipne/transito/excelTransito','xls', array(
							'fini' => $fini,
							'ffin' => $ffin
							));
			break;
			case '5':
						header('Content-type: application/pdf');
						header('Content-Disposition: attachment; filename="reporte.pdf";charset=UTF-8');
						echo $jasper->run('/reports/siipne/polco/NovedadMapa','PDF', array(
							'fini' => $fini,
							'ffin' => $ffin,
							'geo'=> $geosem
							));
			break;
	}





	//$jasper->run('/reports/samples/AllAccounts','PDF', null, true);

} catch (\Exception $e) {
	echo $e->getMessage();
	die;
}
