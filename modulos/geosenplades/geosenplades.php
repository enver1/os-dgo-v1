<?php
/* Aqui van los parametros a cambiar en cada formulario */
/* path del directorio del modulo */
$directorio = 'geosenplades';
/* Nombre de la tabla  */
$sNtabla = 'genGeoSenplades';
/* Select para mostrar los datos en el grid */
$sqltable = urlencode("select a.idGenGeoSenplades,a.descripcion,b.descripcion gen_idGenGeoSenplades,c.descripcion idGenTipoGeoSenplades, a.siglasGeoSenplades siglasGeoSenplades, a.codigoSenplades codigoSenplades from genGeoSenplades a left outer join genGeoSenplades b on b.idGenGeoSenplades=a.gen_idGenGeoSenplades left outer join genTipoGeoSenplades c on a.idGenTipoGeoSenplades=c.idGenTipoGeoSenplades order by 3,2,4,5,6 ");
/* Es el numero de la columna en que la funcion "buscapagina.php" va realizar la busqueda del contenido */
$colbusqueda = 1;
/*  Esta parte se mantiene para todos los modulos */
$tgrid = $directorio . '/grid.php'; // php para mostrar la grid
$tforma = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
$tborra = $directorio . '/borra.php'; // php para borrar un registro
$tgraba = $directorio . '/graba.php'; // php para grabar un registro
$tprint = $directorio . '/imprime.php'; // nombre del php que imprime los registros
/*  Fin de configuraciones    */
?>

<div id='formulario'>
    <img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>
<div id='retrieved-data'>
    <img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>
<?php include_once('../js/ajaxuid.php'); // Este archivo contiene las funciones de ajax para update, insert, delete, y edit 
?>