<?php
session_start();
include '../../../funciones/db_connect.inc.php';
include_once('../../../funciones/redirect.php');
$sNtabla='hdrTipoResum';
$idcampo=ucfirst($sNtabla);
if($_POST['id'.$idcampo]=='' or $_POST['id'.$idcampo]==0)
	{
	$sql="SELECT idHdrTipoResum FROM hdrTipoResum WHERE desHdrTipoResum = '{$_POST['desHdrTipoResum']}' and idHdrGrupResum = '{$_POST['idHdrGrupResum']}'";
	$rs=$conn->query($sql);
	if ($row=$rs->fetch(PDO::FETCH_ASSOC))
		redirect('../../../funciones/error.php?errno=1');
	else {
	/*------------------------------*/
	// *** CAMBIAR ***
	$sentencia = $conn->prepare("insert into ".$sNtabla." (idHdrGrupResum,desHdrTipoResum,usuario,fecha,ip) values  (?,?,?,now(),?)");
	$sentencia->bindParam(1, $_POST['idHdrGrupResum']);
	$sentencia->bindParam(2, $_POST['desHdrTipoResum']);
	$sentencia->bindParam(3, $_SESSION['usuarioAuditar']);
	$sentencia->bindParam(4, realIP());
	$sentencia->execute() or die('error');
	}
	}
else
	{
	$sql="SELECT idHdrTipoResum FROM hdrTipoResum WHERE desHdrTipoResum = '{$_POST['desHdrTipoResum']}' and idHdrGrupResum = '{$_POST['idHdrGrupResum']}' and id".$idcampo."!=".$_POST['id'.$idcampo];
	$rs=$conn->query($sql);
	if ($row=$rs->fetch(PDO::FETCH_ASSOC))
		redirect('../../../funciones/error.php?errno=1');
	else {
	$sentencia = $conn->prepare("update ".$sNtabla." set idHdrGrupResum = ?,desHdrTipoResum = ?,usuario = ?,fecha = now(),ip = ? where id".$idcampo."=?");
	$sentencia->bindParam(1, $_POST['idHdrGrupResum']);
	$sentencia->bindParam(2, $_POST['desHdrTipoResum']);
	$sentencia->bindParam(3, $_SESSION['usuarioAuditar']);
	$sentencia->bindParam(4, realIP());
	$sentencia->bindParam(5, $_POST['id'.$idcampo]);
	/*-----------------------------------*/
	$sentencia->execute() or die('error');
	}
	}
	redirect('tiporesumen.php?idHdrGrupResum='.$_POST['idHdrGrupResum']);
?>