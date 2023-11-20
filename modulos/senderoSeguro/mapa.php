<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

include_once '../../../clases/autoload.php';

$senderoSeguro = new SenderoSeguro;


$idRuta = strip_tags($_POST['idRuta']);
$actualizarMapa = "NO";
$tamPost = sizeof($_POST);



if ($tamPost > 1) {
  $actualizarMapa = strip_tags($_POST['actualizarMapa']);
}



$datosRuta          = array();
$datosRutaDetalle   = array();
$datosAlerta        = array();



if ($idRuta > 0) {
  $datosRuta = json_encode($senderoSeguro->getConsultarRutasPorId($idRuta));
  $datosRutaDetalle = json_encode($senderoSeguro->getConsultarRutasDetallePorIdRuta($idRuta));
  $datosAlerta = json_encode($senderoSeguro->getConsultarAlertasPorIdRuta($idRuta));
}



function distance($lat1, $lon1, $lat2, $lon2, $unit)
{

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
    return ($miles * 0.8684);
  } else {
    return $miles;
  }
}




?>







<script type="text/javascript">
var map;
var imgPuntoPartida = 'modulos/senderoSeguro/img/partida.png';
var imgPerson = 'modulos/senderoSeguro/img/person.png';
var imgAlerta = 'modulos/senderoSeguro/img/alarma.png';

var layersimboloverde = 'modulos/senderoSeguro/img/layersimboloverde.png';
var layersimboloamarillo = 'modulos/senderoSeguro/img/layersimboloamarillo.png';
var layersimboloazul = 'modulos/senderoSeguro/img/layersimboloazul.png';
var layersimbolorojo = 'modulos/senderoSeguro/img/layersimbolorojo.png';

var latLongInicial;

var rutasDetalleJs = 0;
var alertaJs = 0;

initMap(-0.194769, -78.492358);

function initMap(lat, lng) {


    var rutasJs = <?php echo $datosRuta ?>;


    rutasDetalleJs = <?php echo $datosRutaDetalle ?>;
    alertaJs = <?php echo $datosAlerta ?>;



    var lat = 0;
    var lng = 0;

    if (rutasJs.length > 0) {
        lat = parseFloat(rutasJs[0]['latInicial']);
        lng = parseFloat(rutasJs[0]['lonInicial']);
    }

    var map = L.map("map", {
        center: [lat, lng],
        zoom: 15,
    });



    L.tileLayer("https://{s}.tile.osm.org/{z}/{x}/{y}.png", {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 22,
            maxNativeZoom: 19
        })
        .addTo(map);

    map.invalidateSize(true);



    // add a scale at at your map.

    var scale = L.control.scale().addTo(map);



    addMarkerPuntoPartida(L, map, lat, lng, imgPerson);

    //addMarker('modulos/senderoSeguro/img/person.png',lat,lng);	

    var jsIdRuta = <?php echo $idRuta ?>;

    if (jsIdRuta > 0) {

        generarPolyLineRuta(map, rutasJs);
        generarPolyLineRutaDetalle(map, rutasDetalleJs);
        generarPolyLineAlerta(map, alertaJs);


    }

    //evento click sobre el map

    /*map.on('click', function(e) { 

      console.log( "puntos.add(new LatLong("+e.latlng.lat+","+e.latlng.lng+"));");
     			//alert("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng);


     			addMarkerPuntoPartida(L,map,e.latlng.lat,e.latlng.lng,imgPerson);

         });*/

    dibujarSeñalEtica(L, map);







}

function addMarkerPuntoPartida(L, map, lat, lng) {
    var descripcion = "<h1>Partida</h2><p>Punto de Partida del Turista.</p>";
    addMarker(L, map, lat, lng, imgPuntoPartida, descripcion);
}

function addMarker(L, map, lat, lng, img, descripcion) {


    var estiloPopup = {
        'maxWidth': '300'
    }
    var iconoBase = L.Icon.extend({
        options: {
            iconUrl: img,
            iconSize: [38, 45], // size of the icon
            shadowSize: [50, 64], // size of the shadow
            iconAnchor: [22, 44], // point of the icon which will correspond to marker's location
            shadowAnchor: [4, 62], // the same for the shadow
            popupAnchor: [-1, -20] // point from which the popup should open relative to the iconAnchor

        }
    });
    var iconoPerson = new iconoBase({
        iconUrl: img
    });


    L.marker([lat, lng], {
        icon: iconoPerson
    }).bindPopup(descripcion, estiloPopup).addTo(map);


}


function addMarkerSeñalEtica(L, map, lat, lng, img, descripcion) {


    var estiloPopup = {
        'maxWidth': '300'
    }
    var iconoBase = L.Icon.extend({
        options: {
            iconUrl: img,
            iconSize: [8, 10], // tamaño icono
            shadowSize: [30, 44], // tamaño de la sombra
            iconAnchor: [8, 10], //punto del icono que corresponderá a la ubicación del marcador
            shadowAnchor: [4, 12], //lo mismo para la sombra
            popupAnchor: [-1, -
                10] // punto desde el cual la ventana emergente debería abrirse en relación con el icono

        }
    });
    var iconoPerson = new iconoBase({
        iconUrl: img
    });

    L.marker([lat, lng], {
        icon: iconoPerson
    }).bindPopup(descripcion, estiloPopup).addTo(map);
}


function generarPolyLineRuta(map, rutasJs) {

    var polyLineRuta = rutasJs[0]['polyLine'];

    var pasos = decode(polyLineRuta);
    var line = new Array();

    var lineInicio = new Array();
    var lineFin = new Array();

    for (var p = 0; p < pasos.length; p++) {
        line[p] = [pasos[p].latitude, pasos[p].longitude];

        /*if(p<pasos.length-1){
         var dis1=<?php echo distance($lat1, $lon1, $lat2, $lon2, $unit);  ?>
        }*/


    }

    lineInicio[0] = [pasos[0].latitude, pasos[0].longitude];
    lineInicio[1] = [pasos[0].latitude, pasos[0].longitude];

    lineFin[0] = [pasos[pasos.length - 1].latitude, pasos[pasos.length - 1].longitude];
    lineFin[1] = [pasos[pasos.length - 1].latitude, pasos[pasos.length - 1].longitude];


    var estiloPopup = {
        'maxWidth': '300'
    }


    var polyline = L.polyline(line, {
        color: '#9CF',
        weight: 8
    }).bindPopup("<h1>Ruta " + rutasJs[0]['descGoePunLleg'] + "</h1>", estiloPopup).addTo(map);

    // zoom the map to the polyline

    var jsactualizarMapa = <?php echo "'" . $actualizarMapa . "'" ?>;

    // add a scale at at your map.
    if (jsactualizarMapa == 'NO') {
        map.fitBounds(polyline.getBounds());

    }



    polyline = L.polyline(lineInicio, {
        color: '#008FF8',
        weight: 18
    }).bindPopup("<h1>Punto Partida </h1>", estiloPopup).addTo(map);


    polyline = L.polyline(lineFin, {
        color: '#008FF8',
        weight: 18
    }).bindPopup("<h1>Punto Llegada " + rutasJs[0]['descGoePunLleg'] + "</h1>", estiloPopup).addTo(map);

}

function generarPolyLineRutaDetalle(map, rutasDetalleJs) {

    try {
        var sizeRutaDetalle = rutasDetalleJs.length;


        if (sizeRutaDetalle > 0) {
            var line = new Array();
            for (var i = 0; i < sizeRutaDetalle; i++) {
                line[i] = [rutasDetalleJs[i]['latGoeRutaDetalle'], rutasDetalleJs[i]['lonGoeRutaDetalle']];
            }
            var estiloPopup = {
                'maxWidth': '300'
            }
            var polyline = L.polyline(line, {
                color: '#019B30',
                weight: 8
            }).bindPopup("<h1>Ruta Recorrida</h1>", estiloPopup).addTo(map);




            //se agrega la ultima posicon recorrida

            var desc = rutasDetalleJs[sizeRutaDetalle - 1]['descidGoeRutaDetalle'];
            var fecha = rutasDetalleJs[sizeRutaDetalle - 1]['fecha'];
            var lat = rutasDetalleJs[sizeRutaDetalle - 1]['latGoeRutaDetalle'];
            var long = rutasDetalleJs[sizeRutaDetalle - 1]['lonGoeRutaDetalle'];

            var descripcion = "<h1>Posición</h1>" + "Ultima Posición Recorrida: " + desc +
                "<br>Fecha: " + fecha + "  </br>" +
                "<br>Lat: " + lat + " Lon: " + long + " </br>";

            addMarker(L, map, lat, long, imgPerson, descripcion);

            //map.setView([lat, long], 13); zoom al marcador

            var radio = 100;

            var circulo = L.circle([lat, long], radio, {
                color: "green",
                weight: 2,
                fillColor: "blue"
            }).addTo(map).bindPopup("RADIO DE " + radio + "m APROXIMADO SEGUN ULTIMA POSICION RECORRIDA  " + lat +
                "," + long);

        }


    } catch (error) {
        console.log("generarPolyLineRutaDetalle=" + error);
        // expected output: ReferenceError: nonExistentFunction is not defined
        // Note - error messages will vary depending on browser
    }



}



function generarPolyLineAlerta(map, alertaJs) {


    var sizeAlerta = alertaJs.length;
    if (sizeAlerta > 0) {
        var line2 = new Array();
        var estiloPopup = {
            'maxWidth': '300'
        };
        var polyline = null;

        for (var i = 0; i < sizeAlerta; i++) {
            var line = new Array();
            line2[i] = [alertaJs[i]['latGoeAlerta'], alertaJs[i]['lonGoeAlerta']];

        }
        polyline = L.polyline(line2, {
            color: '#DCA8A8',
            weight: 8
        }).bindPopup("<h1>Alertas</h1>", estiloPopup).addTo(map);

        //se agregan los marcadore
        for (var i = 0; i < sizeAlerta; i++) {


            var latlong = new Array();

            var descripcion = "<h1>Alerta</h1>" + "Evento generado Por: " + alertaJs[i]['descidGoeAlerta'] +
                "<br>Fecha: " + alertaJs[i]['fecha'] + "  </br>" +
                "<br>Lat: " + alertaJs[i]['latGoeAlerta'] + " Lon: " + alertaJs[i]['lonGoeAlerta'] + " </br>";

            addMarker(L, map, alertaJs[i]['latGoeAlerta'], alertaJs[i]['lonGoeAlerta'], imgAlerta, descripcion);

        }


        //se agrega la ultima posicon de la alerta

        var desc = alertaJs[sizeAlerta - 1]['descidGoeAlerta'];
        var fecha = alertaJs[sizeAlerta - 1]['fecha'];
        var lat = alertaJs[sizeAlerta - 1]['latGoeAlerta'];
        var long = alertaJs[sizeAlerta - 1]['lonGoeAlerta'];

        var descripcion = "<h1>Posición</h1>" + "Ultima Posición de la alerta: " + desc +
            "<br>Fecha: " + fecha + "  </br>" +
            "<br>Lat: " + lat + " Lon: " + long + " </br>";

        addMarker(L, map, lat, long, imgPerson, descripcion);

        var radio = 300;

        //agrega el radio de busqueda
        var circulo = L.circle([lat, long], radio, {
            color: "red",
            weight: 2,
            fillColor: "blue"
        }).addTo(map).bindPopup("RADIO DE " + radio +
            "m APROXIMADO DE BUSQUEDA SEGUN LA ULTIMA POSICION DE LA ALERTA  " + lat + "," + long);



    }



}











function dibujarSeñalEtica(L, map) {


    var listSenalEtica = new Array();

    //RUTA DESDE EL REFUGIO ASTA LA CUMBRE DEL GUGUA PICHINCHA
    //PRUEBA REALIZADA EL 25 DE JULIO DEL 2019
    listSenalEtica.push(new javaSeñalEtica("A", "Cartel-Inf", -0.17854, -78.59697, "Descripcion", "VERDE",
        layersimboloverde));

    listSenalEtica.push(new javaSeñalEtica("B", "Mojon-guia", -0.17839, -78.59782, "", "AZUL", layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("C", "Mojon-guia", -0.17878, -78.59892, "", "AZUL", layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("D", "Cartel-Inf", -0.17979, -78.60065, "Descripcion", "AMARILLO",
        layersimboloamarillo));
    listSenalEtica.push(new javaSeñalEtica("E", "Mojon-guia", -0.17760, -78.59984, "", "AZUL", layersimboloazul));

    listSenalEtica.push(new javaSeñalEtica("F", "Mojon-guia", -0.17728, -78.59969, "", "AZUL", layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("G", "Mojon-precaucion", -0.17637, -78.59986, "", "ROJO", layersimbolorojo));
    listSenalEtica.push(new javaSeñalEtica("H", "Cartel-Inf", -0.17616, -78.60002, ".getMsjCartel_H", "AMARILLO",
        layersimboloamarillo));
    listSenalEtica.push(new javaSeñalEtica("E3", "Mojon-guia", -0.17541, -78.60053, "", "AZUL", layersimboloazul));

    listSenalEtica.push(new javaSeñalEtica("E1", "Cartel-Inf-Exper", -0.17454, -78.60061, ".getMsjCartel_E1", "ROJO",
        layersimbolorojo));

    listSenalEtica.push(new javaSeñalEtica("E2", "Cartel-Inf", -0.17679, -78.59919, ".getMsjCartel_E2", "AMARILLO",
        layersimboloamarillo));
    listSenalEtica.push(new javaSeñalEtica("I", "Cartel-Inf", -0.1768463, -78.59818071, ".getMsjCartel_I", "AZUL",
        layersimboloazul));
    //FIN RUTA DESDE EL REFUGIO ASTA LA CUMBRE DEL GUGUA PICHINCHA



    listSenalEtica.push(new javaSeñalEtica("1", "Cartel-Inf", -0.1782530376284788, -78.59595300119776,
        ".getMsjCartel_1", "AMARILLO", layersimboloamarillo));
    listSenalEtica.push(new javaSeñalEtica("2", "Mojon-guia", -0.1772759581147831, -78.5950940336708, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("3", "Mojon-guia", -0.175622980687261, -78.59399003107258, "", "AZUL",
        layersimboloazul));

    listSenalEtica.push(new javaSeñalEtica("4", "Cartel-Inf", -0.1753030141874852, -78.59208198563749,
        ".getMsjCartel_4", "AMARILLO", layersimboloamarillo));
    listSenalEtica.push(new javaSeñalEtica("5", "Mojon-guia", -0.1745479917566998, -78.59019599638697, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("6", "Mojon-guia", -0.1740839918408831, -78.58727400184223, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("7", "Mojon-guia", -0.1724439789887978, -78.58567203906252, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("8", "Mojon-guia", -0.171148998105822, -78.58336798539681, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("9", "Mojon-guia", -0.1704670194741579, -78.58074601151749, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("10", "Mojon-guia", -0.170569034495457, -78.58044997030063, "", "AZUL",
        layersimboloazul));

    listSenalEtica.push(new javaSeñalEtica("11", "Cartel-Inf", -0.1705399632257792, -78.58001199197723,
        ".getMsjCartel_11", "AMARILLO", layersimboloamarillo));
    listSenalEtica.push(new javaSeñalEtica("12", "Mojon-guia", -0.1681839800347796, -78.57849497174108, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("13", "Mojon-guia", -0.1666050006501335, -78.57837000235701, "", "AZUL",
        layersimboloazul));

    listSenalEtica.push(new javaSeñalEtica("14", "Señaletica", -0.1648170116223092, -78.57804797391205,
        ".getMsjCartel_14", "AZUL", layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("15", "Mojon-guia", -0.1625959743025595, -78.57637703581929, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("16", "Cartel-Inf", -0.1614000258048311, -78.57506700817321,
        ".getMsjCartel_16", "AMARILLO", layersimboloamarillo));
    listSenalEtica.push(new javaSeñalEtica("17", "Mojon-guia", -0.1612200248833172, -78.5748060192538, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("18", "Mojon-guia", -0.1610070188967035, -78.57444303649477, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("19", "Mojon-guia", -0.1606049599057107, -78.57370799990929, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("20", "Mojon-guia", -0.1604189959765174, -78.57346802196169, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("21", "Mojon-guia", -0.1599279608539348, -78.57246803585763, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("22", "Mojon-guia", -0.1597920175846483, -78.57175397893559, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("23", "Mojon-guia", -0.1597399817582628, -78.57048404420448, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("24", "Mojon-guia", -0.160012962523145, -78.56896204200049, "", "AZUL",
        layersimboloazul));

    listSenalEtica.push(new javaSeñalEtica("25", "Cartel-Inf", -0.1604059765908356, -78.56815095535063,
        ".getMsjCartel_25", "ROJO", layersimbolorojo));
    listSenalEtica.push(new javaSeñalEtica("26", "Mojon-guia", -0.1611040104473803, -78.5676800332011, "", "AZUL",
        layersimboloazul));

    listSenalEtica.push(new javaSeñalEtica("27", "Señaletica", -0.1614040748181672, -78.5673979787715,
        ".getMsjCartel_27", "AZUL", layersimboloazul));

    listSenalEtica.push(new javaSeñalEtica("28", "Señaletica", -0.161695987694475, -78.56698196417155,
        ".getMsjCartel_28", "AZUL", layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("29", "Mojon-guia", -0.1615209616154713, -78.5667409986747, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("30", "Mojon-guia", -0.1616480367707884, -78.56662004146543, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("31", "Mojon-guia", -0.1619309691780134, -78.56669102866617, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("32", "Señaletica", -0.1620620344353473, -78.56667700636832,
        ".getMsjCartel_32", "AZUL", layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("33", "Mojon-guia", -0.1625570302448224, -78.56679797905704, "", "ROJO",
        layersimbolorojo));
    listSenalEtica.push(new javaSeñalEtica("34", "Cartel-Inf", -0.162737000575993, -78.56681304158565,
        ".getMsjCartel_34", "AMARILLO", layersimboloamarillo));
    listSenalEtica.push(new javaSeñalEtica("35", "Cartel-Inf", -0.1627480032389658, -78.56660698080115,
        ".getMsjCartel_35", "VERDE", layersimboloverde));
    listSenalEtica.push(new javaSeñalEtica("36", "Mojon-guia", -0.1628370219608311, -78.56647202139321, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("37", "Mojon-guia", -0.1625719600079314, -78.56617899090436, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("38", "Mojon-guia", -0.1621650288347539, -78.56625302344014, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("39", "Mojon-guia", -0.1616759566690647, -78.56578098590931, "", "AZUL",
        layersimboloazul));


    //ULTIMO PUNTO DE LA PRUEBA REALIZADA EL 01 DE AGOSTO DEL 2019
    listSenalEtica.push(new javaSeñalEtica("40", "Señaletica", -0.16199546, -78.56442923, ".getMsjCartel_40", "AZUL",
        layersimboloazul)); //CAMBIADA
    listSenalEtica.push(new javaSeñalEtica("41", "Mojon-guia", -0.1621449907993292, -78.56425196170855, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("42", "Mojon-guia", -0.1624610104429718, -78.56361695678258, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("43", "Mojon-guia", -0.1626450250710668, -78.56344400679387, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("44", "Mojon-guia", -0.1629579639066925, -78.56275100072323, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("45", "Mojon-guia", -0.1638310321737101, -78.5618840119208, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("46", "Cartel-Inf-Exper", -0.1656279567494948, -78.56008601057903,
        ".getMsjCartel_46", "ROJO", layersimbolorojo));
    listSenalEtica.push(new javaSeñalEtica("47", "Cartel-Inf", -0.1664230288845018, -78.55933503437048,
        ".getMsjCartel_47", "VERDE", layersimboloverde));
    listSenalEtica.push(new javaSeñalEtica("48", "Mojon-guia", -0.1677969868313018, -78.55807400349451, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("49", "Cartel-Inf", -0.1685219621835799, -78.55556198104317,
        ".getMsjCartel_49", "AMARILLO", layersimboloamarillo));
    listSenalEtica.push(new javaSeñalEtica("50", "Señaletica", -0.1697600223514841, -78.55331503455017,
        ".getMsjCartel_50", "AZUL", layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("51", "Mojon-guia", -0.1712250147026503, -78.55011301631497, "", "AZUL",
        layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("52", "Señaletica", -0.17287877, -78.54814664, ".getMsjCartel_52", "AZUL",
        layersimboloazul)); //CAMBIADA
    listSenalEtica.push(new javaSeñalEtica("53", "Señaletica", -0.1763949793463179, -78.54485498744619,
        ".getMsjCartel_53", "AZUL", layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("54", "Cartel-Inf", -0.1799329961671453, -78.54145095847547,
        ".getMsjCartel_54", "AMARILLO", layersimboloamarillo));
    listSenalEtica.push(new javaSeñalEtica("55", "Señaletica", -0.1860939937608759, -78.5374010163808,
        ".getMsjCartel_55", "AZUL", layersimboloazul));
    listSenalEtica.push(new javaSeñalEtica("56", "Cartel-Inf", -0.18344379, -78.540343457, ".getMsjCartel_56", "VERDE",
        layersimboloverde)); //CAM



    //se agregan las señal eticas
    for (var i = 0; i < listSenalEtica.length; i++) {
        var senalEtica_ = listSenalEtica[i];

        var descripcion = "<h1>" + senalEtica_.getTitulo + " (" + senalEtica_.getNombre + ") " + "</h1>";
        var lat = senalEtica_.getLatitud;
        var lng = senalEtica_.getLongitud;
        var img = senalEtica_.getImg;

        addMarkerSeñalEtica(L, map, lat, lng, img, descripcion);


    }
}
</script>
<div id='map' name='map' style=" height:500px" class="map"></div>