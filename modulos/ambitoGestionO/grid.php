<?php
include_once '../clases/autoload.php';
$ambitoGestionOrden = new AmbitoGestionOrden;
$formAmbitoGestionOrden     = new FormAmbitoGestionOrden;
$idcampo              = $ambitoGestionOrden->getIdCampo(); //Primary Key Table
$gridS                = $formAmbitoGestionOrden->getGrillaAmbitoGestionOrden(); //Campos de la Grilla
$colBusca             = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas             = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
