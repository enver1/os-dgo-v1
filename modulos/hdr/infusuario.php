<script>
function buscapersona1()
{
		var result='';
		$.ajax({
		type: "GET",
		url: "modulos/infusuario/buscapersona.php?usuario="+$("#cedula").val(),
        data: values,		
				async: false,
				success: function(response){
	      result = eval(response);
				//var targetURL = 'modulos/muestraresultados_user.php?page=1&grilla=<?php //echo $tgrid ?>&opc=<?php //echo $_GET['opc'] ?>&modl=<?php //echo $sqgrid ?>&usuario='+result[0];					
				document.getElementById('usercdg_up').value=result[0];
				document.getElementById('nombres').value=result[1];
				document.getElementById('siglas').value=result[2];
				document.getElementById('institucion').value=result[3];
				document.getElementById('email').value=result[4];
				document.getElementById('descripcion').value=result[5];
				document.getElementById('nombreUsuario').value=result[6];
				document.getElementById('siglaUsuario').value=result[7];
				document.getElementById('situacionPolicial').value=result[8];
				document.getElementById('fechaNacimiento').value=result[9];
				document.getElementById('sexo').value=result[10];
				//$('#retrieved-data').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');        
				//$('#retrieved-data').load( targetURL ).hide().fadeIn('slow');				
				}
		});
}
</script>