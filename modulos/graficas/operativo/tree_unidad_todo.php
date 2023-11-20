<?php
// para obtener todo el arbol de unidades cambiar el 1094 por el cero 0 2660
include '../../../../clases/autoload.php';
$conn = DB::getConexionDB();
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$result = array();

if ($id <> 0)
	$sql = "select idGenGeoSenplades,gen_idGenGeoSenplades,descripcion from genGeoSenplades where gen_idGenGeoSenplades =" . $id . " order by 3";
else
	$sql = "select idGenGeoSenplades,gen_idGenGeoSenplades,descripcion from genGeoSenplades where gen_idGenGeoSenplades=3166 order by 3";

$rs = $conn->query($sql);
while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
	$node = array();
	$node['id'] = $row['idGenGeoSenplades'];
	$p = array('/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/');
	$r = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'n', 'N');
	$x = preg_replace($p, $r, $row['descripcion']);
	$node['text'] = $x;
	$node['state'] = has_child($row['idGenGeoSenplades'], $conn) ? 'closed' : 'open';
	array_push($result, $node);
}

echo json_encode($result);

function has_child($id, $conn)
{
	$sql = "select count(*) numreg from genGeoSenplades where gen_idGenGeoSenplades=" . $id . " ";
	//echo $sql;
	$rs = $conn->query($sql);
	$row = $rs->fetch(PDO::FETCH_ASSOC);
	if ($row['numreg'] == 0)
		return false;
	else {
		return true;
	}
}
