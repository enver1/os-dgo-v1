<?php
/* Aqui van los parametros a cambiar en cada formulario */
/* path del directorio del modulo */
$directorio='funcion'; // ** CAMBIAR **
/* Nombre de la tabla  */
$sNtabla='hdrFuncion'; // ** CAMBIAR **
/*---------------------------------------------*/
/* Para el Id de la tabla convierte la primera letra en mayuscula*/
$idcampo=ucfirst($sNtabla);
/* Select para mostrar los datos en el grid*/
/*-----------------** CAMBIAR **-----------------------------------------------------------------*/
$sqltable=urlencode("select a.idHdrFuncion,a.descripcion,b.descripcion idGenEstado from hdrFuncion a,genEstado b where a.idGenEstado=b.idGenEstado "); 
/*-----------------------------------------------------------------------------------------------*/
/*  Esta parte se mantiene para todos los modulos */
$tgrid=$directorio.'/grid.php'; // php para mostrar la grid
$tforma=$directorio.'/formulario.php'; // php para mostrar el formulario en la parte superior
$tborra=$directorio.'/borra.php'; // php para borrar un registro
$tgraba=$directorio.'/graba.php'; // php para grabar un registro
$tprint=$directorio.'/imprime.php'; // nombre del php que imprime los registros
/*  Fin de configuraciones    */
?>
<div id='formulario'>
    <img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>
<div id='retrieved-data'>
    <img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>
<?php include_once('../js/ajaxuid.php'); // Este archivo contiene las funciones de ajax para update, insert, delete, y edit ?>
