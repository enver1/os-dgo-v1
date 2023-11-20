<?php
class logica{
	/**
	 * clase de conexión
	 * @var PDO
	 */
	var $conn;
	
	/**
	 * codigo del distrito de la tabla genTipoGeoSenplades
	 * @var number
	 */
	var $distrito = 3;
	
	/**
	 * codigo del circuito
	 * @var number
	 */
	var $circuito = 4;
	
	/**
	 * codigo del subcircuito
	 * @var number
	 */
	var $subcirtuito = 5;
	
	/**
	 * constructor
	 * @param PDO $conn
	 */
	function __construct($conn){
		$this->setConexion($conn);
	}
	
// 	/**
// 	 * obtener información de la tabla genClaseTipificacion
// 	 * @return array
// 	 */
// 	function getClaseTipificacion(){
// 		try{
// 			$array = array();
// 			$claseTipificacion="SELECT idGenClaseTipificacion,descripcion FROM genClaseTipificacion";
			
// 			if(($rsClaseTipificacion = $this->getConexion()->query($claseTipificacion)) != false){
// 				while($row=$rsClaseTipificacion->fetch(PDO::FETCH_ASSOC)){
// 					$array[] = $row;
// 				}
				
// 				return $array;
// 			}else{
// 				echo $this->getConexion()->errorInfo();
// 				exit();
// 			}
// 		}catch (Exception $ex){
// 			echo $ex->getMessage();
// 			exit();
// 		}
// 	}
	
// 	/**
// 	 * obtener la subtificación de acorde a la tipificación seleccionada
// 	 * @param number $idGenClaseTipificacion
// 	 * @return array
// 	 */
// 	function getSubTipificacion($idGenClaseTipificacion){
// 		try{
// 			$array = array();
			
// 			if($idGenClaseTipificacion != ''){
			
// 				$subtificacion = "SELECT idGenSubTipificacion AS 'codigo',descripcion FROM genSubTipificacion WHERE idGenClaseTipificacion = $idGenClaseTipificacion";
					
// 				if(($rsTipificacion = $this->getConexion()->query($subtificacion)) != false){
// 					while($row=$rsTipificacion->fetch(PDO::FETCH_ASSOC)){
// 						$array[] = $row;
// 					}
// 					return $array;
// 				}else{
// 					echo $this->getConexion()->errorInfo();
// 					exit();
// 				}
// 			}else{
// 				return $array;
// 			}
// 		}catch (Exception $ex){
// 			echo $ex->getMessage();
// 			exit();
// 		}
// 	}
// 	/**
// 	 * obtener tipificación segun subclase tipificacion
// 	 * @param number $idGenSubTipificacion subtipificacion seleccionada
// 	 * @return array
// 	 */
// 	function getTipoTipificacion($idGenSubTipificacion){
// 		try{
// 			$array = array();
				
// 			if($idGenSubTipificacion != ''){
// 				$tipoTipificacion = "SELECT idGenTipoTipificacion AS 'codigo',descripcion FROM genTipoTipificacion WHERE idGenSubTipificacion = $idGenSubTipificacion";
				
// 				if(($rsTipificacion = $this->getConexion()->query($tipoTipificacion)) != false){
// 					while($row=$rsTipificacion->fetch(PDO::FETCH_ASSOC)){
// 						$array[] = $row;
// 					}
// 					return $array;
// 				}else{
// 					echo $this->getConexion()->errorInfo();
// 					exit();
// 				}
// 			}else {
// 				return $array;
// 			}
// 		}catch (Exception $ex){
// 			echo $ex->getMessage();
// 			exit();
// 		}
// 	}
// 	/**
// 	 * obtener información del tipo de resumen
// 	 * @return array
// 	 */
// 	function getGrupoResumen(){
// 		try{
// 			$array = array();
// 			$sqlResumen="SELECT idHdrGrupResum AS 'codigo',desHdrGrupResum AS 'descripcion' FROM hdrGrupResum";
			
// 			if(($rsResumen = $this->getConexion()->query($sqlResumen)) != false){
// 				while($row=$rsResumen->fetch(PDO::FETCH_ASSOC)){
// 					$array[] = $row;
// 				}
// 				return $array;
// 			}else{
// 				echo $this->getConexion()->errorInfo();
// 				exit();
// 			}
// 		}catch (Exception $ex){
// 			echo $ex->getMessage();
// 			exit();
// 		}
// 	}
// 	/**
// 	 * obtener los tipos resumenes
// 	 * @param number $idHdrGrupResum codigo de grupo de resumen
// 	 * @return array
// 	 */
// 	function getTipoResumen($idHdrGrupResum){
// 		try{
// 			$array = array();
		
// 			if($idHdrGrupResum != ''){
// 				$tipoTipificacion = "SELECT idHdrTipoResum AS 'codigo',desHdrTipoResum AS 'descripcion' FROM hdrTipoResum WHERE idHdrGrupResum = $idHdrGrupResum";
// 				if(($rsTipificacion = $this->getConexion()->query($tipoTipificacion)) != false){
// 					while($row=$rsTipificacion->fetch(PDO::FETCH_ASSOC)){
// 						$array[] = $row;
// 					}
// 					return $array;
// 				}else{
// 					echo $this->getConexion()->errorInfo();
// 					exit();
// 				}
// 			}else {
// 				return $array;
// 			}
// 		}catch (Exception $ex){
// 			echo $ex->getMessage();
// 			exit();
// 		}
// 	}
	
// 	/**
// 	 * obtener los distritos
// 	 * @return array
// 	 */
// 	function getGenGeoSempladesDistrito(){
// 		try{
// 			$array = array();
// 			$geoSemplades="SELECT idGenGeoSenplades AS 'codigo', descripcion FROM genGeoSenplades WHERE idGenTipoGeoSenplades = ".$this->distrito;
				
// 			if(($rsGeoSemplades = $this->getConexion()->query($geoSemplades)) != false){
// 				while($row=$rsGeoSemplades->fetch(PDO::FETCH_ASSOC)){
// 					$array[] = $row;
// 				}
// 				return $array;
// 			}else{
// 				echo $this->getConexion()->errorInfo();
// 				exit();
// 			}
// 		}catch (Exception $ex){
// 			echo $ex->getMessage();
// 			exit();
// 		}
// 	}
// 	/**
// 	 * obtener los circuitos de un distrito
// 	 * @param number $gen_idGenGeoSenplades
// 	 * @return array
// 	 */
// 	function getGenGeoSempladesCircuito($gen_idGenGeoSenplades){
// 		try{
// 			$array = array();
// 			$geoSemplades="SELECT idGenGeoSenplades AS 'codigo', descripcion FROM genGeoSenplades WHERE idGenTipoGeoSenplades = {$this->circuito} AND gen_idGenGeoSenplades = $gen_idGenGeoSenplades";
	
// 			if(($rsGeoSemplades = $this->getConexion()->query($geoSemplades)) != false){
// 				while($row=$rsGeoSemplades->fetch(PDO::FETCH_ASSOC)){
// 					$array[] = $row;
// 				}
// 				return $array;
// 			}else{
// 				echo $this->getConexion()->errorInfo();
// 				exit();
// 			}
// 		}catch (Exception $ex){
// 			echo $ex->getMessage();
// 			exit();
// 		}
// 	}
// 	/**
// 	 * obtener los subcircuitos de un circuito
// 	 * @param number $gen_idGenGeoSenplades
// 	 * @return array
// 	 */
// 	function getGenGeoSempladesSubCircuito($gen_idGenGeoSenplades){
// 		try{
// 			$array = array();
// 			$geoSemplades="SELECT idGenGeoSenplades AS 'codigo', descripcion FROM genGeoSenplades WHERE idGenTipoGeoSenplades = {$this->subcirtuito} AND gen_idGenGeoSenplades = $gen_idGenGeoSenplades";
	
// 			if(($rsGeoSemplades = $this->getConexion()->query($geoSemplades)) != false){
// 				while($row=$rsGeoSemplades->fetch(PDO::FETCH_ASSOC)){
// 					$array[] = $row;
// 				}
// 				return $array;
// 			}else{
// 				echo $this->getConexion()->errorInfo();
// 				exit();
// 			}
// 		}catch (Exception $ex){
// 			echo $ex->getMessage();
// 			exit();
// 		}
// 	}
	
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