<?php
session_start();
include_once '../clases/autoload.php';
$idGenUsuario = strip_tags(htmlspecialchars(isset($_SESSION['usuarioAuditar']) ? $_SESSION['usuarioAuditar'] : ''));
if (!empty($idGenUsuario) && $idGenUsuario > 0) {
	$usuario         = new Usuarios;
	$parametro       = new Parametro;
	$clsModulo       = new Modulo;
	$cabecera        = new Cabeceras;
	$idGenModulo     = strip_tags(htmlspecialchars(isset($_GET['modulo']) ? $_GET['modulo'] : ''));
	$opc             = strip_tags(htmlspecialchars(isset($_GET['opc']) ? $_GET['opc'] : ''));
	$opcgen          = strip_tags(htmlspecialchars(isset($_GET['opcgen']) ? $_GET['opcgen'] : ''));
	$modulo          = '';
	$fondoModulo     = '';
	$datosParametroS = $parametro->getDatosNombreParametroModulo('controlSession', '1');
	if (!empty($datosParametroS)) {
		$valorParametroSesion = $datosParametroS['valor'];
		if ($valorParametroSesion == 'S') {
			if ($usuario->verificarSesionUsuario($idGenUsuario, $_COOKIE['IDSESSPNE'])) {
				session_destroy();
				echo '<script>alert("Ha iniciado session desde otro dispositivo, esta session se cerrara");location.reload();</script>';
			}
		}
	}
	if (!empty($idGenModulo)) {
		$datosModulo          = $clsModulo->getDatosModuloIndex($idGenModulo);
		$_SESSION['elmodulo'] = $idGenModulo;
		if (!empty($datosModulo)) {
			$fondoModulo = $datosModulo[FuncionesGenerales::upc('pathImagenModulo')];
		}
	}
	include_once '../includes/cabeceraJs.php';
	include_once '../includes/cabecera_modulo.php';
	if (!empty($opc)) {
		$modulo = $cabecera->getContenido($opcgen, $opc, $idGenUsuario);
		echo '<script language="javascript">document.getElementById("aplicacion").innerHTML="' . $modulo . '";</script>';
	} else {
		if (!empty($fondoModulo)) {
			include_once '../includes/fondoModulo.php';
		}
	}
	include_once '../includes/pie_modulo.php';
} else {
	FuncionesGenerales::redirect('../includes/salir.php');
}
