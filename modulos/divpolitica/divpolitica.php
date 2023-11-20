<?php
/* Aqui van los parametros a cambiar en cada formulario */
/* path del directorio del modulo */
$directorio='divpolitica';
/* Nombre de la tabla  */
$sNtabla='genDivPolitica';  
/* Select para mostrar los datos en el grid */
$sqltable=urlencode("select a.idGenDivPolitica,a.descripcion,b.descripcion gen_idGenDivPolitica,c.descripcion idGenTipoDivision from genDivPolitica a left outer join genDivPolitica b on  b.idGenDivPolitica=a.gen_idGenDivPolitica left outer join genTipoDivision c on a.idGenTipoDivision=c.idGenTipoDivision order by 3,2,4"); 
/* Es el numero de la columna en que la funcion "buscapagina.php" va realizar la busqueda del contenido */
$colbusqueda=1;
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
