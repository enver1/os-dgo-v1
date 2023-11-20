<?php
if (!isset($_SESSION)){ session_start();}
include '../../../../funciones/db_connect.inc.php';
include_once('../../../../funciones/redirect.php');
/*----------------------------*/
$sNtabla='hdrRuta'; //  *** CAMBIAR *** Nombre de la tabla
/*-----------------------------*/
$idcampo=ucfirst($sNtabla);// Nombre del Id de la Tabla
if($_POST['id'.$idcampo]=='' or $_POST['id'.$idcampo]==0)
	{
	$sql="select * from hdrRuta where idGenActividadGA='".$_POST['idGenActividadGA']."' and fechaHdrRutaInicio='".$_POST['fechaHdrRutaInicio']."' and horarioInicio='".$_POST['horarioInicio']."' and fechaHdrRutaFin='{$_POST['fechaHdrRutaFin']}' and horarioFin='{$_POST['horarioFin']}'";
	echo $sql;
	$rs=$conn->query($sql);
	if ($row=$rs->fetch(PDO::FETCH_ASSOC))
		redirect('../../../../funciones/error.php?errno=2&alerta=1');
	else {
	/*------------------------------*/
	// *** CAMBIAR ***
	$sentencia = $conn->prepare("insert into hdrRuta (idGenActividadGA,fechaHdrRutaInicio,fechaHdrRutaFin,horarioInicio,horarioFin,idGenPersona,usuario,ip) values  ( ?, ?, ?, ?,?,(SELECT idGenPersona FROM v_persona WHERE documento = ?),?,?)");
	$sentencia->bindParam(1, $_POST['idGenActividadGA']);
	$sentencia->bindParam(2, $_POST['fechaHdrRutaInicio']);
	$sentencia->bindParam(3, $_POST['fechaHdrRutaFin']);
	$sentencia->bindParam(4, $_POST['horarioInicio']);
	$sentencia->bindParam(5, $_POST['horarioFin']);
	$sentencia->bindParam(6, trim($_POST['cedula']));
	$sentencia->bindParam(7, $_SESSION['usuarioAuditar']);
	$sentencia->bindParam(8, realIP());
	$sentencia->execute() or die(print_r($sentencia->errorInfo()));
	}
	}
else
	{
// 	$sql="select * from hdrRuta where idGenActividadGA='".$_POST['idGenActividadGA']."' and fechaHdrRutaInicio='".$_POST['fechaHdrRutaInicio']."' and horarioInicio='".$_POST['horarioInicio']."' and fechaHdrRutaFin='{$_POST['fechaHdrRutaFin']}' and horarioFin='{$_POST['horarioFin']}'";
// 	//echo $sql;
// 	$rs=$conn->query($sql);
// 	if ($row=$rs->fetch(PDO::FETCH_ASSOC))
// 		redirect('../../../../funciones/error.php?errno=2&alerta=1');
// 	else {
	$sentencia = $conn->prepare("update hdrRuta set idGenActividadGA=?,fechaHdrRutaInicio=?,fechaHdrRutaFin=?,horarioInicio=?,horarioFin=?, idGenPersona = (SELECT idGenPersona FROM v_persona WHERE documento = ?), usuario=?,fecha=now(),ip=? where idHdrRuta=?");
	$sentencia->bindParam(1, $_POST['idGenActividadGA']);
	$sentencia->bindParam(2, $_POST['fechaHdrRutaInicio']);
	$sentencia->bindParam(3, $_POST['fechaHdrRutaFin']);
	$sentencia->bindParam(4, $_POST['horarioInicio']);
	$sentencia->bindParam(5, $_POST['horarioFin']);
	$sentencia->bindParam(6, trim($_POST['cedula']));
	$sentencia->bindParam(7, $_SESSION['usuarioAuditar']);
	$sentencia->bindParam(8, realIP());
	$sentencia->bindParam(9, $_POST['idHdrRuta']);
	/*-----------------------------------*/
	$sentencia->execute() or die('error');
// 	}
	}
$pesta='';$recno='';
if($_POST['pesta']<>0)
	$pesta='&pesta='.$_POST['pesta'];
if($_POST['recno']<>0)
	$pesta='&recno='.$_POST['recno'];

redirect('../../../index.php?opc='.$_POST['opc'].$pesta.$recno);
?>