<?php
session_start();
include '../../../../clases/autoload.php';
$conn = DB::getConexionDB();
include_once('../../../../funciones/redirect.php');
$transaccion = new Transaccion;
$ip = $transaccion->getRealIP();
$tStructure = array(
	'idDgoParticipa' => 'idDgoParticipa',
	'idDgoVisita' => 'idDgoVisita',
	//'idDgoEjeProcSu'=>'idDgoEjeProcSu',
	'idGenPersona' => 'idGenPersona',
	'tipoParticipacion' => 'tipoParticipacion',
	'obsDgoParticipa' => 'obsDgoParticipa',
);

$idcampo = 'idDgoParticipa';
$sNtabla = 'dgoParticipa';
/* Campo de la tabla que permite evitar registros duplicados al momento de grabar
	Si no desea controlar duolicados deje en blanco el campo*/
$descripcion = 'idGenPersona';

//print_r($_POST);
//die();
/*
  Este bloque de codigo permite subir archivos al servidor a traves de upload tales como jpg, pdf etc
*/
$swf = false;
$obligatorio = 'N';
/*   Fin  bloque subir archivos */

if ($_POST[$idcampo] == '' or $_POST[$idcampo] == 0) {
	/* Verifica que no exista una descripcion duplicada al hacer insert */
	if (!empty($descripcion)) {
		$cdupli = explode(',', $descripcion);
		$whered = '';
		$masdeunaCondicion = true;
		foreach ($cdupli as $camposd) {
			if ($masdeunaCondicion) {
				$whered .= $camposd . "='" . trim($_POST[$camposd]) . "'";
				$masdeunaCondicion = false;
			} else
				$whered .= ' and ' . $camposd . "='" . trim($_POST[$camposd]) . "'";
		}
		//		$sql="select * from ".$sNtabla." where (".$whered.") and idDgoVisita='".$_POST['idDgoVisita']."' and idDgoEjeProcSu='".$_POST['idDgoEjeProcSu']."'";
		$sql = "select * from " . $sNtabla . " where (" . $whered . ") and idDgoVisita='" . $_POST['idDgoVisita'] . "'";
		$rs = $conn->query($sql);
		if ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
			die('Error al grabar el Participante ya existe en este proceso');
			$noduplicado = false;
		} else
			$noduplicado = true;
	} else
		$noduplicado = true;

	if ($noduplicado) {
		/*------ SI el ID de la tabla viene en cero o vacio es un nuevo registro por lo tanto hace un INSERT -------------*/
		$sqlI = "insert into " . $sNtabla . " (";
		$sf = " values (";
		/* Construye la sentencia INSERT a partir del arreglo $tStructure */
		foreach ($tStructure as $campo => $valor) {
			$sqlI .= $campo . ",";
			$sf .= "?,";
		}
		if ($swf)
			$sqlI .= "usuario,ip," . $campoImg . ")" . $sf . "?, ?, ?)";
		else
			$sqlI .= "usuario,ip)" . $sf . "?, ?)";

		$sentencia = $conn->prepare($sqlI);
		$i = 1;
		/* Construye la lista de parametros a partir del arreglo $tStructure */
		foreach ($tStructure as $campo => $valor) {
			$sentencia->bindParam($i, $_POST[$valor]);
			$i++;
		}
		$sentencia->bindParam($i, $_SESSION['usuarioAuditar']);
		$sentencia->bindParam(++$i, $ip);
		if ($swf)
			$sentencia->bindParam(++$i,	$arch['b']);
		$sentencia->execute() or die('error');
	}
} else
/*===== Caso contrario si el ID es diferente de 0 o de espacio esta editando el registro y hace un UPDATE ======*/ {
	/* Verifica que no exista una descripcion duplicada al hacer update */
	if (!empty($descripcion)) {
		$cdupli = explode(',', $descripcion);
		$whered = '';
		$masdeunaCondicion = true;
		foreach ($cdupli as $camposd) {
			if ($masdeunaCondicion) {
				$whered .= $camposd . "='" . trim($_POST[$camposd]) . "'";
				$masdeunaCondicion = false;
			} else
				$whered .= ' and ' . $camposd . "='" . trim($_POST[$camposd]) . "'";
		}
		//			$sql="select * from ".$sNtabla." where (".$whered.") and idDgoVisita='".$_POST['idDgoVisita']."' and idDgoEjeProcSu='".$_POST['idDgoEjeProcSu']."' and ".$idcampo."!=".$_POST[$idcampo];
		$sql = "select * from " . $sNtabla . " where (" . $whered . ") and idDgoVisita='" . $_POST['idDgoVisita'] . "'  and " . $idcampo . "!=" . $_POST[$idcampo];
		$rs = $conn->query($sql);
		if ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
			die('Error al grabar el Participante ya existe en este proceso');
			$noduplicado = false;
		} else
			$noduplicado = true;
	} else
		$noduplicado = true;
	if ($noduplicado) {
		$sqlI = "update " . $sNtabla . " set ";
		/* Construye la sentencia UPDATE a partir del arreglo $tStructure */
		foreach ($tStructure as $valor) {
			$sqlI .= $valor . "=?, ";
		}
		if ($swf)
			$sqlI .= "usuario=?,fecha=now(),ip=?," . $campoImg . "=? where " . $idcampo . "=?";
		else
			$sqlI .= "usuario=?,fecha=now(),ip=? where " . $idcampo . "=?";
		$sentencia = $conn->prepare($sqlI);
		$i = 1;
		/* Construye la lista de parametros a partir del arreglo $tStructure */
		foreach ($tStructure as $campo => $valor) {
			$sentencia->bindParam($i, $_POST[$valor]);
			$i++;
		}
		$sentencia->bindParam($i, $_SESSION['usuarioAuditar']);
		$sentencia->bindParam(++$i, $ip);
		if ($swf) {
			$sentencia->bindParam(++$i, $arch['b']);
		}
		$sentencia->bindParam(++$i, $_POST[$idcampo]);
		/*-----------------------------------*/
		$sentencia->execute() or die(print_r($sentencia->errorInfo()));
	}
}
