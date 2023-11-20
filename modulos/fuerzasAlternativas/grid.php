<?php
include_once '../clases/autoload.php';

$formFuerzasAlternativas = new FormFuerzasAlternativas;
$fuerzasAlternativas     = new FuerzasAlternativas;
$idcampo           = $fuerzasAlternativas->getIdCampo(); //Primary Key Table
$simple = 0;
$gridS             = $formFuerzasAlternativas->getGrillaFuerzasAlternativas(); //Campos de la Grilla
$colBusca          = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas          = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
