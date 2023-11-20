<?php
if(isset($_SESSION ['usuarioAuditar'])){
	include_once 'config.php';
	include_once '../clases/autoload.php';
	$TipoTipificacion = new TipoTipificacion();
	$encriptar = new Encriptar();
	
	$sqltable = $encriptar->getEncriptar($TipoTipificacion->getSqlTipoTipificacion(), $_SESSION ['usuarioAuditar']);

	$tgrid = $directorio . '/grid.php'; // php para mostrar la grid
	$tforma = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
	$tborra = $directorio . '/borra.php'; // php para borrar un registro
	$tgraba = $directorio . '/graba.php'; // php para grabar un registro
	$tprint = $directorio . '/imprime.php'; // nombre del php que imprime los registros
	?>
<div id='formulario'>
	<img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>
<?php

include_once '../js/ajaxuidGenerico.php'; // Este archivo contiene las funciones de ajax para update, insert, delete, y edit
} else{
	header('Location: imprime.php');
}
?>
<script type="text/javascript"
	src="<?php echo '../' . $directorio ?>/validacionR.js">
</script>
