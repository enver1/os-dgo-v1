<?php
include_once '../clases/autoload.php';
$formDgoEjemplarOrden = new FormDgoEjemplarOrden;
$DgoEjemplarOrden     = new DgoEjemplarOrden;
$idcampo              = $DgoEjemplarOrden->getIdCampo(); //Primary Key Table
$gridS                = $formDgoEjemplarOrden->getGrillaDgoEjemplarOrden(); //Campos de la Grilla
$colBusca             = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas             = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
