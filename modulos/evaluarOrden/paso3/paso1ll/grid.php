<?php
include_once '../clases/autoload.php';
$formDgoTalentoHumano = new FormDgoTalentoHumano;
$dgoTalentoHumanoOrden     = new DgoTalentoHumanoOrden;
$idcampo              = $dgoTalentoHumanoOrden->getIdCampo(); //Primary Key Table
$gridS                = $formDgoTalentoHumano->getGrillaDgoTalentoHumano(); //Campos de la Grilla
$colBusca             = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas             = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
