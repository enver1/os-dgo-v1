<?php
header('Content-Type: Json; charset=UTF-8');

include_once '../../../clases/autoload.php';


$senderoSeguro = new SenderoSeguro;

$idRuta = strip_tags($_POST['idRuta']);
$accionTomada = strip_tags($_POST['accionTomada']);


$res = $senderoSeguro->modificarEstado($idRuta,'finalizada',  $accionTomada);

$msj=($res==1)?"Modificado":"Error Modificando" ;

echo json_encode(array('estado'=>$res, 'msj'=>$msj));