<?php
include_once '../clases/autoload.php';
$formTipoResumen = new FormTipoResumen;
$TipoResumen     = new TipoResumen;
$idcampo         = $TipoResumen->getIdCampo(); //Primary Key Table
$gridS           = $formTipoResumen->getGrillaTipoResumen(); //Campos de la Grilla
$colBusca        = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas        = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
