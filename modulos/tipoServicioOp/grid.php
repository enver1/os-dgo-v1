<?php
include_once '../clases/autoload.php';
$formTipoServicioOp = new FormTipoServicioOp;
$TipoServicioOp     = new TipoServicioOp;
$idcampo            = $TipoServicioOp->getIdCampoTipoServicioOp(); //Primary Key Table
$gridS              = $formTipoServicioOp->getGrillaTipoServicioOp(); //Campos de la Grilla
$colBusca           = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas           = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/resultado.php';
