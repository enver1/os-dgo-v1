<?php
if (isset($_SESSION['usuarioAuditar'])) {
	include_once('config.php');
	$tgrid = $directorio . '/grid.php'; // php para mostrar la grid
	$tforma = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
	$tborra = $directorio . '/borra.php'; // php para borrar un registro
	$tgraba = $directorio . '/graba.php'; // php para grabar un registro
	$tprint = $directorio . '/imprime.php'; // nombre del php que imprime los registros
	$dt = new DateTime('now', new DateTimeZone('America/Guayaquil'));
	$fechaHoy = $dt->format('Y-m-d');
	$anioActal = $dt->format('Y');
?>
	<script type="text/javascript" src="../../js/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		<?php	/* Llama a la funcion el momento de la carga de la hoja ONLOAD*/ ?>

		$(function() {
			getdata(1);
			getregistro(0);
		});

		<?php /* Refresca la grilla, recibe como parametro el numero de la pagina IMPORTANTE AL INICIAR LA PAGINA*/ ?>

		function getdata(pageno) {
			var busca = $('#idPersona').val();
			var targetURL = 'modulos/muestraresultados.php?page=' + pageno + '&grilla=<?php echo $tgrid ?>&opc=<?php echo $_GET['opc'] ?>&sql=<?php echo $sqltable ?>' + busca;
			$('#retrieved-data').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
			$('#retrieved-data').load(targetURL).hide().fadeIn('slow');
		}

		<?php /* ESTA FUNCION NO ACTUA EN NADA YA QUE NO SE PASA EL PARAMETRO QUE ES $sqltable2 */ ?>

		function getdatadetalle(pageno, id) {

			var targetURL = 'modulos/muestraresultados.php?page=' + pageno + '&grilla=<?php echo isset($tgrid2) ? $tgrid2 : '' ?>&opc=<?php echo $_GET['opc'] ?>&sql=<?php echo isset($sqltable2) ? $sqltable2 : '' ?>' + id;
			var $forma = $('html,body');
			$('#retrieved-detalle').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
			$('#retrieved-detalle').load(targetURL).hide().fadeIn('slow');
			$("html, body").animate({
				scrollTop: $forma.height()
			}, "slow");
		}

		<?php /* carga la informacion en el formulario cuando se hace click en un elemento de la grilla, recibe como parametro el id del registro Y AL INICIAR EL FORMULARIO*/ ?>

		function getregistro(c) {
			if ($('#idDgoAsignacion').val() > 0) {
				$('#idPersona').val(0);
				$('#cursante').val('');
				$('#cedula').val('');
			}
			var urlt = 'modulos/<?php echo $tforma ?>?opc=<?php echo $_GET['opc'] ?>&c=' + c;
			$('#formulario').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
			$('#formulario').load(urlt);
			$("html, body").animate({
				scrollTop: 0
			}, "slow");

		}

		<?php /* Elimina un registro de la tabla cuando se hace click en un elemento de la grilla, recibe como parametro el id del registro*/ ?>

		function delregistro(c) {
			var targetURL = 'modulos/muestraresultados.php?page=1&grilla=<?php echo $tgrid ?>&opc=<?php echo $_GET['opc'] ?>&sql=<?php echo $sqltable ?>';
			var urlt = 'modulos/<?php echo $tforma ?>?opc=<?php echo $_GET['opc'] ?>&c=0';
			si = confirm('Eliminar el registro')
			if (si == true) {
				$.ajax({
					type: "POST",
					url: "modulos/<?php echo $tborra ?>?id=" + c + "&opc=<?php echo $_GET['opc'] ?>",
					data: "id=" + c,
					success: function(result) {
						var result1 = '';
						result1 = result;
						getdata(1);
					}
				});
				//			$('#retrieved-data').load( targetURL ).hide().fadeIn('slow');
				if (!(result1 == '' || typeof(result1) == 'undefined')) {
					alert(result1);
				}
				return true;
			} else {
				return false;
			}
		}

		function grabaregistro(c, d) {

			var targetURL = 'modulos/muestraresultados.php?page=1&grilla=<?php echo $tgrid ?>&opc=<?php echo $_GET['opc'] ?>&sql=<?php echo $sqltable ?>';
			/* Aqui campos del formulario */
			var $inputs = $('#edita :input');
			var values = {};
			$inputs.each(function() {
				values[this.name] = $(this).val();
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
					url: "modulos/<?php echo $tgraba ?>",
					data: values,

					success: function(response) {
						result = response;
						getdata(1);
						var urlt = 'modulos/<?php echo $tforma ?>?opc=<?php echo $_GET['opc'] ?>&c=0';
						$('#formulario').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
						$('#formulario').load(urlt);
						$("html, body").animate({
							scrollTop: $forma.height()
						}, "slow");
					}
				});
			}
			if (!(result == '' || typeof(result) == 'undefined')) {
				alert(result);
			}
		}

		function processI(c, d) {
			var targetURL = 'modulos/muestraresultados.php?page=1&grilla=<?php echo $tgrid ?><?php echo (isset($filaspp) ? '&filaspp=' . $filaspp : '') ?>&opc=<?php echo $_GET['opc'] ?>&sql=<?php echo $sqltable ?>';
			var $inputs = $('#edita :input');
			var values = {};
			$inputs.each(function() {
				if (this.type == 'checkbox') {
					values[this.name] = (this.checked ? "1" : "0");
				} else
				if (this.type == 'radio') {
					if (this.checked) {
						values[this.name] = $(this).val();
					}
				} else {
					values[this.name] = $(this).val();
				}
			});
			/* Valida permisos y privilegios sobre la BDD*/
			var id = values[d];
			if (c == '2' && !(id == "" || id == "0" || typeof(id) == 'undefined')) {
				alert('No tiene permisos para Modificar Registros');
				return;
			}

			if (c == '3' && (id == "" || id == "0" || typeof(id) == 'undefined')) {
				alert('No tiene permisos para Insertar Nuevos Registros');
				return
			}

			/* valida los campos del documento    */
			if (validate(document.getElementById("edita"))) {
				var result = '';
				var $forma = $('html,body');
				var form_data = new FormData();
				$inputs.each(function() {
					//alert(this.type);
					if (this.type == 'file') {
						form_data.append([this.name], $(this).prop('files')[0]);
					} else {
						if (this.type == 'checkbox') {
							form_data.append([this.name], ($(this).checked ? "1" : "0"))
						} else {
							form_data.append([this.name], $(this).val())
						}
					}
				});

				$.ajax({
					url: "modulos/<?php echo $tgraba ?>",
					dataType: 'text',
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,
					type: 'post',

					success: function(response) {
						result = eval(response);
						if (result[0]) {
							success(result[1]);
							getregistro(0);
							getdata(1);
						} else {
							error(result[1]);
						}
					}
				});
			}
		}

		<?php	/* Llama a la funcion que imprime los registros en formato PDF*/ ?>

		function imprimirdata() {
			var url = "modulos/<?php echo $tprint ?>?p=" + $('#idPersona').val();
			var l = screen.width;
			var t = screen.height;
			var opts = 'scrollbars=yes,toolbar=no,width=' + screen.width + ',height=' + screen.height + ',top=' + t + ' ,left=' + l;
			var name = 'pdf';
			window.open(url, name, opts);

		}


		<?php	/* Busca un dato dentro de un Grid y se posiciona en la pagina que contiene el registro, en caso de no encontrar regresa a la Pag 1*/ ?>

		function buscagrid() {
			var result = '';
			$.ajax({
				type: "GET",
				url: "../funciones/buscapagina.php?sql=<?php echo $sqltable ?>&col=<?php echo isset($colbusqueda) ? $colbusqueda : 0 ?>&busqueda=" + $("#criterio").val(),
				data: values,

				success: function(response) {
					result = response;
					var targetURL = 'modulos/muestraresultados.php?page=' + result + '&grilla=<?php echo $tgrid ?>&opc=<?php echo $_GET['opc'] ?>&sql=<?php echo $sqltable ?>';
					$('#retrieved-data').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
					$('#retrieved-data').load(targetURL).hide().fadeIn('slow');
				}
			});
		}

		function getregistroBuzon(c) {
			var urlt = 'modulos/<?php echo $tforma ?>?opc=<?php echo $_GET['opc'] ?>&c=' + c;
			$('#formulario').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
			$('#formulario').load(urlt);
			getdata(1);
			$("html, body").animate({
				scrollTop: 0
			}, "slow");
		}

		function buscaCursante() {
			if ($('#cedula').val() == '') {
				alert('INGRESE UN NUMERO DE CEDULA');
				$('#cursante').val('');
				$('#idPersona').val(0);
				$('#email').val('');
				$('#telefono').val('');
			} else {
				$.ajax({
					type: 'POST',
					url: 'modulos/asignacion/buscaCedula.php',
					data: {
						'usuario': $('#cedula').val(),
						'an': $('#anioActal').val()
					},
					success: function(response) {
						//result = JSON.parse(response);
						result = response;
						if (result[0] > 0) {
							$('#idPersona').val(result['idGenPersona']);
							$('#cursante').val(result['siglasApenom']);
							$('#email').val(result['email']);
							$('#telefono').val(result['fono']);
							getregistro(0);
							getdata(1);
						} else {
							$('#idPersona').val(0);
							$('#cursante').val(result[2]);
							$('#email').val('');
							$('#telefono').val('');
						}
					}
				});
			}
		}

		function limpiarCampos() {
			$('#cursante').val('');
			$('#idPersona').val(0);
			$('#cedula').val('');
			$('#email').val('');
			$('#telefono').val('');
			getregistro(0);
			getdata(1);
		}
	</script>
	<div id="forPerso">
		<table width="100%" border="0">
			<tr>
				<td class="etiqueta">Cursante:</td>
				<td>
					<table>
						<tr>
							<td align="left">
								<input type="hidden" name="fechaHoy" id="fechaHoy" readonly="readonly" value="<?php echo $fechaHoy ?>" />
								<input type="hidden" name="anioActal" id="anioActal" readonly="readonly" value="<?php echo $anioActal ?>" />
								<input type="hidden" name="idPersona" id="idPersona" value="0" />
								<input name="cedula" id="cedula" style="width:100px;text-align:left" maxlength="10" value="" class="inputSombra" type="text" />
							</td>
							<td>
								<input type="button" id="Buscar" class="boton_general" onclick="buscaCursante()" value="Buscar" style="display: block;" />
							</td>
							<td>
								<input name="cursante" id="cursante" style="width:300px;text-align:left" value="" class="inputSombra" readonly="readonly" type="text" />
								<!--<a href="modulos/asignacion/listCursantes.php?an=<?php echo $anioActal ?>" onclick="return GB_showPage('CURSANTES', this.href)"><img src="../../../imagenes/buscarNombres.png" alt="Abrir" border="0"></a>-->
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="etiqueta">Email:</td>
				<td>
					<input name="email" id="email" style=" width:250px;text-align:left" value="" class="inputSombra" readonly="readonly" type="text" />
				</td>
			</tr>
			<tr>
				<td class="etiqueta">Telefono:</td>
				<td>
					<input name="telefono" id="telefono" style=" width:250px;text-align:left" value="" class="inputSombra" readonly="readonly" type="text" />
				</td>
			</tr>
		</table>
	</div>
	<hr>
	<div id='formulario'>
		<img src="../funciones/paginacion/images/ajax-loader.gif" />
	</div>
	<div id='retrieved-data'>
		<img src="../funciones/paginacion/images/ajax-loader.gif" />
	</div>
<?php //include_once('../js/ajaxuid.php'); // Este archivo contiene las funciones de ajax para update, insert, delete, y edit 
} else
	header('Location: imprime.php');
?>
<script type="text/javascript" src="<?php echo 'modulos/' . $directorio ?>/validacion.js"></script>