<?Php
/**
 * path del directorio del modulo 
 */
$directorio='unidadesgeoreferencial';
/**
 * Nombre de la tabla 
 */
$sNtabla='genUnidadActividadGA';

/**
 * Para el Id de la tabla convierte la primera letra en mayuscula
 */
$idcampo=ucfirst($sNtabla);
/**
 * Select para mostrar los datos en el grid 
 */
$sqltable = urlencode("SELECT a.idGenUnidadesGeoreferencial, CONCAT((SELECT g.descGestionAdmin FROM genGestionAdmin g WHERE g.idGenGestionAdmin = b.idGenGestionAdmin),' - ',(SELECT t.descGenTipoActividad FROM genTipoActividad t WHERE t.idGenTipoActividad =  b.idGenTipoActividad) ) descTipoActividad, c.descripcion descUnidad
FROM genUnidadesGeoreferencial a, genActividadGA b, genGeoSenplades c WHERE a.idGenActividadGA=b.idGenActividadGA AND a.idGenGeoSenplades=c.idGenGeoSenplades");

/*-----------------------------------------------------------------------------------------------*/
/*  Esta parte se mantiene para todos los modulos */
$tgrid = $directorio.'/grid.php'; // php para mostrar la grid
$tforma = $directorio.'/aplicacion.php'; // php para mostrar el formulario en la parte superior
$tborra = $directorio.'/borra.php'; // php para borrar un registro
$tgraba = $directorio.'/graba.php'; // php para grabar un registro
$tprint = $directorio.'/imprime.php'; // nombre del php que imprime los registros
/*  Fin de configuraciones    */
?>
<div id='formulario'>
    <img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>
<div id='retrieved-data'>
    <img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>
<?php include_once('../js/ajaxuid.php'); // Este archivo contiene las funciones de ajax para update, insert, delete, y edit ?>
