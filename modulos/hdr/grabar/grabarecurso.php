<?php
if (!isset($_SESSION)){ session_start();}
include '../../../../funciones/db_connect.inc.php';
include_once('../../../../funciones/redirect.php');
/*----------------------------*/
$sNtabla='hdrRecurso'; //  *** CAMBIAR *** Nombre de la tabla
/*-----------------------------*/
$idcampo=ucfirst($sNtabla);// Nombre del Id de la Tabla
if($_POST['id'.$idcampo]=='' or $_POST['id'.$idcampo]==0)
	{
	$sql="select * from ".$sNtabla." where idHdrRuta='".$_POST['ruta']."' and idHdrRecurso='".$_POST['idHdrRecurso']."' and nominativo='".$_POST['nominativo']."'";

	$rs=$conn->query($sql);
	if ($row=$rs->fetch(PDO::FETCH_ASSOC))
		redirect('../../../../funciones/error.php?errno=2&alerta=1');
	else {
	/*------------------------------*/
	// *** CAMBIAR ***
	$sentencia = $conn->prepare("insert into ".$sNtabla." (idHdrRuta,idHdrEstadoRecurso,nominativo,idHdrVehiculo, telefonoRecurso, radioRecurso, obsHdrRecurso, usuario, ip) values((select  idHdrRuta from hdrRuta where sha1(idHdrRuta)=?),?,?,?,?,?,?,?,?)");
	$sentencia->bindParam(1, $_POST['idHdrRuta']);
	$sentencia->bindParam(2, $_POST['idHdrEstadoRecurso']);
	$sentencia->bindParam(3, $_POST['nominativo']);
	$sentencia->bindParam(4, $_POST['idHdrVehiculo']);
	$sentencia->bindParam(5, $_POST['telefonoRecurso']);
	$sentencia->bindParam(6, $_POST['radioRecurso']);
	$sentencia->bindParam(7, $_POST['observacion']);
	$sentencia->bindParam(8, $_SESSION['usuarioAuditar']);
	$sentencia->bindParam(9, realIP());
	
	$sentencia->execute() or die(print_r($sentencia->errorInfo()));
	}
	}
else{
		
	$sql="select * from ".$sNtabla." where idHdrRuta='".$_POST['ruta']."' and idHdrRecurso<>'".$_POST['idHdrRecurso']."' and nominativo = '".$_POST['nominativo']."'";
	echo $sql;

	$rs=$conn->query($sql);
	if ($row=$rs->fetch(PDO::FETCH_ASSOC))
		redirect('../../../../funciones/error.php?errno=2&alerta=1');
	else {
	$sentencia = $conn->prepare("update hdrRecurso set idHdrEstadoRecurso=?,nominativo=?, idHdrVehiculo=?, telefonoRecurso=?, radioRecurso=?, obsHdrRecurso=?, usuario=?, ip=? where idHdrRecurso=?");
	$sentencia->bindParam(1, $_POST['idHdrEstadoRecurso']);
	$sentencia->bindParam(2, $_POST['nominativo']);
	$sentencia->bindParam(3, $_POST['idHdrVehiculo']);
	$sentencia->bindParam(4, $_POST['telefonoRecurso']);
	$sentencia->bindParam(5, $_POST['radioRecurso']);
	$sentencia->bindParam(6, $_POST['observacion']);
	$sentencia->bindParam(7, $_SESSION['usuarioAuditar']);
	$sentencia->bindParam(8, realIP());
	$sentencia->bindParam(9, $_POST['idHdrRecurso']);
	/*-----------------------------------*/
	$sentencia->execute() or die('error');
	}
	
}
$pesta='';
$recno='';
if($_POST['pesta']<>'0')
	$pesta='&pesta='.$_POST['pesta'];
if($_POST['idHdrRuta']<>'0')
	$recno='&recno='.$_POST['idHdrRuta'];
?>
<script>
selectnombre();
function selectnombre()
{
	parent.parent.window.location="../../../index.php?opc=<?php echo $_POST['opc'].$pesta.$recno ?>";
	parent.parent.GB_hide();
}
</script>