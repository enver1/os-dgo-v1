<?php
if (!isset($_SESSION)){ session_start();}
include '../../../../funciones/db_connect.inc.php';
include 'logica.php';
/**
 * obtener datos desde una clase
 */
$logica = new logica($conn);
if(isset($_POST['detalleResumen'])){
	switch($_POST['detalleResumen']){
		case 1:
			//insertar
			$idHdrTipoResum = $_POST['SubResumenId'];
			$idHdrEvento = $_POST['idHdrEvento'];
			$cantidad = $_POST['txtcantidad'];
			$descEventoResum = $_POST['txtdescripcion'];
			$usuario = $_SESSION['usuarioAuditar'];
			$ip = realIP();
			if($logica->guardarDetalleEvento($idHdrTipoResum, $idHdrEvento, $cantidad, $descEventoResum, $usuario, $ip)){
				echo json_encode(array('success'=>true, 'msg'=>'Detalle guardado exitosamente'));
			}else{
				echo json_encode(array('success'=>false, 'msg'=>'Error al guardar intente de nuevo'));
			}
		break;
		case 2:
			//actualizar
		break;
		case 3:
			//borrar
		break;
	}
	exit();
}
/**
 * 
 */
if(isset($_POST['txtbuscarRecurso'])){
	$array = $logica->buscarRecursoHojaRuta(date('Y-m-d'), date('H:m:s'), $_POST['txtbuscarRecurso']);
	?>
	<table style="width: 100%;">
	<tr>
		<th class="data-th" width="15%">Codigo</th>
		<th class="data-th" width="25%">Nominativo</th>
		<th class="data-th" width="25%">Radio Recurso</th>
		<th class="data-th" width="5%">Tel&eacute;fono Recurso</th>
		<th class="data-th" width="30%">Observaci&oacute;n</th>
	</tr>
	<?php	
		foreach($array as $row){
		?>
		<tr  class='data-tr' align='center'>
			<td><?php echo $row['idHdrRecurso']?></td>
			<td><a href="javascript:void(0)" onclick="seleccionarRecurso('<?php echo $row['idHdrRecurso']?>','<?php echo $row['nominativo']?>')"><?php echo $row['nominativo']?></a></td>
			<td><?php echo $row['radioRecurso']?></td>
			<td><?php echo $row['cantidad']?></td>
			<td><?php echo $row['descEventoResum']?></td>
		</tr>	
		<?php
		}
	?>	
	</table>
	<?php
}

if(isset($_POST['eliminarRecurso'])){
	$idRecursoEvento = $_POST['recurso'];
	$sql="SELECT * FROM hdrActividad WHERE idRecursoEvento = $idRecursoEvento";
	$rs=$conn->query($sql);
	if (!($row=$rs->fetch(PDO::FETCH_ASSOC))){
		$idRecursoEvento = $_POST['recurso'];
		if($logica->eliminarvehiculoAsignado($idRecursoEvento)){
			echo json_encode(array('success'=>true, 'msg'=>'Recurso eliminado exitosamente'));
		}else{
			echo json_encode(array('success'=>false, 'msg'=>'Error al asignar intente de nuevo'));
		}
	}else{
		echo json_encode(array('success'=>false, 'msg'=>'No se puede eliminar el recurso, ya cuenta con actividades registradas'));
	}
}

if(isset($_POST['guardarAsignacion'])){
	$idHdrEvento = $_POST['idHdrEvento'];
	$idHdrRecurso= $_POST['AsigCodigoId'];
	$descripcion = $_POST['DescripcionAsignacion'];
	$usuario = $_SESSION['usuarioAuditar']; 
	$ip = realIP();
	if($logica->guardarvehiculoAsignado($idHdrEvento, $idHdrRecurso, $descripcion, $usuario, $ip)){
		echo json_encode(array('success'=>true, 'msg'=>'Recurso asignado exitosamente'));
	}else{
		echo json_encode(array('success'=>false, 'msg'=>'Error al asignar intente de nuevo'));
	}
}

if(isset($_POST['eliminarDetalle'])){
	$idHdrEventoResum = $_POST['detalle'];
	if($logica->eliminarEventoDetalle($idHdrEventoResum)){
		echo json_encode(array('success'=>true, 'msg'=>'Detalle eliminado exitosamente'));
	}else{
		echo json_encode(array('success'=>false, 'msg'=>'Error al asignar intente de nuevo'));
	}
}

if(isset($_POST['guardarInformacion'])){
	$fechaEvento = $_POST['fechaEjecucion'].' '.$_POST['horaecho'];
	$latitud1 = $_POST['latitud'];
	$longitud2 = $_POST['longitud'];
	$idGenGeoSenplades = $_POST['subCircuito'];
	$idGenTipoTipificacionReal = $_POST['tipotipificacion'];
	$idHdrEvento = $_POST['idHdrEvento'];
	if($logica->guardarInformacionUbicacion($fechaEvento, $latitud1, $longitud2, $idGenGeoSenplades, $idGenTipoTipificacionReal, $idHdrEvento)){
		echo json_encode(array('success'=>true, 'msg'=>'Datos guardados exitosamente'));
	}else{
		echo json_encode(array('success'=>false, 'msg'=>'Error al guardar intente de nuevo'));
	}
}

if(isset($_POST['guardarRegistroResumen'])){
	$descripcionFinal = $_POST['resumen'];
	$idHdrEvento = $_POST['idHdrEvento'];
	if($logica->guardarDescripcionFinal($descripcionFinal, $idHdrEvento)){
		echo json_encode(array('success'=>true, 'msg'=>'Datos guardados exitosamente'));
	}else{
		echo json_encode(array('success'=>false, 'msg'=>'Error al guardar intente de nuevo'));
	}
}

if(isset($_POST['finalizarFicha'])){
	$idGenPersona = $_SESSION['usuarioAuditar'];
	$estadoPolicia = $_POST['finalizarFicha'];
	$usuario = $_SESSION['usuarioAuditar']; 
	$ip = realIP();
	$idHdrEvento = $_POST['idHdrEvento'];
	if($logica->FinalizarFicha($idGenPersona, $estadoPolicia, $usuario, $ip, $idHdrEvento)){
		echo json_encode(array('success'=>true, 'msg'=>'Ficha Finalizada exitosamente'));
	}else{
		echo json_encode(array('success'=>false, 'msg'=>'Error al guardar intente de nuevo'));
	}
}

if(isset($_POST['insertarActividad'])){
	$idHdrEstadoActividad = $_POST['idHdrEstadoActividad'];
	$idRecursoEvento = $_POST['idRecursoEvento'];
	$descripcion = $_POST['descripcionActividad'];
	$horaActividad = date('H:m:s');
	$fechaActividad = date('Y-m-d');
	$usuario = $_SESSION['usuarioAuditar']; 
	$ip = realIP();
	if($logica->insertarActividadrecurso($idHdrEstadoActividad, $idRecursoEvento, $descripcion, $horaActividad, $fechaActividad, $usuario, $ip)){
		echo json_encode(array('success'=>true, 'msg'=>'Actividad agregada exitosamente'));
	}else{
		echo json_encode(array('success'=>false, 'msg'=>'Error al registrar actividad intente de nuevo'));
	}
}

if(isset($_POST['actividadDetalleEventoRecurso'])){
	$idRecursoEvento = $_POST['codigo'];
	$array = $logica->obtenerActividadRecursoEvento($idRecursoEvento);
?>
	<table style="width: 100%;">
	<tr>
		<th class="data-th" width="15%">Fecha</th>
		<th class="data-th" width="15%">Hora</th>
		<th class="data-th" width="50%">Descripci&oacute;n</th>
		<th class="data-th" width="20%">Estado</th>
	</tr>
	<?php	
		foreach($array as $row){
		?>
		<tr  class='data-tr' align='center'>
			<td><?php echo $row['fechaActividad']?></td>
			<td><?php echo $row['horaActividad']?></td>
			<td><?php echo $row['descripcion']?></td>
			<td><?php echo $row['estado']?></td>
		</tr>	
		<?php
		}
	?>	
	</table>
	<?php
}