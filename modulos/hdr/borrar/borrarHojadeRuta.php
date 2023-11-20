<?php
include '../../../../funciones/db_connect.inc.php';
$tabla='hdrRuta'; // *** CAMBIAR *** Nombre de la Tabla
$idcampo=ucfirst($tabla); //Nombre del Id de la tabla

if(!isset($_GET['recno'])){
	echo 'No se obtuvieron los parametros obligatorios';
}else{
	$rs = $conn->query("SELECT hdrRuta.idHdrRuta FROM hdrRuta WHERE SHA1(hdrRuta.idHdrRuta) = '{$_GET['recno']}'");
	$row=$rs->fetch(PDO::FETCH_ASSOC);
	
	$idHdrRuta = $row['idHdrRuta'];
	
	/**
	 * iniciando la transacción
	 */
	$conn->beginTransaction();
	
	/**
	 * para borrar una hoja de ruta se debe borrar todos los registros hijos
	 * en este orden
	 * - Tabla sectores
	 * - tabla integrantes
	 * - tabla recursos
	 * - tabla hoja de ruta
	 */
	
	$sqlBorrarSectorPatrulla = "DELETE FROM hdrSectorPatrulla WHERE hdrSectorPatrulla.idHdrRecurso IN (SELECT hdrRecurso.idHdrRecurso FROM hdrRecurso WHERE hdrRecurso.idHdrRuta = ?)";
	
	$sqlBorrarIntegrantes = "DELETE FROM hdrIntegrante WHERE hdrIntegrante.idHdrRecurso IN (SELECT hdrRecurso.idHdrRecurso FROM hdrRecurso WHERE hdrRecurso.idHdrRuta = ?)";
	
	$sqlBorrarRecursos = "DELETE FROM hdrRecurso WHERE hdrRecurso.idHdrRuta = ?";
	
	$sqlBorrarHojaRuta = "DELETE FROM hdrRuta WHERE hdrRuta.idHdrRuta = ?";
	
	$sqlBorrarActividadIntegrante = "DELETE FROM hdrIntegAct WHERE idHdrIntegrante IN (SELECT hdrIntegrante.idHdrIntegrante FROM hdrIntegrante
	INNER JOIN hdrRecurso ON hdrIntegrante.idHdrRecurso = hdrRecurso.idHdrRecurso
	WHERE hdrRecurso.idHdrRuta = ?)";
	
	/**
	 * borrando sector patrulla
	 */
	$sentencia = $conn->prepare($sqlBorrarSectorPatrulla);
	$sentencia->bindParam(1, $idHdrRuta);
	$sentencia->execute() or die(print_r($sentencia->errorInfo()));
	
	/**
	 * borrando actividades de integrantes
	 */
	$sentencia = $conn->prepare($sqlBorrarActividadIntegrante);
	$sentencia->bindParam(1, $idHdrRuta);
	$sentencia->execute() or die(print_r($sentencia->errorInfo()));
	
	/**
	 * borrando integrantes
	 */
	$sentencia = $conn->prepare($sqlBorrarIntegrantes);
	$sentencia->bindParam(1, $idHdrRuta);
	$sentencia->execute() or die(print_r($sentencia->errorInfo()));
	
	/**
	 * borrando recursos
	 */
	$sentencia = $conn->prepare($sqlBorrarRecursos);
	$sentencia->bindParam(1, $idHdrRuta);
	$sentencia->execute() or die(print_r($sentencia->errorInfo()));
	
	/**
	 * borrando hoja de ruta
	 */
	$sentencia = $conn->prepare($sqlBorrarHojaRuta);
	$sentencia->bindParam(1, $idHdrRuta);
	$sentencia->execute() or die(print_r($sentencia->errorInfo()));
	
	/**
	 * guardando los cambios sin problemas
	 */
	$conn->commit();
	
	echo 'Hoja de Ruta Eliminada Exitosamente';
}
?>