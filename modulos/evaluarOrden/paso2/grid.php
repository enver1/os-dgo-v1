<?php
include_once '../clases/autoload.php';
$formDgoAntecedentesInforme = new FormDgoAntecedentesInforme;
$DgoAntecedentesInforme     = new DgoAntecedentesInforme;
$idcampo              = $DgoAntecedentesInforme->getIdCampo(); //Primary Key Table
$gridS                = $formDgoAntecedentesInforme->getGrillaDgoAntecedentesInforme(); //Campos de la Grilla
$colBusca             = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas             = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
