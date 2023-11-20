function getLocation(accZoom) {
    navigator.geolocation.getCurrentPosition(function(location) {
	    initMap(location.coords.latitude, location.coords.longitude);
	}, function(argument) {
		initMap('-0.4494108397310957','-78.585734328125',accZoom);
	});
}

function initMap(latitud, longitud, accZoom = 14) {

	var options = {
		center: [latitud, longitud],
		zoom: accZoom
	}

	var map = L.map('map', options);

	L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {attribution: 'OSM'})
	.addTo(map);

	getSenplades(latitud, longitud);

	var myMarker = L.marker([latitud, longitud], {title: "Punto", alt: "The Big I", draggable: true})
	.addTo(map)
	.on('dragend', function() {	
		var coordenada = myMarker.getLatLng();
		getSenplades(coordenada.lat, coordenada.lng);
	});
}

function getSenplades(latitud, longitud) {
	getAddress(latitud, longitud);
	parent.parent.document.getElementById('latitud').value = latitud;
    parent.parent.document.getElementById('longitud').value = longitud;
    parent.parent.document.getElementById('getS').click();
}

function getAddress(latitud, longitud) {
	var latlng = {lat: latitud, lng: longitud};
	var geocodeService = L.esri.Geocoding.geocodeService();
	geocodeService.reverse().latlng(latlng).run(function(error, result) {
		console.log(result.address.LongLabel);
		document.getElementById('address').innerHTML = result.address.LongLabel;
		parent.parent.document.getElementById('direccion').value = result.address.LongLabel;
    });
}