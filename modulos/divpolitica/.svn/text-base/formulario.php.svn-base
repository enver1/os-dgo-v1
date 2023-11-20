<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include '../../../funciones/db_connect.inc.php';
include_once('../../../funciones/funcion_select.php');
$tgraba='divpolitica/graba.php'; // nombre del php para insertar o actualizar un registro
$Ntabla='genDivPolitica';
$idcampo=ucfirst($Ntabla);
$directorio='modulos/divpolitica';
if (isset($_GET['c']))
	{
		$sql="select a.*,b.descripcion padre from ".$Ntabla." a left outer join genDivPolitica b on b.idGenDivPolitica=a.gen_idGenDivPolitica 
		where a.id".$idcampo."='".$_GET['c']."'";
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
		//alert(node.id);
		$('#paisDesc').attr('value', node.text);
		$('#paisCdg').attr('value', node.id);
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
		<td>Descripci&oacute;n:</td>
		<td>
    	<input type="text" name="descripcion"  size="60" value="<?php echo isset($rowt['descripcion'])?$rowt['descripcion']:'' ?>" />
    </td>
	</tr>
  <tr>
		<td>Division Politica:</td>
		<td>
      <input type="text" readonly="readonly" size="5" name="paisCdg" id="paisCdg"
        value="<?php echo isset($rowt['gen_idGenDivPolitica'])?$rowt['gen_idGenDivPolitica']:'' ?>" />
      <input type="text" id="paisDesc" name="paisDesc" value="<?php echo isset($rowt['padre'])?$rowt['padre']:'' ?>"  size="48"/>->
    </td>
	</tr>
  <tr>
		<td>Tipo Division:</td>
		<td>
			<?php echo generaComboSimple($conn,'genTipoDivision','idGenTipoDivision','descripcion',isset($rowt['idGenTipoDivision'])?$rowt['idGenTipoDivision']:''); ?></td>
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