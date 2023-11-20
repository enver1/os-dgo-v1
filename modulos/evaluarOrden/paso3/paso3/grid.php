<?php
include_once '../clases/autoload.php';
$formDgoOperacionesInforme = new FormDgoOperacionesInforme;
$DgoOperacionesInforme     = new DgoOperacionesInforme;
$idcampo              = $DgoOperacionesInforme->getIdCampo(); //Primary Key Table
$gridS                = $formDgoOperacionesInforme->getGrillaDgoOperacionesInforme(); //Campos de la Grilla
$colBusca             = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas             = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
