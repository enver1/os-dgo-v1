<?php
//error_reporting(-1);
//echo $_SERVER["PHP_SELF"];

/* Aqui van los parametros a cambiar en cada formulario */
/* path del directorio del modulo */
$directorio='repoperativo'; // ** CAMBIAR **
/*-----------------------------------------------------------------------------------------------*/
$tforma=$directorio.'/formulario.php'; // php para mostrar el formulario en la parte superior
$tprint=$directorio.'/reporte.php';
$tprinMW=$directorio.'/operativosMovilWeb.php'; // ejemplo para jasper
/*  Fin de configuraciones    */
?>
<script type="text/javascript" src="../js/jquery.easyui.min.js"></script>

<script type = "text/javascript">
$(function(){

getregistro(0);

});

 function getregistro(c)
 {

  	var urlt = 'modulos/<?php echo $tforma ?>?opc=<?php echo $_GET['opc'] ?>&c='+c;
  	$('#formulario').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
  	$('#formulario').load( urlt );
   	$("html, body").animate({ scrollTop: 0 }, "slow");

}
function porusuario()
{
 // alert("....................");
	var fini=$('#fechaini').val();
	var ffin=$('#fechafin').val();
	var lugar=$('#idGenGeoSenplades').val();


	if(fini=='' || ffin=='' || lugar==null )
  {
		alert("No ha ingresado datos en fecha de inicio, fin  o no seleccionó un lugar...");
		return false;
	}
  else
  {
      	 var resultado="";
         var porNombre=document.getElementsByName("forma");
       // Recorremos todos los valores del radio button para encontrar el
       // seleccionado
         	for(var i=0;i<porNombre.length;i++)
           {
            	if(porNombre[i].checked)
             	resultado=porNombre[i].value;
           }
		   if(fini==ffin){
				if(resultado!=4)
				{

					var url="modulos/<?php echo $tprint ?>?fini="+fini+'&ffin='+ffin+'&op='+resultado+'&geosem='+lugar;
					//alert(url);
					  window.open(url);

				  }
				else
				{
					var url="modulos/<?php echo $tprinMW ?>?fini="+fini+'&ffin='+ffin+'&op='+resultado+'&geosem='+lugar;
					window.open(url);
				}
               }else{
			   alert("LA FECHA SOLO TIENE QUE SER DE UN DIA");
			   
			   }			
	}

	}

</script>

<?php

?>
<div id='formulario'>
    <img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>
<?php //if((include'ajaxuid.php')==true){ echo "llego";}else{ echo "nooooo";}
//include_once('ajaxuid.php');  // Este archivo contiene las funciones de ajax para update, insert, delete, y edit ?>
