<?php
/* MUESTRA LA GRILLA EN LA PARTE INFERIOR DEL FORMULARIO */
include_once '../clases/autoload.php';

$Comisios     = new Comisios;
$formComisios = new FormComisios;
$idcampo      = $Comisios->getIdCampoComisios(); //Primary Key Table
$gridS        = $formComisios->getGrillaComisios(); //Campos de la Grilla
$colBusca     = 2; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas     = count($gridS) + 2; //Numero de columnas + edit y delete

include_once '../includes/datatablePaginado.php';

//include_once '../operaciones/modulos/recintosElectorales/includes/resultadoP2.php';
