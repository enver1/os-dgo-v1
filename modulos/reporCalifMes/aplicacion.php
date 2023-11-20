<?php
/* Aqui van los parametros a cambiar en cada formulario */
/* path del directorio del modulo */
$directorio = 'reporCalifMes'; // ** CAMBIAR **
/*-----------------------------------------------------------------------------------------------*/
$sqltable = '';
$tgrid = '';
$tborra = '';
$tgraba = '';
$tforma = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
$tprint = $directorio . '/reporte.php';
$tprinMW = $directorio . '/operativosMovilWeb.php'; // ejemplo para jasper
/*  Fin de configuraciones    */
?>
<div id='formulario'>
    <img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>
<?php include_once('js/ajaxuid.php'); // Este archivo contiene las funciones de ajax para update, insert, delete, y edit 
?>
<script type="text/javascript" src="<?php echo 'modulos/' . $directorio ?>/validacion.js"></script>