<?php 

/**
* 
*/
class calificacion
{
	//Metodo para realizar las consultas a la base de datos
	public function consultaMatriz($conn,$sql)
	{
		try {
			$rs  = $conn->query($sql);
			return $row =$rs->fetchAll(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			die('ERROR: '. $e->getMessage());
		}
	}

	//Metodo que obtiene los indicadores
	public function obtenerIndicadores($conn)
	{
		$sql="SELECT a.campoTabla, b.regla, a.datoCalif, a.descDgoIndicador FROM dgoIndicador a, dgoEjeNivel b WHERE a.idDgoEjeNivel=b.idDgoEjeNivel";

		if(!empty($datos=$this->consultaMatriz($conn,$sql))){
			return $datos;
		}
	}
	
	//Metodo que obtiene los indicadores por clasificacion de regla I (Homicidios - Asesinatos, Delincuencia) y D (Productividad)
	public function obtenerIndicadoresClasificados($conn)
	{
		$indicadores = array();

		if(!empty($datos=$this->obtenerIndicadores($conn))){
			foreach ($datos as $key => $value) {
				if($value['regla']==='I'){
					$indicadores[0][] = $value;	
				}
				elseif($value['regla']==='D'){
					$indicadores[1][] = $value;
				}
			}
		}

		return $indicadores;
	}

	//Metodo que obtiene los cursantes
	public function obtenerCursantes($conn, $anio, $idGenGeoSenplades=0)
	{
		$arrayCursantes=array();
		$zona = "";
		$conzona = "";

		if($idGenGeoSenplades > 0){
			$zona = "LEFT JOIN genGeoSenplades g1 ON g1.idGenGeoSenplades = a.idGenGeoSenplades
			LEFT JOIN genGeoSenplades g2 ON (g2.idGenGeoSenplades = g1.gen_idGenGeoSenplades OR g2.idGenGeoSenplades = a.idGenGeoSenplades) AND g2.idGenTipoGeoSenplades = 4
			LEFT JOIN genGeoSenplades g3 ON (g3.idGenGeoSenplades = g2.gen_idGenGeoSenplades OR g3.idGenGeoSenplades = a.idGenGeoSenplades) AND g3.idGenTipoGeoSenplades = 3
			LEFT JOIN genGeoSenplades g4 ON (g4.idGenGeoSenplades = g3.gen_idGenGeoSenplades OR g4.idGenGeoSenplades = a.idGenGeoSenplades) AND g4.idGenTipoGeoSenplades = 2
			LEFT JOIN genGeoSenplades g5 ON (g5.idGenGeoSenplades = g4.gen_idGenGeoSenplades OR g5.idGenGeoSenplades = a.idGenGeoSenplades) AND g5.idGenTipoGeoSenplades = 1";
			$conzona = " AND (g4.gen_idGenGeoSenplades = {$idGenGeoSenplades} OR  g5.idGenGeoSenplades = {$idGenGeoSenplades}) ";
		}

		$sql="SELECT
					a.idGenGeoSenplades,
					a.idGenPersona,
					CONCAT_WS(' ', gr.siglas, gp.apenom) apenom,
					a.senplades,
					a.meses
			FROM
					dgoAsignacion a
			LEFT JOIN genPersona gp ON gp.idGenPersona = a.idGenPersona
			LEFT JOIN dgpResumenPersonal rp ON rp.idGenPersona = gp.idGenPersona
			LEFT JOIN dgpAscenso pa ON pa.idDgpAscenso = rp.idDgpAscenso
			LEFT JOIN dgpGrado gr ON gr.idDgpGrado = pa.idDgpGrado {$zona}
			WHERE
					a.idGenPersona = gp.idGenPersona AND a.anio={$anio} {$conzona}
			ORDER BY
					gr.idDgpGrado, gp.apenom";

		if(!empty($datos=$this->consultaMatriz($conn,$sql))){

			$keyCursante=array_unique(array_column($datos, 'idGenPersona'));

			foreach ($keyCursante as $keyC => $valueC) {
					
				$keyDC=array(); 

				$keyDC=array_keys(array_column($datos,'idGenPersona'),$valueC);

				foreach ($keyDC as $key => $value) {
					$arrayCursantes[$valueC][]=$datos[$value];
				}
			}
		}

		return $arrayCursantes;
	}

	//Metodo que genera la sentencia sql de las calificaciones de los subcircuitos
	public function generarSqlCalificaciones($conn,$anio,$idGenGeoSenplades=0)
	{

		$zona = "";
		$conzona = "";

		if($idGenGeoSenplades > 0){
			$zona = "LEFT JOIN genGeoSenplades gc ON gc.idGenGeoSenplades = gp.gen_idGenGeoSenplades
			LEFT JOIN genGeoSenplades gd ON gd.idGenGeoSenplades = gc.gen_idGenGeoSenplades
			LEFT JOIN genGeoSenplades gsz ON gsz.idGenGeoSenplades = gd.gen_idGenGeoSenplades";
			$conzona = " WHERE gsz.gen_idGenGeoSenplades = {$idGenGeoSenplades} ";
		}

		$i=0;

		$grupo5=0;
		$stG5='';
		$grupo4=0;
		$stG4='';
		$grupo3=0;
		$stG3='';
		$grupo2=0;
		$stG2='';
		$grupo1=0;
		$stG1='';

		$vioDelin='';
		$productividad='';

		if (!empty($indicadores = $this->obtenerIndicadoresClasificados($conn))) {

		$sqlR='select gp.idGenGeoSenplades,gp.codigoSenplades, ';

			foreach ($indicadores as $keyUno => $valueUno) {
				foreach ($valueUno as $keyDos => $valueDos) {
					if($valueDos['regla']==='I'){
						$i++;

						if ($keyDos==0) {
							$vioDelin.=" ( IF(a.".$valueDos['campoTabla']."<=((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2),".$valueDos['datoCalif'].",((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2)*".$valueDos['datoCalif']."/a.".$valueDos['campoTabla'].") ";
						} else {
							$vioDelin.=" + IF(a.".$valueDos['campoTabla']."<=((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2),".$valueDos['datoCalif'].",((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2)*".$valueDos['datoCalif']."/a.".$valueDos['campoTabla'].") ";
						}
					}
					elseif($valueDos['regla']==='D'){

						switch ($valueDos['datoCalif']) {
									case 5:
										$grupo5++;

										if ($keyDos==0 or $grupo5==1) {
											$stG5.="IF(a.".$valueDos['campoTabla'].">=((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2),".$valueDos['datoCalif'].",".$valueDos['datoCalif']." * a.".$valueDos['campoTabla']." / ((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2)) ";
										} else {
											$stG5.=" + IF(a.".$valueDos['campoTabla'].">=((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2),".$valueDos['datoCalif'].",".$valueDos['datoCalif']." * a.".$valueDos['campoTabla']." / ((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2)) ";
										}

										break;
									case 4:
										$grupo4++;

										if ($keyDos==0 or $grupo4==1) {
											$stG4.="IF(a.".$valueDos['campoTabla'].">=((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2),".$valueDos['datoCalif'].",".$valueDos['datoCalif']." * a.".$valueDos['campoTabla']." / ((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2)) ";
										} else {
											$stG4.=" + IF(a.".$valueDos['campoTabla'].">=((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2),".$valueDos['datoCalif'].",".$valueDos['datoCalif']." * a.".$valueDos['campoTabla']." / ((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2)) ";
										}

										break;
									case 3:
										$grupo3++;

										if ($keyDos==0 or $grupo3==1) {
											$stG3.="IF(a.".$valueDos['campoTabla'].">=((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2),".$valueDos['datoCalif'].",".$valueDos['datoCalif']." * a.".$valueDos['campoTabla']." / ((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2)) ";
										} else {
											$stG3.=" + IF(a.".$valueDos['campoTabla'].">=((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2),".$valueDos['datoCalif'].",".$valueDos['datoCalif']." * a.".$valueDos['campoTabla']." / ((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2)) ";
										}

										break;
									case 2:
										$grupo2++;

										if ($keyDos==0 or $grupo2==1) {
											$stG2.="IF(a.".$valueDos['campoTabla'].">=((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2),".$valueDos['datoCalif'].",".$valueDos['datoCalif']." * a.".$valueDos['campoTabla']." / ((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2)) ";
										} else {
											$stG2.=" + IF(a.".$valueDos['campoTabla'].">=((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2),".$valueDos['datoCalif'].",".$valueDos['datoCalif']." * a.".$valueDos['campoTabla']." / ((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2)) ";
										}

										break;
									case 1:
										$grupo1++;

										if ($keyDos==0 or $grupo1==1) {
											$stG1.="IF(a.".$valueDos['campoTabla'].">=((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2),".$valueDos['datoCalif'].",".$valueDos['datoCalif']." * a.".$valueDos['campoTabla']." / ((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2)) ";
										} else {
											$stG1.=" + IF(a.".$valueDos['campoTabla'].">=((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2),".$valueDos['datoCalif'].",".$valueDos['datoCalif']." * a.".$valueDos['campoTabla']." / ((b.".$valueDos['campoTabla']." + c.".$valueDos['campoTabla'].") / 2)) ";
										}

										break;
								}

					
					}
				}

				if (!empty($stG5)) {
					$productividad.=" ((".$stG5.")/".$grupo5.") + ";
				} 
				if (!empty($stG4)) {
					$productividad.=" ((".$stG4.")/".$grupo4.") + ";
				} 
				if (!empty($stG3)) {
					$productividad.=" ((".$stG3.")/".$grupo3.") + ";
				} 
				if (!empty($stG2)) {
					$productividad.=" ((".$stG2.")/".$grupo2.") + ";
				}	
				if (!empty($stG1)) {
					$productividad.=" ((".$stG1.")/".$grupo1.")  ";
				}	
			}
		}


		$vioDelin.=" )/".$i." as resultVioDelin, ";
		$productividad.="  as resultProduc ";

		$sqlR.="".$vioDelin." ".$productividad.", tmp.idGenMes  
		from (select tm.idGenGeoSenplades, m.idGenMes from genMes m, dgoDatos tm where tm.anio=".$anio." group by tm.idGenGeoSenplades, m.idGenMes) tmp 
		inner join genGeoSenplades gp on tmp.idGenGeoSenplades = gp.idGenGeoSenplades 
		{$zona}
		left join dgoDatos a on tmp.idGenGeoSenplades = a.idGenGeoSenplades and tmp.idGenMes = a.idGenMes and a.anio=".$anio." 
		left join dgoDatos b on tmp.idGenGeoSenplades = b.idGenGeoSenplades and tmp.idGenMes = b.idGenMes and b.anio=".($anio-1)." 
		left join dgoDatos c on tmp.idGenGeoSenplades = c.idGenGeoSenplades and tmp.idGenMes = c.idGenMes and c.anio = ".($anio-2)."
		{$conzona} 
		order by gp.codigoSenplades, gp.idGenGeoSenplades, tmp.idGenMes";

		return $sqlR;

	}

	// Metodo que obtiene las notas de los subcircuitos para el excel
	public function obtenerCalificacionesSubCircutos($conn,$anio)
	{
		$notasSubCircuitos = array();

		if (!empty($sqlNC=$this->generarSqlCalificaciones($conn,$anio))) {

			if (!empty($notasSubCircuitos=$this->consultaMatriz($conn,$sqlNC))) {
				$notasSubCircuitos=array_chunk($notasSubCircuitos,12);
			}
		}

		return $notasSubCircuitos;
	}


	//Metodo que genera las calificaciones de los cursantes
	public function generarCalificaciones($conn,$cursantes,$notasSubCircuitos)
	{
		$arrayCursCalif = array();
		$notasSubCircuitos=array_chunk($notasSubCircuitos,12);

		foreach ($cursantes as $keyCursante => $valueCursante) {
			$arrayCursCalif[$keyCursante] = $this->obtenerCalificacionAlumno($conn,$valueCursante,$notasSubCircuitos);
		}

		return $arrayCursCalif;
	}


	//Metodo que obtiene las calificaciones por mes del cursante 
	public function obtenerCalificacionAlumno($conn,$valueCursante,$notasSubCircuitos)
	{
		$respuesta = array();

		foreach ($valueCursante as $keyDato => $valueDato) {
				if ($valueDato['senplades']==5) {
					$senplades = array(array('idGenGeoSenplades'=>$valueDato['idGenGeoSenplades']));

				}elseif ($valueDato['senplades']==4) {
					/*SELECT PARA NIVEL DE CIRCUITO*/
					$sqlC="SELECT 
								idGenGeoSenplades 
							FROM 
								genGeoSenplades 
							WHERE 
								gen_idGenGeoSenplades=".$valueDato['idGenGeoSenplades']."";

					$senplades = $this->consultaMatriz($conn,$sqlC);


				}elseif ($valueDato['senplades']==3) {
					/*SELECT PARA NIVEL DE DISTRITO*/
					$sqlD="SELECT
								gsc.idGenGeoSenplades
							FROM
								genGeoSenplades gc,
								genGeoSenplades gsc
							WHERE
								gc.gen_idGenGeoSenplades = ".$valueDato['idGenGeoSenplades']." 
							AND gc.idGenGeoSenplades = gsc.gen_idGenGeoSenplades";

					$senplades = $this->consultaMatriz($conn,$sqlD);


				}elseif ($valueDato['senplades']==2) {
					/*SELECT PARA NIVEL DE SUBZONA*/
					$sqlSZ="SELECT
								gsc.idGenGeoSenplades
							FROM
								genGeoSenplades gd,
								genGeoSenplades gc,
								genGeoSenplades gsc
							WHERE
								gd.gen_idGenGeoSenplades = ".$valueDato['idGenGeoSenplades']." 
							AND gd.idGenGeoSenplades = gc.gen_idGenGeoSenplades
							AND gc.idGenGeoSenplades = gsc.gen_idGenGeoSenplades";

					$senplades = $this->consultaMatriz($conn,$sqlSZ);
					

				}elseif ($valueDato['senplades']==1) {
					/*SELECT PARA NIVEL DE ZONA*/
					$sqlZ="SELECT
								gsc.idGenGeoSenplades
							FROM
								genGeoSenplades gsz,
								genGeoSenplades gd,
								genGeoSenplades gc,
								genGeoSenplades gsc
							WHERE
								gsz.gen_idGenGeoSenplades = ".$valueDato['idGenGeoSenplades']." 
							AND gsz.idGenGeoSenplades = gd.gen_idGenGeoSenplades
							AND gd.idGenGeoSenplades = gc.gen_idGenGeoSenplades
							AND gc.idGenGeoSenplades = gsc.gen_idGenGeoSenplades";

					$senplades = $this->consultaMatriz($conn,$sqlZ);
					
				}

				$arrayMeses = explode(',', $valueDato['meses']);

				foreach ($arrayMeses as $keyMes => $valueMes) {
					$calViolenciaDelincuencia =0;
					$calProducion             =0;

					foreach ($senplades as $keySenplades => $valueSenplades) {
						
						//Recorre el arreglo de calificaciones de los subcircuitos
						foreach ($notasSubCircuitos as $keyNC => $valueNC) {
							$senpladesArray = array();
							$senpladesArray = array_keys(array_column($valueNC, 'idGenGeoSenplades'), $valueSenplades['idGenGeoSenplades']);

							//Si encuentra el idGenGeoSenplades extrae el valor y lo suma
							if (!empty($senpladesArray)) {							
								$keyMesNota = array_search($valueMes, array_column($valueNC, 'idGenMes'));
								$calViolenciaDelincuencia  += $valueNC[$keyMesNota]['resultVioDelin'];
								$calProducion += $valueNC[$keyMesNota]['resultProduc'];
										
							}
						}
									
					}

					$respuesta[$valueMes]=array(
												'idGenGeoSenplades'=>$valueDato['idGenGeoSenplades'],
												'apenom'=>$valueDato['apenom'],
												'resultVioDelin'=>$calViolenciaDelincuencia/count($senplades),
												'resultProduc'=>$calProducion/count($senplades),
												'idGenMes'=>$valueMes
												);	

				}

		}

		return $respuesta;
	}

	//Metodo que obtiene las calificaciones de los cursantes
	public function obtenerCalificacionesCursantes($conn, $anio, $idGenGeoSenplades)
	{

		if (!empty($cursantes=$this->obtenerCursantes($conn,$anio,$idGenGeoSenplades))) {
			
			if (!empty($sqlNC=$this->generarSqlCalificaciones($conn,$anio,$idGenGeoSenplades))) {
				
				if (!empty($notasSubCircuitos=$this->consultaMatriz($conn,$sqlNC))) {
					
					if (!empty($calificaciones=$this->generarCalificaciones($conn,$cursantes,$notasSubCircuitos))) {
						return $calificaciones;
					}else{
						die('NO EXISTEN CALIFICACIONES');
					}

				} else {
					die('ERROR AL OBTENER NOTAS SUBCIRCUITOS');
				}
				
			} else {
				die('ERROR AL OBTENER SQL NOTAS');
			}
			
		} else {
			die('ERROR AL OBTENER CURSANTES');
		}		

	}
	
}
