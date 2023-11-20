<?php
session_start();
header("content-type: application/json; charset=utf-8");
include '../../../funciones/db_connect.inc.php';
include_once '../../../clases/autoload.php';
include_once 'config.php';

$InfoAppDgscop = new InfoAppDgscop;


$_POST['orden'] = empty($_POST['orden']) ? null : $_POST['orden'];
$_POST['dna_IdDnaInfoApp'] = empty($_POST['dna_IdDnaInfoApp']) ? null : $_POST['dna_IdDnaInfoApp'];



$respuesta = $InfoAppDgscop->registrarInfoAppDgscop($_POST, $_FILES);

echo json_encode($respuesta);