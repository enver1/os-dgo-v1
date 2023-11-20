<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include_once '../../../../clases/autoload.php';
include_once 'config.php';

$AsignaPersonalElec     = new AsignaPersonalElec;
$formAsignaPersonalElec = new FormAsignaPersonalElec;
$encriptar              = new Encriptar;
$dt                     = new DateTime('now', new DateTimeZone('America/Guayaquil'));

$rowt = array();
$opc  = strip_tags($_GET['opc']);
$id   = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
/*-------------------------------------------------*/
if ($id > 0) {
	$rowt = $AsignaPersonalElec->getEditAsignaPersonalElec($id);
}

?>
<br>
<fieldset style="border-color:#336699">
	<legend><strong>DETALLE RECINTOS:</strong></legend>
	<form name="edita" id="edita" method="post">
		<table width="100%" border="0">
			<?php
			$formAsignaPersonalElec->getFormularioAsignaPersonalElec($rowt, $AsignaPersonalElec->getIdCampoAsignaPersonalElec(), $opc);
			?>
			<script type="text/javascript">
				$(function() {
					$('#idDgoCreaOpReci').val($('#idJefe').val());
				});

				function buscaConductor() {
					if ($('#cedulaPersonaC').val() == '') {
						Swal.fire(
							'Ingrese un Número de Cédula',
							'Crear Operativo',
							'info'
						)
						limpiarR();
					} else {
						$.ajax({
							type: 'GET',
							url: 'modulos/verificacionPer/includes/buscaCedulaCiu.php',
							data: 'cedula=' + $('#cedulaPersonaC').val(),
							success: function(response) {
								result = JSON.parse(response);
								if (result['codeResponse'] > 0) {
									if (result['msj'] == 'SERVIDOR POLICIAL') {
										$('#nombrePersonaC').val(result['datos']['apenom']);
										$('#idGenPersona').val(result['datos']['idGenPersona']);
									} else {
										Swal.fire(
											'Persona No es Servidor Policial',
											'Registrar Integrantes',
											'error'
										)
										limpiarR();
									}
								} else {
									Swal.fire(
										result['msj'],
										'Crear Operativo',
										'info'
									)
									$('#idGenPersona').val('');
									$('#nombrePersonaC').val('');
									$('#cedulaPersonaC').val('');

								}
							}
						});
					}

				}

				function buscaConductor1() {
					if ($('#cedulaPersonaC').val() == '') {
						$('#nombrePersonaC').val('EL CAMPO CÉDULA NO PUEDE ESTAR EN BLANCO');
						$('#idGenPersona').val('');
						$('#cedulaPersonaC').val('');
					} else {
						var str = $('#cedulaPersonaC').val();
						var n = str.length;
						if (n != 10) {
							$('#nombrePersonaC').val('LA CEDULA INGRESADA NO ES VALIDA');
							$('#idGenPersona').val('');
							$('#cedulaPersonaC').val('');
						} else {
							$.ajax({
								type: 'GET',
								url: 'includes/buscaCedulaCiu.php',
								data: 'usuario=' + $('#cedulaPersonaC').val(),
								success: function(response) {
									result = response;

									if (result[0] > 0) {
										$('#nombrePersonaC').val(result[1]);
										$('#idGenPersona').val(result[0]);
									} else {
										$('#idGenPersona').val('');
										$('#nombrePersonaC').val(result[1]);
										$('#cedulaPersonaC').val('');
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

				function cargaCmbEjeP(idTipoEje1) {
					//	verificaEje(idTipoEje1);
					$.post("modulos/recintosElectorales/paso1/includes/cmbMuestraEje.php", {
							idTipoEje1: idTipoEje1
						},
						function(resultado) {
							document.getElementById("idDgoTipoEje2").innerHTML = resultado;
							document.getElementById("idDgoTipoEje").innerHTML = 'SELECCIONE';

						}
					);
				}

				function cargaCmbEjeP1(idTipoEje1) {
					//verificaEje1(idTipoEje1);
					$.post("modulos/recintosElectorales/paso1/includes/cmbMuestraEje.php", {
							idTipoEje1: idTipoEje1
						},
						function(resultado) {
							document.getElementById("idDgoTipoEje").innerHTML = resultado;

						}
					);
				}
			</script>
			<script type="text/javascript">
				$(function() {
					$('#idDgoProcElec').val($('#idDgoProcE').val());
					$('#idDgoReciElect').val($('#idRElec').val());

				});
			</script>