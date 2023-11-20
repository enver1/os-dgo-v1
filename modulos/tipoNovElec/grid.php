<?php
include_once '../clases/autoload.php';
$formNovedadesElect = new FormNovedadesElect;
$NovedadesElect     = new NovedadesElect;
$idcampo           = $NovedadesElect->getIdCampo(); //Primary Key Table
$gridS             = $formNovedadesElect->getGrillaNovedadesElect(); //Campos de la Grilla
$colBusca          = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas          = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
