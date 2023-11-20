
<script type="text/javascript">

$(document).ready(function() {
  	pesta(1);
});
function pesta(n)
{
	if(($('#idProceso').val()!=0 && $('#idProceso').val()!='' && $('#idProceso').val()!=undefined) || n==1) {
		var nP=1;
		var urlt = 'modulos/procesosElectorales/paso'+n+'/aplicacion.php?opc=<?php echo $_GET['opc'] ?>&idR='+$('#idProceso').val();

		var np='<?php echo $nPes ?>';

		for(i=1;i<=np;i++) {
			$('#p'+i).css('background-color', '#336699');
			$('#ap'+i).css('color', '#ffffff');
		}

		$('#p'+n).css('background-color', '#222');
		$('#ap'+n).css('color', '#ffff99');

		$('#formPesta').html('<p><img src="../../../funciones/paginacion/images/ajax-loader.gif" /></p>');
		$('#formPesta').load( urlt ).hide().fadeIn('slow');
	 	$("html, body").animate({ scrollTop: 230 }, "slow");

} else {
		alert('**SELECCIONE UN REGISTRO**');
	}
}
</script>