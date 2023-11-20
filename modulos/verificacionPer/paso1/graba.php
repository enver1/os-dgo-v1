<?php
session_start();
header("content-type: application/json; charset=utf-8");
if (!isset($_SESSION['usuarioAuditar'])) {
  header('Location: indexSiipne.php');
  exit;
}
include_once '../../../../clases/autoload.php';

include_once '../../../../appmovil/siipneMovil/clases/autoloadSiipneMovil.php';
$CrearOperativoReci = new CrearOperativoReci;
$usuario            = controllerGenUsuario::verificarPersonaNoTieneNovedadesActualesRegistradas($_POST['idGenPersona']);

if ($usuario['existe']) {
  $_POST['idGenPersona']   = '';
  $_POST['nombrePersonaC'] = '';
  $respuesta = array(true, 'El Usurario esta con ' . $usuario['novedad'] . ', no puede Iniciar un Operativo', 0);
  ob_clean();
  echo json_encode($respuesta);
  exit;
}

if ($_POST['finalizado'] > 0) {
  $respuesta = array(true, 'Este Operativo ya Fue Finalizado no lo Puede Volver a Iniciar o Modificar', 0);
  ob_clean();
  echo json_encode($respuesta);
  exit;
}

$disponibilidadRecinto  = $CrearOperativoReci->getVerificaRecintoActivo($_POST['idDgoReciElect'], $_POST['idDgoProcElec']);

$disponibilidadServidor = $CrearOperativoReci->getVerificaServidorActivo($_POST['cedulaPersonaC'], $_POST['idDgoProcElec']);

if ($_POST['auxC'] == $_POST['cedulaPersonaC'] && $_POST['auxR'] == $_POST['idDgoComisios']) {

  $respuesta = $CrearOperativoReci->registrarCrearOperativoReci($_POST);
  ob_clean();
  echo json_encode($respuesta);
  exit;
}
if (!empty($disponibilidadRecinto)) {
  if ($disponibilidadRecinto['idDgoCreaOpReci'] > 0 && (!empty($disponibilidadRecinto['idDgoCreaOpReci']))) {
    $_POST['idGenPersona']   = '';
    $_POST['nombrePersonaC'] = '';
    ob_clean();
    echo json_encode(array(false, 'Ya se encuentra un Encargado en este recinto,' . $disponibilidadRecinto['personal'] . '     Proceso:     ' . $disponibilidadRecinto['descProcElecc'], 0));
    exit;
  }
}
if (!empty($disponibilidadServidor)) {
  if ($disponibilidadServidor['idDgoCreaOpReci'] > 0 && (!empty($disponibilidadServidor['idDgoCreaOpReci']))) {
    $_POST['idGenPersona'] = '';
    $_POST['nombrePersonaC'] = '';
    ob_clean();
    echo json_encode(array(false, 'Usted ya es parte de un recinto,' . $disponibilidadServidor['nomRecintoElec'] . '     Proceso:     ' . $disponibilidadServidor['descProcElecc'], 0));
    exit;
  }
}
$respuesta     = $CrearOperativoReci->registrarCrearOperativoReci($_POST);
$respuestaJefe = $CrearOperativoReci->registrarJefe($respuesta[2], $_POST['idGenPersona'], $_POST['latitud'], $_POST['longitud'], $_POST['idDgoReciElect'], $_POST['telefono'], $_POST['idDgoTipoEje']);
$respuestaNov  = $CrearOperativoReci->registraPrimeraNovedad($respuestaJefe[2], 'REGISTRO DE PERSONAL (JEFE)', 1, $_POST['latitud'], $_POST['longitud']);
ob_clean();
echo json_encode($respuesta);
exit;
