<?php
include_once('../../../clases/autoload.php');
$conn = DB::getConexionDB();
$dt = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$hoyA = $dt->format('Y');
$soloServicioUrbano = "AND c.siglas LIKE 'OPSU%'";
$sql = "select siglasGeoSenplades from genGeoSenplades where idGenGeoSenplades=" . $_GET['geo'];
//echo $sql;
$rs = $conn->query($sql);
$row = $rs->fetch();
$siglas = trim($row['siglasGeoSenplades']);
$st = '';
if (isset($_GET['mes']) and $_GET['mes'] > 0) {
	$st = " and year(fechaEvento)=" . (isset($_GET['anio']) ? $_GET['anio'] : $hoyA) . " and month(fechaEvento)=" . $_GET['mes'];
} else {
	$st = " and year(fechaEvento)=" . (isset($_GET['anio']) ? $_GET['anio'] : $hoyA) . " ";
}

$st .= (isset($_GET['estado']) && $_GET['estado'] > 0) ? " and estadoPolicia={$_GET['estado']} " : "";

if (isset($_GET["geo"]) and $_GET["geo"] > 0) {

	$sql = "SELECT 
  a.estadoPolicia, 
  a.usuario,
  a.fechaEvento,
  a.descripcion,
  a.idHdrEvento,
  FORMAT(a.latitud, 12) latitud,
   FORMAT(a.longitud, 12) longitud,
   codigoEvento,
   c.descripcion desctipo,
   c.siglas, b.siglasGeoSenplades,
	b.descripcion descS 
	from hdrEvento a,
	genGeoSenplades b,
	genTipoTipificacion c  
	where 
	a.idGenGeoSenplades=b.idGenGeoSenplades " . $st . " 
	and a.idGenTipoTipificacion=c.idGenTipoTipificacion " . $soloServicioUrbano . " 
	and b.siglasGeoSenplades like '" . $siglas . "%'
	order by a.idHdrEvento desc";
};
$rs = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset=utf-8 />
	<!--<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />-->
	<meta name='viewport' content='width=device-width, initial-scale=1.0' />
	<meta http-equiv=“Content-Security-Policy” content=“default-src ‘self’ gap://ready file://* *; style-src ‘self’ ‘unsafe-inline’; script-src ‘self’ ‘unsafe-inline’ ‘unsafe-eval’” />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@latest/dist/leaflet.css" />
	<link rel="stylesheet" href="src/leaflet-sidebar.css" />
	<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
	<link rel="stylesheet" href="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.css">
	<link rel="stylesheet" href="dist/leaflet.groupedlayercontrol.css" />
	<link rel="stylesheet" href="dist/MarkerCluster.css" />
	<link rel="stylesheet" href="dist/MarkerCluster.Default.css" />


	<!-- Load Leaflet from CDN -->


	<script type="text/javascript" src="../../../js/jquery-3.0.0.min.js"></script>
	<link rel="stylesheet" href="index.css" />

</head>

<body>
	<div id="container">
		<div id="sidebar" class="sidebar collapsed">
			<!-- Nav tabs -->
			<div class="sidebar-tabs">
				<ul role="tablist">
					<li><a href="#home" role="tab"><i class="fa fa-filter"></i></a></li>
					<li><a href="#list" role="tab"><i class="fa fa-bars"></i></a></li>

				</ul>
			</div>

			<!-- Tab panes -->
			<div class="sidebar-content">
				<div class="sidebar-pane" id="home">
					<h1 class="sidebar-header">
						Filtros
						<span class="sidebar-close"><i class="fa fa-caret-left"></i></span>
					</h1>
					<br><br>
					<div id="filtros"></div>
				</div>
				<div class="sidebar-pane" id="list">
					<h1 class="sidebar-header">
						Operativos
						<span class="sidebar-close"><i class="fa fa-caret-left"></i></span>
					</h1>
					<div class="panel panel-default" id="features">
						<div class="panel-body">
							<div class="row">
								<div class="col-xs-8 col-md-8">
									<input type="text" class="form-control search" placeholder="Filtro" />
								</div>
							</div>
						</div>
						<div class="sidebar-table">
							<table class="table table-hover" id="feature-list">
								<thead class="hidden">
									<tr>
										<th>Icon</th>
									</tr>
									<tr>
										<th>Evento</th>
									</tr>
									<tr>
										<th>Fecha</th>
									</tr>
								</thead>
								<tbody class="list"></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div id="map"></div>
	</div>
	<div class="modal fade" id="featureModal" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title text-primary" id="feature-title"></h4>
				</div>
				<div class="modal-body" id="feature-info"></div>
				<div class="modal-body" id="feature-resumen"></div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
	<script src="https://unpkg.com/leaflet@latest/dist/leaflet-src.js"></script>
	<script src="src/leaflet-sidebar.js"></script>
	<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
	<script src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.min.js"></script>
	<script src="dist/leaflet.groupedlayercontrol.js"></script>
	<script src="dist/leaflet.markercluster-src.js"></script>
	<script type="text/javascript">
		/*var movil = false; 
      if ( /Android|webOS|Iphone|Ipod|BlackBerry|IEMobile|Opera Mini/i.test(navigation.userAgent)){
        movil = true;
      }*/


		/* Basemap Layers */
		var cartoLight = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
			maxZoom: 19,
			attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, &copy; <a href="https://cartodb.com/attributions">CartoDB</a>'
		});

		<?php while ($row = $rs->fetch()) { ?>
			<?php if (!empty($row['latitud']) and !empty($row['longitud'])) : ?>
				<?php
				$sqlG = "select 3 from hdrEvento where idHdrEvento=" . $row['idHdrEvento'] . " and estadoPolicia=3 limit 1";
				$rsG = $conn->query($sqlG);

				$sqlJefeO = "select v.siglas siglas,v.apenom apenom from v_persona v, genUsuario u where v.idGenPersona=u.idGenPersona and u.idGenUsuario=" . $row['usuario'];
				//echo $sqlJefeO;
				$rsJefeO = $conn->query($sqlJefeO);
				$rowJefeO = $rsJefeO->fetch();
				$sqlR = "select b.idHdrTipoResum,b.desHdrTipoResum,count(*) cuantos from hdrEventoResum a,hdrTipoResum b where a.idHdrTipoResum=b.idHdrTipoResum and a.idHdrEvento=" . $row['idHdrEvento'] . " group by a.idHdrTipoResum ";
				$rsD = $conn->query($sqlR);
				$userData = array();
				while ($rowD = $rsD->fetch()) {
					$userData[] = array('tipres' => $rowD['idHdrTipoResum'], 'descrip' => $rowD['desHdrTipoResum'], 'cta' => $rowD['cuantos']);
				}

				?>

			<?php endif ?>


		<?php

			$ubic[] = array(
				'type' => 'Feature',
				'properties' => array(
					'evento' => $row['codigoEvento'],
					'siglasGeoSenplades' => $row['siglasGeoSenplades'],
					'descS' => $row['descS'],
					'fechaEvento' => $row['fechaEvento'],
					'idHdrEvento' => $row['idHdrEvento'],
					'estadoPolicia' => $row['estadoPolicia'],
					'siglas' => $row['siglas'],
					'descripcion' => $row['descripcion'],
					'descTipoResum' => $userData,
					'jefeOperativo' => $rowJefeO['siglas'] . ' ' . $rowJefeO['apenom'],
					'desctipo' => $row['desctipo']
				),
				'geometry' => array(
					'type' => 'Point',
					'coordinates' => array(
						$row['longitud'],
						$row['latitud']
					)
				)
			);
		};
		$locali['features'] = !empty($ubic) ? $ubic : '0';
		$ver = json_encode($locali);

		?>
		var operativos = <?php echo $ver; ?>;
	</script>
	<script type="text/javascript" src="js/funciones.js"></script>
</body>