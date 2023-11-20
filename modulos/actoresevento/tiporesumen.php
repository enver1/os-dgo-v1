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
/**
 * eliminar registro
 */
function delregistroTipo(id){
	if(confirm('Confirmar','Desea eliminar el registro')){
		$.ajax({
			type: "GET",
			url: "borratiporesumen.php?id=" + id,
			success: function(result){
				targetURL = 'tipo_resumen.php?idHdrGrupResum=<?php echo $_GET['idHdrGrupResum']; ?>';
				$('#retrieved-data-tipo').load( targetURL ).hide().fadeIn('slow');
			}
		});
	}
}
</script>
</head>
<body style="background-color:#fff">
<div id="wraper">
  <div id="top">
    <div id="faux">
      <div id="content">
        <div id="content_top"></div>
        <div id="content_mid">
          <div id="contenido">
          <?php 
          if(isset($_GET['idHdrTipoResum'])){
          	$sql="SELECT idHdrTipoResum, desHdrTipoResum FROM hdrTipoResum WHERE idHdrTipoResum = {$_GET['idHdrTipoResum']}";
			$rs=$conn->query($sql);
			$rowt = $rs->fetch(PDO::FETCH_ASSOC);
          }
          ?>
          
          
			<form action="grabatiporesumen.php" method="post" id="frmTipoResumen">
	<table width="100%" align="left">
	  <tr>
	    <td class="etiqueta">C&oacute;digo:</td>
	    <td>
	    	<input type="text" name="idHdrTipoResum" readonly="readonly" value="<?php echo isset($rowt['idHdrTipoResum'])?$rowt['idHdrTipoResum']:''?>" class="inputSombra" style="width:80px"/>
	    </td>
	  </tr>
	  <tr>
	    <td class="etiqueta">Descripci&oacute;n:</td>
	    <td>
	    	<input type="text" name="desHdrTipoResum" value="<?php echo isset($rowt['desHdrTipoResum'])?$rowt['desHdrTipoResum']:''?>" class="inputSombra"  style="width:320px"/>
	    	<input type="hidden" name="idHdrGrupResum" value="<?php echo $_GET['idHdrGrupResum']; ?>"/>
	    </td>
	  </tr>
	</table>
	<table width="100%" align="left">
	  <tr>
	    	<td></td>
	    	<td  colspan="2" align="center"><input type="submit" value="Enviar" class="boton_save"></td>
	        <td colspan="2" align="center">
	        	<a href="tiporesumen.php?idHdrGrupResum=<?php echo $_GET['idHdrGrupResum']; ?>" class="button" style="width:100px"><span>Nuevo</span></a>
	        </td>
	    </tr>
	</table>
	
</form>

<div id='retrieved-data-tipo'>
	<img src="../../../funciones/paginacion/images/ajax-loader.gif" />
</div>
<script type="text/javascript">
	targetURL = 'tipo_resumen.php?idHdrGrupResum=<?php echo $_GET['idHdrGrupResum']; ?>';
	$('#retrieved-data-tipo').load( targetURL ).hide().fadeIn('slow');
</script>

</div>
<div id="content_bot"></div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>