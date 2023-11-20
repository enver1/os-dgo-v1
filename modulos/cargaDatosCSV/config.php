<?php

$directorioMantenimiento = __FILE__;
$elementos               = explode('/', $directorioMantenimiento);
$totalElementos          = count($elementos);
//$directorio              = $elementos[$totalElementos - 2];
$directorio = $elementos[$totalElementos - 3] . '/' . $elementos[$totalElementos - 2];
