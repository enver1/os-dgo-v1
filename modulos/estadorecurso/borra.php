<?php
session_start();
include '../../../funciones/db_connect.inc.php';
$tabla='hdrEstadoRecurso'; // *** CAMBIAR *** Nombre de la Tabla
$idcampo=ucfirst($tabla); //Nombre del Id de la tabla
if($_POST['id']=='' or $_POST['id']==0)
	{
		echo '<script language="javascript"> alert("Registro vacio");</script>';
	}
else
	{
	
	$sentencia = $conn->prepare("delete from $tabla where id".$idcampo."=?");
	$sentencia->bindParam(1, $_POST['id']);
	$sentencia->execute() or die('error '.$_POST['id']);
	}
?>