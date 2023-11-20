<?php
include_once('../../../clases/autoload.php');
$conn = DB::getConexionDB();
$dt = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$hoyA = $dt->format('Y');
$soloServicioUrbano = " and a.idHdrTipoServicio= 4 ";
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



if (isset($_GET["tipo"]) and $_GET["tipo"] > 0) {
	if (isset($_GET['tipo']) and $_GET['tipo'] != '')
		$st .= " and c.idGenTipoTipificacion=" . $_GET['tipo'] . " ";
	$sql = "select a.estadoPolicia, a.usuario,a.fechaEvento,a.descripcion,a.idHdrEvento,FORMAT(a.latitud, 12) latitud, FORMAT(a.longitud, 12) longitud,codigoEvento,c.descripcion desctipo,c.siglas, b.siglasGeoSenplades, b.descripcion descS   from hdrEvento a,genGeoSenplades b,genTipoTipificacion c  where a.idGenGeoSenplades=b.idGenGeoSenplades " . $st . " and a.idGenTipoTipificacion=c.idGenTipoTipificacion " . $soloServicioUrbano . " and b.siglasGeoSenplades like '" . $siglas . "%' order by a.idHdrEvento desc ";
} else {
	$sql = "select a.estadoPolicia, a.usuario,a.fechaEvento,a.descripcion,a.idHdrEvento,FORMAT(a.latitud, 12) latitud,FORMAT(a.longitud, 12) longitud,codigoEvento,c.descripcion desctipo,c.siglas,b.siglasGeoSenplades, b.descripcion descS 	 from hdrEvento a, genGeoSenplades b, genTipoTipificacion c where a.idGenGeoSenplades=b.idGenGeoSenplades " . $st . " and a.idGenTipoTipificacion=c.idGenTipoTipificacion " . $soloServicioUrbano . " and b.siglasGeoSenplades like '" . $siglas . "%' order by a.idHdrEvento desc ";
}
$rs = $conn->query($sql);
?>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-16" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.4/leaflet.css" />

	<link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow" rel="stylesheet" />
	<link rel="stylesheet" href="index.css" />
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.4/leaflet.js"></script>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</head>

<style>
	#map-content {
		width: 100%;
		height: 100%;
		margin: 0;
	}

	#panel {
		position: absolute;
		height: 90%;
		width: 150px;
		background-color: white;
		top: 2%;
		right: 2%;
		z-index: 999;
		padding-left: 15px;
		opacity: 0.9;
		border: 15px solid white;
		border-opacity: 0;
		font-size: 80%;
	}
</style>

<body>
	<div id="map-content"></div>

	<div id="panel">
		<h4>GENERAL</h4>
		<p class="select-row">base map:</p>
		<select id="base-map">
			<option value="osm" selected>OSM</option>
			<option value="osmBW">OSM BlackWhite</option>
			<option value="EsriWorldImagery">ESRI satellite</option>
		</select>
		<p class="select-row">Estado de Operativo:</p>
		<select id="estado">
			<option value="0" selected>Todos</option>
			<option value="3">En Ejecucion</option>
			<option value="5">Finalizados</option>
		</select>
		<p class="select-row">Tipo de Operativo:</p>
		<select id="tipo">
			<option value="0" selected>Todos</option>
			<option value="MOTOS">Motocicletas</option>
			<option value="PERSONAS">Personas</option>
			<option value="TAXIS">Taxis</option>
			<option value="VEHÍCULOS">Vehiculos</option>
			<option value="CACHINERÍAS">Cachinerias</option>
			<option value="MECÁNICAS">Mecanicas</option>
			<option value="MICROTRÁFICO">Microtrafico</option>
			<option value="CONTROL DE ARMAS">Control de Armas</option>
			<option value="CENTROS DE DIVERSÍON">Centros de Diversion</option>
		</select>
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
	<script>
		// global variables
		var map;

		// creates extent for random data
		var maxX = -2,
			minX = -1.8,
			minY = -81.0,
			maxY = -80.3;
		var mapZoom = 6;
		var mapPosition = [(maxX + minX) / 2, (maxY + minY) / 2];
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
					'desHdrTipoResum' => $userData,
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
		}
		$locali['features'] = $ubic;
		$ver = json_encode($locali);


		?>
		var operativos = <?php echo $ver; ?>;

		function iconmoto(feature, latlng) {
			if (feature.properties.estadoPolicia === '3') {
				return L.marker(latlng, {
					icon: L.icon({
						iconUrl: "img/operativoM-r.png",
						iconSize: [26, 42],
						iconAnchor: [12, 42],
						popupAnchor: [1, -34],
						shadowSize: [42, 42]
					}),
					title: feature.properties.evento,
					riseOnHover: true
				});
			} else {
				return L.marker(latlng, {
					icon: L.icon({
						iconUrl: "img/operativoM.png",
						iconSize: [26, 42],
						iconAnchor: [12, 42],
						popupAnchor: [1, -34],
						shadowSize: [42, 42]
					}),
					title: feature.properties.evento,
					riseOnHover: true
				});
			}
		}

		function detalle(feature, layer) {
			if (feature.properties) {

				var content = "<table class='table table-striped table-bordered table-condensed'>" +
					"<tr><th>Ubicación de Operativo:</th><td>" + feature.properties.siglasGeoSenplades + "/" + feature.properties.descS + "</td></tr>" +
					"<tr><th>Operativo de:</th><td>" + feature.properties.siglas + "/" + feature.properties.desctipo + "</td></tr>" +
					"<tr><th>Descripción:</th><td>" + feature.properties.descripcion + "</td></tr>" +
					"<tr><th>Persona que Registró el Operativo:</th><td>" + feature.properties.jefeOperativo + "</td></tr>" +
					"<tr><th>Fecha:</th><td>" + feature.properties.fechaEvento + "</td></tr>"
				for (x in feature.properties.desHdrTipoResum) {
					content += "<tr><th><a href='javascript:void(0)' onclick='muestraResumen(" + feature.properties.idHdrEvento + "," + feature.properties.desHdrTipoResum[x].tipres + ")'>" + feature.properties.desHdrTipoResum[x].descrip + "</a></th><td>" + feature.properties.desHdrTipoResum[x].cta + "</td></tr>";
				} +
				"</table>";

				layer.on({
					click: function(e) {
						$("#feature-title").html(feature.properties.evento);
						$("#feature-info").html(content);
						$("#featureModal").modal("show");

					}

				});

			}
		}
		//////FUNCION MUESTRA DETALLE
		function muestraResumen(a, b) {
			$('#feature-resumen').load('cargaResumen.php?idEv=' + a + '&tipT=' + b);
		}
		$(document).on("click", function(e) {

			var container = $("#feature-resumen");

			if (!container.is(e.target) && container.has(e.target).length === 0) {
				document.getElementById('feature-resumen').innerHTML = "";
			}
		});

		function estado(feature, layer) {
			if ($("#estado").val() == 0 && $("#tipo").val() == 0) {
				return (feature.properties.estadoPolicia && feature.properties.desctipo);
			} else if ($("#estado").val() == 0 && $("#tipo").val() != 0) {
				return ((feature.properties.estadoPolicia == 3 || feature.properties.estadoPolicia == 5) && feature.properties.desctipo == $("#tipo").val());
			} else if ($("#estado").val() != 0 && $("#tipo").val() == 0) {
				return (feature.properties.estadoPolicia == $("#estado").val() && (feature.properties.desctipo == "MOTOS" || feature.properties.desctipo == "TAXIS" || feature.properties.desctipo == "VEHÍCULOS" || feature.properties.desctipo == "CACHINERÍAS" || feature.properties.desctipo == "MECÁNICAS" || feature.properties.desctipo == "MICROTRÁFICO" || feature.properties.desctipo == "CONTROL DE ARMAS" || feature.properties.desctipo == "CENTROS DE DIVERSÍON" || feature.properties.desctipo == "PERSONAS"));
			} else {
				return (feature.properties.estadoPolicia == $("#estado").val() && feature.properties.desctipo == $("#tipo").val());
			}
		}

		$(document).ready(function() {
			refreshMap();
			$("select").change(function() {
				refreshMap();
			});
		});

		function refreshMap() {
			var baseTiles = {
				osm: L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {
					attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
				}),
				osmBW: L.tileLayer(
					"http://{s}.tiles.wmflabs.org/bw-mapnik/{z}/{x}/{y}.png", {
						attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
					}
				),
				EsriWorldImagery: L.tileLayer(
					"http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}", {
						attribution: "Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community"
					}
				)
			} [$("#base-map").val()];

			// setting map
			if (map) {
				map.remove();
			}

			map = L.map("map-content", {
				maxZoom: 18
			}).setView(
				mapPosition,
				mapZoom
			);
			map.on("zoomend", function() {
				mapZoom = map.getZoom();

			});
			map.on("moveend", function() {
				mapPosition = map.getCenter();

			});
			baseTiles.addTo(map);
			var operativoM = L.geoJson(operativos, {
				filter: estado,
				pointToLayer: iconmoto,
				onEachFeature: detalle
			});

			map.addLayer(operativoM);
		}
	</script>
</body>

</html>