<?php
session_start();
include '../../../funciones/db_connect.inc.php';
$sNtabla='genDivPolitica';
$idcampo=ucfirst($sNtabla);

if($_POST['id'.$idcampo]=='' or $_POST['id'.$idcampo]==0)
	{
	$pais=($_POST['paisCdg']==''?null:$_POST['paisCdg']);
	$sql="select * from ".$sNtabla." where descripcion='".$_POST['descripcion']."' and idGenTipoDivision=". $_POST['idGenTipoDivision']." and gen_idGenDivPolitica=". $pais;
	$rs=$conn->query($sql);
	if ($row=$rs->fetch(PDO::FETCH_ASSOC))
		redirect('../../../funciones/error.php?errno=1');
	else {

	$sentencia = $conn->prepare("insert into ".$sNtabla." (gen_idGenDivPolitica,idGenTipoDivision,descripcion,usuario) values  ( ?, ?, ?, ?)");
	$sentencia->bindParam(1, $pais);
	$sentencia->bindParam(2, $_POST['idGenTipoDivision']);
	$sentencia->bindParam(3, $_POST['descripcion']);
	$sentencia->bindParam(4, $_SESSION['usuarioAuditar']);
	$sentencia->execute() or die('error');
	}
	}
else
	{
	$pais=($_POST['paisCdg']==''?null:$_POST['paisCdg']);
	$sql="select * from ".$sNtabla." where descripcion='".$_POST['descripcion']."' and idGenTipoDivision=". $_POST['idGenTipoDivision']." and gen_idGenDivPolitica=". $pais." and idGenDivPolitica!=".$_POST['id'.$idcampo];

	$rs=$conn->query($sql);
	if ($row=$rs->fetch(PDO::FETCH_ASSOC))
		redirect('../../../funciones/error.php?errno=1');
	else {

	$sentencia = $conn->prepare("update ".$sNtabla." set gen_idGenDivPolitica=?,idGenTipoDivision=?,descripcion=?,usuario=?,fecha=now() where id".$idcampo."=?");
	$sentencia->bindParam(1, $pais);
	$sentencia->bindParam(2, $_POST['idGenTipoDivision']);
	$sentencia->bindParam(3, $_POST['descripcion']);
	$sentencia->bindParam(4,$_SESSION['usuarioAuditar']);
	$sentencia->bindParam(5, $_POST['id'.$idcampo]);
	$sentencia->execute() or die('error');
	}
	}
?>