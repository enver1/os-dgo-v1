<?php
//include_once "../clases/autoload.php";
$directorio = 'notasCursantes';
$sqltable = '';
$tgrid    = '';
$tborra   = '';
$tgraba   = '';
$tforma   = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
$tprint   = $directorio . '/reporte.php';
$tprinMW  = $directorio . '/operativosMovilWeb.php'; // ejemplo para jasper


?>
<div id='formulario'>
  <img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>
<?php include_once 'js/ajaxuid.php'; // Este archivo contiene las funciones de ajax para update, insert, delete, y edit 
?>
<script type="text/javascript" src="<?php echo 'modulos/' . $directorio ?>/funciones.js"></script>