<?php
session_start();
/**
 * cargando librerias importantes
 */
include '../../../clases/autoload.php';
$conn = DB::getConexionDB();
include_once('../../../funciones/redirect.php');
// include_once('config.php');
$transaccion = new Transaccion;
$ip = $transaccion->getRealIP();
/**
 * nombre de tabla y id de campo
 */
$sNtabla = "genUnidadesGeoreferencial";
$idcampo = 'id' . ucfirst($sNtabla);

if ($_POST[$idcampo] == '' or $_POST[$idcampo] == 0) {
	/**
	 * Verifica que no exista una descripcion duplicada al hacer insert 
	 */
	if (!empty($_POST['descripcion'])) {
		$sql = "SELECT idGenUnidadesGeoreferencial FROM genUnidadesGeoreferencial WHERE idGenActividadGA ='{$_POST['idGenActividadGA']}' AND idGenGeoSenplades = '{$_POST['idGenGeoSenplades']}'";
		$rs = $conn->query($sql);
		if ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
			redirect('../../../funciones/error.php?errno=1');
			$noduplicado = false;
		} else {
			$noduplicado = true;
		}
	} else {
		$noduplicado = true;
	}

	if ($noduplicado) {
		$sql = "INSERT INTO genUnidadesGeoreferencial(idGenGeoSenplades, idGenActividadGA, usuario, ip)VALUES(?, ?, ?, ?)";
		$sentencia = $conn->prepare($sql);
		$sentencia->bindParam(1, $_POST['idGenGeoSenplades']);
		$sentencia->bindParam(2, $_POST['idGenActividadGA']);
		$sentencia->bindParam(3, $_SESSION['usuarioAuditar']);
		$sentencia->bindParam(4, $ip);
		$sentencia->execute() or die($sentencia->errorInfo());
	}
} else {
	/* Verifica que no exista una descripcion duplicada al hacer update */
	if (!empty($descripcion)) {
		$sql = "SELECT idGenUnidadesGeoreferencial FROM genUnidadesGeoreferencial WHERE idGenActividadGA ='{$_POST['idGenActividadGA']}' AND idGenGeoSenplades = '{$_POST['idGenGeoSenplades']}'";
		$rs = $conn->query($sql);
		if ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
			redirect('../../../funciones/error.php?errno=1');
			$noduplicado = false;
		} else {
			$noduplicado = true;
		}
	} else {
		$noduplicado = true;
	}

	if ($noduplicado) {
		$sql = "UPDATE genUnidadesGeoreferencial SET idGenGeoSenplades = ? , idGenActividadGA = ? , usuario = ? , ip = ? WHERE idGenUnidadesGeoreferencial = ?";
		$sentencia = $conn->prepare($sql);
		$sentencia->bindParam(1, $_POST['idGenGeoSenplades']);
		$sentencia->bindParam(2, $_POST['idGenActividadGA']);
		$sentencia->bindParam(3, $_SESSION['usuarioAuditar']);
		$sentencia->bindParam(4, $ip);
		$sentencia->bindParam(5, $_POST['idGenUnidadesGeoreferencial']);
		$sentencia->execute() or die($sentencia->errorInfo());
	}
}
