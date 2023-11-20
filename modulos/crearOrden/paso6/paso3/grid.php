<?php
include_once '../clases/autoload.php';
$formDgoMediosLogisticos = new FormDgoMediosLogisticos;
$dgoMediosLogisticos     = new DgoMediosLogisticos;
$idcampo              = $dgoMediosLogisticos->getIdCampo(); //Primary Key Table
$gridS                = $formDgoMediosLogisticos->getGrillaDgoMediosLogisticos(); //Campos de la Grilla
$colBusca             = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas             = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
