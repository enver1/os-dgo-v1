<?php
include_once '../clases/autoload.php';
$formTipoEjeComisios = new FormTipoEjeComisios;
$TipoEjeComisios     = new TipoEjeComisios;
$idcampo             = $TipoEjeComisios->getIdCampo(); //Primary Key Table
$gridS               = $formTipoEjeComisios->getGrillaTipoEjeComisios(); //Campos de la Grilla
$colBusca            = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas            = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
