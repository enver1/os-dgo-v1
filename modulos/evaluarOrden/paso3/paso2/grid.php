<?php
include_once '../clases/autoload.php';
$formDgoMediosLogisticosInf = new FormDgoMediosLogisticosInf;
$DgoMediosLogisticosInf     = new DgoMediosLogisticosInf;
$idcampo              = $DgoMediosLogisticosInf->getIdCampo(); //Primary Key Table
$gridS                = $formDgoMediosLogisticosInf->getGrillaDgoMediosLogisticosInf(); //Campos de la Grilla
$colBusca             = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas             = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
