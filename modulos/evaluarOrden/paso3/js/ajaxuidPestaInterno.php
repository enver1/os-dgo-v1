<script type="text/javascript">
	function pestaI(n) {
		var nPI = 1;
		var urltI = 'modulos/evaluarOrden/paso3/paso' + n + '/aplicacion.php?opc=<?php echo $_GET['opc'] ?>&id=' + $('#idOrden').val();
		var npI = '<?php echo $nPesI ?>';
		for (i = 1; i <= npI; i++) {
			$('#pI' + i).css('background-color', '#4188CE');
			$('#apI' + i).css('color', '#ffffff');
		}
		$('#pI' + n).css('background-color', '#222');
		$('#apI' + n).css('color', '#ffff99');
		$('#formPestaI').html('<p><img src="../../../../../funciones/paginacion/images/ajax-loader.gif" /></p>');
		$('#formPestaI').load(urltI).hide().fadeIn('slow');
		$("html, body").animate({
			scrollTop: 230
		}, "slow");
	}
</script>