<?php
session_start();
header("content-type: application/json; charset=utf-8");

include_once '../../../clases/autoload.php';
include_once 'config.php';

$UsuariosAppDgscop = new UsuariosAppDgscop;
$respuesta    = $UsuariosAppDgscop->registrarUsuariosAppDgscop($_POST);
echo json_encode($respuesta);
