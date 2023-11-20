<?php
include '../../../clases/autoload.php';
$conn = DB::getConexionDB();
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$result = array();
if ($id <> 0)
	$sql = "select idGenGeoSenplades,gen_idGenGeoSenplades,descripcion from genGeoSenplades where gen_idGenGeoSenplades =" . $id . " order by 3";
else
	$sql = "select idGenGeoSenplades,gen_idGenGeoSenplades,descripcion from genGeoSenplades where gen_idGenGeoSenplades is null order by 3";

$rs = $conn->query($sql);
while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
	$node = array();
	$node['id'] = $row['idGenGeoSenplades'];
	$p = array('/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/');
	$r = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'n', 'N');
	$x = preg_replace($p, $r, $row['descripcion']);
	$node['text'] = $x;
	$node['attributes'] = array($row['gen_idGenGeoSenplades']);
	$node['state'] = has_child($row['idGenGeoSenplades'], $conn) ? 'closed' : 'open';
	array_push($result, $node);
}
/**
 * imprimir resultado
 */
echo json_encode($result);
/**
 * verificar si tiene hijos
 * @param number $id codigo primario de tabla genGeoSenplades
 * @param conection $conn clase de conecci�n para acceder a la base de datos
 * @return boolean
 */
function has_child($id, $conn)
{
	$sql = "select count(*) numreg from genGeoSenplades where gen_idGenGeoSenplades=$id";
	$rs = $conn->query($sql);
	$row = $rs->fetch(PDO::FETCH_ASSOC);
	if ($row['numreg'] == 0)
		return false;
	else
		return true;
}
