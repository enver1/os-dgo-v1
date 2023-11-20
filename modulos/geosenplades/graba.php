	<?php
session_start();
include '../../../funciones/db_connect.inc.php';
include '../../../funciones/redirect.php';
$sNtabla='genGeoSenplades';
$idcampo=ucfirst($sNtabla);
if ($_POST['tipo']=='')
		$subtipo=1;
		else
		$subtipo=$_POST['tipo'];
if($_POST['id'.$idcampo]=='' or $_POST['id'.$idcampo]==0)
	{
			if ($_POST['siglasParte1']=='')
		$siglas=$_POST['siglasGeoSenplades'];
		else
		$siglas=trim($_POST['siglasParte1']).'-'.$_POST['siglasGeoSenplades'];
		$pais=($_POST['paisCdg']==''?' is null ':'='.$_POST['paisCdg']);
	$sql="select * from ".$sNtabla." where descripcion='".$_POST['descripcion']."' and gen_idGenGeoSenplades".$pais;
	$rs=$conn->query($sql);
	if ($row=$rs->fetch(PDO::FETCH_ASSOC))
		redirect('../../../funciones/error.php?errno=1');
	else {
	
	$pais=($_POST['paisCdg']==''?NULL:$_POST['paisCdg']);
	$sqlInsert="insert into ".$sNtabla." (gen_idGenGeoSenplades,idGenTipoGeoSenplades,descripcion,siglasGeoSenplades,codigoSenplades,usuario,ip) values  ( ?, ?, ?, ?, ?, ?,?)";
	//echo $sqlInsert;
	//echo 'pais:'.$pais.' tipo:'.$subtipo.' descripcion:'.$_POST['descripcion'].' siglas:'.$siglas.' codigoSenplades:'.$_POST['codigoSenplades'].' usuario:'.$_SESSION['usuarioAuditar'].' ip:'.$ip.' campo:'.$_POST['id'.$idcampo] ;
	$sentencia = $conn->prepare($sqlInsert);
	$sentencia->bindParam(1, $pais);
	$sentencia->bindParam(2, $subtipo);
	$sentencia->bindParam(3, $_POST['descripcion']);
	$sentencia->bindParam(4, $siglas);
	$sentencia->bindParam(5, $_POST['codigoSenplades']);
	$sentencia->bindParam(6, $_SESSION['usuarioAuditar']);
	$sentencia->bindParam(7, $ip);
	$sentencia->execute() or die('error');
	
	}
	}
else
	{
		if ($_POST['siglasParte1']=='')
			$siglas=$_POST['siglasGeoSenplades'];
		else
			$siglas=trim($_POST['siglasParte1']).'-'.$_POST['siglasGeoSenplades'];
		$pais=($_POST['paisCdg']==''?' is null ':'='.$_POST['paisCdg']);
		$sql="select * from ".$sNtabla." where descripcion='".$_POST['descripcion']."' and idGenTipoGeoSenplades=". $_POST['tipo']." and gen_idGenGeoSenplades". $pais." and idGenGeoSenplades!=".$_POST['id'.$idcampo];
		//die($sql);
		$rs=$conn->query($sql);
		if ($row=$rs->fetch(PDO::FETCH_ASSOC))
			redirect('../../../funciones/error.php?errno=1');
		else {
			$pais=($_POST['paisCdg']==''?NULL:$_POST['paisCdg']);
			$sqlUpdate="update ".$sNtabla." set gen_idGenGeoSenplades=?,idGenTipoGeoSenplades=?,descripcion=?, siglasGeoSenplades=?,codigoSenplades=?,usuario=?,fecha=now(),ip=? where id".$idcampo."=?";
			//echo $sqlUpadate;
			//echo 'pais:'.$pais.' tipo:'.$subtipo.' descripcion:'.$_POST['descripcion'].' siglas:'.$siglas.' codigoSenplades:'.$_POST['codigoSenplades'].' usuario:'.$_SESSION['usuarioAuditar'].' ip:'.$ip.' campo:'.$_POST['id'.$idcampo] ;
			$sentencia = $conn->prepare($sqlUpdate);
			$sentencia->bindParam(1, $pais);
			$sentencia->bindParam(2, $subtipo);
			$sentencia->bindParam(3, $_POST['descripcion']);
			$sentencia->bindParam(4, $siglas);
			$sentencia->bindParam(5, $_POST['codigoSenplades']);
			$sentencia->bindParam(6, $_SESSION['usuarioAuditar']);
			$sentencia->bindParam(7, $ip);
			$sentencia->bindParam(8, $_POST['id'.$idcampo]);
			$sentencia->execute() or die('error');
		}
	}
?>