<?php
include_once '../clases/autoload.php';
$formDgoEjemplarInforme = new FormDgoEjemplarInforme;
$DgoEjemplarInforme     = new DgoEjemplarInforme;
$idcampo              = $DgoEjemplarInforme->getIdCampo(); //Primary Key Table
$gridS                = $formDgoEjemplarInforme->getGrillaDgoEjemplarInforme(); //Campos de la Grilla
$colBusca             = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas             = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
