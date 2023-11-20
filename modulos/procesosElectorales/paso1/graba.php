<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../../clases/autoload.php';

$ProcesosElectorales = new ProcesosElectorales;
$respuesta           = $ProcesosElectorales->registrarProcesosElectorales($_POST);
echo json_encode($respuesta);
