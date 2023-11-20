<?php
$directorioMantenimiento = __FILE__;
$elementos               = explode('/', $directorioMantenimiento);
$directorioModulo        = $elementos[3] . '/' . $elementos[4] . '/' . $elementos[5] . '/' . $elementos[6];
$directorio              = $directorioModulo; // ** Nombre del directorio donde se encuentra la aplicacion **
$tabla                   = 'dgoReciElect'; // ** Nombre de la Tabla
$directorioC             = '../' . $directorio;
