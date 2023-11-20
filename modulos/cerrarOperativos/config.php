<?php
$tabla       = 'hdrEvento'; // ** Nombre de la Tabla
$directorioMantenimiento = __FILE__;
$elementos               = explode('/', $directorioMantenimiento);
$directorioModulo        = $elementos[3] . '/' . $elementos[4] . '/' . $elementos[5];
$directorio              = $directorioModulo; // ** Nombre del directorio donde se encuentra la aplicacion **
/*Colocar los datos a mostrar en la grilla*/
$gridS = array(
    'C&oacute;digo'      => 'CodigoOperativo',
    'Lugar' => 'LugarOperativo',
    'Descripcion'             => 'TipoOperativo',
);
$idcampo                = 'id' . ucfirst($tabla); 	/* contruye el id de la tabla con el estandar del SIIPNE 3w*/
