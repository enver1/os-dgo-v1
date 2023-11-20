<?php
//include_once('../funciones/funciones_generales.php');
$sqltable = urlencode(encrypt(urldecode($sqltable), $_SESSION['nomUsuarioLogueado']));
?>
<script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
<script type="text/javascript">
	<?php	/* Llama a la funcion el momento de la carga de la hoja ONLOAD*/ ?>

	$(function() {
		getdata(1);
		getregistro(0);
	});


	<?php /* Refresca la grilla, recibe como parametro el numero de la pagina IMPORTANTE AL INICIAR LA PAGINA*/ ?>

	function getdata(pageno) {
		var targetURL = 'modulos/muestraresultados_car.php?page=' + pageno + '&grilla=<?php echo $tgrid ?>&opc=<?php echo $_GET['opc'] ?>&sql=<?php echo $sqltable ?>';
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

					$('#retrieved-data').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
					$('#retrieved-data').load(targetURL);
					$('#formulario').load(urlt);
					if (!(result1 == '' || typeof(result1) == 'undefined')) {
						alert(result1);
					}
				}
			});
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
					$('#retrieved-data').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
					$('#retrieved-data').load(targetURL).hide().fadeIn('slow');
					var urlt = 'modulos/<?php echo $tforma ?>?opc=<?php echo $_GET['opc'] ?>&c=0';
					$('#formulario').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
					$('#formulario').load(urlt);
					$("html, body").animate({
						scrollTop: $forma.height()
					}, "slow");
					if (!(result == '' || typeof(result) == 'undefined')) {
						alert(result);
					}
				}
			});
		}


	}
	<?php	/* Llama a la funcion que imprime los registros en formato PDF*/ ?>

	function imprimirdata() {
		var url = "modulos/<?php echo $tprint ?>";
		var l = screen.width;
		var t = screen.height;
		var opts = 'scrollbars=yes,toolbar=no,width=' + screen.width + ',height=' + screen.height + ',top=' + t + ' ,left=' + l;
		var name = 'pdf';
		window.open(url, name, opts);

	}







	function porusuario() {
		var fini = $('#fechaini').val();
		var ffin = $('#fechafin').val();
		var lugar = $('#idGenGeoSenplades').val();
		alert();

		if (fini == '' || ffin == '' || lugar == null) {
			alert("No ha ingresado datos en fecha de inicio, fin  o no seleccionó un lugar...");
			return false;
		} else {
			var resultado = "";
			var porNombre = document.getElementsByName("forma");
			// Recorremos todos los valores del radio button para encontrar el
			// seleccionado
			for (var i = 0; i < porNombre.length; i++) {
				if (porNombre[i].checked)
					resultado = porNombre[i].value;
			}

			if (resultado != 4) {

				var url = "modulos/<?php echo $tprint ?>?fini=" + fini + '&ffin=' + ffin + '&op=' + resultado + '&geosem=' + lugar;
				window.open(url);

			} else {

				var url = "modulos/<?php echo $tprinMW ?>?fini=" + fini + '&ffin=' + ffin + '&op=' + resultado + '&geosem=' + lugar;
				window.open(url);
			}
		}

	}


	function reportedgo() {
		var fini = $('#fechaini').val();
		var ffin = $('#fechafin').val();
		//var lugar=$('#idGenGeoSenplades').val();

		//alert(fini);
		if (fini == '' || ffin == '') {
			alert("No ha ingresado datos en fecha de inicio, fin  o no seleccionó un lugar...");
			return false;
		} else {
			var resultado = "";
			var porNombre = document.getElementsByName("forma");
			// Recorremos todos los valores del radio button para encontrar el
			// seleccionado
			for (var i = 0; i < porNombre.length; i++) {
				if (porNombre[i].checked)
					resultado = porNombre[i].value;
			}

			if (resultado != 4) {
				//alert(url);
				var url = "modulos/<?php echo $tprint ?>?fini=" + fini + '&ffin=' + ffin + '&op=' + resultado;

				window.open(url);

			} else {

				var url = "modulos/<?php echo $tprinMW ?>?fini=" + fini + '&ffin=' + ffin + '&op=' + resultado;
				//alert(url);
				window.open(url);
			}
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
</script>