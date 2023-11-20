<?php
include_once '../clases/autoload.php';
$ambitoGestionAppCg = new AmbitoGestionAppCg;
$formAmbitoGestionAppCg     = new FormAmbitoGestionAppCg;
$idcampo              = $ambitoGestionAppCg->getIdCampo(); //Primary Key Table
$gridS                = $formAmbitoGestionAppCg->getGrillaAmbitoGestionAppCg(); //Campos de la Grilla
$colBusca             = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas             = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
