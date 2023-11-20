<?php
include_once '../clases/autoload.php';
$hdrEveResDis = new HdrEveResDis;
$formulario  = new FormDiscriminacion;
$idcampo     = $hdrEveResDis->getIdCampo(); //Primary Key Table
$gridS       = $formulario->getGrilla(); //Campos de la Grilla
$colBusca    = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas    = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
