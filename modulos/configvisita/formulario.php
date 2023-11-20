<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include '../../../clases/autoload.php';
$conn = DB::getConexionDB();
include_once('../../../funciones/funcion_select.php');
include_once('config.php');
$dt = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$fechaHoy = $dt->format('Y-m-d');
$rowt = array();
$frm                  = new Form;
$opc                  = strip_tags($_GET['opc']);
/*-------------------------------------------------*/
if (isset($_GET['c']) && $_GET['c'] > 0) {
	$sql = "select a.*,b.documento cedulaPersona,concat(siglas,' ',b.apenom) nombrePersona from " . $Ntabla . " a,v_persona_dgl b where a.idGenPersona=b.idGenPersona and a." . $idcampo . "='" . $_GET['c'] . "'";
	$rs = $conn->query($sql);
	$rowt = $rs->fetch(PDO::FETCH_ASSOC);
}
/* ==== Aqui se incluye el formulario de edicion */
$frm->getFormulario($formulario, $rowt, $idcampo, $opc, true, true, true, true);
?>

<script type="text/javascript" src="../js/jquery-migrate-3.5.1.js"></script>
<script type="text/javascript" src="../js/jquery.maskedinput.js"></script>

<script type="text/javascript">
	$(function() {
		$('#idDgoActUnidad').val($('#idDgoActUnidadX').val());
		$('#fecInicial').val($('#fini').val());
		$('#fecFinal').val($('#ffin').val());
		//	muestraGrid();
	});

	jQuery(function($) {
		$.mask.definitions['H'] = '[012]';
		$.mask.definitions['N'] = '[012345]';
		$.mask.definitions['n'] = '[0123456789]';
		$("#horaInicio").mask("Hn:Nn:Nn");
		$("#horaFin").mask("Hn:Nn:Nn");
	});

	function buscaPersona() {
		if ($('#cedulaPersona').val() == '') {
			$('#nombrePersona').val('NO SE HA REALIZADO LA BUSQUEDA EL CAMPO ESTA EN BLANCO');
			$('#idGenPersona').val('');
		} else {
			var str = $('#cedulaPersona').val();
			var n = str.length;
			if (n < 10) {
				$('#nombrePersona').val('LA CEDULA INGRESADA NO ES VALIDA');
				$('#idGenPersona').val('');
			} else {
				$.ajax({
					type: 'GET',
					url: 'modulos/configvisita/buscaCedula.php',
					data: 'cedula=' + $('#cedulaPersona').val(),
					success: function(response) {
						result = JSON.parse(response);
						if (result['codeResponse'] > 0) {
							var datos = result['datos'];
							if (result['msj'] == 'PERSONA CIVIL') {
								$('#nombrePersona').val('PERSONA NO ES SERVIDOR POLICIAL');
								$('#cedulaPersona').val('');
								$('#idGenPersona').val('');
							} else {
								$('#nombrePersona').val(datos['apenom']);
								$('#idGenPersona').val(datos['idGenPersona']);
							}


						}
					}
				});
			}
		}
	}
</script>