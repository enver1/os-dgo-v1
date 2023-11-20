<?php
session_start();
if (isset($_SESSION['usuarioAuditar'])) {

	$tgrid = 'grid.php'; // php para mostrar la grid
	$tforma = 'formulario.php'; // php para mostrar el formulario en la parte superior
	$tborra = 'borra.php'; // php para borrar un registro
	$tgraba = 'graba.php'; // php para grabar un registro
	$tprint = 'imprime.php'; // nombre del php que imprime los registros
	$_GET['opc'] = '';

?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Actividades</title>
		<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
		<link rel="stylesheet" href="../../../../css/siipne3.css" type="text/css" media="screen" />
		<script type="text/javascript" src="../../../../js/jquery-3.5.1.min.js"></script>
		<script type="text/javascript" src="../../../../js/validaciones.js"></script>
		<script>
			function max(txarea, longo, id) {
				total = longo;
				tam = txarea.value.length;
				str = "";
				str = str + tam;
				document.getElementById('Dig' + id).innerHTML = str;
				document.getElementById('Res' + id).innerHTML = total - str;
				if (tam > total) {
					aux = txarea.value;
					txarea.value = aux.substring(0, total);
					document.getElementById('Dig' + id).innerHTML = totaldocument.getElementById('Res' + id).innerHTML = 0
				}
			}

			<?php	/* Llama a la funcion el momento de la carga de la hoja ONLOAD*/ ?>
			$(function() {
				getregistro(0);
				getdata(1);
			});

			<?php /* carga la informacion en el formulario cuando se hace click en un elemento de la grilla, recibe como parametro el id del registro Y AL INICIAR EL FORMULARIO*/ ?>

			function getregistro(c) {
				var urlt = '<?php echo $tforma ?>?opc=<?php echo $_GET['opc'] ?>&c=' + c + '&act=' + $('#idActividad').val() + '&vst=' + $('#idVisita').val();
				$('#resp-formulario').html('<p><img src="../../../../funciones/paginacion/images/ajax-loader.gif" /></p>');
				$('#resp-formulario').load(urlt);
				$("html, body").animate({
					scrollTop: 0
				}, "slow");
			}

			<?php /* Refresca la grilla, recibe como parametro el numero de la pagina IMPORTANTE AL INICIAR LA PAGINA*/ ?>

			function getdata(pageno) {
				var targetURL = 'grid.php?act=' + $('#idActividad').val() + '&vst=' + $('#idVisita').val();

				$('#retrieved-data').html('<p><img src="../../../../funciones/paginacion/images/ajax-loader.gif" /></p>');
				$('#retrieved-data').load(targetURL).hide().fadeIn('slow');
			}

			function grabaregistro(c, d) {

				/* Aqui campos del formulario */
				var $inputs = $('#edita :input');
				var values = {};
				$inputs.each(function() {
					if (this.type == 'checkbox') {
						values[this.name] = (this.checked ? "1" : "0");
					} else {
						values[this.name] = $(this).val();
					}
				});

				var id = values[d];
				if (c == '2' && !(id == "" || id == "0" || typeof(id) == 'undefined')) {
					alert('No tiene permisos para Modificar Registros');
					return;
				}
				if (c == '3' && (id == "" || id == "0" || typeof(id) == 'undefined')) {
					alert('No tiene permisos para Insertar Nuevos Registros');
					return
				}
				/*    */
				if (validate(document.getElementById("edita"))) {

					var result = '';
					var $forma = $('html,body');
					$.ajax({
						type: "POST",
						url: "graba.php",
						data: values,

						success: function(response) {
							result = response;
							if (result.trim() != '')
								alert(result);
							else {
								getregistro(0);
								getdata(1);
							}
						}
					});
				}
			}

			<?php /* Elimina un registro de la tabla cuando se hace click en un elemento de la grilla, recibe como parametro el id del registro*/ ?>

			function delregistro(c) {
				si = confirm('Eliminar el registro')
				if (si == true) {
					$.ajax({
						type: "POST",
						url: "<?php echo $tborra ?>?id=" + c + "&opc=<?php echo $_GET['opc'] ?>",
						data: "id=" + c,
						success: function(result) {
							var result1 = '';
							result1 = result;
							getregistro(0);
							getdata(1);
						}
					});
					if (!(result1 == '' || typeof(result1) == 'undefined')) {
						alert(result1);
					}
					return true;
				} else {
					return false;
				}
			}
		</script>
		<input type="hidden" name="idVisita" id="idVisita" value="<?php echo isset($_GET['vst']) ? $_GET['vst'] : 0 ?>">
		<input type="hidden" name="idActividad" id="idActividad" value="<?php echo isset($_GET['prueba']) ? $_GET['prueba'] : 0 ?>">
		<div id="header" style="margin:0 auto"></div>
		<div id="navigation" style="margin:0 auto;font-family:Verdana, Geneva, sans-serif;height:40px"></div>
		<div id="contenido" style="margin-top:0">
			<div id='resp-formulario'>
				<img src="../../../../funciones/paginacion/images/ajax-loader.gif" />
			</div>
			<div id='retrieved-data'>
				<img src="../../../../funciones/paginacion/images/ajax-loader.gif" />
			</div>
		</div>
	<?php //include_once('../js/ajaxuid.php'); // Este archivo contiene las funciones de ajax para update, insert, delete, y edit 
} else
	header('Location: imprime.php');
	?>
	<script type="text/javascript" src="validacionres.js"></script>