<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

include_once '../../../funciones/db_connect.inc.php';
include_once '../../../clases/autoload.php';

$hdrEveResDis = new HdrEveResDis;
$formulario     = new FormDiscriminacion;
$encriptar      = new Encriptar;
$opc            = strip_tags($_GET['opc']);
$rowt           = array();
$idHdrEveResDis = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
if ($idHdrEveResDis > 0) {
	$rowt = $hdrEveResDis->getDiscriminacionRegistro($idHdrEveResDis);
}
$formulario->getForma($rowt, $hdrEveResDis->getIdCampo(), $opc);
?>
<table width="100%">
	<tr>
		<td align="center">
			<input type="button" name="excel" onclick="excel()" value="Excel" class="boton_print">
		</td>
	</tr>
</table>
<script type="text/javascript">
	$(function() {
		<?php if (empty($_GET['c'])) : ?>
			$('#fechaRegistro').val('<?= date('Y-m-d H:i:s') ?>');
			$('#idGenUsuario').val('<?= $_SESSION['usuarioAuditar'] ?>');
			$('#usuario').val('<?= $_SESSION['usuarioLogueado'] ?>');
		<?php endif ?>
	});

	function buscarRegistro() {
		if (validate_required(codigoEvento, "Nro. Operativo") == false) {
			codigoEvento.focus();
			return false;
		}
		if (validate_required(documento, "Nro. Cedula") == false) {
			documento.focus();
			return false;
		}

		$.post('modulos/discriminarrosm/data.php', {
			documento: documento.value,
			codigoEvento: codigoEvento.value
		}, function(data, textStatus, xhr) {
			if (data.success) {
				$('#idHdrEventoResum').val(data.data.idHdrEventoResum);
				$('#fechaEvento').val(data.data.fechaEvento);
				$('#apenom').val(data.data.apenom);
				$('#policia').val(data.data.policia);
				$('#idHdrTipoResum').val(data.data.idHdrTipoResum);
				$('#desHdrTipoResum').val(data.data.desHdrTipoResum);
				$('#descTipoTipificacion').val(data.data.descTipoTipificacion);
			} else {
				alert(data.msg);
				$('#idHdrEventoResum').val('');
				$('#fechaEvento').val('');
				$('#apenom').val('');
				$('#policia').val('');
				$('#idHdrTipoResum').val('');
				$('#desHdrTipoResum').val('');
				$('#descTipoTipificacion').val('');
			}
		});
	}

	function buscaPersona() {
		if ($('#cedula').val() == '') {
			$('#nombrePersona').val('NO SE HA REALIZADO LA BUSQUEDA EL CAMPO ESTA EN BLANCO');
			$('#idGenPersona').val('');
		} else {
			var str = $('#cedula').val();
			var n = str.length;
			if (n < 10) {
				$('#nombrePersona').val('LA CEDULA INGRESADA NO ES VALIDA');
				$('#idGenPersona').val('');
			} else {
				$.ajax({
					type: 'GET',
					url: '../../polco/includes/buscaCedulaCiu.php',
					data: 'cedula=' + $('#cedula').val(),
					success: function(response) {
						result = JSON.parse(response);
						if (result['codeResponse'] > 0) {
							var datos = result['datos'];
							$('#nombrePersona').val(datos['apenom']);
							$('#idGenPersona').val(datos['idGenPersona']);

						}
					}
				});
			}
		}
	}

	function limpiar(value) {
		$('#cedula').val('');
		$('#idGenPersona').val('');
		$('#nombrePersona').val('');
	}

	function excel() {
		var url = "modulos/discriminarrosm/excel.php";
		var l = screen.width;
		var t = screen.height;
		var opts = 'scrollbars=yes,toolbar=no,width=' + screen.width + ',height=' + screen.height + ',top=' + t + ' ,left=' + l;
		var name = 'pdf';
		window.open(url, name, opts);
	}
</script>