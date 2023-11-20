<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';
include_once 'config.php';
$asignacion = new Asignacion;
$formAsignacion   = new FormAsignacion;

print_r($_POST);
die();

$meses = ""; // meses para grabar en caracteres de acuerdo a los valores del arreglo
/* funcion que se encuentra en funcion_graba.php y transforma checks */
$form = $formAsignacion->getCamposFormAsignacion();
$meses = FuncionesGenerales::getCheckToString($form[2], 'valores', 'meses', $_POST);
if (empty($meses)) {
	echo json_encode(array(false, 'Meses no puede estar en blanco', 0));
	die();
}
$_POST['meses'] = $meses;
$respuesta = $asignacion->registrarAsignacion($_POST, $_FILES);

echo json_encode($respuesta);
