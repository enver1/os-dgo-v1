<?php
$dt         = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$hoyA       = $dt->format('Y');
$directorio = 'operativossu';
$encuentra  = false;
if (file_exists('../clases/autoload.php')) {
	include_once '../funciones/funcion_select.php';
	include_once '../funciones/funciones_generales.php';
	include_once '../clases/autoload.php';
}
if (file_exists('../../../clases/autoload.php')) {
	include_once '../../../funciones/funcion_select.php';
	include_once '../../../funciones/funciones_generales.php';
	include_once '../../../clases/autoload.php';
	$encuentra = true;
}
$conn = DB::getConexionDB();
$formPareto = new FormPareto();
$hdrEvento  = new HdrEvento();
$senplades = new Senplades();

$siglas = 'OPSU%';
$idGenGeoSenplades = 0;
$gen_idGenGeoSenplades = ((isset($_GET['id'])) ? $_GET['id'] : 0);

if ($gen_idGenGeoSenplades > 0) {
	$data = $senplades->getGenGeoSenplades($gen_idGenGeoSenplades);
	$idGenGeoSenplades = (!empty($data['gen_idGenGeoSenplades'])) ? $data['gen_idGenGeoSenplades'] : 0;
} else {
	$gen_idGenGeoSenplades = 3166;
}

$anio                  = ((isset($_GET['anio'])) ? $_GET['anio'] : $dt->format('Y'));
$mes                   = ((isset($_GET['mes'])) ? $_GET['mes'] : 0);
$idGenTipoTipificacion = 0; //((isset($_GET['tipo'])) ? $_GET['tipo'] : 0);
$estadoPolicia         = 3; //((isset($_GET['estado'])) ? $_GET['estado'] : 0);
$titulo                = 'ESTADISTICAS DE OPERATIVOS POLICIALES DE SERVICIO URBANO';

$data = $hdrEvento->getTotalHdrEventoOSU($gen_idGenGeoSenplades, $siglas, $anio, $mes, $idGenTipoTipificacion, $estadoPolicia);
$maximo = 0;
$total = 0;
$territorionombre = array();
$territoriocant = array();
$territorioid = array();
foreach ($data as $key => $value) {
	if ($value['cuantos'] > $maximo) {
		$maximo = $value['cuantos'];
	}
	$territorionombre[] = $value['descripcion'];
	$territoriocant[] = $value['cuantos'];
	$territorioid[] = $value['idGenGeoSenplades'];
	$total += $value['cuantos'];
}
// print_r($data);
// die();
?>
<style>
	.baret {
		width: 100px;
		height: 20px;
		background-color: #bbb;
		color: #000;
		font-family: Verdana, Geneva, sans-serif;
		font-size: 10px;
		text-align: center;
		border: solid 1px #333;
		border-radius: 8px;
		-moz-border-radius: 8px;
		-webkit-border-radius: 8px;
	}

	.bar {
		width: 500px;
		height: 40px;
		background-color: #F33;
		color: #111;
		font-family: Verdana, Geneva, sans-serif;
		font-size: 10px;
		text-align: center;
		border: solid 2px #444;
		border-radius: 0 4px 4px 0;
		-moz-border-radius: 0 4px 4px 0;
		-webkit-border-radius: 0 4px 4px 0;
		-webkit-box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
		-moz-box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
		box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
	}

	a.barra {
		text-decoration: none;
		border: none;
		color: #fff;
	}

	.bar:hover {
		background-color: #F9F;
		font-size: 12px;
	}

	.cuantos {
		font-family: Verdana, Geneva, sans-serif;
		font-size: 12px;
		font-weight: bold;
		padding-right: 5px;
	}

	.barMes {
		width: 500px;
		height: 20px;
		background-color: #F33;
		color: #111;
		font-family: Verdana, Geneva, sans-serif;
		font-size: 10px;
		text-align: center;
		border: solid 2px #444;
		border-radius: 0 4px 4px 0;
		-moz-border-radius: 0 4px 4px 0;
		-webkit-border-radius: 0 4px 4px 0;
	}

	.barMes:hover {
		background-color: #F9F;
		font-size: 12px;
	}
</style>
<script>
	$(function() {
		colorButon(<?php echo $anio ?>, <?php echo $mes ?>);
	});

	function colorButon(anio, mes) {
		for (i = 0; i <= 12; i++) {
			$('#b' + i).css('background-color', '#555');
		}

		for (i = 2014; i <= 2050; i++) {
			$('#c' + i).css('background-color', '#333');
		}

		$('#b' + mes).css('background-color', '#F33');
		$('#c' + anio).css('background-color', '#F33');
	}

	function selectAnio(a) {
		$('#tAnio').val(a);
		$('#subir').val(0);
		entrar(0);
	}

	function selectMes(m) {
		$('#tMes').val(m);
		$('#subir').val(0);
		entrar(0);
	}

	function entrar(c) {
		var id = c;
		var anio = $('#tAnio').val();
		var mes = $('#tMes').val();
		var subir = $('#subir').val();

		$('#forma').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
		$('#forma').load('modulos/operativossu/aplicacion.php?id=' + c + '&mes=' + mes + '&anio=' + anio + '&subir=' + subir);
	}
</script>

<div id="forma">
	<div><span class="texto_gris" style="font-size:18px"><?php echo $titulo ?></span>
		<p>
	</div>
	<div><?php echo $formPareto->getBotones(); ?><br></div>
	<form id="edita">
		<table width="100%" border="0" cellspacing="4" cellpadding="3">
			<tr>
				<td colspan="3">
					<input type="hidden" id="tAnio" value="<?php echo $anio ?>" />
					<input type="hidden" id="tMes" value="<?php echo $mes ?>" />
					<input type="hidden" id="subir" value="<?php echo $idGenGeoSenplades ?>" />
				</td>
			</tr>

		</table>
	</form>




	<!-- Custom fonts for this template-->
	<link href="modulos/operativossu/src/operational/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

	<!-- Custom styles for this template-->
	<link href="modulos/operativossu/src/css/sb-admin-2.css" rel="stylesheet">

	<!-- Page Wrapper -->
	<div id="wrapper">


		<!-- Content Wrapper -->
		<div id="content-wrapper">

			<!-- Main Content -->
			<div id="content">

				<!-- Begin Page Content -->
				<div class="container-fluid">

					<!-- Content Row -->
					<div class="row">
						<!-- Card Total -->
						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-left-primary shadow h-100 py-2">
								<div class="card-body">
									<div class="row no-gutters align-items-center">
										<div class="col mr-2">
											<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Operativos</div>
											<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total  ?></div>
										</div>
										<div class="col-auto">
											<i class="fas fa-circle fa-2x text-gray-500"></i>
										</div>
									</div>
								</div>
								<?php if ($total > 0) { ?>
									<a class="card-footer text-danger clearfix small z-1" href="modulos/operativossu/gmaps.php?geo=<?= $gen_idGenGeoSenplades ?>&mes=<?php echo $mes ?>&anio=<?php echo $anio ?>&estado=<?php echo $estadoPolicia ?>" onclick="return GB_showPage('Geolocalizaci&oacute;n de Operativos de Servicio Urbano', this.href)">
										<span class="float-left">Ver Mapa</span>
										<span class="float-right">
											<i class="fas fa-angle-right"></i>
										</span>
									</a>
								<?php }; ?>

							</div>
						</div>
						<!-- Card Registros -->
						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-left-success shadow h-100 py-2">
								<div class="card-body">
									<div class="row no-gutters align-items-center">
										<div class="col mr-2">
											<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Registros</div>
											<?php
											$ctareg = $hdrEvento->cuentaregistrosOsu($gen_idGenGeoSenplades, $anio, $mes, $estadoPolicia, $siglas);
											$totalr = 0;
											foreach ($ctareg as $key => $valuer) {
												$totalr += $valuer['cuantosr'];
											}
											?>
											<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalr; ?></div>
										</div>
										<div class="col-auto">
											<i class="fas fa-registered fa-2x text-gray-500"></i>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Card Resultados -->
						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-left-info shadow h-100 py-2">
								<div class="card-body">
									<div class="row no-gutters align-items-center">
										<div class="col mr-2">
											<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Resultados</div>
											<div class="row no-gutters align-items-center">
												<div class="col-auto">
													<?php
													$ctars = $hdrEvento->cuentaResultadosOsu($gen_idGenGeoSenplades, $anio, $mes, $estadoPolicia, $siglas);
													$totalrs = 0;
													foreach ($ctars as $key => $valuers) {
														$totalrs += $valuers['cuantosrs'];
													}
													?>
													<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $totalrs; ?></div>
												</div>
											</div>
										</div>
										<div class="col-auto">
											<i class="fas fa-chart-line fa-2x text-gray-500"></i>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
					<div class="row">
						<!-- Bar Chart tipo operativo -->
						<div class="col-xl-6 col-lg-5">
							<div class="card shadow mb-4">
								<!-- Card Header - Dropdown -->
								<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary">Operativos por Tipo</h6>
								</div>
								<!-- Card Body -->
								<div class="card-body">
									<div class="chart-bar">
										<canvas id="myBarChart"></canvas>
									</div>
								</div>
							</div>
						</div>
						<!-- Bar Chart por zona-->
						<div class="col-xl-6 col-lg-5">
							<div class="card shadow mb-4">
								<!-- Card Header - Dropdown -->
								<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary">Operativos por Territorio</h6>
								</div>
								<!-- Card Body -->
								<div class="card-body">
									<div class="chart-bar">
										<?php if ($gen_idGenGeoSenplades > 0) : ?>

											<a href="javascript:void(0)" onClick="entrar(<?php echo $idGenGeoSenplades ?>)" class="barra">
												<div class="baret"><span>Subir</span></div>
											</a>

										<?php endif ?>
										<canvas id="BarChartTerritorio"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>


				</div>
				<!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->


		</div>
		<!-- End of Content Wrapper -->

	</div>
</div>
<?php
$ctatipo = $hdrEvento->cuentaxTipoOsu($gen_idGenGeoSenplades, $anio, $mes, $estadoPolicia, $siglas);
$tiponombre1 = array();
$tipocant1 = array();

foreach ((array)$ctatipo as $observacion) {
	$tiponombre1[] = $observacion['desctipo'];
	$tipocant1[] = $observacion['ctatipo'];
}
?>
<script type="text/javascript">
	var tiponombre = <?php echo json_encode($tiponombre1) ?>;
	var tipocant = <?php echo json_encode($tipocant1) ?>;
	var territorionombre = <?php echo json_encode($territorionombre) ?>;
	var territoriocant = <?php echo json_encode($territoriocant) ?>;
	var territorioid = <?php echo json_encode($territorioid) ?>;
</script>
<!-- Page level plugins -->
<script src="modulos/operativossu/src/operational/chart.js/Chart.min.js"></script>

<!-- scripts operativos por tipo -->
<script src="modulos/operativossu/js/chart-bar.js"></script>
<!-- scripts operativos por zona -->
<script src="modulos/operativossu/js/chart-bar-h.js"></script>