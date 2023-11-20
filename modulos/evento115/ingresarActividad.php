<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include_once('../../../funciones/db_connect.inc.php');
include_once('../../../funciones/funcion_select.php');

$sql="Select r.nominativo from hdrRecursoEvento h
inner join hdrRecurso r on h.idHdrRecurso = r.idHdrRecurso
where h.idRecursoEvento = {$_GET['idRecursoEvento']}";
$rs=$conn->query($sql);
$rowt = $rs->fetch(PDO::FETCH_ASSOC);
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
	function guardarActividadRecursoEvento(form){
		if(validate_combo(form.idHdrEstadoActividad, 'Estado')){
			if(validate_required(form.descripcionActividad, 'Descripci\xF3n')){
				$.ajax({
					type: "POST",
					url: form.action,
					data: $(form).serialize(),
					success: function(result){
						try{
							var obj = jQuery.parseJSON(result);
							alert(obj.msg);
							if(obj.success){
								form.reset();
								mostrarActividadRecursoEvento(form.idRecursoEvento.value, 'ActividadesId');
							}
						}catch (e) {
							alert(result);
						}
					}
				});
			}
		}
	}
	function mostrarActividadRecursoEvento(eventoRecurso, componente){
		$('#'+componente).html('<p><img src="../../../funciones/paginacion/images/ajax-loader.gif" /></p>');
		$.ajax({
			type: "POST",
			url: 'logica/evento115.php',
			data: {actividadDetalleEventoRecurso:'1',codigo:eventoRecurso},
			success: function(result){
				try{
					$('#'+componente).html(result);
				}catch (e) {
					alert(result);
				}
			}
		});
	}
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
          	<legend>Datos de la Actividad</legend>
          	<form action="logica/evento115.php" method="post">
          		<input type="hidden" name="idRecursoEvento" value="<?php echo $_GET['idRecursoEvento']?>"/>
          		<input type="hidden" name="insertarActividad" value="1"/>
	          	<table width="100%">
				  <tr>
				    <td class="etiqueta">Recurso:</td>
				    <td><label name="Unidad" id="Unidad" style="border:none; background-color:#fff; color:#006; font-size:11px;font-weight:bold;height:auto"><?php echo $rowt['nominativo']?></label></td>
				  </tr>
				  <tr>
				  	<td class="etiqueta">Descripci&oacute;n:</td>
				    <td><textarea rows="3" cols="40" name="descripcionActividad"></textarea></td>
				  </tr>
				  <tr>
			      	<td class="etiqueta">Estado:</td>
			        <td> <?php echo generaComboSimple($conn, 'hdrEstadoActividad', 'idHdrEstadoActividad', 'descripcion', ''); ?></td>
			      </tr>
				  <tr>
				  	<td>&nbsp;</td>
				  	<td>
				  		<button type="button" onclick="this.form.reset();" style="float: left;" class="boton_save">Nuevo</button>
				  		<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
				  		<button type="button" onclick="guardarActividadRecursoEvento(this.form)" style="float: left;" class="boton_save">Guardar</button>
				  	</td>
				  </tr>
				</table>
			</form>
          </fieldset>
          <div id="ActividadesId"></div>
</div>
<div id="content_bot"></div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
	mostrarActividadRecursoEvento('<?php echo $_GET['idRecursoEvento'] ?>', 'ActividadesId');
</script>
</body>
</html>