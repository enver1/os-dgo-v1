<?php
session_start();
include '../../../funciones/db_connect.inc.php';
include_once('../../../funciones/redirect.php');
/*----------------------------*/
$sNtabla='hdrConsigna'; //  *** CAMBIAR *** Nombre de la tabla
/*-----------------------------*/
$idcampo=ucfirst($sNtabla);// Nombre del Id de la Tabla
if($_POST['id'.$idcampo]=='' or $_POST['id'.$idcampo]==0)
	{	
	$sql="select * from ".$sNtabla." where descripcionConsigna='".$_POST['descripcion']."'";
	$rs=$conn->query($sql);
	if ($row=$rs->fetch(PDO::FETCH_ASSOC)){
		//die($sql);
		redirect('../../../funciones/error.php?errno=1');
	}else {
	/*------------------------------*/
	// *** CAMBIAR ***
//	$xx=sprintf("insert into ".$sNtabla." (idGenGeoSenplades,idGenEstado,descripcionConsigna,fechaInicial,fechaCaducidad,observacion,usuario) values  (%s,%s,%s,%s,%s,%s,%s)",$_POST('codSenplades'),$_POST['idGenEstado'],$_POST['descripcion'],$_POST['fechaInicio'],$_POST['fechaCaducidad'],$_POST['observacion'],$_SESSION['usuarioAuditar']);
//	die($xx);
	$sentencia = $conn->prepare("insert into ".$sNtabla." (idGenGeoSenplades, idGenEstado, descripcionConsigna, fechaInicial, fechaCaducidad, observacion, usuario,ip) values  (?,?,?,?,?,?,?,?)");
	$sentencia->bindParam(1, $_POST['codSenplades']);
	$sentencia->bindParam(2, $_POST['idGenEstado']);
	$sentencia->bindParam(3, $_POST['descripcion']);
	$sentencia->bindParam(4, $_POST['fechaInicio']);
	$sentencia->bindParam(5, $_POST['fechaCaducidad']);
	$sentencia->bindParam(6, $_POST['observacion']);
	$sentencia->bindParam(7, $_SESSION['usuarioAuditar']);
	$sentencia->bindParam(8, realIP());
	$sentencia->execute() or die('error');
	}
	}
else
	{
	$sql="select * from ".$sNtabla." where descripcionConsigna='".$_POST['descripcion']."' and id".$idcampo."!=".$_POST['id'.$idcampo];
	//echo $sql;
	$rs=$conn->query($sql);
	if ($row=$rs->fetch(PDO::FETCH_ASSOC))
		redirect('../../../funciones/error.php?errno=1');
	else {
	$sentencia = $conn->prepare("update ".$sNtabla." set idGenGeoSenplades=?, idGenEstado=?, descripcionConsigna=?, fechaInicial=?,fechaCaducidad=?,observacion=?,usuario=?,fecha=now(),ip=? where id".$idcampo."=?");
	$sentencia->bindParam(1, $_POST['codSenplades']);
	$sentencia->bindParam(2, $_POST['idGenEstado']);
	$sentencia->bindParam(3, $_POST['descripcion']);
	$sentencia->bindParam(4, $_POST['fechaInicio']);
	$sentencia->bindParam(5, $_POST['fechaCaducidad']);
	$sentencia->bindParam(6, $_POST['observacion']);
	$sentencia->bindParam(7, $_SESSION['usuarioAuditar']);
	$sentencia->bindParam(8, realIP());
	$sentencia->bindParam(9, $_POST['id'.$idcampo]);
	/*-----------------------------------*/
	$sentencia->execute() or die('error');
	}
	}
?>