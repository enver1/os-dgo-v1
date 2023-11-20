<?php
session_start();
if (!isset($_SESSION['usuarioAuditar'])) {
  exit();
}

include '../../../clases/autoload.php';
$dgoDatos = new DgoDatos();
header('Content-Type: application/json');
echo  json_encode(array('data' => $dgoDatos->getDgoDatosMeses()));
?>
