<?php
/*
Funciones de ajax jquery para realizar inserciones, actulizaciones, eliminaciones o editar registros en cualquier formulario
*/

$sqltable = urlencode(encrypt(urldecode($sqltable), $_SESSION['nomUsuarioLogueado']));

?>
<script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
<script type="text/javascript" src="../js/sha1.js"></script>
<script type="text/javascript">
	<?php	/* Llama a la funcion el momento de la carga de la hoja ONLOAD*/ ?>

	$(function() {
		getdata(1);
		getregistro(0);
	});


	<?php /* Refresca la grilla, recibe como parametro el numero de la pagina IMPORTANTE AL INICIAR LA PAGINA*/ ?>

	function getdata(pageno) {
		var targetURL = 'modulos/muestraresultados.php?page=' + pageno + '&grilla=<?php echo $tgrid ?>&opc=<?php echo $_GET['opc'] ?>&sql=<?php echo $sqltable ?>';
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
		var urlt = 'modulos/<?php echo $tforma ?>?opc=<?php echo $_GET['opc'] ?>&c=' + c;
		$('#formulario').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
		$('#formulario').load(urlt);
		$("html, body").animate({
			scrollTop: 0
		}, "slow");

	}
	<?php /* Elimina un registro de la tabla cuando se hace click en un elemento de la grilla, recibe como parametro el id del registro*/ ?>

	function delregistro(c) {
		var result = '';
		si = confirm('Eliminar el registro');

		if (si == true) {
			$.ajax({
				type: "POST",
				url: "modulos/<?php echo $tborra ?>?id=" + c + "&opc=<?php echo $_GET['opc'] ?>",
				data: "id=" + c,
				success: function(response) {

					result = response;

					if (!(result == '' || typeof(result) == 'undefined')) {
						alert(result);
					}

					getregistro(0);
					getdata(1);
				}
			});
			return true;
		} else {
			return false;
		}
	}


	<?php /* Graba un registro de la tabla cuando se hace click en el boton grabar, recibe como parametro el id del registro
			y el nombre del campo que contiene el ID en el formulario para poder saber si esta haciendo un insert o un update
			y de acuerdo a los privilegios le permite continuar o no*/ ?>

	function grabaregistro(c, d) {

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

					alert(result[1]);

					if (result[0]) {
						getdata(1);
						getregistro(0);
					}

				}
			});
		}

	}


	// Funcion para grabar registros y cargar archivos
	function processI(c, d) {
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
						form_data.append([this.name], ($(this).prop('checked') ? $(this).val() : ""));
					} else {
						form_data.append([this.name], $(this).val());
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
				type: 'POST',

				success: function(response) {
					result = response;

					result = JSON.parse(result);

					alert(result[1]);

					if (result[0]) {
						getregistro(0);
						getdata(1);
					}
				}
			});
		}
	}


	<?php	/* Llama a la funcion que imprime los registros en formato PDF*/ ?>

	function imprimirdata(titulo = 'REPORTE') {
		var url = "../../polco/modulos/<?php echo $tprint ?>";
		return GB_showPage(titulo, url);
	}

	function buscaEventoRes(ep) {
		if (isNaN(ep)) {
			alert('** DATO INCORRECTO **');
		} else {
			$.ajax({
				type: "POST",
				url: "includes/eventoPolco/buscaEvento.php",
				data: 'ep=' + ep,

				success: function(response) {
					result = response;
					$('#objetivo').val(result[5]);
					$('#tema').val(result[6]);
					$('#fechaEvento').val(result[3]);
				}
			});
		}
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


	function persona() {
		if ($('#cedulaPersona').val() == '') {
			$('#nombrePersona').val('');
			$('#idGenPersona').val('');
		} else {
			$.ajax({
				type: 'POST',
				url: 'funciones/buscaCedula.php',
				data: 'usuario=' + $('#cedulaPersona').val(),

				success: function(response) {
					result = response;

					$('#nombrePersona').val(result[1]);

					if (result[0] > 0) {
						$('#idGenPersona').val(result[0]);
					} else {
						$('#idGenPersona').val('');
					}

				}
			});
		}
	}
</script>