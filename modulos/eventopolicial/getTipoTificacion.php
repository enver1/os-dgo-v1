<?php
/**
 * Autor Carlos León SIS ECU 911
 * obtener el arbol con su respectiva selección
 * @fecha 10-06-2014
 */

/**
 * obtener la clase de conección
 */
include '../../../funciones/db_connect.inc.php';
include '../evento115/logica/Configuraciones.php';

/**
 * si $_POST['id'] = 0 obtener todos los nodos principales
 * caso contrario obtener los hijos
 * 
 * SQL de consulta a la base de datos
 */
if(isset($_REQUEST['buscar'])){
	if(strlen($_REQUEST['buscar']) == 0){
		if(!isset($_POST['id'])){
			if(isset($_REQUEST['sisecu'])){
				$sql="SELECT idGenTipoTipificacion,descripcion, '' AS'superior', genTipoTipificacion.detalle, genTipoTipificacion.protocolo, genTipoTipificacion.gen_idGenTipoTipificacion FROM genTipoTipificacion WHERE idGenTipoTipificacion = 1 ORDER BY descripcion";
			}else{
				$sql="SELECT idGenTipoTipificacion,descripcion, '' AS'superior', genTipoTipificacion.detalle, genTipoTipificacion.protocolo, genTipoTipificacion.gen_idGenTipoTipificacion FROM genTipoTipificacion WHERE gen_idGenTipoTipificacion IS NULL AND nivelImportancia IS NULL ORDER BY descripcion";
			}
		}else{
			$sql="SELECT genTipoTipificacion.idGenTipoTipificacion,genTipoTipificacion.descripcion, s.descripcion AS'superior', genTipoTipificacion.detalle, genTipoTipificacion.protocolo, genTipoTipificacion.gen_idGenTipoTipificacion 
			FROM genTipoTipificacion 
			INNER JOIN genTipoTipificacion s ON s.idGenTipoTipificacion = genTipoTipificacion.gen_idGenTipoTipificacion
			WHERE genTipoTipificacion.gen_idGenTipoTipificacion = {$_POST['id']} AND genTipoTipificacion.nivelImportancia IS NULL ORDER BY descripcion";
		}
	}else{
		$sql="SELECT genTipoTipificacion.idGenTipoTipificacion, genTipoTipificacion.descripcion, s.descripcion AS'superior', genTipoTipificacion.detalle, genTipoTipificacion.protocolo, genTipoTipificacion.gen_idGenTipoTipificacion
		FROM genTipoTipificacion 
		INNER JOIN genTipoTipificacion s ON genTipoTipificacion.gen_idGenTipoTipificacion = s.idGenTipoTipificacion
		WHERE genTipoTipificacion.descripcion LIKE '%{$_REQUEST['buscar']}%' AND genTipoTipificacion.nivelImportancia IS NULL 
		UNION 
		SELECT genTipoTipificacion.idGenTipoTipificacion, genTipoTipificacion.descripcion, '' AS'superior', genTipoTipificacion.detalle, genTipoTipificacion.protocolo, genTipoTipificacion.gen_idGenTipoTipificacion
		FROM genTipoTipificacion 
		WHERE genTipoTipificacion.descripcion LIKE '%{$_REQUEST['buscar']}%' AND genTipoTipificacion.nivelImportancia IS NULL AND gen_idGenTipoTipificacion IS NULL
		ORDER BY descripcion";
	}
}else{
	if(!isset($_POST['id'])){
		if(isset($_REQUEST['sisecu'])){
			$sql="SELECT idGenTipoTipificacion,descripcion, '' AS'superior', genTipoTipificacion.detalle, genTipoTipificacion.protocolo, genTipoTipificacion.gen_idGenTipoTipificacion FROM genTipoTipificacion WHERE idGenTipoTipificacion = 1 ORDER BY descripcion";
		}else{
			$sql="select idGenTipoTipificacion,descripcion, '' AS'superior', genTipoTipificacion.detalle, genTipoTipificacion.protocolo, genTipoTipificacion.gen_idGenTipoTipificacion FROM genTipoTipificacion WHERE gen_idGenTipoTipificacion IS NULL AND nivelImportancia IS NULL ORDER BY descripcion";
		}
	}else{
		$sql="SELECT genTipoTipificacion.idGenTipoTipificacion,genTipoTipificacion.descripcion, s.descripcion AS'superior', genTipoTipificacion.detalle, genTipoTipificacion.protocolo, genTipoTipificacion.gen_idGenTipoTipificacion 
		FROM genTipoTipificacion 
		INNER JOIN genTipoTipificacion s ON s.idGenTipoTipificacion = genTipoTipificacion.gen_idGenTipoTipificacion
		WHERE genTipoTipificacion.gen_idGenTipoTipificacion = {$_POST['id']} AND genTipoTipificacion.nivelImportancia IS NULL ORDER BY descripcion";
	}
}

/**
 * preparando la consulta
 */
$rs = $conn->query($sql);

/**
 * definiendo arreglo
 */
$result = array();

if(isset($_REQUEST['buscar'])){
	if(strlen($_REQUEST['buscar']) > 0){
		/**
		 * recorriendo la lista resultante
		 */
		while($row=$rs->fetch(PDO::FETCH_ASSOC)){
			$node = array();
			$node['id'] = $row['idGenTipoTipificacion'];
			$p = array('/á/','/é/','/í/','/ó/','/ú/','/Á/','/É/','/Í/','/Ó/','/Ú/','/à/','/è/','/ì/','/ò/','/ù/','/ñ/','/Ñ/');
			$r = array('a','e','i','o','u','A','E','I','O','U','a','e','i','o','u','n','N');
			$x = preg_replace($p, $r, $row['superior'].' - '.$row['descripcion']);
			$tipoPadre = preg_replace($p, $r, $row['superior']);
			$tipo = preg_replace($p, $r, $row['descripcion']);
			$detalle = preg_replace($p, $r, $row['detalle']);
			$protocolo = preg_replace($p, $r, $row['protocolo']);
			$node['text'] = $x;
			$node['attributes'] = array("detalle" => $detalle, 
										"protocolo" => $protocolo,
										"tipo"=> $tipo,
										"idPadre" => $row['gen_idGenTipoTipificacion'],
										"tipoPadre" => $tipoPadre);
			$node['state'] = 'open';
			array_push($result,$node);
		}
		
		echo json_encode($result);
		exit();
	}
}

/**
 * recorriendo la lista resultante
 */
while($row=$rs->fetch(PDO::FETCH_ASSOC)){
	$node = array();
	$node['id'] = $row['idGenTipoTipificacion'];
	$p = array('/á/','/é/','/í/','/ó/','/ú/','/Á/','/É/','/Í/','/Ó/','/Ú/','/à/','/è/','/ì/','/ò/','/ù/','/ñ/','/Ñ/');
	$r = array('a','e','i','o','u','A','E','I','O','U','a','e','i','o','u','n','N');
	$x = preg_replace($p, $r, $row['descripcion']);
	$tipoPadre = preg_replace($p, $r, $row['superior']);
			$tipo = preg_replace($p, $r, $row['descripcion']);
			$detalle = preg_replace($p, $r, $row['detalle']);
			$protocolo = preg_replace($p, $r, $row['protocolo']);
			$node['text'] = $x;
			$node['attributes'] = array("detalle" => $detalle, 
										"protocolo" => $protocolo,
										"tipo"=> $tipo,
										"idPadre" => $row['gen_idGenTipoTipificacion'],
										"tipoPadre" => $tipoPadre);
	$node['state'] = has_child($row['idGenTipoTipificacion'],$conn) ? 'closed' : 'open';
	array_push($result,$node);
}

echo json_encode($result);

/**
 * verificar si tiene hijos anidados
 * @param number $id codigo unico de fila
 * @param conn $conn objeto conexion
 * @return boolean
 */
function has_child($id,$conn){
	$sql = "select count(*) numreg from genTipoTipificacion where gen_idGenTipoTipificacion = $id and nivelImportancia is null";//"select count(gen_idGenGeoSenplades) numreg from genGeoSenplades where gen_idGenGeoSenplades=$id";
	$rs = $conn->query($sql);
	$row=$rs->fetch(PDO::FETCH_ASSOC);
	if ($row['numreg'] == 0){
		return false;
	}else{
		return true;
	}
}
?>

