<script type="text/javascript">
	$(document).ready(function() {
		pesta(1);
	});

	function pesta(n) {
		if (($('#idJefe').val() != 0 && $('#idJefe').val() != '' && $('#idJefe').val() != undefined) || n == 1) {
			if (($('#est').val() == 'A') || n == 1) {
				var nP = 1;
				// var urlt = 'modulos/verificacionPer/paso'+n+'/aplicacion.php?opc=<?php echo $_GET['opc'] ?>&idR='+$('#idJefe').val()+'&idDgoProcE='+$('#idDgoProcE').val()+'&latitud1='+$('#lat').val()+'&longitud1='+$('#long').val();
				var urlt = 'modulos/verificacionPer/paso' + n + '/aplicacion.php?opc=<?php echo $_GET['opc'] ?>&idR=' + $('#idJefe').val() + '&idDgoProcE=' + $('#idDgoProcE').val();
				var np = '<?php echo $nPes ?>';

				for (i = 1; i <= np; i++) {
					$('#p' + i).css('background-color', '#336699');
					$('#ap' + i).css('color', '#ffffff');
				}

				$('#p' + n).css('background-color', '#222');
				$('#ap' + n).css('color', '#ffff99');

				$('#formPesta').html('<p><img src="../../../funciones/paginacion/images/ajax-loader.gif" /></p>');
				$('#formPesta').load(urlt).hide().fadeIn('slow');
				$("html, body").animate({
					scrollTop: 230
				}, "slow");
			} else {
				alert('El Recinto debe Estar Activo para Agregar Personal');
			}
		} else {
			alert('**SELECCIONE UN REGISTRO**');
		}
	}
</script>