<?php

session_start();
if (isset($_SESSION['usuarioAuditar'])) {
	include_once '../../../../funciones/funciones_generales.php';
	include_once 'config.php';
	$tforma        = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
	$tborra        = $directorio . '/borra.php'; // php para borrar un registro
	$tgraba        = $directorio . '/graba.php'; // php para grabar un registro
	$tprint        = $directorio . '/imprime.php'; // nombre del php que imprime los registros
	$usuarioactual = 0;
	$idDgoInfOrdenServicio = isset($_GET['id']) ? $_GET['id'] : 0;
} else {
	header('Location: imprime.php');
}

?>
<script>
	$(function() {
		comprobarEstado();
		$('#formAyuda').load('modulos/evaluarOrden/includes/formularioAyuda.php?bn=<?php echo $_GET['opc'] ?>&id=<?php echo (isset($_GET['id']) ? $_GET['id'] : 0) ?>');
		var urlt = 'modulos/evaluarOrden/paso8/botones.php?id=<?php echo $idDgoInfOrdenServicio ?>&a=1';
		$('#formulario').load(urlt);
		$('#resultado').load('modulos/evaluarOrden/paso8/buscaEstado.php?id=<?php echo $idDgoInfOrdenServicio ?>');
	});

	function comprobarEstado() {
		var cas = "<?php echo $_GET['id'] ?>";
		$.ajax({
			type: 'GET',
			url: "modulos/evaluarOrden/paso8/activaOrdenServicio.php",
			data: {
				idDgoInfOrdenServicio: cas,
			},
			success: function(response) {
				result = eval(response);
			}
		});
	}

	function verifica(idDgoInfOrdenServicio) {
		var c = idDgoInfOrdenServicio;
		if (c == '') {
			Swal.fire(
				'No Existe Datos',
				'Validación Orden de Servicio',
				'info'
			)
		} else {
			$.post("modulos/evaluarOrden/paso8/verifica.php", {
				id: c
			}, function(data) {
				$("#resultado").html(data);
				var urlt = 'modulos/evaluarOrden/paso8/botones.php?id=' + c + '&a=' + c;
				$('#formulario').load(urlt);
			});
		}
	}

	function previsualiza() {
		var idDgoInfOrdenServicio = "<?php echo $_GET['id'] ?>";
		var url = "modulos/evaluarOrden/paso8/imprimeRepo.php?id=" + idDgoInfOrdenServicio;
		var l = screen.width;
		var t = screen.height;
		var opts = 'scrollbars=yes,toolbar=no,width=' + screen.width + ',height=' + screen.height + ',top=' + t + ' ,left=' + l;
		var name = 'pdf';
		window.open(url, name, opts);

	}

	function procesar() {
		var c = "<?php echo $_GET['id'] ?>";
		Swal.fire({
			title: 'Esta Seguro de Procesar la Orden de Servicio?',
			text: "Validación Orden de Servicio",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#14cf14',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Aceptar',
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			if (result.isConfirmed) {
				$('#resultado').html('<p>Procesando <img src="../../../funciones/paginacion/images/ajax-loader.gif" /></p>');
				var urlt = 'modulos/evaluarOrden/paso8/procesa.php';
				$.ajax({
					type: "POST",
					url: urlt,
					data: {
						id: c,
					},
					success: function(response) {
						result = eval(response);
						if (result[0]) {
							$('#resultado').html('<div class="okmess"><p style="font-size:14px">' + result[0] + '</p></div>');
							Swal.fire(
								'La Orden de Servicio ha sido creada con éxito',
								'Validación Orden de Servicio',
								'success'
							)

						} else {
							$('#resultado').html('<div class="errormess"><p style="font-size:14px">' + result[0] + '</p></div>');
						}
						var urlt = 'modulos/evaluarOrden/paso8/botones.php?id=' + c + '&a=' + c;
						$('#formulario').load(urlt);
					}
				});

			} else {
				Swal.fire(
					'Creación de Orden de Servicio Cancelada',
					'Validación Orden de Servicio',
					'error'
				)
			}
		})
	}

	function imprimir() {
		var idDgoInfOrdenServicio = "<?php echo $_GET['id'] ?>";
		var url = "modulos/evaluarOrden/paso8/imprime.php?id=" + idDgoInfOrdenServicio;
		var l = screen.width;
		var t = screen.height;
		var opts = 'scrollbars=yes,toolbar=no,width=' + screen.width + ',height=' + screen.height + ',top=' + t + ' ,left=' + l;
		var name = 'pdf';
		window.open(url, name, opts);

	}
</script>
<!-- <input type="hidden" name="bdid" id="bdid" value="" /> -->

<table>
	<tr>
		<!-- <td><input type="hidden" name="idDnaParte" id="idDnaParte" value="" readonly="readonly" class="inputSombra" style="width:70px" /></td> -->
		<td></td>
	</tr>
</table>
<div id='formAyuda'>
	<img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>
<table width="100%">
	<tr>
		<td valign="top" width="15%">
			<div id='formulario' style="border-right:solid #999 2px; float:left">
			</div>
		</td>
		<td valign="top" width="85%">
			<div id="resultado" style="float:left;padding-left:20px" width="100%">
			</div>
		</td>
	</tr>
</table>