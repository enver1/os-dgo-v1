<?php
/**
 * Se obtiene datos principales como fecha de la hoja de ruta a clonarse
 * Ingresando nuevas fechas de inicio y fin, asi mismo como las horas
 * @author Juan León SIS-ECU 911
 * @fecha 11-06-2014
 * @package modulos/hdr/grabar/grabahdrduplicar.php
 */

/**
 * importando clase de conexion con Base de Datos
 */
include '../../../../funciones/db_connect.inc.php';

/**
 * obteniendo el id de la hoja de ruta anterior
 */
$idHdrRutaClonar = $_POST['idHdrRutaClonar'];

/**
 * obteniendo los recursos registrados en la hoja de ruta a clonar
 */
$sql = "SELECT idHdrRecurso, idHdrEstadoRecurso, idHdrVehiculo, nominativo, telefonoRecurso, radioRecurso, obsHdrRecurso FROM hdrRecurso WHERE idHdrRuta = $idHdrRutaClonar";
$rs = $conn->query($sql);
/**
 * recorriendo los datos y guardando en un arreglo asociativo provicional
 */
$array = array();
while( $row = $rs->fetch(PDO::FETCH_ASSOC)){
	$recursos = array();
	$recursos['recursos'] = $row;
	$recursos['integrantes'] = getIntegrantes($row['idHdrRecurso'], $conn);
	$recursos['sectores'] = getSectores($row['idHdrRecurso'], $conn);
	
	$array[] = $recursos;
}

/**
 * iniciando la transacción
 */
$conn->beginTransaction();

/**
 * Guardar Hoja de Ruta
 */
$sentencia = $conn->prepare("insert into hdrRuta (idGenActividadGA,idGenPersona,fechaHdrRutaInicio,fechaHdrRutaFin,horarioInicio,horarioFin,usuario,ip)values( ?, ?, ?, ?,?,?,?,?)");
$sentencia->bindParam(1, $_POST['idGenActividadGA']);
$sentencia->bindParam(2, $_POST['idGenPersona']);
$sentencia->bindParam(3, $_POST['fechaHdrRutaInicio']);
$sentencia->bindParam(4, $_POST['fechaHdrRutaFin']);
$sentencia->bindParam(5, $_POST['horarioInicio']);
$sentencia->bindParam(6, $_POST['horarioFin']);
$sentencia->bindParam(7, $_SESSION['usuarioAuditar']);
$sentencia->bindParam(8, realIP());
$sentencia->execute() or die(print_r($sentencia->errorInfo()));
/**
 * obteniendo el Id de autoincremento
 */
$idHdrRuta = $conn->lastInsertId();

/**
 * recorriendo arreglo
 */
foreach($array as $row){
	
	$recursos = $row['recursos'];
	
	if($recursos['idHdrVehiculo'] > 0){
		/**
		 * preparando sentencia para el guardado de recursos vehiculos
		 */
		$senRecursosV = $conn->prepare("insert into hdrRecurso (idHdrRuta,idHdrEstadoRecurso,nominativo,idHdrVehiculo, telefonoRecurso, radioRecurso, obsHdrRecurso, usuario, ip) values(?,?,?,?,?,?,?,?,?)");
		$senRecursosV->bindParam(1, $idHdrRuta);
		$senRecursosV->bindParam(2, $recursos['idHdrEstadoRecurso']);
		$senRecursosV->bindParam(3, $recursos['nominativo']);
		$senRecursosV->bindParam(4, $recursos['idHdrVehiculo']);
		$senRecursosV->bindParam(5, $recursos['telefonoRecurso']);
		$senRecursosV->bindParam(6, $recursos['radioRecurso']);
		$senRecursosV->bindParam(7, $recursos['obsHdrRecurso']);
		$senRecursosV->bindParam(8, $_SESSION['usuarioAuditar']);
		$senRecursosV->bindParam(9, realIP());
		$senRecursosV->execute() or die(print_r($senRecursosV->errorInfo()));
	}else{
		/**
		 * preparando sentencia para el guardado de recursos cuando se es a pie
		 */
		$sentenciaP = $conn->prepare("insert into hdrRecurso (idHdrRuta,idHdrEstadoRecurso,nominativo, telefonoRecurso, radioRecurso, obsHdrRecurso, usuario, ip) values(?,?,?,?,?,?,?,?)");
		$sentenciaP->bindParam(1, $idHdrRuta);
		$sentenciaP->bindParam(2, $recursos['idHdrEstadoRecurso']);
		$sentenciaP->bindParam(3, $recursos['nominativo']);
		$sentenciaP->bindParam(4, $recursos['telefonoRecurso']);
		$sentenciaP->bindParam(5, $recursos['radioRecurso']);
		$sentenciaP->bindParam(6, $recursos['obsHdrRecurso']);
		$sentenciaP->bindParam(7, $_SESSION['usuarioAuditar']);
		$sentenciaP->bindParam(8, realIP());
		$sentenciaP->execute() or die(print_r($sentenciaP->errorInfo()));
	}
	/**
	 * obteniendo el Id del codigo autoincremental del recurso grabado
	 */
	$idRecurso = $conn->lastInsertId();
	
	/**
	 * obteniendo arreglo de integrantes
	 */
	$integrantes = $row['integrantes'];
	
	/**
	 * recorriendo arreglo y guardando
	 */
	foreach ($integrantes as $lstIntegrantes){
		$rowIntegrantes =  $lstIntegrantes['integrantes'];
		/**
		 * preparando sentencia para el guardado de integrantes
		 */
		$sentenciaI = $conn->prepare("insert into hdrIntegrante (idHdrRecurso,idHdrFuncion,idGenPersona,idGenEstado,observacionIntegrante, usuario, ip) values(?,?,?,?,?,?,?)");
		$sentenciaI->bindParam(1, $idRecurso);
		$sentenciaI->bindParam(2, $rowIntegrantes['idHdrFuncion']);
		$sentenciaI->bindParam(3, $rowIntegrantes['idGenPersona']);
		$sentenciaI->bindParam(4, $rowIntegrantes['idGenEstado']);
		$sentenciaI->bindParam(5, $rowIntegrantes['observacionIntegrante']);
		$sentenciaI->bindParam(6, $_SESSION['usuarioAuditar']);
		$sentenciaI->bindParam(7, realIP());
		$sentenciaI->execute() or die(print_r($sentenciaI->errorInfo()));
		
		$idHdrIntegrante = $conn->lastInsertId();
		
		$actividades = $lstIntegrantes['actividades'];
		
		foreach ($actividades as $rowActividades){
			/**
			 * insertado
			 */
			$sqlInsert = "INSERT INTO hdrIntegAct(idHdrIntegrante,horaIni,horaFin,obsActividad,usuario,ip)VALUE(?,?,?,?,?,?)";
			$sentenciaA=$conn->prepare($sqlInsert);
			$sentenciaA->bindParam(1, $idHdrIntegrante);
			$sentenciaA->bindParam(2, $rowActividades['horaIni']);
			$sentenciaA->bindParam(3, $rowActividades['horaFin']);
			$sentenciaA->bindParam(4, $rowActividades['obsActividad']);
			$sentenciaA->bindParam(5, $_SESSION['usuarioAuditar']);
			$sentenciaA->bindParam(6, realIP());
			$sentenciaA->execute() or die(print_r($sentencia->errorInfo()));
		}
	}
	/**
	 * obteniendo arreglo de sectores
	 */
	$sectores = $row['sectores'];
	
	/**
	 * recorriendo arreglo y guardando
	 */
	foreach($sectores as $rowSectores){
		/**
		 * preparando sentencia para el guardado de sectores patrulla
		 */
		$sentenciaSP = $conn->prepare("INSERT INTO hdrSectorPatrulla(idHdrRecurso,idGenGeoSenplades,usuario,ip)VALUES(?,?,?,?)");
		$sentenciaSP->bindParam(1,$idRecurso);
		$sentenciaSP->bindParam(2,$rowSectores['idGenGeoSenplades']);
		$sentenciaSP->bindParam(3, $_SESSION['usuarioAuditar']);
		$sentenciaSP->bindParam(4, realIP());
		$sentenciaSP->execute() or die(print_r($sentenciaSP->errorInfo()));
	}
}

/**
 * guardando los cambios sin problemas
 */
$conn->commit();

$pesta='';$recno='';
if($_POST['pesta']<>0)
	$pesta='&pesta='.$_POST['pesta'];

$recno='&recno='.sha1($idHdrRuta);

?>
<script>
selectnombre();
function selectnombre()
{
	//alert('Hoja de Ruta Duplicada Exitosamente');
	parent.parent.window.location="../../../index.php?opc=<?php echo $_POST['opc'].$pesta.$recno ?>";
	parent.parent.GB_hide();
}
</script>
<?php
/**
 * funcion que obtiene los integrantes del recurso en vehiculo o a pie asignados
 * @param number $idHdrRecurso codigo del recurso
 * @param object $conn objeto de conexion
 */
function getIntegrantes($idHdrRecurso, $conn){
	/**
	 * consulta de obtención de datos
	 */
	$sql = "SELECT idHdrIntegrante, idHdrFuncion, idGenPersona, idGenEstado, observacionIntegrante FROM hdrIntegrante WHERE idHdrRecurso = $idHdrRecurso";
	$rs = $conn->query($sql);
	
	/**
	 * recorriendo el resultado
	 */
	$array = array();
	while( $row = $rs->fetch(PDO::FETCH_ASSOC)){
		$aux = array();
		$aux['integrantes'] = $row;
		$aux['actividades'] = getActividades($row['idHdrIntegrante'], $conn);
		$array[] = $aux;
	}
	
	return $array;
}
/**
 * obtener las actividades registradas a un integrante
 * @param number $idHdrIntegrante
 * @param object $conn
 * @return array
 */
function getActividades($idHdrIntegrante, $conn){
	/**
	 * consulta de obtención de datos
	 */
	$sql = "SELECT horaIni, horaFin, obsActividad FROM hdrIntegAct WHERE idHdrIntegrante = $idHdrIntegrante";
	$rs = $conn->query($sql);
	
	/**
	 * recorriendo el resultado
	*/
	$array = array();
	while( $row = $rs->fetch(PDO::FETCH_ASSOC)){
		$array[] = $row;
	}
	
	return $array;
}

/**
 * funcion que obtiene los sectores a cubrir por el recurso
 * @param number $idHdrRecurso codigo del recurso
 * @param object $conn objeto de conexcion
 */
function getSectores($idHdrRecurso, $conn){
	/**
	 * consulta de obtención de datos
	 */
	$sql = "SELECT idGenGeoSenplades FROM hdrSectorPatrulla WHERE idHdrRecurso = $idHdrRecurso";
	$rs = $conn->query($sql);
	
	/**
	 * recorriendo el resultado
	*/
	$array = array();
	while( $row = $rs->fetch(PDO::FETCH_ASSOC)){
		$array[] = $row;
	}
	
	return $array;
}
?>