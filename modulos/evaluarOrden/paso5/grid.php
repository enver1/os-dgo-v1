<?php
include_once '../clases/autoload.php';
$formDgoOportunidadesInforme  = new FormDgoOportunidadesInforme;
$DgoOportunidadesInforme      = new DgoOportunidadesInforme;
$idcampo              = $DgoOportunidadesInforme->getIdCampo(); //Primary Key Table
$gridS                = $formDgoOportunidadesInforme->getGrillaDgoOportunidadesInforme(); //Campos de la Grilla
$colBusca             = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas             = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
