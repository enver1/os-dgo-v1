<?php
include_once '../clases/autoload.php';
$formUsuariosAppDgscop = new FormUsuariosAppDgscop;
$UsuariosAppDgscop     = new UsuariosAppDgscop;
$idcampo           = $UsuariosAppDgscop->getIdCampo(); //Primary Key Table
$gridS             = $formUsuariosAppDgscop->getGrillaUsuariosAppDgscop(); //Campos de la Grilla
$colBusca          = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas          = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
