<?php
include_once '../clases/autoload.php';
$formDgoEvaluacionInf  = new FormDgoEvaluacionInf;
$DgoEvaluacionInf      = new DgoEvaluacionInf;
$idcampo              = $DgoEvaluacionInf->getIdCampo(); //Primary Key Table
$gridS                = $formDgoEvaluacionInf->getGrillaDgoEvaluacionInf(); //Campos de la Grilla
$colBusca             = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas             = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
