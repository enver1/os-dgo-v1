<?php
session_start();
header("content-type: application/json; charset=utf-8");
include 'config.php';
include_once '../../../../appmovil/siipneMovil/clases/autoloadSiipneMovil.php';
include_once '../../../../clases/autoload.php';
$CrearOperativoReci = new CrearOperativoReci;
$AsignaPersonalElec = new AsignaPersonalElec;
$usuario            = controllerGenUsuario::verificarPersonaNoTieneNovedadesActualesRegistradas($_POST['idGenPersona']);


$disponibilidadServidor = $AsignaPersonalElec->getverificaServidor($_POST['cedulaPersonaC'], $_POST['idDgoProcElec']);

if ($usuario['existe']) {
    $respuesta               = array(true, 'El Usurario esta con ' . $usuario['novedad'] . ', no puede ser Agregado al Operativo', 0);
    $_POST['idGenPersona']   = '';
    $_POST['nombrePersonaC'] = '';
    ob_clean();
    echo json_encode($respuesta);
    exit;
}

if ($_POST['idGenEstado'] == 2) {
    $respuesta = $AsignaPersonalElec->registrarAsignaPersonalElec($_POST);
    ob_clean();
    echo json_encode($respuesta);
    exit;
}
if (!empty($disponibilidadServidor) && $disponibilidadServidor['idDgoPerAsigOpe'] > 0 && (!empty($disponibilidadServidor['idDgoPerAsigOpe']))) {
    $respuesta               = (array(false, 'Ya se encuentra asignado en el recinto, ' . $disponibilidadServidor['nomRecintoElec'] . '     Proceso:     ' . $disponibilidadServidor['descProcElecc'], 0));
    $_POST['idGenPersona']   = '';
    $_POST['nombrePersonaC'] = '';
    ob_clean();
    echo json_encode($respuesta);
    exit;
} else {
    $respuesta = $AsignaPersonalElec->registrarAsignaPersonalElec($_POST);
    ob_clean();
    echo json_encode($respuesta);
    exit;
}
