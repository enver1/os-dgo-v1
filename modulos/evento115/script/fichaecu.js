/**
 * generar los combos de tipificación
 * @param url string pagina que debe ejecutarse
 * @param data array datos que deben ejecutarse
 * @param componente object componente que debe agregarse los resultados
 */
function getComboTipificacion(url, data, componente){
	$(componente).find('option').remove();
	$(componente).append("<option value=''>Seleccione...</option>");
	$.ajax({
		type: "POST",
		url: url,
		data: data,
		success: function(result){
			try{
				var obj = jQuery.parseJSON(result);
				for(var i= 0; i < obj.length;i++){
					  var o = obj[i];
					  $(componente).append("<option value='"+o.codigo+"'>"+ o.descripcion +"</option>");
				}
			}catch (e) {
				alert(result);
			}
		}
	});
}

function getComboTipificacionSelect(url, data, componente, valor){
	$(componente).find('option').remove();
	$(componente).append("<option value=''>Seleccione...</option>");
	$.ajax({
		type: "POST",
		url: url,
		data: data,
		success: function(result){
			try{
				var obj = jQuery.parseJSON(result);
				for(var i= 0; i < obj.length;i++){
					  var o = obj[i];
					  $(componente).append("<option value='"+o.codigo+"'>"+ o.descripcion +"</option>");
				}
				$(componente).val(valor);
			}catch (e) {
				alert(result);
			}
		}
	});
}

/**
 * generar los combos de resumen
 * @param url string pagina que debe ejecutarse
 * @param data array datos que deben ejecutarse
 * @param componente object componente que debe agregarse los resultados
 */
function getComboResumen(url, data, componente, id){
	$(componente).find('option').remove();
	$(componente).append("<option value=''>Seleccione...</option>");
	$.ajax({
		type: "POST",
		url: url,
		data: data,
		success: function(result){
			try{
				$('.fichaSel').removeClass( "fichaSel" ).addClass( "ficha" );
				$('#'+id).removeClass( "ficha" ).addClass( "fichaSel" );
				var obj = jQuery.parseJSON(result);
				for(var i= 0; i < obj.length;i++){
					  var o = obj[i];
					  $(componente).append("<option value='"+o.codigo+"'>"+ o.descripcion +"</option>");
				}
			}catch (e) {
				alert(result);
			}
		}
	});
}

/**
 * generar los combos de geosemplades
 * @param url string pagina que debe ejecutarse
 * @param data array datos que deben ejecutarse
 * @param componente object componente que debe agregarse los resultados
 */
function getComboGeosemplades(url, data, componente){
	$(componente).find('option').remove();
	$(componente).append("<option value=''>Seleccione...</option>");
	$.ajax({
		type: "POST",
		url: url,
		data: data,
		success: function(result){
			try{
				var obj = jQuery.parseJSON(result);
				for(var i= 0; i < obj.length;i++){
					  var o = obj[i];
					  $(componente).append("<option value='"+o.codigo+"'>"+ o.descripcion +"</option>");
				}
			}catch (e) {
				alert(result);
			}
		}
	});
}

function getComboGeosempladesSelect(url, data, componente, valor){
	$(componente).find('option').remove();
	$(componente).append("<option value=''>Seleccione...</option>");
	$.ajax({
		type: "POST",
		url: url,
		data: data,
		success: function(result){
			try{
				var obj = jQuery.parseJSON(result);
				for(var i= 0; i < obj.length;i++){
					  var o = obj[i];
					  $(componente).append("<option value='"+o.codigo+"'>"+ o.descripcion +"</option>");
				}
				$(componente).val(valor);
			}catch (e) {
				alert(result);
			}
		}
	});
}
/**
 * eliminar listas
 * @param componente
 */
function removerlistas(componente){
	$(componente).find('option').remove();
	$(componente).append("<option value=''>Seleccione...</option>");
}
/**
 * validar que escriba solo numeros
 * @param e
 * @returns
 */
function justNumbers(e)
{
	var keynum = window.event ? window.event.keyCode : e.which;
	if ((keynum == 8) || (keynum == 46))
		return true;
	return /\d/.test(String.fromCharCode(keynum));
}

/**
 * ingresar información detalla del evento
 * @param form
 */
function guardarDetalle(form){
	if(validate_combo(form.SubResumenId, 'Par\xE1metro')){
		if(form.txtcantidad.value.length > 0){
			if(validate_required(form.txtdescripcion,'Descripci\xF3n')){
				$.ajax({
					type: "POST",
					url: form.action,
					data: $(form).serialize(),
					success: function(result){
						try{
							var obj = jQuery.parseJSON(result);
							if(obj.success){
								form.SubResumenId.value = '';
								form.txtcantidad.value = '';
								form.txtdescripcion.value = '';
								getdata(form.idHdrEvento.value);
							}
							alert(obj.msg);
						}catch (e) {
							alert(result);
						}
					}
				});
			}
		}else{
			alert('Cantidad no puede estar en blanco');
		}
	}
}
function eliminarAsignacionrecurso(codigo, codigoEvento){
	if(confirm('Desea cancelar el despacho?')){
		$.ajax({
			type: "POST",
			url: 'modulos/evento115/logica/evento115.php',
			data: {recurso: codigo, eliminarRecurso: '1'},
			success: function(result){
				try{
					var obj = jQuery.parseJSON(result);
					if(obj.success){
						getdataDespacho(codigoEvento);
					}
					alert(obj.msg);
				}catch (e) {
					alert(result);
				}
			}
		});
	}
}

function eliminarEventoDetalle(codigo, codigoEvento){
	if(confirm('Desea eliminar la actividad?')){
		$.ajax({
			type: "POST",
			url: 'modulos/evento115/logica/evento115.php',
			data: {detalle: codigo, eliminarDetalle: '1'},
			success: function(result){
				try{
					var obj = jQuery.parseJSON(result);
					if(obj.success){
						getdata(codigoEvento);
					}
					alert(obj.msg);
				}catch (e) {
					alert(result);
				}
			}
		});
	}
}

function guardarRegistro(form){
		$.ajax({
			type: "POST",
			url: form.action,
			data: $(form).serialize(),
			success: function(result){
				try{
					var obj = jQuery.parseJSON(result);
					alert(obj.msg);
				}catch (e) {
					alert(result);
				}
			}
		});
}

function guardarRegistroResumenFinal(form){
	$.ajax({
		type: "POST",
		url: form.action,
		data: $(form).serialize(),
		success: function(result){
			try{
				var obj = jQuery.parseJSON(result);
				alert(obj.msg);
			}catch (e) {
				alert(result);
			}
		}
	});
}

function finalizarFichaEcu(form){
	if(confirm('Luego de finalizar no podra realizar cambios \r\n Esta seguro de realizar esta accion?')){
		$.ajax({
			type: "POST",
			url: form.action,
			data: $(form).serialize(),
			success: function(result){
				console.log(result);
				try{
					var obj = jQuery.parseJSON(result);
					alert(obj.msg);
					if(obj.success){
						MostrarListadoFichas();
					}
				}catch (e) {
					alert(result);
				}
			}
		});
	}
}

/**
 * validar combos
 * @param field
 * @param alerttxt
 * @returns {Boolean}
 */
function validate_combo(field, alerttxt)
{
	
with (field)
  {
  if (value=="0" || value=="" || value==" ")
    {
    alert('Seleccione un valor en el campo '+alerttxt);return false;
    }
  else
    {
	    return true;
    }
  }
}
/**
 * validar cajas de texto
 * @param field
 * @param alerttxt
 * @returns {Boolean}
 */
function validate_required(field,alerttxt)
{
with (field)
  {
  if (value==null||value=="")
    {
    alert(alerttxt+' no puede estar en blanco');return false;
    }
  else
    {
		if(value.length<3)
		{
			alert(alerttxt+' debe tener al menos 3 caracteres');return false;
			}
		else
		{
		    return true;
		}
    }
  }
}

/**
 * obtener los datos de la grilla
 */
function getdata(codigoEvento){
	var targetURL = 'modulos/evento115/eventodetalle.php?codigoEvento='+codigoEvento;
	$('#retrieved-data').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');        
	if(targetURL != ''){
		$('#retrieved-data').load( targetURL );
	}
}

/**
 * obtener los datos de la grilla
 */
function getdataDespacho(codigoEvento){
	var targetURL = 'modulos/evento115/eventodespacho.php?codigoEvento='+codigoEvento;
	$('#DespachosEventoId').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');        
	if(targetURL != ''){
		$('#DespachosEventoId').load( targetURL );
	}
}