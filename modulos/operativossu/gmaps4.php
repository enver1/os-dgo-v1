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
	$sql = "select 
  a.estadoPolicia,
  a.usuario,
  a.fechaEvento,
  a.descripcion,
  a.idHdrEvento,
  FORMAT(a.latitud, 12) latitud,
  FORMAT(a.longitud, 12) longitud,
  codigoEvento,
  c.descripcion desctipo,
  c.siglas,
  b.siglasGeoSenplades,
  b.descripcion descS
  from hdrEvento a, genGeoSenplades b, genTipoTipificacion c where a.idGenGeoSenplades=b.idGenGeoSenplades " . $st . " and a.idGenTipoTipificacion=c.idGenTipoTipificacion " . $soloServicioUrbano . " and b.siglasGeoSenplades like '" . $siglas . "%' order by a.idHdrEvento desc ";
}
$rs = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset=utf-8 />
	<!--<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />-->
	<meta name='viewport' content='width=device-width, initial-scale=1.0' />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@latest/dist/leaflet.css" />
	<link rel="stylesheet" href="src/leaflet-sidebar.css" />
	<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder@latest/dist/Control.Geocoder.css" />
	<link rel="stylesheet" href="dist/L.Control.Locate.min.css" />
	<link rel="stylesheet" href="dist/leaflet.groupedlayercontrol.css" />
	<link rel="stylesheet" href="dist/MarkerCluster.css" />
	<link rel="stylesheet" href="dist/MarkerCluster.Default.css" />


	<style type="text/css">
		.leaflet-control-attribution {
			display: none;
		}

		body {
			padding: 0;
			margin: 0;
		}

		html,
		body,
		#map {
			height: 100%;
			font: 10pt "Helvetica Neue", Arial, Helvetica, sans-serif;
		}
	</style>

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
					<div>
						<input type='radio' name='choice' id='cho1' value='0'> <label for='opt1' class='lb' checked>Todos</label>
						<input type='radio' name='choice' id='cho1' value='3'> <label for='opt1' class='lb'>En Ejecucion</label>
						<input type='radio' name='choice' id='cho1' value='5'> <label for='opt1' class='lb'>Finalizados</label>
					</div>
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
	<script src="https://unpkg.com/leaflet-control-geocoder@latest/dist/Control.Geocoder.js"></script>
	<script src="src/L.Control.Locate.js"></script>
	<script src="dist/leaflet.groupedlayercontrol.js"></script>
	<script src="dist/leaflet.markercluster-src.js"></script>
	<script type="text/javascript">
		/*var movil = false; 
      if ( /Android|webOS|Iphone|Ipod|BlackBerry|IEMobile|Opera Mini/i.test(navigation.userAgent)){
        movil = true;
      }*/


		/* Basemap Layers */
		var cartoLight = L.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
			maxZoom: 19,
			attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, &copy; <a href="https://cartodb.com/attributions">CartoDB</a>'
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
				$sqlR = "select b.idHdrTipoResum,b.descTipoResum,count(*) cuantos from hdrEventoResum a,hdrTipoResum b where a.idHdrTipoResum=b.idHdrTipoResum and a.idHdrEvento=" . $row['idHdrEvento'] . " group by a.idHdrTipoResum ";
				$rsD = $conn->query($sqlR);
				$userData = array();
				while ($rowD = $rsD->fetch()) {
					$userData[] = array('tipres' => $rowD['idHdrTipoResum'], 'descrip' => $rowD['descTipoResum'], 'cta' => $rowD['cuantos']);
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
		}
		$locali['features'] = $ubic;
		$ver = json_encode($locali);


		?>

		$(document).on("click", ".feature-row", function(e) {
			$(document).off("mouseout", ".feature-row", clearHighlight);
			sidebarClick(parseInt($(this).attr("id"), 10));
		});
		if (!("ontouchstart" in window)) {
			$(document).on("mouseover", ".feature-row", function(e) {
				highlight.clearLayers().addLayer(L.circleMarker([$(this).attr("lat"), $(this).attr("lng")], highlightStyle));
			});
		}
		$(document).on("mouseout", ".feature-row", clearHighlight);

		function clearHighlight() {
			highlight.clearLayers();
		}

		function sidebarClick(id) {
			var layer = markerClusters.getLayer(id);
			map.setView([layer.getLatLng().lat, layer.getLatLng().lng], 20);
			//layer.fire("click");
		}

		function syncSidebar() {
			/* Empty sidebar features */
			$("#feature-list tbody").empty();
			/* Loop through theaters layer and add only features which are in the map bounds */
			operativoM.eachLayer(function(layer) {
				if (map.hasLayer(operativoMLayer)) {
					$("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoM.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
				}
			});

			operativoP.eachLayer(function(layer) {
				if (map.hasLayer(operativoPLayer)) {
					$("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoP.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
				}
			});
			operativoT.eachLayer(function(layer) {
				if (map.hasLayer(operativoTLayer)) {
					$("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoT.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
				}
			});
			operativoME.eachLayer(function(layer) {
				if (map.hasLayer(operativoMELayer)) {
					$("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoME.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
				}
			});
			operativoMI.eachLayer(function(layer) {
				if (map.hasLayer(operativoMILayer)) {
					$("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoMI.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
				}
			});
			operativoC.eachLayer(function(layer) {
				if (map.hasLayer(operativoCLayer)) {
					$("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoC.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
				}
			});
			operativoCA.eachLayer(function(layer) {
				if (map.hasLayer(operativoCALayer)) {
					$("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoCA.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
				}
			});
			operativoCD.eachLayer(function(layer) {
				if (map.hasLayer(operativoCDLayer)) {
					$("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoCD.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
				}
			});
			operativoV.eachLayer(function(layer) {
				if (map.hasLayer(operativoVLayer)) {
					$("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoV.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
				}
			});

			///// LISTAR EN SIDEBAR

			featureList = new List("features", {
				valueNames: ["feature-name"]
			});
			featureList.sort("feature-name", {
				order: "asc"
			});
		}


		var highlight = L.geoJson(null);
		var highlightStyle = {
			stroke: false,
			fillColor: "#164987",
			fillOpacity: 0.7,
			radius: 10
		};
		var operativos = <?php echo $ver; ?>;



		var markerClusters = new L.MarkerClusterGroup({
			spiderfyOnMaxZoom: true,
			showCoverageOnHover: true,
			zoomToBoundsOnClick: true,
			disableClusteringAtZoom: 18
		});

		/////////////// FUNCION DETALLE

		function detalle(feature, layer) {
			if (feature.properties) {

				var content = "<table class='table table-striped table-bordered table-condensed'>" +
					"<tr><th>Ubicación de Operativo:</th><td>" + feature.properties.siglasGeoSenplades + "/" + feature.properties.descS + "</td></tr>" +
					"<tr><th>Operativo de:</th><td>" + feature.properties.siglas + "/" + feature.properties.desctipo + "</td></tr>" +
					"<tr><th>Descripción:</th><td>" + feature.properties.descripcion + "</td></tr>" +
					"<tr><th>Persona que Registró el Operativo:</th><td>" + feature.properties.jefeOperativo + "</td></tr>" +
					"<tr><th>Fecha:</th><td>" + feature.properties.fechaEvento + "</td></tr>"
				for (x in feature.properties.descTipoResum) {
					content += "<tr><th><a href='javascript:void(0)' onclick='muestraResumen(" + feature.properties.idHdrEvento + "," + feature.properties.descTipoResum[x].tipres + ")'>" + feature.properties.descTipoResum[x].descrip + "</a></th><td>" + feature.properties.descTipoResum[x].cta + "</td></tr>";
				} +
				"</table>";

				layer.on({
					click: function(e) {
						$("#feature-title").html(feature.properties.evento);
						$("#feature-info").html(content);
						$("#featureModal").modal("show");
						highlight.clearLayers().addLayer(L.circleMarker([feature.geometry.coordinates[1], feature.geometry.coordinates[0]], highlightStyle));
					}

				});

			}
		}

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
		///////////////MOTOS

		var operativoMLayer = L.geoJson(null);
		var operativoM = L.geoJson(operativos, {
			filter: function(feature, layer) {
				return (feature.properties.desctipo == "MOTOS");
			},
			pointToLayer: iconmoto,
			onEachFeature: detalle
		});

		function iconpersonas(feature, latlng) {
			if (feature.properties.estadoPolicia === '3') {
				return L.marker(latlng, {
					icon: L.icon({
						iconUrl: "img/operativoP-r.png",
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
						iconUrl: "img/operativoP.png",
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



		///////////////PERSONAS
		var operativoPLayer = L.geoJson(null);
		var operativoP = L.geoJson(operativos, {
			filter: function(feature, layer) {
				return feature.properties.desctipo === "PERSONAS";
			},
			pointToLayer: iconpersonas,
			onEachFeature: detalle
		});

		function icontaxis(feature, latlng) {
			if (feature.properties.estadoPolicia === '3') {
				return L.marker(latlng, {
					icon: L.icon({
						iconUrl: "img/operativoT-r.png",
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
						iconUrl: "img/operativoT.png",
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
		///////////////TAXIS
		var operativoTLayer = L.geoJson(null);
		var operativoT = L.geoJson(operativos, {
			filter: function(feature, layer) {
				return feature.properties.desctipo === "TAXIS";
			},
			pointToLayer: icontaxis,
			onEachFeature: detalle
		});

		function iconvehiculos(feature, latlng) {
			if (feature.properties.estadoPolicia === '3') {
				return L.marker(latlng, {
					icon: L.icon({
						iconUrl: "img/operativoV-r.png",
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
						iconUrl: "img/operativoV.png",
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
		///////////////VEHÍCULOS
		var operativoVLayer = L.geoJson(null);
		var operativoV = L.geoJson(operativos, {
			filter: function(feature, layer) {
				return feature.properties.desctipo === "VEHÍCULOS";
			},
			pointToLayer: iconvehiculos,
			onEachFeature: detalle
		});

		function iconcachinerias(feature, latlng) {
			if (feature.properties.estadoPolicia === '3') {
				return L.marker(latlng, {
					icon: L.icon({
						iconUrl: "img/operativoC-r.png",
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
						iconUrl: "img/operativoC.png",
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
		///////////////CACHINERÍAS
		var operativoCLayer = L.geoJson(null);
		var operativoC = L.geoJson(operativos, {
			filter: function(feature, layer) {
				return feature.properties.desctipo === "CACHINERÍAS";
			},
			pointToLayer: iconcachinerias,
			onEachFeature: detalle
		});

		function iconmecanicas(feature, latlng) {
			if (feature.properties.estadoPolicia === '3') {
				return L.marker(latlng, {
					icon: L.icon({
						iconUrl: "img/operativoME-r.png",
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
						iconUrl: "img/operativoME.png",
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
		///////////////MECÁNICAS
		var operativoMELayer = L.geoJson(null);
		var operativoME = L.geoJson(operativos, {
			filter: function(feature, layer) {
				return feature.properties.desctipo === "MECÁNICAS";
			},
			pointToLayer: iconmecanicas,
			onEachFeature: detalle
		});

		function iconmicrotrafico(feature, latlng) {
			if (feature.properties.estadoPolicia === '3') {
				return L.marker(latlng, {
					icon: L.icon({
						iconUrl: "img/operativoMI-r.png",
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
						iconUrl: "img/operativoMI.png",
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
		///////////////MICROTRÁFICO
		var operativoMILayer = L.geoJson(null);
		var operativoMI = L.geoJson(operativos, {
			filter: function(feature, layer) {
				return feature.properties.desctipo === "MICROTRÁFICO";
			},
			pointToLayer: iconmicrotrafico,
			onEachFeature: detalle
		});

		function iconarmas(feature, latlng) {
			if (feature.properties.estadoPolicia === '3') {
				return L.marker(latlng, {
					icon: L.icon({
						iconUrl: "img/operativoCA-r.png",
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
						iconUrl: "img/operativoCA.png",
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
		///////////////CONTROL DE ARMAS
		var operativoCALayer = L.geoJson(null);
		var operativoCA = L.geoJson(operativos, {
			filter: function(feature, layer) {
				return feature.properties.desctipo === "CONTROL DE ARMAS";
			},
			pointToLayer: iconarmas,
			onEachFeature: detalle
		});

		function icondiversion(feature, latlng) {
			if (feature.properties.estadoPolicia === '3') {
				return L.marker(latlng, {
					icon: L.icon({
						iconUrl: "img/operativoCD-r.png",
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
						iconUrl: "img/operativoCD.png",
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
		///////////////CENTROS DE DIVERSÍON
		var operativoCDLayer = L.geoJson(null);
		var operativoCD = L.geoJson(operativos, {
			filter: function(feature, layer) {
				return feature.properties.desctipo === "CENTROS DE DIVERSÍON";
			},
			pointToLayer: icondiversion,
			onEachFeature: detalle
		});


		map = L.map("map", {
			zoom: 10,
			center: [-0.4494108397310957, -78.585734328125],
			layers: [cartoLight, markerClusters, highlight],

		});
		/////

		///////CLUSTER AL SELECCIONAR
		map.on("overlayadd", function(e) {
			if (e.layer === operativoVLayer) {
				markerClusters.addLayer(operativoV);
				syncSidebar()

			}

			if (e.layer === operativoCLayer) {
				markerClusters.addLayer(operativoC);
				syncSidebar()
			}
			if (e.layer === operativoCDLayer) {
				markerClusters.addLayer(operativoCD);
				syncSidebar()
			}
			if (e.layer === operativoCALayer) {
				markerClusters.addLayer(operativoCA);
				syncSidebar()
			}
			if (e.layer === operativoMELayer) {
				markerClusters.addLayer(operativoME);
				syncSidebar()
			}
			if (e.layer === operativoMILayer) {
				markerClusters.addLayer(operativoMI);
				syncSidebar()
			}
			if (e.layer === operativoMLayer) {
				markerClusters.addLayer(operativoM);
				syncSidebar()
			}

			if (e.layer === operativoPLayer) {
				markerClusters.addLayer(operativoP);
				syncSidebar()
			}
			if (e.layer === operativoTLayer) {
				markerClusters.addLayer(operativoT);
				syncSidebar()
			}
		});

		map.on("overlayremove", function(e) {
			if (e.layer === operativoVLayer) {
				markerClusters.removeLayer(operativoV);
				syncSidebar()
			}

			if (e.layer === operativoCLayer) {
				markerClusters.removeLayer(operativoC);
				syncSidebar()
			}
			if (e.layer === operativoCDLayer) {
				markerClusters.removeLayer(operativoCD);
				syncSidebar()
			}
			if (e.layer === operativoCALayer) {
				markerClusters.removeLayer(operativoCA);
				syncSidebar()
			}
			if (e.layer === operativoMELayer) {
				markerClusters.removeLayer(operativoME);
				syncSidebar()
			}
			if (e.layer === operativoMILayer) {
				markerClusters.removeLayer(operativoMI);
				syncSidebar()
			}
			if (e.layer === operativoMLayer) {
				markerClusters.removeLayer(operativoM);
				syncSidebar()
			}

			if (e.layer === operativoPLayer) {
				markerClusters.removeLayer(operativoP);
				syncSidebar()
			}
			if (e.layer === operativoTLayer) {
				markerClusters.removeLayer(operativoT);
				syncSidebar()
			}

		});

		map.on("moveend", function(e) {
			syncSidebar();
		});

		map.on("click", function(e) {
			highlight.clearLayers();
		});
		//////

		///////////////GROUPLAYER

		var groupedOverlays =

			{

				"<b style=color:rgb(220,31,37);>Tipos de Operativo</b> <br>": {


					"<div class='iconogroup'><img src='img/operativoC.png'  height='30'></div>(<span id='Cachinerías'></span>)&nbsp;<span class='nomgroup'>Cachinerías</span>": operativoCLayer,
					"<div class='iconogroup'><img src='img/operativoCD.png'  height='30'></div>(<span id='Diversión'></span>)&nbsp;<span class='nomgroup'>Centros de Diversión</span>": operativoCDLayer,
					"<div class='iconogroup'><img src='img/operativoCA.png' height='30'></div>(<span id='Armas'></span>)&nbsp;<span class='nomgroup'>Control de Armas</span>": operativoCALayer,
					"<div class='iconogroup'><img src='img/operativoME.png' height='30'></div>(<span id='Mecánicas'></span>)&nbsp;<span class='nomgroup'>Mecánicas</span>": operativoMELayer,
					"<div class='iconogroup'><img src='img/operativoMI.png' height='30'></div>(<span id='Microtráfico'></span>)&nbsp;<span class='nomgroup'>Microtráfico</span>": operativoMILayer,
					"<div class='iconogroup'><img src='img/operativoM.png' height='30'></div>(<span id='Motocicletas'></span>)&nbsp;<span class='nomgroup'>Motocicletas</span>": operativoMLayer,
					"<div class='iconogroup'><img src='img/operativoP.png' height='30'></div>(<span id='Personas'></span>)&nbsp;<span class='nomgroup'>Personas</span>": operativoPLayer,
					"<div class='iconogroup'><img src='img/operativoT.png' height='30'></div>(<span id='Taxis'></span>)&nbsp;<span class='nomgroup'>Taxis</span>": operativoTLayer,
					"<div class='iconogroup'><img src='img/operativoV.png' height='30'></div>(<span id='Vehículos'></span>)&nbsp;<span class='nomgroup'>Vehículos</span>": operativoVLayer
				}

			};


		///////CUENTA DE OPERATIVOS POR VARIABLE
		$(function() {
			$('#Cachinerías').append(operativoC.getLayers().length);
			$('#Diversión').append(operativoCD.getLayers().length);
			$('#Armas').append(operativoCA.getLayers().length);
			$('#Mecánicas').append(operativoME.getLayers().length);
			$('#Microtráfico').append(operativoMI.getLayers().length);
			$('#Motocicletas').append(operativoM.getLayers().length);
			$('#Personas').append(operativoP.getLayers().length);
			$('#Taxis').append(operativoT.getLayers().length);
			$('#Vehículos').append(operativoV.getLayers().length);
		});



		//////////
		////CUADRO SIDEBAR
		/////////
		var options = {
			exclusiveGroups: ["Tipos de Operativo"],
			groupCheckboxes: true,
			collapsed: false,
		};
		var sidebar = L.control.sidebar('sidebar').addTo(map);
		////subimos a div groupedLayers
		var panel = L.control.groupedLayers(null, groupedOverlays, options).addTo(map);




		var htmlObject = panel.getContainer();
		var a = document.getElementById('filtros')

		function setParent(el, newParent) {
			newParent.appendChild(el);
		}
		setParent(htmlObject, a);
		////QUITAR HIGTH
		$("#featureModal").on("hidden.bs.modal", function(e) {
			$(document).on("mouseout", ".feature-row", clearHighlight);
		});

		//////////POSICION DEL ZOOM
		map.zoomControl.setPosition('topright');

		//////////BUSCAR
		L.Control.geocoder({
			placeholder: "Buscar...",
		}).addTo(map);





		//////////LOCALIZACION
		L.control.locate({
			position: "topright",
			strings: {
				title: "Mostrar tu Ubicacion"
			}
		}).addTo(map);


		$("input:radio[name=choice]").click(function() {
			var selected_choice = $(this).val();

			markerClusters.clearLayers();
			var operativoM = L.geoJson(operativos, {
				filter: function(feature, layer) {
					if (selected_choice == 3) {
						return (feature.properties.estadoPolicia == 3 && feature.properties.desctipo == "MOTOS");
					} else if (selected_choice == 5) {
						return (feature.properties.estadoPolicia == 5 && feature.properties.desctipo == "MOTOS");
					} else {
						return feature.properties.desctipo == "MOTOS";
					}
				},
				pointToLayer: iconmoto,
				onEachFeature: detalle
			});
			var operativoP = L.geoJson(operativos, {
				filter: function(feature, layer) {
					if (selected_choice == 3) {
						return (feature.properties.estadoPolicia == 3 && feature.properties.desctipo == "PERSONAS");
					} else if (selected_choice == 5) {
						return (feature.properties.estadoPolicia == 5 && feature.properties.desctipo == "PERSONAS");
					} else {
						return feature.properties.desctipo == "PERSONAS";
					}
				},
				pointToLayer: iconpersonas,
				onEachFeature: detalle
			});
			var operativoME = L.geoJson(operativos, {
				filter: function(feature, layer) {
					if (selected_choice == 3) {
						return (feature.properties.estadoPolicia == 3 && feature.properties.desctipo == "MECÁNICAS");
					} else if (selected_choice == 5) {
						return (feature.properties.estadoPolicia == 5 && feature.properties.desctipo == "MECÁNICAS");
					} else {
						return feature.properties.desctipo == "MECÁNICAS";
					}
				},
				pointToLayer: iconmecanicas,
				onEachFeature: detalle
			});
			var operativoMI = L.geoJson(operativos, {
				filter: function(feature, layer) {
					if (selected_choice == 3) {
						return (feature.properties.estadoPolicia == 3 && feature.properties.desctipo == "MICROTRÁFICO");
					} else if (selected_choice == 5) {
						return (feature.properties.estadoPolicia == 5 && feature.properties.desctipo == "MICROTRÁFICO");
					} else {
						return feature.properties.desctipo == "MICROTRÁFICO";
					}
				},
				pointToLayer: iconmicrotrafico,
				onEachFeature: detalle
			});
			var operativoC = L.geoJson(operativos, {
				filter: function(feature, layer) {
					if (selected_choice == 3) {
						return (feature.properties.estadoPolicia == 3 && feature.properties.desctipo == "CACHINERÍAS");
					} else if (selected_choice == 5) {
						return (feature.properties.estadoPolicia == 5 && feature.properties.desctipo == "CACHINERÍAS");
					} else {
						return feature.properties.desctipo == "CACHINERÍAS";
					}
				},
				pointToLayer: iconmoto,
				onEachFeature: detalle
			});
			var operativoCA = L.geoJson(operativos, {
				filter: function(feature, layer) {
					if (selected_choice == 3) {
						return (feature.properties.estadoPolicia == 3 && feature.properties.desctipo == "CONTROL DE ARMAS");
					} else if (selected_choice == 5) {
						return (feature.properties.estadoPolicia == 5 && feature.properties.desctipo == "CONTROL DE ARMAS");
					} else {
						return feature.properties.desctipo == "CONTROL DE ARMAS";
					}
				},
				pointToLayer: iconarmas,
				onEachFeature: detalle
			});
			var operativoV = L.geoJson(operativos, {
				filter: function(feature, layer) {
					if (selected_choice == 3) {
						return (feature.properties.estadoPolicia == 3 && feature.properties.desctipo == "VEHÍCULOS");
					} else if (selected_choice == 5) {
						return (feature.properties.estadoPolicia == 5 && feature.properties.desctipo == "VEHÍCULOS");
					} else {
						return feature.properties.desctipo == "VEHÍCULOS";
					}
				},
				pointToLayer: iconvehiculos,
				onEachFeature: detalle
			});
			var operativoCD = L.geoJson(operativos, {
				filter: function(feature, layer) {
					if (selected_choice == 3) {
						return (feature.properties.estadoPolicia == 3 && feature.properties.desctipo == "CENTROS DE DIVERSÍON");
					} else if (selected_choice == 5) {
						return (feature.properties.estadoPolicia == 5 && feature.properties.desctipo == "CENTROS DE DIVERSÍON");
					} else {
						return feature.properties.desctipo == "CENTROS DE DIVERSÍON";
					}
				},
				pointToLayer: icondiversion,
				onEachFeature: detalle
			});
			var operativoT = L.geoJson(operativos, {
				filter: function(feature, layer) {
					if (selected_choice == 3) {
						return (feature.properties.estadoPolicia == 3 && feature.properties.desctipo == "TAXIS");
					} else if (selected_choice == 5) {
						return (feature.properties.estadoPolicia == 5 && feature.properties.desctipo == "TAXIS");
					} else {
						return feature.properties.desctipo == "TAXIS";
					}
				},
				pointToLayer: icontaxis,
				onEachFeature: detalle
			});
			var markerClustersM = L.featureGroup();
			var markerClustersV = L.featureGroup();
			var markerClustersC = L.featureGroup();
			var markerClustersCA = L.featureGroup();
			var markerClustersCD = L.featureGroup();
			var markerClustersME = L.featureGroup();
			var markerClustersMI = L.featureGroup();
			var markerClustersT = L.featureGroup();
			var markerClustersP = L.featureGroup();
			//////
			syncSidebar();

			function syncSidebar() {
				/* Empty sidebar features */
				$("#feature-list tbody").empty();
				/* Loop through theaters layer and add only features which are in the map bounds */
				operativoM.eachLayer(function(layer) {
					if (map.hasLayer(markerClustersM)) {
						$("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoM.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
					}
				});

				operativoP.eachLayer(function(layer) {
					if (map.hasLayer(markerClustersP)) {
						$("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoP.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
					}
				});
				operativoT.eachLayer(function(layer) {
					if (map.hasLayer(markerClustersT)) {
						$("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoT.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
					}
				});
				operativoME.eachLayer(function(layer) {
					if (map.hasLayer(markerClustersME)) {
						$("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoME.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
					}
				});
				operativoMI.eachLayer(function(layer) {
					if (map.hasLayer(markerClustersMI)) {
						$("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoMI.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
					}
				});
				operativoC.eachLayer(function(layer) {
					if (map.hasLayer(markerClustersC)) {
						$("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoC.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
					}
				});
				operativoCA.eachLayer(function(layer) {
					if (map.hasLayer(markerClustersCA)) {
						$("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoCA.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
					}
				});
				operativoCD.eachLayer(function(layer) {
					if (map.hasLayer(markerClustersCD)) {
						$("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoCD.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
					}
				});
				operativoV.eachLayer(function(layer) {
					if (map.hasLayer(markerClustersV)) {
						$("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoV.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
					}
				});
				featureList = new List("features", {
					valueNames: ["feature-name"]
				});
				featureList.sort("feature-name", {
					order: "asc"
				});
			}
			///////CLUSTER AL SELECCIONAR
			map.on("overlayadd", function(e) {
				if (e.layer === markerClustersV) {
					markerClusters.addLayer(operativoV);
					syncSidebar()

				}

				if (e.layer === markerClustersC) {
					markerClusters.addLayer(operativoC);
					syncSidebar()
				}
				if (e.layer === markerClustersCD) {
					markerClusters.addLayer(operativoCD);
					syncSidebar()
				}
				if (e.layer === markerClustersCA) {
					markerClusters.addLayer(operativoCA);
					syncSidebar()
				}
				if (e.layer === markerClustersME) {
					markerClusters.addLayer(operativoME);
					syncSidebar()
				}
				if (e.layer === markerClustersMI) {
					markerClusters.addLayer(operativoMI);
					syncSidebar()
				}
				if (e.layer === markerClustersM) {
					markerClusters.addLayer(operativoM);
					syncSidebar()
				}

				if (e.layer === markerClustersP) {
					markerClusters.addLayer(operativoP);
					syncSidebar()
				}
				if (e.layer === markerClustersT) {
					markerClusters.addLayer(operativoT);
					syncSidebar()
				}
			});

			map.on("overlayremove", function(e) {
				if (e.layer === markerClustersV) {
					markerClusters.removeLayer(operativoV);
					syncSidebar()
				}

				if (e.layer === markerClustersC) {
					markerClusters.removeLayer(operativoC);
					syncSidebar()
				}
				if (e.layer === markerClustersCD) {
					markerClusters.removeLayer(operativoCD);
					syncSidebar()
				}
				if (e.layer === markerClustersCA) {
					markerClusters.removeLayer(operativoCA);
					syncSidebar()
				}
				if (e.layer === markerClustersME) {
					markerClusters.removeLayer(operativoME);
					syncSidebar()
				}
				if (e.layer === markerClustersMI) {
					markerClusters.removeLayer(operativoMI);
					syncSidebar()
				}
				if (e.layer === markerClustersM) {
					markerClusters.removeLayer(operativoM);
					syncSidebar()

				}

				if (e.layer === markerClustersP) {
					markerClusters.removeLayer(operativoP);
					syncSidebar()
				}
				if (e.layer === markerClustersT) {
					markerClusters.removeLayer(operativoT);
					syncSidebar()
				}

			});
			map.on("moveend", function(e) {
				syncSidebar();
			});

			//operativoMLayer.addLayer(operativoM);
			map.removeControl(panel);
			panel = L.control.groupedLayers(null, {

				"<b style=color:rgb(220,31,37);>Tipos de Operativo</b> <br>": {


					"<div class='iconogroup'><img src='img/operativoC.png'  height='30'></div>(<span id='Cachinerías'></span>)&nbsp;<span class='nomgroup'>Cachinerías</span>": markerClustersC,
					"<div class='iconogroup'><img src='img/operativoCD.png'  height='30'></div>(<span id='Diversión'></span>)&nbsp;<span class='nomgroup'>Centros de Diversión</span>": markerClustersCD,
					"<div class='iconogroup'><img src='img/operativoCA.png' height='30'></div>(<span id='Armas'></span>)&nbsp;<span class='nomgroup'>Control de Armas</span>": markerClustersCA,
					"<div class='iconogroup'><img src='img/operativoME.png' height='30'></div>(<span id='Mecánicas'></span>)&nbsp;<span class='nomgroup'>Mecánicas</span>": markerClustersME,
					"<div class='iconogroup'><img src='img/operativoMI.png' height='30'></div>(<span id='Microtráfico'></span>)&nbsp;<span class='nomgroup'>Microtráfico</span>": markerClustersMI,
					"<div class='iconogroup'><img src='img/operativoM.png' height='30'></div>(<span id='Motocicletas'></span>)&nbsp;<span class='nomgroup'>Motocicletas</span>": markerClustersM,
					"<div class='iconogroup'><img src='img/operativoP.png' height='30'></div>(<span id='Personas'></span>)&nbsp;<span class='nomgroup'>Personas</span>": markerClustersP,
					"<div class='iconogroup'><img src='img/operativoT.png' height='30'></div>(<span id='Taxis'></span>)&nbsp;<span class='nomgroup'>Taxis</span>": markerClustersT,
					"<div class='iconogroup'><img src='img/operativoV.png' height='30'></div>(<span id='Vehículos'></span>)&nbsp;<span class='nomgroup'>Vehículos</span>": markerClustersV


				}

			}, options).addTo(map);
			$(function() {
				$('#Cachinerías').append(operativoC.getLayers().length);
				$('#Diversión').append(operativoCD.getLayers().length);
				$('#Armas').append(operativoCA.getLayers().length);
				$('#Mecánicas').append(operativoME.getLayers().length);
				$('#Microtráfico').append(operativoMI.getLayers().length);
				$('#Motocicletas').append(operativoM.getLayers().length);
				$('#Personas').append(operativoP.getLayers().length);
				$('#Taxis').append(operativoT.getLayers().length);
				$('#Vehículos').append(operativoV.getLayers().length);
			});
			var htmlObject = panel.getContainer();
			var a = document.getElementById('filtros')

			function setParent(el, newParent) {
				newParent.appendChild(el);
			}
			setParent(htmlObject, a);


		})

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
	</script>

</body>