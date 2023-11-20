<?php
session_start();
include_once '../../../clases/autoload.php';
$conn = DB::getConexionDB();
include_once('../../../funciones/redirect.php');
include_once('../../../funciones/funcion_upload.php');
include_once('config.php');
/*
  Este bloque de codigo permite subir archivos al servidor a traves de upload tales como jpg, pdf etc
*/
$swf = false;
$obligatorio = 'N';
foreach ($formulario as $campos) {
	if ($campos['tipo'] == 'file') {
		$swf = true;
		$campoImg = $campos['campoTabla'];
		$obligatorio = $campos['obligatorio'];
	}
}
if ($swf) {
	if ($obligatorio == 'S' and empty($_POST[$campoImg]) and empty($_FILES['myfile']['name']))
		die('El archivo a cargar es obligatorio');

	if (!empty($_FILES['myfile']['name'])) {
		if ($_POST[$idcampo] != '' and $_POST[$idcampo] != 0) {
			$sqlI = "select " . $campoImg . " from " . $tabla . " where " . $idcampo . "=" . $_POST[$idcampo];
			$rsI = $conn->query($sqlI);
			if ($rowI = $rsI->fetch() and !empty($rowI[$campoImg]))
				unlink($_POST['pathFile'] . $rowI[$campoImg]);
		}
		$arch = subirArchivoNoParam('myfile', $_POST['pathFile'], $_POST['fileSize'], $_POST['fileTypes'], $_POST['campoEtiqueta']);
		switch ($arch['a']) {
			case 2:
				$archivo = $arch['b'];
				break;
			case 1:
			case 3:
			case 4:
			case 5:
			case 6:
			case 7:
			case 8:
				die($arch['b']);
				break;
			default:
				die('No se ha subido el Archivo, por favor consulte con el Subadministrador');
				break;
		}
	} else
		if (empty($_POST[$campoImg]))
		$arch = array('a' => '', 'b' => '');
	else
		$arch = array('a' => '', 'b' => $_POST[$campoImg]);
}
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
		$sql = "select * from " . $sNtabla . " where (" . $whered . ")";
		$rs = $conn->query($sql);
		if ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
			redirect('../../../funciones/error.php?errno=1');
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
		$sql = "select * from " . $sNtabla . " where (" . $whered . ") and " . $idcampo . "!=" . $_POST[$idcampo];
		$rs = $conn->query($sql);
		if ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
			redirect('../../../funciones/error.php?errno=1');
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
