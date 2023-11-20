<?php
/* Aqui van los parametros a cambiar en cada formulario */
/* path del directorio del modulo */
$directorio = 'color'; // ** CAMBIAR **


/* Nombre de la tabla  */
$sNtabla = 'genColor'; // ** CAMBIAR **
/*---------------------------------------------*/
/* Para el Id de la tabla convierte la primera letra en mayuscula*/
$idcampo = ucfirst($sNtabla);
/* Select para mostrar los datos en el grid */
/*-----------------** CAMBIAR **-----------------------------------------------------------------*/
$sqltable = urlencode("select a.id" . $idcampo . ",a.descripcion from " . $sNtabla . " a order by 2");
/*-----------------------------------------------------------------------------------------------*/
/*  Esta parte se mantiene para todos los modulos */
$tgrid = $directorio . '/grid.php'; // php para mostrar la grid
$tforma = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
$tborra = $directorio . '/borra.php'; // php para borrar un registro
$tgraba = $directorio . '/graba.php'; // php para grabar un registro
$tprint = $directorio . '/imprime.php'; // nombre del php que imprime los registros
/*  Fin de configuraciones    */
?>
<script type="text/javascript" src="modulos/color/validacion.js"></script>
<div id='formulario'>
    <img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>
<div id='retrieved-data'>
    <img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>
<?php include_once('../js/ajaxuid.php'); // Este archivo contiene las funciones de ajax para update, insert, delete, y edit 
?>