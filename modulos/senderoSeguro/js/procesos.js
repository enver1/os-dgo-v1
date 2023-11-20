
var fire,i=0;
var datosAlertasFireBase;
var datosAlertasFireBaseNew;
var idRuta_=0;

$(document).ready(function(){

  generarTodasRutasActivas();

  i=0;

  getFechaActual();  

  firebaseConfig();




  $("#btnGenerar").click(generar);
  


  $("#btn").click(function(event) {

   $('#overlay').addClass('active');
   $('#popup').addClass('active'); 

 });

  $("#btn-cerrar-popup").click(function(event) {

    $('#overlay').removeClass('active');
    $('#popup').removeClass('active');     

  });

 // var hilo=setInterval(actualizarMapa,5000);


});


function removerDiv(id){
if (document.getElementById){ //se obtiene el id
var el = document.getElementById(id); //se define la variable "el" igual a nuestro div
//el.style.display = 'none'; //damos un atributo display:none que oculta el div
var idComp='#'+id;
$(idComp).remove();

}
}

function getFechaActual(){

    var fecha = new Date(); //Fecha actual
  var mes = fecha.getMonth()+1; //obteniendo mes
  var dia = fecha.getDate(); //obteniendo dia
  var ano = fecha.getFullYear(); //obteniendo año
  if(dia<10)
    dia='0'+dia; //agrega cero si el menor de 10
  if(mes<10)
    mes='0'+mes //agrega cero si el menor de 10
  //document.getElementById('fechaini').value=ano+"-"+mes+"-"+dia;
  
  
}

function actualizarMapa(){
  if(idRuta_>0){
    cargarMapa(idRuta_,'SI');
    console.log('Actualizando Mapa');
  }
}



function firebaseConfig(){
 var config = {
  apiKey: "AIzaSyDEemy8B4piIyHSGgopaqSBivuuounaA2o",
  authDomain: "senderoseguro.firebaseapp.com",
  databaseURL: "https://senderoseguro.firebaseio.com",
  projectId: "senderoseguro",
  storageBucket: "senderoseguro.appspot.com",
  messagingSenderId: "184912054010"
};
var i=0;
firebase2 =firebase.initializeApp(config);

firebaseAlerta();


}

//evnto utilizado para escuchar cuando se recibe una alerta y mostrarla
function firebaseAlerta(){

  firebase2.database().ref('alertas'). on('value', function(snapshot){  
   datosAlertasFireBase=snapshot.val();
   if(datosAlertasFireBase==null){
     i=0;
   }
   
   generarTodasRutasActivas();

   if(i>0){  


     var data=datosAlertasFireBase; 
     var ultimokey='';
     for (var key in data) {
      ultimokey=key;
    }

    if(ultimokey!=''){
      idGoeRutas= data[ultimokey]['idGoeRutas'];    
      fecha= data[ultimokey]['fecha'];    
      nombres= data[ultimokey]['nombres'];    
      popupToastAlertas(idGoeRutas,fecha,nombres);

    }



}//if i

i=1;



}//firebase.database
);

}//firebaseAlerta




//construlle el popup de las alertas

function  popupToastAlertas(idRuta,fecha,nombres){




  var toast = '';
  var id=idRuta;
  var idComp='#'+id;
  if ($(idComp).length) {
  // si existe

  removerDiv(id);



} else {
  // no existe

}


  //toast='<div id="toast-container" class="toast-top-left">';
  toast +='<div id="'+idRuta+'" class="toast toast-error" aria-live="assertive" style="" onclick="cargarMapa('+ idRuta+')"">';  
  toast +='<div class="toast-progress" style="width: 96.136%;">';
  toast +='</div>';
  toast +='<button type="button" class="toast-close-button" role="button"  onclick=removerDiv('+id+');>×</button>';
  toast +='<div class="toast-message">NUEVA ALERTA</div>'; 
  toast +='<div class="toast-message">Nombres: '+ nombres+'</div>';
  toast +='<div class="toast-message">Fecha: '+ fecha+' </div>  ';
  toast +='<audio id="audioplayer" autoplay="auto" >';
  toast +='<source src="modulos/senderoSeguro/sound/alerta.ogg" type="audio/ogg">';
  toast +='<source src="modulos/senderoSeguro/sound/alerta.mp3" type="audio/mpeg">';
  toast +=' Su Navegador No Sorta Audio.';
  toast +='</audio>';
  toast +='</div>';
   //toast +='</div>';











  $("#toast-container").prepend(toast);//agrega al final sin reemplazar el div anterior

}

function generar(){
	var fecha = document.getElementById("fechaini").value; 

  if(fecha==""){
		//alert("Seleccione la Fecha");

  }
  else{

    cargarMapa(0,'NO');
    var idPuntoLlegada = document.getElementById("comboPuntoLlegada").value;
    getRutas(fecha,idPuntoLlegada); 
  }

}

function generarTodasRutasActivas(){

  cargarMapa(0,'NO'); 

    getRutas("fecha",-1); //-1 todas las rutas

  }

  function generarTodasAlertasActivas(){

    cargarMapa(0,'NO'); 

    getRutas("fecha",-2);  //-2 todas las alertas

  }



  









  function cargarMapa(idRuta,actualizarMapa) {

    if(idRuta>0){
      $("#tdMapa").show();
      removerDiv(idRuta);



      $.post('modulos/senderoSeguro/mapa.php', {idRuta: idRuta,actualizarMapa: actualizarMapa}, function(data) {
        $('#tdMapa').html(data);
      }); 


    //marca la celda seleccionda
    $( "spane:contains('-')" ).css("background-color","transparent");
    $( "spane:contains('-')" ).html("");
    $('#s'+idRuta).css('background-color','blue');
    $('#s'+idRuta).html('-');

    idRuta_=idRuta;



  }
  else{
    $("#tdMapa").hide();
    idRuta_=0;
  }

  
}





function getRutas(fecha, idPuntoLlegada) {
  $.post('modulos/senderoSeguro/grid.php', {fecha: fecha,idPuntoLlegada:idPuntoLlegada }, function(data) {
    $('#tdRutas').html(data);
  });
}

function getRutasAlertas(datosAlertasFireBase) {
  $.post('modulos/senderoSeguro/gridAlertas.php', {datos: datosAlertasFireBase}, function(data) {
    $('#tdRutas').html(data);
  });
}





function cargarDatosUser(idUser,idRuta) {


  var url = "../../operaciones/modulos/senderoSeguro/fratListDatosUser.php?idUser="+idUser+"&idRuta="+idRuta;
  return GB_showPage('DATOS PERSONALES', url);


}







