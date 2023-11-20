<?php
include_once '../clases/autoload.php';
$formRecintoElectoral = new FormRecintoElectoral;
$RecintoElectoral     = new RecintoElectoral;
$idcampo              = $RecintoElectoral->getIdCampoRecintoElectoral(); //Primary Key Table
$gridS                = $formRecintoElectoral->getGrillaRecintoElectoral(); //Campos de la Grilla
$colBusca             = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas             = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
