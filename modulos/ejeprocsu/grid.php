<?php
include_once '../clases/autoload.php';
include_once('config.php');
$colBusca                 = 2; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas                 = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
