<?php
$directorio = 'notasCursantes';

$tforma   = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
$tprint   = $directorio . '/reporte.php';
$tprinMW  = $directorio . '/operativosMovilWeb.php'; // ejemplo para jasper
$sqltable = '';
$tgrid    = '';
$tborra   = '';
$tgraba   = '';

?>
<div id='formulario'>
  <img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>
<?php include_once 'js/ajaxuid.php'; // Este archivo contiene las funciones de ajax para update, insert, delete, y edit 
?>