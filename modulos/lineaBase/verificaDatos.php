<?php
header('Content-Type: text/html; charset=UTF-8');
include '../../../clases/autoload.php';
include('clases/valida.php');
$conn = DB::getConexionDB();
$valida = new valida;

echo json_encode($valida->verificaExistenNotas($conn, $_POST['anio']));
