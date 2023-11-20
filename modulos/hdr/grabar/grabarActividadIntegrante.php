<?php
if (!isset($_SESSION)){session_start();}

/**
 * librerias de guardado
 */
include '../../../../funciones/db_connect.inc.php';
include_once('../../../../funciones/redirect.php');

/**
 * Obtener información de la fecha de la hoja de ruta
 */
$sql = "SELECT hdrRuta.fechaHdrRutaInicio 
FROM hdrRuta
INNER JOIN hdrRecurso ON hdrRuta.idHdrRuta = hdrRecurso.idHdrRuta
INNER JOIN hdrIntegrante ON hdrRecurso.idHdrRecurso = hdrIntegrante.idHdrRecurso
WHERE hdrIntegrante.idHdrIntegrante = {$_POST['integrante']}";

$rs = $conn->query($sql);
$row = $rs->fetch(PDO::FETCH_ASSOC);
$horaIni =$row['fechaHdrRutaInicio'].' '.trim($_POST['horaInicioActividad']);
$horaFin= $row['fechaHdrRutaInicio'].' '.trim($_POST['horaFinActividad']);

/**
 * iniciando la transacción
 */
$conn->beginTransaction();

if($_POST['idHdrIntegAct'] == 0){
	/**
	 * insertado
	 */
	$sqlInsert = "INSERT INTO hdrIntegAct(idHdrIntegrante,horaIni,horaFin,obsActividad,usuario,ip)VALUE(?,?,?,?,?,?)";
	$sentencia=$conn->prepare($sqlInsert);
	$sentencia->bindParam(1, $_POST['integrante']);
	$sentencia->bindParam(2, $horaIni);
	$sentencia->bindParam(3, $horaFin);
	$sentencia->bindParam(4, $_POST['txtactividad']);
	$sentencia->bindParam(5, $_SESSION['usuarioAuditar']);
	$sentencia->bindParam(6, realIP());
	$sentencia->execute() or die(print_r($sentencia->errorInfo()));
}else{
	$sqlUpdate = "UPDATE hdrIntegAct SET idHdrIntegrante = ?, horaIni = ?, horaFin = ?, obsActividad = ?, usuario = ?, ip = ? WHERE idHdrIntegAct = ?";
	$sentencia=$conn->prepare($sqlUpdate);
	$sentencia->bindParam(1, $_POST['integrante']);
	$sentencia->bindParam(2, $horaIni);
	$sentencia->bindParam(3, $horaFin);
	$sentencia->bindParam(4, $_POST['txtactividad']);
	$sentencia->bindParam(5, $_SESSION['usuarioAuditar']);
	$sentencia->bindParam(6, realIP());
	$sentencia->bindParam(7, $_POST['idHdrIntegAct']);
	$sentencia->execute() or die(print_r($sentencia->errorInfo()));
}
	$sqlActividades = "SELECT 
		  idHdrIntegAct AS 'codigo',
		  obsActividad AS 'actividad',
		  TIME(horaIni) AS 'inicio',
		  TIME(horaFin) AS 'fin' 
		FROM
		  hdrIntegAct 
		WHERE idHdrIntegrante = {$_POST['integrante']}
		ORDER BY horaIni ASC";
	$rs = $conn->query($sqlActividades);
	$array = array();
	while($row = $rs->fetch(PDO::FETCH_ASSOC)){
		$array[] = $row;
	}
/**
 * guardando los cambios sin problemas
 */
$conn->commit();

echo json_encode($array);
?>