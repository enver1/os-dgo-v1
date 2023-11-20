<?php
/* Aqui van los parametros a cambiar en cada formulario */
/* path del directorio del modulo */
$directorio='vehiculos'; // ** CAMBIAR **
/* Nombre de la tabla  */
$sNtabla='hdrVehiculo'; // ** CAMBIAR **
/*---------------------------------------------*/
/* Para el Id de la tabla convierte la primera letra en mayuscula*/
$idcampo=ucfirst($sNtabla);
$sqgrid=sha1('vehiculos');
/* Select para mostrar los datos en el grid */
/*-----------------** CAMBIAR **-----------------------------------------------------------------*/
$sqltable=urlencode("select a.idHdrVehiculo,b.descripcion tipo,c.descripcion marca,d.descripcion modelo,placa,a.idDgpUnidad,concat(e.nomenclatura,' (',e.descripcion,')') unidad
from hdrVehiculo a
left outer join hdrTipoVehiculo b on a.idHdrTipoVehiculo=b.idHdrTipoVehiculo
left outer join hdrModelo       d on a.idHdrModelo=d.idHdrModelo
left outer join hdrMarca        c on d.idHdrMarca=c.idHdrMarca
left outer join dgpUnidad       e on a.idDgpUnidad=e.idDgpUnidad
order by placa"); 
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
