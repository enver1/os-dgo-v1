<?php
if (!isset($_SESSION)){ session_start();}
include '../../../../funciones/db_connect.inc.php';
include_once('../../../../funciones/redirect.php');
/*----------------------------*/
$sNtabla='hdrIntegrante'; //  *** CAMBIAR *** Nombre de la tabla
/*-----------------------------*/
$idcampo=ucfirst($sNtabla);// Nombre del Id de la Tabla

if($_POST['integrante']=='' or $_POST['integrante']==0){
	$sql="select * from ".$sNtabla." where idHdrIntegrante='".$_POST['integrante']."'";
	$sql1="Select idHdrRecurso from hdrRecurso where sha1(idHdrRecurso)='".$_POST['recurso']."'";
	//print_r($sql1);

	$rs=$conn->query($sql);
	$rs1=$conn->query($sql1);
	$rowt = $rs1->fetch(PDO::FETCH_ASSOC);
	if ($row=$rs->fetch(PDO::FETCH_ASSOC))
		redirect('../../../../funciones/error.php?errno=2&alerta=1');
	else {
		/*------------------------------*/
		// *** CAMBIAR ***
		$sentencia = $conn->prepare("insert into ".$sNtabla." (idHdrIntegrante,idHdrRecurso,idHdrFuncion,idGenPersona,idGenEstado,observacionIntegrante, usuario, ip) values(?,?,?,?,?,?,?,?)");
		$sentencia->bindParam(1, $_POST['integrante']);
		$sentencia->bindParam(2, $rowt['idHdrRecurso']);
		$sentencia->bindParam(3, $_POST['idHdrFuncion']);
		$sentencia->bindParam(4, $_POST['idGenPersonal']);
		$sentencia->bindParam(5, $_POST['idGenEstado']);
		$sentencia->bindParam(6, $_POST['observacion']);
		$sentencia->bindParam(7, $_SESSION['usuarioAuditar']);
		$sentencia->bindParam(8, realIP());
		$sentencia->execute() or die(print_r($sentencia->errorInfo()));
	}
}
else{
		$sentencia = $conn->prepare("update hdrIntegrante set idHdrFuncion=?, idGenEstado=?, observacionIntegrante=?, usuario=?, ip=? where idHdrIntegrante=?");
		$sentencia->bindParam(1, $_POST['idHdrFuncion']);
		$sentencia->bindParam(2, $_POST['idGenEstado']);
		$sentencia->bindParam(3, $_POST['observacion']);
		$sentencia->bindParam(4, $_SESSION['usuarioAuditar']);
		$sentencia->bindParam(5, realIP());
		$sentencia->bindParam(6, $_POST['integrante']);
		/*-----------------------------------*/
		$sentencia->execute() or die('error');
	}
	
$pesta='';
$recno='';
if($_POST['pesta']<>'0')
	$pesta='&pesta='.$_POST['pesta'];
if($_POST['recno']<>'0')
	$recno='&recno='.$_POST['recno'];
	
?>
<script>
selectnombre();
function selectnombre()
{
	/**
	 * mostrar el mensaje respectivo
	 */
	//alert('registro guardado exitosamente');
	location.href = "/operaciones/modulos/hdr/integrantesforma.php?Guardar=si&id=<?php echo $_POST['id'];?>&recno=<?php echo $_POST['recno']; ?>&pesta=<?php echo $_POST['pesta'];?>&opc=<?php echo $_POST['opc'];?>";
}
</script>
