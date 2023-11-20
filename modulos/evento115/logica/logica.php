<?php
class logica{
	/**
	 * clase de conexión
	 * @var PDO
	 */
	var $conn;
	
	/**
	 * zona
	 */
	var $zona = 1;
	
	/**
	 * constructor
	 * @param PDO $conn
	 */
	function __construct($conn){
		$this->setConexion($conn);
	}
	
	/**
	 * obtener información de la tabla genClaseTipificacion
	 * @return array
	 */
	function getClaseTipificacion(){
		try{
			$array = array();
			$claseTipificacion="SELECT idGenClaseTipificacion,descripcion FROM genClaseTipificacion";
			
			if(($rsClaseTipificacion = $this->getConexion()->query($claseTipificacion)) != false){
				while($row=$rsClaseTipificacion->fetch(PDO::FETCH_ASSOC)){
					$array[] = $row;
				}
				
				return $array;
			}else{
				echo $this->getConexion()->errorInfo();
				exit();
			}
		}catch (Exception $ex){
			echo $ex->getMessage();
			exit();
		}
	}
	
	/**
	 * obtener la subtificación de acorde a la tipificación seleccionada
	 * @param number $idGenClaseTipificacion
	 * @return array
	 */
	function getSubTipificacion($idGenClaseTipificacion){
		try{
			$array = array();
			
			if($idGenClaseTipificacion != ''){
			
				$subtificacion = "SELECT idGenSubTipificacion AS 'codigo',descripcion FROM genSubTipificacion WHERE idGenClaseTipificacion = '$idGenClaseTipificacion'";
					
				if(($rsTipificacion = $this->getConexion()->query($subtificacion)) != false){
					while($row=$rsTipificacion->fetch(PDO::FETCH_ASSOC)){
						$array[] = $row;
					}
					return $array;
				}else{
					echo $this->getConexion()->errorInfo();
					exit();
				}
			}else{
				return $array;
			}
		}catch (Exception $ex){
			echo $ex->getMessage();
			exit();
		}
	}
	/**
	 * obtener tipificación segun subclase tipificacion
	 * @param number $idGenSubTipificacion subtipificacion seleccionada
	 * @return array
	 */
	function getTipoTipificacion($idGenSubTipificacion){
		try{
			$array = array();
				
			if($idGenSubTipificacion != ''){
				$tipoTipificacion = "SELECT idGenTipoTipificacion AS 'codigo',descripcion FROM genTipoTipificacion WHERE idGenSubTipificacion = '$idGenSubTipificacion'";
				
				if(($rsTipificacion = $this->getConexion()->query($tipoTipificacion)) != false){
					while($row=$rsTipificacion->fetch(PDO::FETCH_ASSOC)){
						$array[] = $row;
					}
					return $array;
				}else{
					echo $this->getConexion()->errorInfo();
					exit();
				}
			}else {
				return $array;
			}
		}catch (Exception $ex){
			echo $ex->getMessage();
			exit();
		}
	}
	/**
	 * obtener información del tipo de resumen
	 * @return array
	 */
	function getGrupoResumen(){
		try{
			$array = array();
			$sqlResumen="SELECT idHdrGrupResum AS 'codigo',desHdrGrupResum AS 'descripcion' FROM hdrGrupResum";
			
			if(($rsResumen = $this->getConexion()->query($sqlResumen)) != false){
				while($row=$rsResumen->fetch(PDO::FETCH_ASSOC)){
					$array[] = $row;
				}
				return $array;
			}else{
				echo $this->getConexion()->errorInfo();
				exit();
			}
		}catch (Exception $ex){
			echo $ex->getMessage();
			exit();
		}
	}
	/**
	 * obtener los tipos resumenes
	 * @param number $idHdrGrupResum codigo de grupo de resumen
	 * @return array
	 */
	function getTipoResumen($idHdrGrupResum){
		try{
			$array = array();
		
			if($idHdrGrupResum != ''){
				$tipoTipificacion = "SELECT idHdrTipoResum AS 'codigo',desHdrTipoResum AS 'descripcion' FROM hdrTipoResum WHERE idHdrGrupResum = '$idHdrGrupResum'";
				if(($rsTipificacion = $this->getConexion()->query($tipoTipificacion)) != false){
					while($row=$rsTipificacion->fetch(PDO::FETCH_ASSOC)){
						$array[] = $row;
					}
					return $array;
				}else{
					echo $this->getConexion()->errorInfo();
					exit();
				}
			}else {
				return $array;
			}
		}catch (Exception $ex){
			echo $ex->getMessage();
			exit();
		}
	}
	
	/**
	 * obtener los distritos
	 * @return array
	 */
	function getGenGeoSempladesZona(){
		try{
			$array = array();
			$geoSemplades="SELECT idGenGeoSenplades AS 'codigo', descripcion FROM genGeoSenplades WHERE idGenTipoGeoSenplades = ".$this->zona;
	
			if(($rsGeoSemplades = $this->getConexion()->query($geoSemplades)) != false){
				while($row=$rsGeoSemplades->fetch(PDO::FETCH_ASSOC)){
					$array[] = $row;
				}
				return $array;
			}else{
				echo $this->getConexion()->errorInfo();
				exit();
			}
		}catch (Exception $ex){
			echo $ex->getMessage();
			exit();
		}
	}
	/**
	 * obtener los circuitos de un distrito
	 * @param number $gen_idGenGeoSenplades
	 * @return array
	 */
	function getGenGeoSemplades($gen_idGenGeoSenplades){
		try{
			$array = array();
			$geoSemplades="SELECT idGenGeoSenplades AS 'codigo', descripcion FROM genGeoSenplades WHERE gen_idGenGeoSenplades = '$gen_idGenGeoSenplades'";
	
			if(($rsGeoSemplades = $this->getConexion()->query($geoSemplades)) != false){
				while($row=$rsGeoSemplades->fetch(PDO::FETCH_ASSOC)){
					$array[] = $row;
				}
				return $array;
			}else{
				echo $this->getConexion()->errorInfo();
				exit();
			}
		}catch (Exception $ex){
			echo $ex->getMessage();
			exit();
		}
	}
	function obtenerFicha($idHdrEvento){
		try{
			$array = array();
			$sql="SELECT h.*,sc.descripcion AS 's', c.descripcion AS 'c', d.descripcion AS 'd', t.descripcion AS 't', st.descripcion AS 'st', ct.descripcion AS 'ct' 
			FROM hdrEvento h
			INNER JOIN genGeoSenplades sc ON h.idGenGeoSenplades = sc.idGenGeoSenplades
			INNER JOIN genGeoSenplades c ON sc.gen_idGenGeoSenplades = c.idGenGeoSenplades
			INNER JOIN genGeoSenplades d ON c.gen_idGenGeoSenplades = d.idGenGeoSenplades
			INNER JOIN genTipoTipificacion t ON h.idGenTipoTipificacionEcu = t.idGenTipoTipificacion
			INNER JOIN genSubTipificacion st ON t.idGenSubTipificacion = st.idGenSubTipificacion
			INNER JOIN genClaseTipificacion ct ON st.idGenClaseTipificacion = ct.idGenClaseTipificacion
			WHERE h.idHdrEvento = '$idHdrEvento'";
	
			if(($rsGeoSemplades = $this->getConexion()->query($sql)) != false){
				if($row=$rsGeoSemplades->fetch(PDO::FETCH_ASSOC)){
					$array = $row;
				}
				return $array;
			}else{
				echo $this->getConexion()->errorInfo();
				exit();
			}
		}catch (Exception $ex){
			echo $ex->getMessage();
			exit();
		}
	}
	/**
	 * buscar un recurso asignado a una hoja de ruta y que no se encuentre en algun evento
	 * @param string $fecha
	 * @param string $hora
	 * @param string $string
	 * @return mixed
	 */
	function buscarRecursoHojaRuta($fecha, $hora, $string){
		try{
			$array = array();
			$sql = "SELECT hrR.idHdrRecurso, hrR.nominativo, hrR.radioRecurso, hrR.telefonoRecurso, hrR.obsHdrRecurso FROM hdrRuta hr
			INNER JOIN hdrRecurso hrR ON hr.idHdrRuta = hrR.idHdrRuta
			INNER JOIN hdrEstadoRecurso hrsr ON hrR.idHdrEstadoRecurso = hrsr.idHdrEstadoRecurso
			WHERE ('$fecha' BETWEEN hr.fechaHdrRutaInicio AND hr.fechaHdrRutaFin) AND ('$hora' BETWEEN hr.horarioInicio AND hr.horarioFin) 
			AND hrR.idHdrRecurso NOT IN (SELECT r.idHdrRecurso FROM hdrRecursoEvento er
			INNER JOIN hdrRecurso r ON er.idHdrRecurso = r.idHdrRecurso
			INNER JOIN hdrEvento e ON er.idHdrEvento = e.idHdrEvento
			WHERE e.estadoPolicia <> 5) AND hrR.nominativo LIKE '%$string%'";
			if(($rs = $this->getConexion()->query($sql)) != false){
				while($row=$rs->fetch(PDO::FETCH_ASSOC)){
					$array[] = $row;
				}
				return $array;
			}else{
				echo $this->getConexion()->errorInfo();
				exit();
			}
		}catch (Exception $ex){
			echo $ex->getMessage();
			exit();
		}
	}
	
	function obtenerActividadRecursoEvento($idRecursoEvento){
		try{
			$sql = "SELECT a.fechaActividad,a.horaActividad,a.descripcion,e.descripcion AS 'estado' FROM hdrActividad a
			INNER JOIN hdrEstadoActividad e ON a.idHdrEstadoActividad = e.idHdrEstadoActividad 
			WHERE idRecursoEvento = $idRecursoEvento";
			if(($rs = $this->getConexion()->query($sql)) != false){
				while($row=$rs->fetch(PDO::FETCH_ASSOC)){
					$array[] = $row;
				}
				return $array;
			}else{
				echo $this->getConexion()->errorInfo();
				exit();
			}
		}catch (Exception $ex){
			echo $ex->getMessage();
			exit();
		}
	}
	 
	/**
	 * obtener listado de fichas del evento
	 * @return array
	 */
	function getFichaEvento($idGenUsuario, $idGenTipoActividad){
		try{
			$array = array();
			$sqlFichas="SELECT
			 *
			FROM
			 hdrEvento h,
			 genGeoSenplades s,
			 genGeoSenplades c
			WHERE
			 h.idGenGeoSenplades = s.idGenGeoSenplades
			AND s.gen_idGenGeoSenplades = c.idGenGeoSenplades
			AND h.estadoPolicia <> 5
			AND c.gen_idGenGeoSenplades in 
			(
			 SELECT
			  genGeoSenplades.idGenGeoSenplades
			 FROM
			  genUsuario
			 INNER JOIN genUsuarioActividadGA ON genUsuario.idGenUsuario = genUsuarioActividadGA.idGenUsuario
			 INNER JOIN genActividadGA ON genUsuarioActividadGA.idGenActividadGA = genActividadGA.idGenActividadGA
			 INNER JOIN genUnidadesGeoreferencial ON genActividadGA.idGenActividadGA = genUnidadesGeoreferencial.idGenActividadGA
			 INNER JOIN genGeoSenplades ON genGeoSenplades.idGenGeoSenplades = genUnidadesGeoreferencial.idGenGeoSenplades
			 WHERE
			  genUsuario.idGenUsuario = '$idGenUsuario'
			 AND genActividadGA.idGenTipoActividad = '$idGenTipoActividad'
			)";
			if(($rsFichas = $this->getConexion()->query($sqlFichas)) != false){
				while($row=$rsFichas->fetch(PDO::FETCH_ASSOC)){
					$array[] = $row;
				}
				return $array;
			}else{
				echo $this->getConexion()->errorInfo();
				exit();
			}
		}catch (Exception $ex){
			echo $ex->getMessage();
			exit();
		}
	}
	/**
	 * guardar detalle del evento
	 * @param number $idHdrTipoResum codigo del resumen
	 * @param number $idHdrEvento codigo del evento
	 * @param number $cantidad cantidad
	 * @param string $descEventoResum descripcion segun tipo resumen
	 * @param number $usuario usuario auditar
	 * @param string $ip ip de donde se realiza el guardado
	 * @return boolean
	 */
	function guardarDetalleEvento($idHdrTipoResum, $idHdrEvento, $cantidad, $descEventoResum, $usuario, $ip){
		try{
			$sql = "INSERT INTO hdrEventoResum(idHdrTipoResum,idHdrEvento,cantidad,descEventoResum,usuario,ip)VALUES(?,?,?,?,?,?)";
			$sentencia = $this->getConexion()->prepare($sql);
			$sentencia->bindParam(1, $idHdrTipoResum);
			$sentencia->bindParam(2, $idHdrEvento);
			$sentencia->bindParam(3, $cantidad);
			$sentencia->bindParam(4, $descEventoResum);
			$sentencia->bindParam(5, $usuario);
			$sentencia->bindParam(6, $ip);
			$sentencia->execute() or die(print_r($sentencia->errorInfo()));
			return true;
		}catch (Exception $ex){
			echo $ex->getMessage();
			exit();
		}
	}
	
	function guardarvehiculoAsignado($idHdrEvento, $idHdrRecurso, $descripcion, $usuario, $ip){
		try{
			$sql = "INSERT INTO hdrRecursoEvento(idHdrEvento, idHdrRecurso, descripcion, usuario, ip)VALUES(?, ?, ?, ?, ?)";
			$sentencia = $this->getConexion()->prepare($sql);
			$sentencia->bindParam(1, $idHdrEvento);
			$sentencia->bindParam(2, $idHdrRecurso);
			$sentencia->bindParam(3, $descripcion);
			$sentencia->bindParam(4, $usuario);
			$sentencia->bindParam(5, $ip);
			$sentencia->execute() or die(print_r($sentencia->errorInfo()));
			return true;
		}catch (Exception $ex){
			echo $ex->getMessage();
			exit();
		}
	}
	
	function eliminarvehiculoAsignado($idRecursoEvento){
		try{
			$sql = "DELETE FROM hdrRecursoEvento WHERE idRecursoEvento = ?";
			$sentencia = $this->getConexion()->prepare($sql);
			$sentencia->bindParam(1, $idRecursoEvento);
			$sentencia->execute() or die(print_r($sentencia->errorInfo()));
			return true;
		}catch (Exception $ex){
			echo $ex->getMessage();
			exit();
		}
	}
	
	function eliminarEventoDetalle($idHdrEventoResum){
		try{
			$sql = "DELETE FROM hdrEventoResum WHERE idHdrEventoResum = ?";
			$sentencia = $this->getConexion()->prepare($sql);
			$sentencia->bindParam(1, $idHdrEventoResum);
			$sentencia->execute() or die(print_r($sentencia->errorInfo()));
			return true;
		}catch (Exception $ex){
			echo $ex->getMessage();
			exit();
		}
	}
	
	function guardarInformacionUbicacion($fechaEvento, $latitud1, $longitud2, $idGenGeoSenplades, $idGenTipoTipificacionReal, $idHdrEvento){
		try{
			$sql = "UPDATE hdrEvento SET fechaEvento = ?, latitud1 = ?, longitud2 = ?, idGenGeoSenplades = ?, idGenTipoTipificacionReal = ? WHERE idHdrEvento = ?";
			$sentencia = $this->getConexion()->prepare($sql);
			$sentencia->bindParam(1, $fechaEvento);
			$sentencia->bindParam(2, $latitud1);
			$sentencia->bindParam(3, $longitud2);
			$sentencia->bindParam(4, $idGenGeoSenplades);
			$sentencia->bindParam(5, $idGenTipoTipificacionReal);
			$sentencia->bindParam(6, $idHdrEvento);
			$sentencia->execute() or die(print_r($sentencia->errorInfo()));
			return true;
		}catch (Exception $ex){
			echo $ex->getMessage();
			exit();
		}
	}
	
	function guardarDescripcionFinal($descripcionFinal, $idHdrEvento){
		try{
			$sql = "update hdrEvento set descripcionFinal = ? where idHdrEvento = ?";
			$sentencia = $this->getConexion()->prepare($sql);
			$sentencia->bindParam(1, $descripcionFinal);
			$sentencia->bindParam(2, $idHdrEvento);
			$sentencia->execute() or die(print_r($sentencia->errorInfo()));
			return true;
		}catch (Exception $ex){
			echo $ex->getMessage();
			exit();
		}
	}
	
	function FinalizarFicha($idGenPersona, $estadoPolicia, $usuario, $ip, $idHdrEvento){
		try{
			$sql = "UPDATE hdrEvento SET idGenPersona = ?, estadoPolicia = ?, usuario = ?, ip = ? WHERE idHdrEvento = ?";
			$sentencia = $this->getConexion()->prepare($sql);
			$sentencia->bindParam(1, $idGenPersona);
			$sentencia->bindParam(2, $estadoPolicia);
			$sentencia->bindParam(3, $usuario);
			$sentencia->bindParam(4, $ip);
			$sentencia->bindParam(5, $idHdrEvento);
			$sentencia->execute() or die(print_r($sentencia->errorInfo()));
			return true;
		}catch (Exception $ex){
			echo $ex->getMessage();
			exit();
		}
	}
	
	function insertarActividadrecurso($idHdrEstadoActividad,$idRecursoEvento,$descripcion,$horaActividad,$fechaActividad,$usuario,$ip){
		try{
			$sql = "INSERT INTO hdrActividad(idHdrEstadoActividad,idRecursoEvento,descripcion,horaActividad,fechaActividad,usuario,ip)VALUES(?,?,?,?,?,?,?)";
			$sentencia = $this->getConexion()->prepare($sql);
			$sentencia->bindParam(1, $idHdrEstadoActividad);
			$sentencia->bindParam(2, $idRecursoEvento);
			$sentencia->bindParam(3, $descripcion);
			$sentencia->bindParam(4, $horaActividad);
			$sentencia->bindParam(5, $fechaActividad);
			$sentencia->bindParam(6, $usuario);
			$sentencia->bindParam(7, $ip);
			$sentencia->execute() or die(print_r($sentencia->errorInfo()));
			return true;
		}catch (Exception $ex){
			echo $ex->getMessage();
			exit();
		}
	}
	
	function insertarEventoEcu($array, $usuario, $ip){
		try{
			foreach($array as $row){
				/**
				 * iniciando la transacción
				 */
				$this->getConexion()->beginTransaction();
				
				$sql="select * from hdrEvento where codigoEvento={$row['incidentNumber']}";
				echo $sql.'<br>';
				$rs=$this->getConexion()->query($sql);
				$row2=$rs->fetch(PDO::FETCH_ASSOC);
				if(isset($row2['codigoEvento'])){
					
					$sql = "SELECT idGenGeoSenplades FROM genGeoSenplades WHERE codigoSenplades = '{$row['codigoSubcircuito']}'";
					$rs=$this->getConexion()->query($sql);
					$row2=$rs->fetch(PDO::FETCH_ASSOC);
					
					$grade = split(' ', $row['incidentGradeName']);
					
					$sql = "INSERT INTO hdrEvento(idGenTipoTipificacionEcu,idGenGeoSenplades,idGenPersona,codigoEvento,fechaEvento,descripcion,latitud,longitud,estadoEcu,estadoPolicia,nivelAlerta,usuario,ip,latitud1,longitud2,idGenTipoTipificacionReal)VALUE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
					$sentencia = $this->getConexion()->prepare($sql);
					$sentencia->bindParam(1, '1');
					$sentencia->bindParam(2, $row2['idGenGeoSenplades']);
					$sentencia->bindParam(3, $usuario);
					$sentencia->bindParam(4, $row['incidentNumber']);
					$sentencia->bindParam(5, $row['startTime']);
					$sentencia->bindParam(6, $row['incidentDescription']);
					$sentencia->bindParam(7, $row['latitude']);
					$sentencia->bindParam(8, $row['longitude']);
					$sentencia->bindParam(9, $row['stateId']);
					$sentencia->bindParam(10, '1');
					$sentencia->bindParam(11, substr($grade[1], 0, 1));
					$sentencia->bindParam(12, $usuario);
					$sentencia->bindParam(13, $ip);
					$sentencia->bindParam(14, $row['latitude']);
					$sentencia->bindParam(15, $row['longitude']);
					$sentencia->bindParam(16, '1');
					$sentencia->execute() or die(print_r($sentencia->errorInfo()));
					
					echo print_r($row);
				}
				
				/**
				 * guardando los cambios sin problemas
				 */
				$conn->commit();
			}
		} catch (Exception $e) {
		}
	}
	
	/**
	 * agregar la conexión
	 * @param unknown $conn
	 */
	function setConexion($conn){
		$this->conn = $conn;
	}
	/**
	 * obtener la conexión
	 */
	function getConexion(){
		return $this->conn;
	}
	
	function __destruct(){
		unset($this->conn);
	}
}