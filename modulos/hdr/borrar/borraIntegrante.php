<?php
include '../../../../funciones/db_connect.inc.php';
$tabla='hdrIntegrante'; // *** CAMBIAR *** Nombre de la Tabla
$idcampo=ucfirst($tabla); //Nombre del Id de la tabla
if(isset($_GET['id']))
	{
		$respuesta=array('Registro Vacio');
		echo json_encode( $respuesta);
	}
else
{
	/**
	 * iniciando transacción
	 */
	$conn->beginTransaction();
	
	/**
	 * eliminación de actividades
	 */
	$sentencia = $conn->prepare("DELETE FROM hdrIntegAct WHERE idHdrIntegrante = ?");
	$sentencia->bindParam(1, $_POST['id']);
	$sentencia->execute() or die(print_r($sentencia->errorInfo()));
	
	/**
	 * eliminado de integrantes
	 */
	$sentencia = $conn->prepare("delete from $tabla where id".$idcampo."=?");
	$sentencia->bindParam(1, $_POST['id']);
	$sentencia->execute() or die(print_r($sentencia->errorInfo()));
	
	/**
	 * guardando los cambios sin problemas
	 */
	$conn->commit();
	
    $arr = array ('0','Registro borrado correctamente');
    echo json_encode($arr);
}
?>