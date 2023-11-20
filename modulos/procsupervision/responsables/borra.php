<?php
session_start();
header("content-type: application/json; charset=utf-8");
include '../../../../clases/autoload.php';
$conn = DB::getConexionDB();
$transaccion = new Transaccion;
$tabla = 'dgoResAct';
$idcampo = 'idDgoResAct';

$respuesta = $transaccion->borrar($tabla, $_POST['id']);
echo json_encode($respuesta);
