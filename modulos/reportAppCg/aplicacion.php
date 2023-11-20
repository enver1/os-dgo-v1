<?php
include_once('config.php');
$tforma = $directorio . '/formulario.php';

?>
<div id='formulario'>
	<img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>
<div id='retrieved-data'>

</div>
<script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
<script type="text/javascript">
	<?php	/* Llama a la funcion el momento de la carga de la hoja ONLOAD*/ ?>

	$(function() {
		getregistro(0);
	});

	<?php /* carga la informacion en el formulario cuando se hace click en un elemento de la grilla, recibe como parametro el id del registro Y AL INICIAR EL FORMULARIO*/ ?>

	function getregistro(c) {
		var urlt = 'modulos/<?php echo $tforma ?>?opc=<?php echo $_GET['opc'] ?>&c=' + c;

		$('#formulario').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
		$('#formulario').load(urlt);
		$("html, body").animate({
			scrollTop: 0
		}, "slow");

	}
</script>