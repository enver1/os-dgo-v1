<?php
include_once '../clases/autoload.php';
$formTipoAspectoCg = new FormTipoAspectoCg;
$tipoAspectoCg     = new TipoAspectoCg;
$idcampo    = $tipoAspectoCg->getIdCampo(); //Primary Key Table
$gridS      = $formTipoAspectoCg->getGrillaTipoAspectoCg(); //Campos de la Grilla
$colBusca   = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas   = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
