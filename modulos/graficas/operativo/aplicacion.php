<?php
error_reporting(1);
/* Aqui van los parametros a cambiar en cada formulario */
/* path del directorio del modulo */
$directorio = 'graficas/operativo'; // ** CAMBIAR **
/*-----------------------------------------------------------------------------------------------*/
$sqltable = "";
$tgraba = "";
$tborra = "";
$timprime = "";
$tforma = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
$tprint = $directorio . '/reporte.php';
$tprinMW = $directorio . '/operativosMovilWeb.php'; // ejemplo para jasper
/*  Fin de configuraciones    */
?>
<div id='formulario'>
    <img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>
<?php include_once('js/ajaxuid.php');
include('validacion.php'); // Este archivo contiene las funciones de ajax para update, insert, delete, y edit 
?>