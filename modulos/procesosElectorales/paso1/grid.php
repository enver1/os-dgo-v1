<?php
include_once '../clases/autoload.php';
$formProcesosElectorales = new FormProcesosElectorales;
$ProcesosElectorales     = new ProcesosElectorales;
$idcampo                = $ProcesosElectorales->getIdCampoProcesosElectorales(); //Primary Key Table
$gridS                  = $formProcesosElectorales->getGrillaProcesosElectorales(); //Campos de la Grilla
$colBusca               = 1; //Columna Busqueda en la Grilla de acuerdo al SQL
$columnas               = count($gridS) + 2; //Numero de columnas + edit y delete
include_once '../includes/datatablePaginado.php';
