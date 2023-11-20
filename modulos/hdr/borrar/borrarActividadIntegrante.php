<?php
include '../../../../funciones/db_connect.inc.php';

if(isset($_POST['actividades'])){
	/**
	 * iniciando transacción
	 */
	$conn->beginTransaction();
	
	$sqlDelete = "DELETE FROM hdrIntegAct WHERE idHdrIntegAct = ?";
	$sentencia = $conn->prepare($sqlDelete);
	
	foreach($_POST['actividades'] as $row){
		$sentencia->bindParam(1, $row);
		$sentencia->execute() or die(print_r($sentencia->errorInfo()));
	}
	
	/**
	 * guardando los cambios sin problemas
	 */
	$conn->commit();
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

echo json_encode($array);
?>