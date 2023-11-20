<?php 

/**
* 
*/
class Persona
{
	/* Metodo que permite realizar las consultas a la base de datos */
	private function consultar($conn,$sqlC)
	{
		try {

			$rs=$conn->query($sqlC);
			if($row=$rs->fetch(PDO::FETCH_ASSOC)){
				return $row;
			}

		} catch (Exception $e) {
			die('ERROR: '.$e->getMessage());
		}
		
	}

	/* Metodo que verifica si la persona existe */
	public function verificarExistePersona($conn, $documento)
	{
		$sql = "SELECT p.idGenPersona FROM genPersona p, genDocumento doc WHERE p.idGenPersona=doc.idGenPersona AND doc.idGenTipoDocu=1 AND doc.documento='".trim($documento)."'";

		if (!empty($dato = $this->consultar($conn,$sql))) {
			return $dato['idGenPersona'];
		}
	}

	/* Metodo que permite obtener los datos de una persona que trabaje en la Policia Nacional */
	public function obtenerPolicia($conn,$idGenPersona)
	{
		$sql = "SELECT
					p.idGenPersona,
					trim(doc.documento) documento,
					CONCAT(IF(ISNULL(gr.siglas),'',CONCAT(gr.siglas,'. ')), p.apenom) siglaApenom,
					gr.idDgpGrado,
					gr.siglas, 
					p.apenom,
					ts.descripcion situacion,
					uni.nomenclatura as unidad,
					REPLACE (
							un.nomenclatura,
							uni.nomenclatura,
							''
					) AS asignacion,
					CONCAT(uni.nomenclatura,IFNULL(REPLACE (un.nomenclatura,uni.nomenclatura,''),'')) unidadLabora,
					u.idGenUsuario,
					tf.fono, 
					em.email
				FROM
					genPersona p 
				INNER JOIN genDocumento doc ON p.idGenPersona = doc.idGenPersona AND doc.idGenTipoDocu = 1
				INNER JOIN dgpPersonal pp ON pp.idGenPersona = p.idGenPersona 
				LEFT JOIN dgpTipoSituacion ts ON ts.idDgpTipoSituacion = pp.idDgpTipoSituacion 
				LEFT JOIN dgpResumenPersonal rp ON rp.idGenPersona = pp.idGenPersona
				LEFT JOIN dgpPdtPase ps ON rp.idDgpPdtPase=ps.idDgpPdtPase
				LEFT JOIN dgpUnidad uni ON ps.idDgpUnidad=uni.idDgpUnidad
				LEFT JOIN dgpPdtAsignacion pas ON rp.idDgpPdtAsignacion=pas.idDgpPdtAsignacion
				LEFT JOIN dgpUnidad un ON pas.idDgpUnidad=un.idDgpUnidad
				LEFT JOIN dgpAscenso pa ON pa.idDgpAscenso = rp.idDgpAscenso
				LEFT JOIN dgpGrado gr ON gr.idDgpGrado = pa.idDgpGrado
				LEFT JOIN genUsuario u ON p.idGenPersona = u.idGenPersona
				LEFT JOIN genTelefono tf on tf.idGenPersona=pp.idGenPersona and tf.telefonoPrincipal='S'
				LEFT JOIN genEmail em on em.idGenPersona=pp.idGenPersona and em.emailPrinc='S'
				WHERE
					p.idGenPersona = '".$idGenPersona."'";

		if (!empty($datos = $this->consultar($conn,$sql))) {
			return $datos;
		}
	}


}

 ?>