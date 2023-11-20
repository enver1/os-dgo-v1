<?php
if (!isset($_SESSION)){ session_start();}
if(!isset($_SESSION['usuarioAuditar'])) exit();

include '../../../../funciones/db_connect.inc.php';
include 'Configuraciones.php';
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

if(isset($_REQUEST['txtSerachNominativo'])){
	$array = $logica->buscarRecurso(date('Y-m-d'), date('H:i:s'), $_POST['txtbuscarRecurso']);
	?>
		<table style="width: 100%;">
		<tr>
			<th class="data-th">Nominativo</th>
		</tr>
		<?php	
			foreach($array as $row){
			?>
			<tr  class='data-tr' align='center'>
				<td>
					<form action="modulos/evento115/logica/evento115.php" method="post">
						<input type="hidden" name="idHdrRecurso" id="idHdrRecurso" value="<?php echo $row['idHdrRecurso']?>">
						<input type="hidden" name="nominativo" id="nominativo" value="<?php echo $row['nominativo']?>" >
						<button type="button" onclick="seleccionar(this.form)">
							<img src="/operaciones/imagenes/arrow_left.png">
						</button>
						<a class="tooltipIM" href="javascript:void(0)">
							<?php echo $row['nominativo']?>
							<span style="color:blue;" class="fichaSel">
								<p><?php 
								echo 'Radio: '.$row['radioRecurso'].'<br>';
								echo 'telefono: '.$row['telefonoRecurso'].'<br>';
								echo 'Observaci&oacute;n: '.$row['obsHdrRecurso'];
								?></p>
		                	</span>
		                </a>
					</form>
				</td>
			</tr>	
			<?php
			}
		?>	
		</table>
		<?php
		exit();
}

if(isset($_REQUEST['actPro'])){
	$idEventoRecurso=$_REQUEST['idRecursoEvento'];
	$idEvento=$_REQUEST['idHdrEvento'];
	$logica->actualizarProcedimiento($idEventoRecurso, $idEvento);
	exit();
}

if(isset($_REQUEST['guardarACT'])){
$idHdrRecurso = $_REQUEST['idHdrRecurso'];
$idHdrEstadoActividad = $_REQUEST['idHdrEstadoActividad'];
$descripcion = $_REQUEST['descripcion'];
$horaActividad = $_REQUEST['hora'];
$fechaActividad = $_REQUEST['fecha'];
$usuario = $_SESSION['usuarioAuditar']; 
	$ip = realIP();  
$logica->inserthdrActiRec($idHdrRecurso, $idHdrEstadoActividad, $descripcion, $horaActividad, $fechaActividad, $usuario, $ip);	
exit();
}
if(isset($_REQUEST['recursoACT'])){
	$array = $logica->getActividadRecursoNominativo($_REQUEST['idHdrRecurso']);
	?>
	<table style="width: 100%;">
		<tr>
			<th class="data-th">Nominativo</th>
			<th class="data-th">Fecha Actividad</th>
			<th class="data-th">Hora Actividad</th>
			<th class="data-th">Descripci&oacute;n</th>
			<th class="data-th">Estado</th>
		</tr>
		
		<?php foreach ($array as $row){
		?>
		<tr class='data-tr' >
			<td><?php echo $row['nominativo']?></td>
			<td><?php echo $row['fechaActividad']?></td>
			<td><?php echo $row['horaActividad']?></td>
			<td><?php echo $row['desc']?></td>
			<td><?php echo $row['descripcion']?></td>
		</tr>
		<?php
		}?>
		
	</table>
	<?php
}
/**
 * 
 */
if(isset($_POST['txtbuscarRecurso'])){
	$array = $logica->buscarRecursoHojaRuta($_POST['txtbuscarRecurso']);
	?>
	<table style="width: 100%;">
	<tr>
		<th class="data-th">Nominativo</th>
	</tr>
	<?php	
		foreach($array as $row){
		?>
		<tr  class='data-tr' align='center'>
			<td>
				<form action="modulos/evento115/logica/evento115.php" method="post">
					<input type="hidden" name="guardarAsignacion" value="1"/>
					<input type="hidden" name="AsigCodigoId" id="AsigCodigoId" value="<?php echo $row['idHdrRecurso']?>">
					<input type="hidden" name="DescripcionAsignacion" value="Recurso despachado">
					<input type="hidden" value="<?php echo $_POST['idHdrEvento']?>" name="idHdrEvento">
					<button type="button" onclick="guardarAsignacionRecurso(this.form)">
						<img src="/operaciones/imagenes/arrow_left.png">
					</button>
					<a class="tooltipIM" href="javascript:void(0)">
						<?php echo $row['nominativo']?>
						<span style="color:blue;" class="fichaSel">
							<p><?php 
							if(strlen($row['placa'])>4){
								echo 'Placa: '.$row['placa'].'<br>';
							}else{
								echo 'Chasis: '.$row['placa'].'<br>';
							}
							echo 'Radio: '.$row['radioRecurso'].'<br>';
							echo 'telefono: '.$row['telefonoRecurso'].'<br>';
							echo 'Observaci&oacute;n: '.$row['obsHdrRecurso'].'<br>';
							echo 'Sector: '.$row['sector'];
							?></p>
	                	</span>
	                </a>
				</form>
			</td>
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
	
	$hora = date('H');
	$minuto = date('i');
	$segundo = date('s');
	$horaActividad = $hora.':'.$minuto.':'.$segundo;
	
	$dia = date('d');
	$mes = date('m');
	$anio = date('Y');
	$fechaActividad = $anio.'-'.$mes.'-'.$dia;
	
	$evento = $logica->obtenerFicha($_POST['idHdrEvento']);
	$recordFeedbackTime = mktime($hora, $minuto, $segundo, date('n'), date('j'), $anio);
	$ResVehicleNumber = $logica->getVehicleNumber($idHdrRecurso);
	try{
	
		ini_set("soap.wsdl_cache_enabled","0");
		$client = new SoapClient(Configuraciones::urlECU911);
		
		if(count($evento['estadoEcu']) > 0)
		{
			/**
			 * es ficha ecu
			 */
			$arrAux = array('IncidentNumber'=>$evento['codigoEvento'],'ResVehicleNumber'=>$ResVehicleNumber['chasis'],'DispatchTime'=>$recordFeedbackTime);
			$return = objectToArray($client->setDispatch($arrAux));
			
			if($return['setDispatchResult'])
			{
				if($logica->guardarvehiculoAsignado($idHdrEvento, $idHdrRecurso, $descripcion, $usuario, $ip))
				{
					echo json_encode(array('success'=>true, 'msg'=>'Recurso asignado exitosamente'));
				}
				else
				{
					echo json_encode(array('success'=>false, 'msg'=>'Error al asignar intente de nuevo'));
				}
			}
			else
			{
				$logica->cambiarEstadoRecurso(2, $idHdrRecurso, 2);
				echo json_encode(array('success'=>false, 'msg'=>'Recurso no disponible, Se encuentra asignado en SIS ECU'));
			}
		}
		else
		{
			/**
			 * es ficha cgob
			 */
			$arrAux = array('ResVehicleNumber'=>$ResVehicleNumber['chasis'],'StatusId'=>'-2');
			$return = objectToArray($client->setStatusVehicle($arrAux));
				
			if($return['setStatusVehicleResult'])
			{
				if($logica->guardarvehiculoAsignado($idHdrEvento, $idHdrRecurso, $descripcion, $usuario, $ip)){
					echo json_encode(array('success'=>true, 'msg'=>'Recurso asignado exitosamente'));
				}else{
					echo json_encode(array('success'=>false, 'msg'=>'Error al asignar intente de nuevo'));
				}
			}
			else
			{
				$logica->cambiarEstadoRecurso(2, $idHdrRecurso, 2);
				echo json_encode(array('success'=>false, 'msg'=>'Recurso no disponible, Se encuentra asignado en SIS ECU'));
			}
		}
	}catch (Exception $ex){
		echo $ex->getMessage();
		exit();
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
	$idGenTipifMod = $_POST['idGenTipoTipificacion'];
	$idHdrEvento = $_POST['idHdrEvento'];
	$callePrincipal = $_POST['callePrincipal'];
	$calleSecundaria = $_POST['calleSecundaria'];
	$puntoReferencia = $_POST['puntoReferencia'];
	if($logica->guardarInformacionUbicacion($fechaEvento, $latitud1, $longitud2, $idGenGeoSenplades, $idGenTipifMod, $idHdrEvento, $callePrincipal,$calleSecundaria,$puntoReferencia)){
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
	/**
	 * partir para poder convertir en segundos
	 */
	$hora = date('H');
	$minuto = date('i');
	$segundo = date('s');
	
	$horaActividad = $hora.':'.$minuto.':'.$segundo;
	
	$dia = date('d');
	$mes = date('m');
	$anio = date('Y');
	$fechaActividad = $anio.'-'.$mes.'-'.$dia;
	$usuario = $_SESSION['usuarioAuditar']; 
	$ip = realIP();
	
	$resStatus = 0;
	
	switch($idHdrEstadoActividad){
		case 1:
			$resStatus = '5';
		break;
		case 2:
			$resStatus = '3';
		break;
		case 3:
			$resStatus = '4';
		break;
		case 5;
		$resStatus = '7';
		break;
	}
	
	$recordFeedbackTime = mktime($hora, $minuto, $segundo, date('n'), date('j'), $anio);
	
	$resVehicleNumber = $logica->getNumberVehicle($_POST['idRecursoEvento']);
	
	$evento = $logica->obtenerFicha($resVehicleNumber['idHdrEvento']);
	
	/**
	 * registrar primero actividad en base de datos oracle, si regresa false, significa que ya existe el estado que se esta tratando de ingresar
	 */
	try{

		ini_set("soap.wsdl_cache_enabled","0");
		$client = new SoapClient(Configuraciones::urlECU911);

// 		if(count($evento['estadoEcu'])>0){
			
// 			$arrAux = array('IncidentNumber'=>$_POST['IncidentNumber'],
// 							'ResVehicle'=>$resVehicleNumber['chasis'],
// 							'FeedbackInfo'=>json_encode(array('feedbackContent'=>$descripcion,
// 											  'recordFeedbackTime'=>$recordFeedbackTime.'',
// 											  'resStatus'=>$resStatus
// 							),true)
// 			);
// 			$return = objectToArray($client->setDispatchFeedbackInfo($arrAux));
			
// 			if($return['setDispatchFeedbackInfoResult'])
// 			{
// 				if($logica->insertarActividadrecurso($idHdrEstadoActividad, $idRecursoEvento, $descripcion, $horaActividad, $fechaActividad, $usuario, $ip)){
// 					echo json_encode(array('success'=>true, 'msg'=>'Actividad agregada exitosamente'));
// 				}else{
// 					echo json_encode(array('success'=>false, 'msg'=>'Error al registrar actividad intente de nuevo'));
// 				}
// 			}
// 			else
// 			{
// 				echo json_encode(array('success'=>false, 'msg'=>'Ya Asignado en SIS ECU'));
// 			}
// 		}else
// 		{
			if($idHdrEstadoActividad == '5'){
				$arrAux = array('ResVehicleNumber'=>$resVehicleNumber['chasis'],'StatusId'=>'1');
				$return = objectToArray($client->setStatusVehicle($arrAux));
				if($return['setStatusVehicleResult'])
				{
					if($logica->insertarActividadrecurso($idHdrEstadoActividad, $idRecursoEvento, $descripcion, $horaActividad, $fechaActividad, $usuario, $ip)){
						echo json_encode(array('success'=>true, 'msg'=>'Actividad agregada exitosamente'));
					}else{
						echo json_encode(array('success'=>false, 'msg'=>'Error al registrar actividad intente de nuevo'));
					}
				}
			}else
			{
				if($logica->insertarActividadrecurso($idHdrEstadoActividad, $idRecursoEvento, $descripcion, $horaActividad, $fechaActividad, $usuario, $ip)){
					echo json_encode(array('success'=>true, 'msg'=>'Actividad agregada exitosamente'));
				}else{
					echo json_encode(array('success'=>false, 'msg'=>'Error al registrar actividad intente de nuevo'));
				}
			}
// 		}
	}catch (Exception $ex){
		echo $ex->getMessage();
		exit();
	}
}

if(isset($_POST['btCeduda'])){
	try {
		include_once('../../../../funciones/funciones_generales.php');
		$dato1=retornoDatosRegistroCivil($_POST['cedula']);
		
		if($dato1 == null){
			echo json_encode(array('success'=>false, 'msg'=>'Regsitro Civil no devolvio resultados'));
			exit();
		}
		
		$arr = xml2array($dato1);
		
		if(isset($arr['ROW']['FECHA_NACIMIENTO'])){
			$row = $arr['ROW'];
			$hoy=date("Y-m-d");
			$edad=tiempoTranscurrido($row['FECHA_NACIMIENTO'],$hoy);
			$edad=mb_convert_encoding($edad[0],"UTF-8","ISO-8859-1");
			$edad = explode(',', $edad);
			echo json_encode(array('success'=>true, 'msg'=>utf8_encode(((strlen($row['CEDULA']) == 9)? '0'.$row['CEDULA']:$row['CEDULA']).' '.$row['NOMBRE'].' '.$row['GENERO']).' '.$edad[0]));
		}else {
			echo json_encode(array('success'=>false, 'msg'=>utf8_encode('Cédula no encontrada')));
		}
	}catch (Exception $exception){
		echo json_encode(array('success'=>false, 'msg'=>($exception->getMessage())));
	}
	
	exit();
}

if(isset($_POST['btnPlaca'])){
	try{
		ini_set("soap.wsdl_cache_enabled","0");
		$client = new SoapClient(Configuraciones::urlAnt);
		$array = objectToArray($client->DatosMatricula(array("Valor_Consulta"=>$_POST['placa'],"Canal"=>Configuraciones::canalAnt, "Usuario" => Configuraciones::usuarioAnt)));
		$row = $array['return'];
		if(isset($row['claseVehiculo']))
			echo json_encode(array('success'=>true, 'msg'=>$_POST['placa'].' '.utf8_encode($row['claseVehiculo'].' '.$row['marca'].' '.$row['modelo'].' '.$row['color'].' '.$row['anio'])));
		else 
			echo json_encode(array('success'=>false, 'msg'=>utf8_encode($row['mensaje'])));
			
	}catch (SoapFault $exception){
		echo json_encode(array('success'=>false, 'msg'=>($exception->getMessage())));		
	}
	exit();
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
	if(count($array) > 0){
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
	}else{
	?>
		<tr class='data-tr' align='center'>
			<td colspan="4">
				No hay resgistros
			</td>
		</tr>
	<?php
	}
	?>	
	</table>
	<?php
}

function xml2array($xml)
{
	$arr = array();

	try{
	if($xml == null) return $arr;
	foreach ($xml as $element)
	{
		$tag = $element->getName();
		$e = get_object_vars($element);
		if (!empty($e))
		{
			$arr[$tag] = $element instanceof SimpleXMLElement ? xml2array($element) : $e;
		}
		else
		{
			$arr[$tag] = trim($element);
		}
	}
}catch (Exception $ex){}
	return $arr;
}

function objectToArray($d) {
	if (is_object($d)) {
		$d = get_object_vars($d);
	}

	if (is_array($d)) {
		return array_map(__FUNCTION__, $d);
	}
	else {
		return $d;
	}
}