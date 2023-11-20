<?php
include_once '../clases/autoload.php';
$formTipoOperativoOrden = new FormTipoOperativoOrden;
$TipoOperativoOrden     = new TipoOperativoOrden;
$idcampo    = $TipoOperativoOrden->getIdCampo(); //Primary Key Table
$gridS      = $formTipoOperativoOrden->getGrillaTipoOperativoOrden(); //Campos de la Grilla
$colBusca   = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas   = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
