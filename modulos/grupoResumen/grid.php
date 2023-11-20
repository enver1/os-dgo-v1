<?php
include_once '../clases/autoload.php';
$formGrupoResumen = new FormGrupoResumen;
$GrupoResumen     = new GrupoResumen;
$idcampo         = $GrupoResumen->getIdCampoGrupoResumen(); //Primary Key Table
$gridS           = $formGrupoResumen->getGrillaGrupoResumen(); //Campos de la Grilla
$colBusca        = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas        = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';