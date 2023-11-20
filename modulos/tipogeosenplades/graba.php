<?php
session_start();
include '../../../funciones/db_connect.inc.php';
include_once('../../../funciones/redirect.php');
/*----------------------------*/
$sNtabla='genTipoGeoSenplades'; //  *** CAMBIAR *** Nombre de la tabla
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
	$sentencia = $conn->prepare("insert into ".$sNtabla." (descripcion,usuario,ip) values  ( ?,?,?)");
	$sentencia->bindParam(1, $_POST['descripcion']);
	$sentencia->bindParam(2, $_SESSION['usuarioAuditar']);
	$sentencia->bindParam(3, $ip);
	$sentencia->execute() or die('error');
	}
	}
else
	{
	$sql="select * from ".$sNtabla." where descripcion='".$_POST['descripcion']."' and id".$idcampo."!=".$_POST['id'.$idcampo];
	//echo $sql;
	$rs=$conn->query($sql);
	if ($row=$rs->fetch(PDO::FETCH_ASSOC))
		redirect('../../../funciones/error.php?errno=1');
	else {
	$sentencia = $conn->prepare("update ".$sNtabla." set 		    descripcion=?,usuario=?,fecha=now(),ip=? where id".$idcampo."=?");
	$sentencia->bindParam(1, $_POST['descripcion']);
	$sentencia->bindParam(2, $_SESSION['usuarioAuditar']);
	$sentencia->bindParam(3, $ip);
	$sentencia->bindParam(4, $_POST['id'.$idcampo]);
	/*-----------------------------------*/
	$sentencia->execute() or die('error');
	}
	}
?>