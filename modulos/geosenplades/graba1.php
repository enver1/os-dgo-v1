<?php
session_start();
include '../../../funciones/db_connect.inc.php';
include '../../../funciones/redirect.php';
$sNtabla='genGeoSenplades';
$idcampo=ucfirst($sNtabla);
$siglas=trim($_POST['siglasParte1']).'-'.$_POST['siglasGeoSenplades'];
if($_POST['id'.$idcampo]=='' or $_POST['id'.$idcampo]==0)
	{
	$pais=($_POST['paisCdg']==''?' is null ':'='.$_POST['paisCdg']);
	$sql="select * from ".$sNtabla." where descripcion='".$_POST['descripcion']."' and gen_idGenGeoSenplades".$pais;
	$rs=$conn->query($sql);
	if ($row=$rs->fetch(PDO::FETCH_ASSOC))
		redirect('../../../funciones/error.php?errno=1');
	else {
	$pais=($_POST['paisCdg']==''?NULL:$_POST['paisCdg']);
	$sentencia = $conn->prepare("insert into ".$sNtabla." (gen_idGenGeoSenplades,idGenTipoGeoSenplades,descripcion,siglasGeoSenplades,codigoSenplades,usuario) values  ( ?, ?, ?, ?, ?, ?)");
	$sentencia->bindParam(1, $pais);
	$sentencia->bindParam(2, $_POST['idGenTipoGeoSenplades']);
	$sentencia->bindParam(3, $_POST['descripcion']);
	$sentencia->bindParam(4, $siglas);
	$sentencia->bindParam(5, $_POST['codigoSenplades']);
	$sentencia->bindParam(6, $_SESSION['usuarioAuditar']);
	$sentencia->execute() or die('error');
	}
	}
else
	{
	$pais=($_POST['paisCdg']==''?' is null ':'='.$_POST['paisCdg']);
	$sql="select * from ".$sNtabla." where descripcion='".$_POST['descripcion']."' and idGenTipoGeoSenplades=". $_POST['idGenTipoGeoSenplades']." and gen_idGenGeoSenplades". $pais." and idGenGeoSenplades!=".$_POST['id'.$idcampo];
	//die($sql);
	$rs=$conn->query($sql);
	if ($row=$rs->fetch(PDO::FETCH_ASSOC))
		redirect('../../../funciones/error.php?errno=1');
	else {
	$pais=($_POST['paisCdg']==''?NULL:$_POST['paisCdg']);
	$sentencia = $conn->prepare("update ".$sNtabla." set gen_idGenGeoSenplades=?,idGenTipoGeoSenplades=?,descripcion=?, siglasGeoSenplades=?,codigoSenplades=? where id".$idcampo."=?");
	$sentencia->bindParam(1, $pais);
	$sentencia->bindParam(2, $_POST['idGenTipoGeoSenplades']);
	$sentencia->bindParam(3, $_POST['descripcion']);
	$sentencia->bindParam(4, $siglas);
	$sentencia->bindParam(5, $_POST['codigoSenplades']);
	$sentencia->bindParam(6, $_POST['id'.$idcampo]);
	$sentencia->execute() or die('error');
	}
	}
?>