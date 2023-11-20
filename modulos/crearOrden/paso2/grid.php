<?php
include_once '../clases/autoload.php';
$formDgoAntecedentesOrden = new FormDgoAntecedentesOrden;
$dgoAntecedentesOrden     = new DgoAntecedentesOrden;
$idcampo              = $dgoAntecedentesOrden->getIdCampo(); //Primary Key Table
$gridS                = $formDgoAntecedentesOrden->getGrillaDgoAntecedentesOrden(); //Campos de la Grilla
$colBusca             = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas             = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
