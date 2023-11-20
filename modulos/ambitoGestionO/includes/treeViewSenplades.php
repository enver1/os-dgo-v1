<?php
session_start();
include '../../../../clases/autoload.php';
include '../../../../funciones/funciones_generales.php';
$conn = DB::getConexionDB();
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$pais = isset($_GET['pais']) ? $_GET['pais'] : 0;
$parroquia = isset($_GET['parroquia']) ? $_GET['parroquia'] : 0;
$result = array();
$condip = '';
if ($pais != 0)
	$condip = " and idGenGeoSenplades=" . $pais;
if ($id <> 0)
	$sql = "SELECT idGenGeoSenplades,gen_idGenGeoSenplades,descripcion,siglasGeoSenplades, idGenTipoGeoSenplades FROM genGeoSenplades WHERE gen_idGenGeoSenplades =" . $id . " order by 3";
else {
	$sql = "SELECT idGenGeoSenplades,gen_idGenGeoSenplades,descripcion,siglasGeoSenplades, idGenTipoGeoSenplades FROM genGeoSenplades WHERE gen_idGenGeoSenplades=3166 order by descripcion";
}

$rs = $conn->query($sql);
while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
	$node = array();
	$node['id'] = $row[upc('idGenGeoSenplades')];
	$p = array('/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/');
	$r = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'n', 'N');
	$x = preg_replace($p, $r, $row[upc('descripcion')]);
	$node['text'] = $x;
	$node['attributes'] = $row[upc('siglasGeoSenplades')];
	$node['state'] = has_child($row[upc('idGenGeoSenplades')], $conn) ? 'closed' : 'open';
	$node['tipo'] = $row[upc('idGenTipoGeoSenplades')];
	array_push($result, $node);
}

echo json_encode($result);

function has_child($id, $conn)
{
	$sql = "SELECT count(*) numreg  from genGeoSenplades where gen_idGenGeoSenplades=" . $id;
	//echo $sql;
	$rs = $conn->query($sql);
	$row = $rs->fetch(PDO::FETCH_ASSOC);
	if ($row[upc('numreg')] == 0)
		return false;
	else
		return true;
}
