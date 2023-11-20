<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script src="https://maps.googleapis.com/maps/api/js"></script>
<script>
function initialize() {
  var mapProp = {
    center:new google.maps.LatLng(<?php echo $_GET['latitud']?>,<?php echo $_GET['longitud']?>),
    zoom:15,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

  latLng = new google.maps.LatLng(<?php echo $_GET['latitud'];?>,<?php echo $_GET['longitud'];?>);
  map = new google.maps.Map(document.getElementById('googleMap'), {
    zoom:15,
    center: latLng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });

// CREACION DEL MARCADOR  
  marker = new google.maps.Marker({
    position: latLng,
    map: map,
    icon: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png'
  });
  
  marker1 = new google.maps.Marker({
	    position: latLng,
	    map: map,
	    draggable: true,
	    icon: 'https://maps.google.com/mapfiles/ms/icons/green-dot.png'
  });

  google.maps.event.addListener(marker1, 'drag', function(){
	  parent.parent.document.getElementById('latitud').value = marker1.getPosition().lat();
	  parent.parent.document.getElementById('longitud').value = marker1.getPosition().lng();
  });
  
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>

<body>
<div id="googleMap" style="width:590px;height:370px;"></div>
</body>

</html>