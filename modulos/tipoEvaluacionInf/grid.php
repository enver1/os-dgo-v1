<?php
include_once '../clases/autoload.php';

$formDgoTipoEvaluacionInf = new FormDgoTipoEvaluacionInf;
$dgoTipoEvaluacionInf     = new DgoTipoEvaluacionInf;
$idcampo           = $dgoTipoEvaluacionInf->getIdCampo(); //Primary Key Table
$simple = 0;
$gridS             = $formDgoTipoEvaluacionInf->getGrillaDgoTipoEvaluacionInf(); //Campos de la Grilla
$colBusca          = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas          = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
