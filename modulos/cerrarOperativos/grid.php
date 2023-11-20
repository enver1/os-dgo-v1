<?php
include_once '../clases/autoload.php';
include_once('config.php');
$colBusca                 = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas                 = count($gridS) + 2; //Numero de columnas + edit y delete
$simple                   = 2;
include_once '../includes/datatablePaginado.php';
