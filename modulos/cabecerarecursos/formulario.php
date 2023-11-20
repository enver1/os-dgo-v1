<?php
session_start();
include '../../../funciones/db_connect.inc.php';
include_once('../../../funciones/funcion_select.php');
/*-------------------------------------------------*/
$tgraba='consigna/graba.php'; // *** CAMBIAR *** nombre del php para insertar o actualizar un registro
$Ntabla='hdrConsigna'; // *** CAMBIAR *** Nombre de la Tabla
$directorio='modulos/consigna'; // *** CAMBIAR ***
/*-------------------------------------------------*/
$idcampo=ucfirst($Ntabla); // Nombre del Id de la Tabla
if (isset($_GET['c']))
	{
	$sql="select a.*,b.descripcion lugar, c.descripcion estado from ".$Ntabla." a, genGeoSenplades b, genEstado c where b.idGenGeoSenplades=a.idGenGeoSenplades AND c.idGenEstado=a.idGenEstado AND id".$idcampo."='".$_GET['c']."'";
	$rs=$conn->query($sql);
	$rowt = $rs->fetch(PDO::FETCH_ASSOC);
	}
/*
* Aqui se incluye el formulario de edicion
*/
?>

<script type="text/javascript" src="<?php echo $directorio ?>/validacion.js"></script>
<script>
$(document).ready(function(){
	$('#tpais').tree({
		onClick: function(node){
		var node = $('#tpais').tree('getSelected');
		$('#codSenplades').attr('value',node.id);
		$('#lugar').attr('value',node.text);
		//alert(idGeoSenplades);
		/*var codigoSenplades = node.attributes[2];
		var siglaHijo = node.attributes[1];
		var siglaPadre = node.attributes[0]; 
		var TipoGeoSenplades = node.attributes[3];
				
		$('#paisDesc').attr('value', node.text);
		$('#paisCdg').attr('value', node.id);
				
		$('#siglasParte1').attr('value',siglaHijo);*/
		
		/*if (siglaHijo == siglaPadre)
		{
			siglaPadre=' ';
			$('#siglasParte1').attr('value',siglaPadre); //Padre
 	    	$('#siglasGeoSenplades').attr('value',siglaHijo); //Hijo
			alert(siglaHijo);
		}
		else
		{
			var text = siglaHijo;
			var new_text = text.replace(siglaPadre + "-","");
			var siglaCadena = new_text;
			$('#siglasParte1').attr('value',siglaPadre); //Padre
 	    	$('#siglasGeoSenplades').attr('value',siglaCadena); //Hijo	
		}*/
		//$('#siglasParte1').attr('value',node.attributes[0]); //Padre
	  	//$('#siglasGeoSenplades').attr('value',node.attributes[1]); //Hijo
		
		//$('#codigoSenplades').attr('value',codigoSenplades);
		$("html, body").animate({ scrollTop: 0 }, "slow");
		}
	});
 });
 </script>




<table width="100%" border="0">
<tr><td width="55%">
<form name="edita" id="edita" method="post">
  <table width="100%" border="0">
	<tr>
		<td width="20%">C&oacute;digo:</td>
		<td width="80%">
      <input type="text" name="id<?php echo $idcampo ?>"  readonly="readonly" 
      	value="<?php echo isset($rowt['id'.$idcampo])?$rowt['id'.$idcampo]:'' ?>" />
    </td>
    </tr>
    <tr>
    	<td>Lugar:</td>
		<td><input type="text" name="lugar" readonly="readonly" id="lugar" size="60" value="<?php echo isset($rowt['lugar'])?$rowt['lugar']:'' ?>" /><input type="hidden" name="codSenplades" id="codSenplades" value="<?php echo isset($rowt['idGenGeoSenplades'])?$rowt['idGenGeoSenplades']:'' ?>" /></td>
    </tr>
  <tr>
		<td>Descripci&oacute;n:</td>
		<td>
    	<input type="text" name="descripcion"  size="60" value="<?php echo isset($rowt['descripcionConsigna'])?$rowt['descripcionConsigna']:'' ?>" />
    </td>
	</tr>
  <tr>
		<td>Estado:</td>
		<td> <?php echo generaComboSimple($conn,'genEstado','idGenEstado','descripcion',isset($rowt['idGenEstado'])?$rowt['idGenEstado']:''); ?></td>
	</tr>
  <tr>
		<td>Fecha Inicial:</td>
		<td><input type="text" name="fechaInicio" size="12" value="<?php echo isset($rowt['fechaInicial'])?$rowt['fechaInicial']:'' ?>" readonly="readonly"/>
        <input type="button" value="" onclick="displayCalendar(document.forms[0].fechaInicio,'yyyy-mm-dd',this)" class="calendario"/>
        </td>
	</tr>
    <tr>
		<td>Fecha Caducidad:</td>
		<td><input type="text" name="fechaCaducidad" size="12" value="<?php echo isset($rowt['fechaCaducidad'])?$rowt['fechaCaducidad']:'' ?>" readonly="readonly"/>
        <input type="button" value="" onclick="displayCalendar(document.forms[0].fechaCaducidad,'yyyy-mm-dd',this)" class="calendario"/></td>
	</tr>
     <tr>
		<td>Observación:</td>
		<td><textarea name="observacion"><?php echo isset($rowt['observacion'])?$rowt['observacion']:'' ?></textarea></td>
	</tr>
    
  <tr>
		<td colspan="2" ><hr /><input type="hidden" name="opc" value="<?php echo $_GET['opc'] ?>" /></td>
	</tr>
  </table>
<?php include_once('../../../funciones/botonera.php'); ?>
</form>
</td>
<td width="45%"><div style=" overflow: scroll; height:250px">
		<ul id="tpais" class="easyui-tree" animate="true" style="font-size:10px"
        	url="<?php echo $directorio ?>/tree_unidad_todo.php?id=<?php echo (isset($_GET['id'])?$_GET['id']:0) ?>">
		</ul></div>
</td>
</tr></table>
<?php 
echo 'hola';
?>
