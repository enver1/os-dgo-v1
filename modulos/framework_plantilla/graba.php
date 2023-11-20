<?php
session_start();
include '../../../funciones/db_connect.inc.php';
include_once('../../../funciones/redirect.php');
/*----------------------------*/
$sNtabla='dneMateria'; //  *** CAMBIAR *** Nombre de la tabla
/*-----------------------------*/
$idcampo=ucfirst($sNtabla);// Nombre del Id de la Tabla
if($_POST['id'.$idcampo]=='' or $_POST['id'.$idcampo]==0)
	{
	$sql="select * from ".$sNtabla." where descripcion='".$_POST['descripcion']."'";
	$rs=$conn->query($sql);
	if ($row=$rs->fetch(PDO::FETCH_ASSOC))
		redirect('../../../funciones/error.php?errno=1');
	else {
	/*------------------------------*/
	// *** CAMBIAR ***
	$sentencia = $conn->prepare("insert into ".$sNtabla." (idGenEstado,idDneTipoPrueba,descripcion,usuario) values  ( ?, ?, ?, ?)");
	$sentencia->bindParam(1, $_POST['idGenEstado']);
	$sentencia->bindParam(2, $_POST['idDneTipoPrueba']);
	$sentencia->bindParam(3, $_POST['descripcion']);
	$sentencia->bindParam(4, $_SESSION['usuarioAuditar']);
	$sentencia->execute() or die('error');
	}
	}
else
	{
	$sql="select * from ".$sNtabla." where descripcion='".$_POST['descripcion']."' and ".$sNtabla."!=".$_POST['id'.$idcampo];
	$rs=$conn->query($sql);
	if ($row=$rs->fetch(PDO::FETCH_ASSOC))
		redirect('../../../funciones/error.php?errno=1');
	else {
	$sentencia = $conn->prepare("update ".$sNtabla." set idGenEstado=?,idDneTipoPrueba=?,descripcion=?,usuario=?,fecha=now() where id".$idcampo."=?");
	$sentencia->bindParam(1, $_POST['idGenEstado']);
	$sentencia->bindParam(2, $_POST['idDneTipoPrueba']);
	$sentencia->bindParam(3, $_POST['descripcion']);
	$sentencia->bindParam(4,$_SESSION['usuarioAuditar']);
	$sentencia->bindParam(5, $_POST['id'.$idcampo]);
	/*-----------------------------------*/
	$sentencia->execute() or die('error');
	}
	}
?>