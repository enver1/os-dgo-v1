<?php
session_start();
include_once '../../../../funciones/funciones_generales.php';
include_once '../../../../clases/autoload.php';
$datosPersona    = new RegistroAspectoAppCg;
$registroPersona = new RegistroPersona;
$cedula          = $_GET['cedula'];
$mensaje         = 'PERSONA EXISTE';
$codeResponse    = 0;
$respuesta       = null;
$insertarPerson  = true;

$rs = $datosPersona->getDatosPersonaSIIPNE($cedula);

if ($rs != null) {
    $idGenPersona = $rs['idGenPersona'];
    if ($idGenPersona > 0) {
        $insertarPerson = false;
        $respuesta      = $datosPersona->getDatos($idGenPersona, $cedula);
        $codeResponse   = 1;
    }
}
if ($insertarPerson) {
    $datos = $registroPersona->registroPersonaNaturalExtranjera(1, $cedula, "ECU", "N");
    if ($datos[0]) {
        $idGenPersona = $datos[1];
        $respuesta    = $datosPersona->getDatos($idGenPersona, $cedula);
        $codeResponse = 1;
    } else {
        $idGenPersona = 0;
        $mensaje      = 'Cedula Incorrecta';
        $codeResponse = 0;
    }
}

if ($codeResponse == 0) {
    $respuesta = array('msj' => $mensaje, 'codeResponse' => $codeResponse, 'datos' => null);
}
echo json_encode($respuesta);
