<?php 
include ('../notasCursantes/clases/calificacion.php');
/**
* 
*/
class lineaBase extends calificacion
{
	
	//Generar SQL para la linea base
	public function generarSqlLineaBase($conn,$anio,$mes)
	{
		$sql = "select gp.siglasGeoSenplades, gp.descripcion,  gp.codigoSenplades, ";

		if (!empty($indicadores = $this->obtenerIndicadores($conn))) {
		 	foreach ($indicadores as $key => $value) {
		 		$sql.= "((a.".$value['campoTabla']." + b.".$value['campoTabla'].") / 2) as ".$value['campoTabla'].", ";
		 	}
		 } 


		$sql.=" a.idGenMes 
			from dgoDatos a
			left join dgoDatos b on a.idGenGeoSenplades=b.idGenGeoSenplades and a.idGenMes=b.idGenMes and b.anio=".($anio-1)."
			join genGeoSenplades gp on a.idGenGeoSenplades=gp.idGenGeoSenplades
			where a.anio=".($anio-2)." AND a.idGenMes=".$mes." ORDER BY gp.codigoSenplades, a.idGenMes ";

		//echo $sql;
		return $sql;


	}

	//Metodo que obtiene la linea base
	public function obtenerLineaBase($conn,$anio,$mes)
	{
		if (!empty($sqlLB = $this->generarSqlLineaBase($conn,$anio,$mes))) {
			if (!empty($lineaBase =  $this->consultaMatriz($conn,$sqlLB))) {
				return $lineaBase;
			}
		}else{
			die('ERROR: Al obtener SQL de la linea base.');
		}
	}

	//Netodo que obtiene los titulos del reporte
	public function obtenerTitulosLineaBase($conn)
	{
		$titulos = array('Siglas','Nombre Sub Circuito','Codigo Senplades');

		if (!empty($indicadores=$this->obtenerIndicadores($conn))) {
			foreach ($indicadores as $key => $value) {
				array_push($titulos,$value['descDgoIndicador']);
			}
		}

		return $titulos;
	}

	//Netodo que obtiene los titulos del reporte
	public function obtenerData($conn)
	{
		$data = array('siglasGeoSenplades','descripcion','codigoSenplades');

		if (!empty($indicadores=$this->obtenerIndicadores($conn))) {
			foreach ($indicadores as $key => $value) {
				array_push($data,$value['campoTabla']);
			}
		}

		return $data;
	}
	
}

 ?>