<?php
include_once '../clases/autoload.php';
$formTipoTipificacion = new FormTipoTipificacion;
$TipoTipificacion     = new TipoTipificacion;
$idcampo              = $TipoTipificacion->getIdCampo(); //Primary Key Table
$gridS                = $formTipoTipificacion->getGrillaTipoTipificacion(); //Campos de la Grilla
$colBusca             = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas             = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
