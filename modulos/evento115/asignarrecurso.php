<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include_once('../../../funciones/db_connect.inc.php');
include_once('../../../funciones/funcion_select.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SIIPNE 3w OPERACIONES</title>
<link href="../../../css/easyui.css" rel="stylesheet" type="text/css" />
<link href="../../../css/siipne3.css" rel="stylesheet" type="text/css" />
<link href="../../../css/menu.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="../../../js/jquery.easyui.min.js"></script>
<script type="text/javascript">
	function buscarRecursoAsignar(form){
		$('#resultBuscrecursoId').html('<p><img src="../../../funciones/paginacion/images/ajax-loader.gif" /></p>');
		$.ajax({
			type: "POST",
			url: form.action,
			data: $(form).serialize(),
			success: function(result){
				try{
					$('#resultBuscrecursoId').html(result);
				}catch (e) {
					alert(result);
				}
			}
		});
	}
	function seleccionarRecurso(codigo, nominativo){
		$('#AsigCodigoId').val(codigo);
		$('#AsigDescripcionid').val(nominativo);
	}
	function testForEnter(form) 
	{    
		if (event.keyCode == 13) 
		{        
			event.cancelBubble = true;
			event.returnValue = false;

			buscarRecursoAsignar(form);
	    }
	}
	function guardarAsignacionRecurso(form)
	{
		$.ajax({
			type: "POST",
			url: form.action,
			data: $(form).serialize(),
			success: function(result){
				try{
					var obj = jQuery.parseJSON(result);
					alert(obj.msg);
					if(obj.success){
						parent.parent.getdataDespacho(form.idHdrEvento.value);
						parent.parent.GB_hide();
					}
				}catch (e) {
					alert(result);
				}
			}
		});
	}
</script>
</head>
<body >
<div id="wraper">
  <div id="top">
    <div id="faux">
      <div id="content">
        <div id="content_top"></div>
        <div id="content_mid">
          <div id="contenido">
          <fieldset>
          	<legend>Datos del Recurso</legend>
          	<form action="logica/evento115.php" method="post">
          		<input type="hidden" name="idHdrEvento" value="<?php echo $_GET['idHdrEvento']?>"/>
          		<input type="hidden" name="guardarAsignacion" value="1"/>
	          	<table width="100%">
	          	  <tr>
				    <td class="etiqueta">C&oacute;digo</td>
				    <td><input type="text" readonly="readonly" name="AsigCodigoId" id="AsigCodigoId"></td>
				  </tr>
				  <tr>
				    <td class="etiqueta">Recurso</td>
				    <td><input type="text" readonly="readonly" name="AsigDescripcionid" id="AsigDescripcionid"></td>
				  </tr>
				  <tr>
				  	<td class="etiqueta">Descripci&oacute;n</td>
				    <td><textarea rows="3" cols="40" name="DescripcionAsignacion"></textarea></td>
				  </tr>
				  <tr>
				  	<td colspan="2">
				  		<button type="button" onclick="guardarAsignacionRecurso(this.form)"  class="boton_save">Guardar</button>
				  	</td>
				  </tr>
				</table>
			</form>
          </fieldset>
          <fieldset>
          	<legend>Buscar Recurso</legend>
          	<form action="logica/evento115.php" method="post">
	          	<table>
					<tr>
						<td class="etiqueta">Nominativo</td>
						<td><input type="text" name="txtbuscarRecurso" class="inputSombra" onkeydown="testForEnter(this.form);" ></td>
						<td>
					  		<button type="button" class="boton_general" onclick="buscarRecursoAsignar(this.form)">Enviar</button>
					  	</td>
					</tr>
				</table>
			</form>
			<div id="resultBuscrecursoId"></div>
          </fieldset>
</div>
<div id="content_bot"></div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>