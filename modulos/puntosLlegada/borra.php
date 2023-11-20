<?php
session_start();
if (isset($_SESSION['usuarioAuditar'])) {
  
    include_once '../../../clases/autoload.php';
    include_once('config.php');
  	$puntosLlegada     = new PuntosLlegada;
    $id = strip_tags($_POST['id']);
    $respuesta = $puntosLlegada->delete( $tabla, $id);

    echo $respuesta[1];
} else {
    header('Location: indexSiipne.php');
}