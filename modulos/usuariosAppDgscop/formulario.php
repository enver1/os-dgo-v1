<?php
session_start();
include_once '../../../clases/autoload.php';

$formUsuariosAppDgscop = new FormUsuariosAppDgscop;
$UsuariosAppDgscop     = new UsuariosAppDgscop;
$encriptar = new Encriptar;
$opc       = strip_tags($_GET['opc']);
$idDgiUsuariosAppDgscop  = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt      = array();

if ($idDgiUsuariosAppDgscop > 0) {
	$rowt = $UsuariosAppDgscop->getEditUsuariosAppDgscop($idDgiUsuariosAppDgscop);
}
$formUsuariosAppDgscop->getFormularioUsuariosAppDgscop($rowt, $UsuariosAppDgscop->getIdCampo(), $opc);
?>
<script type="text/javascript">
	$('#cedulaPersonaC').keypress(function(e) {
		if (e.which == 13) {
			buscaConductor(false);
		}
	});


	function buscaConductor() {
		if ($('#cedulaPersonaC').val() == '') {
			$('#nombrePersonaC').val('EL CAMPO CÉDULA NO PUEDE ESTAR EN BLANCO');
			$('#idGenPersona').val('');
		} else {
			var str = $('#cedulaPersonaC').val();
			var n = str.length;
			if (n != 10) {
				$('#nombrePersonaC').val('LA CEDULA INGRESADA NO ES VALIDA');
				$('#idGenPersona').val('');
			} else {
				$.ajax({
					type: 'GET',
					url: 'includes/buscaCedulaServ.php',
					data: 'usuario=' + $('#cedulaPersonaC').val(),
					success: function(response) {
						result = response;

						if (result[0] > 0) {
							$('#nombrePersonaC').val(result[1]);
							$('#edad').val(result[2]);
							$('#idGenUsuario').val(result[0]);
						} else {
							$('#idGenUsuario').val('');
							$('#nombrePersonaC').val('NO EXISTE COINCIDENCIAS');
							$('#edad').val('');
						}
					}
				});
			}
		}
	}

	function limpiarR() {
		$('#idGenPersona').val('');
		$('#nombrePersonaC').val('');
		$('#cedulaPersonaC').val('');
	}

	function limpiarR() {
		$('#idGenUsuario').val('');
		$('#nombrePersonaC').val('');
		$('#cedulaPersonaC').val('');
	}
</script>