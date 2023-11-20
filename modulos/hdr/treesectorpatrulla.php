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

/**
 * si $_POST['id'] = 0 obtener todos los nodos principales
 * caso contrario obtener los hijos
 * 
 * SQL de consulta a la base de datos
 */
if(!isset($_POST['id'])){
	/**
	 * cambiar
	 */
	$sql="SELECT genGeoSenplades.idGenGeoSenplades,genGeoSenplades.gen_idGenGeoSenplades,genGeoSenplades.descripcion
	FROM genUsuario
	INNER JOIN genUsuarioActividadGA ON genUsuario.idGenUsuario = genUsuarioActividadGA.idGenUsuario
	INNER JOIN genActividadGA ON genUsuarioActividadGA.idGenActividadGA = genActividadGA.idGenActividadGA
	INNER JOIN genUnidadesGeoreferencial ON genActividadGA.idGenActividadGA = genUnidadesGeoreferencial.idGenActividadGA
	INNER JOIN genGeoSenplades ON genGeoSenplades.idGenGeoSenplades = genUnidadesGeoreferencial.idGenGeoSenplades
	WHERE genUsuario.idGenUsuario = ".$_SESSION['idusuario'] ." AND genActividadGA.idGenTipoActividad = 6";
}else{
	$sql="select idGenGeoSenplades,gen_idGenGeoSenplades,descripcion from genGeoSenplades where gen_idGenGeoSenplades =".$_POST['id']." order by 3";
}

/**
 * obtener el codigo del recurso
 */
$sql1="Select idHdrRecurso from hdrRecurso where sha1(idHdrRecurso)='".$_REQUEST['idRecurso']."'";
$rs1=$conn->query($sql1);
$rowt = $rs1->fetch(PDO::FETCH_ASSOC);
$idHdrRecurso = $rowt['idHdrRecurso'];

/**
 * preparando la consulta
 */
$rs = $conn->query($sql);

/**
 * definiendo arreglo
 */
$result = array();

/**
 * recorriendo la lista resultante
 */
while($row=$rs->fetch(PDO::FETCH_ASSOC)){
	$node = array();
	$node['id'] = $row['idGenGeoSenplades'];
	$p = array('/á/','/é/','/í/','/ó/','/ú/','/Á/','/É/','/Í/','/Ó/','/Ú/','/à/','/è/','/ì/','/ò/','/ù/','/ñ/','/Ñ/');
	$r = array('a','e','i','o','u','A','E','I','O','U','a','e','i','o','u','n','N');
	$x = preg_replace($p, $r, $row['descripcion']);
	$node['text'] = $x;
	$node['state'] = has_child($row['idGenGeoSenplades'],$conn) ? 'closed' : 'open';
	$node['checked']=isChecked($row['idGenGeoSenplades'],$idHdrRecurso,$conn);
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
	$sql = "select count(gen_idGenGeoSenplades) numreg from genGeoSenplades where gen_idGenGeoSenplades=$id";
	$rs = $conn->query($sql);
	$row=$rs->fetch(PDO::FETCH_ASSOC);
	if ($row['numreg'] == 0){
		return false;
	}else{
		return true;
	}
}

/**
 * verificar si el registro a sido guardado para mostrarlo seleccionado
 * @param number $id
 * @param number $idHdrRecurso
 * @param conn $conn objeto conexion
 * @return string
 */
function isChecked($id, $idHdrRecurso, $conn){
	$sql = "SELECT COUNT(idHdrSectorPatrulla) numreg FROM hdrSectorPatrulla WHERE idHdrRecurso = $idHdrRecurso AND idGenGeoSenplades = $id";
	$rs = $conn->query($sql);
	$row=$rs->fetch(PDO::FETCH_ASSOC);
	if ($row['numreg'] == 0){
		return "";
	}else{
		return "checked";
	}
}
?>

