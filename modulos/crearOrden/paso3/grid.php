<?php
include_once '../clases/autoload.php';
$formDgoMisionOrden = new FormDgoMisionOrden;
$DgoMisionOrden     = new DgoMisionOrden;
$idcampo              = $DgoMisionOrden->getIdCampo(); //Primary Key Table
$gridS                = $formDgoMisionOrden->getGrillaDgoMisionOrden(); //Campos de la Grilla
$colBusca             = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas             = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
