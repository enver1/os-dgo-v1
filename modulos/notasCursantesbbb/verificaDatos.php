<?php
header('Content-Type: text/html; charset=UTF-8');
include '../../../funciones/db_connect.inc.php';
include('clases/valida.php');

$valida = new valida;

if ($_POST['anio'] <= 2020) {
  echo json_encode($valida->verificaExistenNotas($conn, $_POST['anio']));
  exit();
}
echo json_encode(array(true));
