<?php
session_start();
header("content-type: application/json; charset=utf-8");
if (isset($_SESSION['usuarioAuditar'])) {

  include_once '../../../clases/autoload.php';
  include_once 'config.php';

  $puntosLlegada     = new PuntosLlegada;
  $respuesta = $puntosLlegada->registrarPuntosLlegada($_POST);
  echo json_encode($respuesta);
} else {
  header('Location: indexSiipne.php');
}