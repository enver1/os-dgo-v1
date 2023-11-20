<?php
session_start();
include '../../../clases/autoload.php';
include_once('../../../funciones/redirect.php');
/*----------------------------*/
$sNtabla = 'hdrVehiculo'; //  *** CAMBIAR *** Nombre de la tabla	
$transaccion = new Transaccion;
$ip = $transaccion->getRealIP();
$conn = DB::getConexionDB();


/*-----------------------------*/
$idcampo = ucfirst($sNtabla); // Nombre del Id de la Tabla
if ($_POST['id' . $idcampo] == '' or $_POST['id' . $idcampo] == 0) {
	$sql = "SELECT idHdrVehiculo FROM hdrVehiculo WHERE idGenVehiculo = {$_POST['idGenVehiculo']} AND idDgpUnidad = {$_POST['idDgpUnidad']}";
	$rs = $conn->query($sql);
	if ($row = $rs->fetch(PDO::FETCH_ASSOC))
		redirect('../../../funciones/error.php?errno=5');
	else {
		/*------------------------------*/
		// *** CAMBIAR ***
		$sentencia = $conn->prepare("insert into " . $sNtabla . " (idGenVehiculo,idDgpUnidad,idGenEstado,fechaAsignacion,usuario,ip,fecha) values  (?, ?, ?, ?, ?, ?, NOW())");
		$sentencia->bindParam(1, $_POST['idGenVehiculo']);
		$sentencia->bindParam(2, $_POST['idDgpUnidad']);
		$sentencia->bindParam(3, $_POST['idGenEstado']);
		$sentencia->bindParam(4, $_POST['fechaAsig']);
		$sentencia->bindParam(5, $_SESSION['usuarioAuditar']);
		$sentencia->bindParam(6, $ip);
		$sentencia->execute() or die(print_r($sentencia->errorInfo()));
	}
} else {
	$sql = "SELECT idHdrVehiculo FROM hdrVehiculo WHERE idGenVehiculo = {$_POST['idGenVehiculo']} AND idDgpUnidad = {$_POST['idDgpUnidad']} and id" . $idcampo . "!=" . $_POST['id' . $idcampo];
	//echo $sql;
	$rs = $conn->query($sql);
	if ($row = $rs->fetch(PDO::FETCH_ASSOC))
		redirect('../../../funciones/error.php?errno=5');
	else {
		$sentencia = $conn->prepare("update " . $sNtabla . " set idGenVehiculo = ?,idDgpUnidad = ?,idGenEstado = ?,fechaAsignacion = ?,usuario = ?,ip = ?,fecha=NOW() where id" . $idcampo . "=?");
		$sentencia->bindParam(1, $_POST['idGenVehiculo']);
		$sentencia->bindParam(2, $_POST['idDgpUnidad']);
		$sentencia->bindParam(3, $_POST['idGenEstado']);
		$sentencia->bindParam(4, $_POST['fechaAsig']);
		$sentencia->bindParam(5, $_SESSION['usuarioAuditar']);
		$sentencia->bindParam(6, $ip);
		$sentencia->bindParam(7, $_POST['id' . $idcampo]);

		/*-----------------------------------*/
		$sentencia->execute() or die('error');
	}
}
