<?php
include_once '../clases/autoload.php';
$formDgoInstruccionesOrden  = new FormDgoInstruccionesOrden;
$dgoInstruccionesOrden      = new DgoInstruccionesOrden;
$idcampo              = $dgoInstruccionesOrden->getIdCampo(); //Primary Key Table
$gridS                = $formDgoInstruccionesOrden->getGrillaDgoInstruccionesOrden(); //Campos de la Grilla
$colBusca             = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas             = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
