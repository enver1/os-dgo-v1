<?php 

/**
* 
*/
class valida 
{
	public function verificaExistenNotas($conn,$anio)
	{
		$existe = array(false,'No existen notas ingresadas para realizar los calculos');

		$anioUno = $anio-1;
		$anioDos = $anio-2;

		$sql="select anio from dgoDatos where anio=".$anioUno." or anio=".$anioDos." or anio=".$anio." group by anio";
		$rs=$conn->query($sql);

		if($row=$rs->fetchAll(PDO::FETCH_ASSOC)){
			$datosAnio = array_column($row,'anio');

			if (!empty(in_array($anio, $datosAnio))) {
				$existe = array(true,'');
			}else{
				$existe = array(false,'No existen notas ingresadas del '.$anio.' para realizar los calculos');
			}

			if (!empty(in_array($anioUno, $datosAnio))) {
				$existe = array(true,'');
			}else{
				$existe = array(false,'No existen notas ingresadas del '.$anioUno.' para realizar los calculos');
			}

			if (!empty(in_array($anioDos, $datosAnio))) {
				$existe = array(true,'');
			}else{
				$existe = array(false,'No existen notas ingresadas del '.$anioDos.' para realizar los calculos');
			}
		}

		return $existe;
	}


}

?>