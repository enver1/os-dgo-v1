<?php
include_once('../../../clases/autoload.php');
$conn = DB::getConexionDB();
$dt = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$hoyA = $dt->format('Y');
$soloServicioUrbano = " and c.siglas like 'OPSU%' ";
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
  $sql = "select a.idHdrEvento,FORMAT(a.latitud, 12) latitud, FORMAT(a.longitud, 12) longitud,codigoEvento from hdrEvento a,genGeoSenplades b,genTipoTipificacion c  where a.idGenGeoSenplades=b.idGenGeoSenplades " . $st . " and a.idGenTipoTipificacion=c.idGenTipoTipificacion " . $soloServicioUrbano . " and b.siglasGeoSenplades like '" . $siglas . "%' order by a.idHdrEvento desc limit 500";
} else {
  $sql = "select a.idHdrEvento,FORMAT(a.latitud, 12) latitud, FORMAT(a.longitud, 12) longitud,codigoEvento from hdrEvento a,genGeoSenplades b,genTipoTipificacion c where a.idGenGeoSenplades=b.idGenGeoSenplades " . $st . " and a.idGenTipoTipificacion=c.idGenTipoTipificacion " . $soloServicioUrbano . " and b.siglasGeoSenplades like '" . $siglas . "%' order by a.idHdrEvento desc limit 500";
}
$rs = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset=utf-8 />
  <!--<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />-->
  <meta name='viewport' content='width=device-width, initial-scale=1.0' />

  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

  <link rel="stylesheet" href="src/leaflet-sidebar.css" />

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin="" />

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

  <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>

  <script src="https://cnd.jsdelivr.net/sweetalert2/6.6.2/sweetalert2.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.0.2/dist/leaflet.js"></script>


  <!-- Load Esri Leaflet from CDN -->
  <script src="https://unpkg.com/esri-leaflet@2.2.3/dist/esri-leaflet.js" integrity="sha512-YZ6b5bXRVwipfqul5krehD9qlbJzc6KOGXYsDjU9HHXW2gK57xmWl2gU6nAegiErAqFXhygKIsWPKbjLPXVb2g==" crossorigin=""></script>

  <!-- Load Esri Leaflet Geocoder from CDN -->
  <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.css" integrity="sha512-v5YmWLm8KqAAmg5808pETiccEohtt8rPVMGQ1jA6jqkWVydV5Cuz3nJ9fQ7ittSxvuqsvI9RSGfVoKPaAJZ/AQ==" crossorigin="">
  <script src="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.js" integrity="sha512-zdT4Pc2tIrc6uoYly2Wp8jh6EPEWaveqqD3sT0lf5yei19BC1WulGuh5CesB0ldBKZieKGD7Qyf/G0jdSe016A==" crossorigin=""></script>
  <script type="text/javascript" src="../../../js/jquery-3.0.0.min.js"></script>
  <link rel="stylesheet" href="index.css" />

  <!--
  CLUSTER
-->
  <link rel="stylesheet" href="dist/MarkerCluster.css" />
  <link rel="stylesheet" href="dist/MarkerCluster.Default.css" />
  <script src="dist/leaflet.markercluster-src.js"></script>

</head>

<body>
  <div id="sidebar" class="sidebar collapsed">
    <!-- Nav tabs -->
    <div class="sidebar-tabs">
      <ul role="tablist">
        <li><a href="#home" role="tab"><i class="fa fa-bars"></i></a></li>

      </ul>
    </div>

    <!-- Tab panes -->
    <div class="sidebar-content">
      <div class="sidebar-pane" id="home">
        <h1 class="sidebar-header">
          Operativos
          <span class="sidebar-close"><i class="fa fa-caret-left"></i></span>
        </h1>
        <div style="width:260;float:right;height:auto;margin-right:10px;">
          <div id="detalle" class="col1" style="border-color:#777"></div>
          <div id="detalleResulta" class="col1" style="border-color:#777"></div>
        </div>

      </div>

    </div>
  </div>




  <div id="map" class="sidebar-map"></div>
  <script src="https://unpkg.com/leaflet@1.0.1/dist/leaflet.js"></script>
  <script src="src/leaflet-sidebar.js"></script>

  <script type="text/javascript">
    /*var movil = false; 
      if ( /Android|webOS|Iphone|Ipod|BlackBerry|IEMobile|Opera Mini/i.test(navigation.userAgent)){
        movil = true;
      }*/




    initMap();

    function initMap() {
      var info;

      var map = L.map('map', {
        center: [-0.4494108397310957, -78.585734328125],
        zoom: 7

      });
      //setView([-0.4494108397310957,-78.585734328125], 8);
      //var map = L.map('map').setView([0,0], 0);

      mapLink = '<a href="http://openstreetmap.org">OpenStreetMap</a>';

      L.tileLayer(
        'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; ' + mapLink + ' Contributors',
          maxZoom: 18,
        }).addTo(map);

      var LeafIcon = L.Icon.extend({
        options: {
          iconSize: [38, 40],
          shadowSize: [50, 64],
          iconAnchor: [22, 94],
          shadowAnchor: [4, 62],
          popupAnchor: [-3, -76]
        }
      });




      <?php while ($row = $rs->fetch()) { ?>
        <?php if (!empty($row['latitud']) and !empty($row['longitud'])) : ?>
          <?php
          echo $sqlG = "select 3 from hdrEvento where idHdrEvento=" . $row['idHdrEvento'] . " and estadoPolicia=3 limit 1";
          $rsG = $conn->query($sqlG);
          ?>
          <?php if ($rowG = $rsG->fetch()) : ?>
            var icon = new L.Icon({
              iconUrl: 'img/marker-icon-2x-red.png',
              iconSize: [25, 41],
              iconAnchor: [12, 41],
              popupAnchor: [1, -34],
              shadowSize: [41, 41]
            });
            //var icon = new LeafIcon({iconUrl: '../../../imagenes/accGrave.png'});
          <?php else : ?>
            var icon = new L.Icon({
              iconUrl: 'img/marker-icon-2x-blue.png',
              iconSize: [25, 41],
              iconAnchor: [12, 41],
              popupAnchor: [1, -34],
              shadowSize: [41, 41]
            });
            // var icon = new LeafIcon({iconUrl: '../../../imagenes/accLeve.png'});
          <?php endif ?>

          marker = new L.marker([<?php echo $row['latitud'] ?>, <?php echo $row['longitud'] ?>], {
              title: 'EVENTO: <?php echo $row['codigoEvento'] ?>',
              icon: icon
            })
            .addTo(map)
            .on('click', function() {
              getDetails(<?php echo $row['idHdrEvento'] ?>);
            });
        <?php endif ?>
      <?php } ?>

      info = L.control({
        position: 'bottomleft'
      });

      //////////
      ////CUADRO SIDEBAR
      /////////
      var sidebar = L.control.sidebar('sidebar').addTo(map);

      ////////
    }

    function getDetails(pos) {
      $('#detalle').load('getDetalle.php?id=' + pos);
      $('#detalleResulta').html('');
    }

    function muestraResumen(a, b) {
      $('#detalleResulta').load('cargaResumen.php?idEv=' + a + '&tipT=' + b);
    }
  </script>

</body>