<?php
include_once '../clases/autoload.php';
$formDgoAnexosInforme = new FormDgoAnexosInforme;
$DgoAnexosInforme     = new DgoAnexosInforme;
$idcampo              = $DgoAnexosInforme->getIdCampo(); //Primary Key Table
$gridS                = $formDgoAnexosInforme->getGrillaDgoAnexosInforme(); //Campos de la Grilla
$colBusca             = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas             = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
