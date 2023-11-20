<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../../clases/autoload.php';
include_once '../../../../appmovil/siipneMovil/clases/autoloadSiipneMovil.php';

$encriptar               = new Encriptar;
$idDgoCreaOpReci         = strip_tags($encriptar->getDesencriptar($_POST['id'], $_SESSION['usuarioAuditar']));
$data                    = array();
$data['idDgoCreaOpReci'] = $idDgoCreaOpReci;
$data['usuario']         = $_SESSION['usuarioAuditar'];
$data['ip']              = 'Remota: '.getRealIP();

$result = controllerDgoCreaOpReci::eliminarRecintoElectoralAbierto($data);

if ($result['eliminarRecintoElectoral']['msj']) {
    $respuesta = array(true, 'REGISTRO ELIMINADO CORRECTAMNETE', $idDgoCreaOpReci);
} else {
    $respuesta = array(false, 'NO SE PUEDE ELIMINAR ESTE REGISTRO', 0);
}
echo json_encode($respuesta);

function getRealIP()
{

    if (isset($_SERVER["HTTP_CLIENT_IP"])) {

        return $_SERVER["HTTP_CLIENT_IP"];

    } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {

        return $_SERVER["HTTP_X_FORWARDED_FOR"];

    } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {

        return $_SERVER["HTTP_X_FORWARDED"];

    } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {

        return $_SERVER["HTTP_FORWARDED_FOR"];

    } elseif (isset($_SERVER["HTTP_FORWARDED"])) {

        return $_SERVER["HTTP_FORWARDED"];

    } else {

        return $_SERVER["REMOTE_ADDR"];

    }
}
