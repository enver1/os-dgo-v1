<?php
include '../../../../funciones/db_connect.inc.php';
if(!isset($_POST['id']))
{
	echo 'Registro Vacio';
}
else
{
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
	*/
	
	$sqlBorrarSectorPatrulla = "DELETE FROM hdrSectorPatrulla WHERE sha1(idHdrRecurso) = ?";
	
	$sqlBorrarIntegrantes = "DELETE FROM hdrIntegrante WHERE sha1(idHdrRecurso) = ?";
	
	$sqlBorrarRecursos = "DELETE FROM hdrRecurso WHERE sha1(idHdrRecurso) = ?";
	
	/**
	 * borrando sector patrulla
	 */
	$sentencia = $conn->prepare($sqlBorrarSectorPatrulla);
	$sentencia->bindParam(1, $_POST['id']);
	$sentencia->execute() or die(print_r($sentencia->errorInfo()));
	
	/**
	 * borrando integrantes
	*/
	$sentencia = $conn->prepare($sqlBorrarIntegrantes);
	$sentencia->bindParam(1, $_POST['id']);
	$sentencia->execute() or die(print_r($sentencia->errorInfo()));
	
	/**
	 * borrando recursos
	*/
	$sentencia = $conn->prepare($sqlBorrarRecursos);
	$sentencia->bindParam(1, $_POST['id']);
	$sentencia->execute() or die(print_r($sentencia->errorInfo()));
	
	/**
	 * guardando los cambios sin problemas
	*/
	$conn->commit();

    echo 'Registro borrado correctamente';
        
}
?>