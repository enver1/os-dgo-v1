<script type="text/javascript">
	$(document).ready(function() {
		pesta(1);
	});

	function pesta(n) {
		if ($('#idOrden').val() != 0 || n == 1) {
			var nP = 1;
			var urlt = 'modulos/evaluarOrden/paso' + n + '/aplicacion.php?opc=<?php echo $_GET['opc'] ?>&id=' + $('#idOrden').val();

			var np = '<?php echo $nPes ?>';

			for (i = 1; i <= np; i++) {
				$('#p' + i).css('background-color', '#4188CE');
				$('#ap' + i).css('color', '#ffffff');
			}

			$('#p' + n).css('background-color', '#222');
			$('#ap' + n).css('color', '#ffff99');

			$('#formPesta').html('<p><img src="../../../../funciones/paginacion/images/ajax-loader.gif" /></p>');
			$('#formPesta').load(urlt).hide().fadeIn('slow');
			$("html, body").animate({
				scrollTop: 230
			}, "slow");
		} else {
			Swal.fire(
				'Seleccione un Registro de la Lista',
				'',
				'info'
			)
			//alert('**SELECCIONE UN REGISTRO**');
		}

	}
</script>