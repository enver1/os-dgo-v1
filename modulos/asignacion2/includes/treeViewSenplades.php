<?php
// para obtener todo el arbol de unidades cambiar el 1094 por el cero 0 2660
include '../../../../clases/autoload.php';
$conn = DB::getConexionDB();
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$pais = isset($_GET['pais']) ? $_GET['pais'] : 0;
$parroquia = isset($_GET['parroquia']) ? $_GET['parroquia'] : 0;
$result = array();
$condip = '';

if ($pais != 0)
	$condip = " and idGenGeoSenplades=" . $pais;
if ($id <> 0)
	$sql = "select idGenGeoSenplades,gen_idGenGeoSenplades,idGenTipoGeoSenplades,descripcion,siglasGeoSenplades from genGeoSenplades where gen_idGenGeoSenplades =" . $id . " order by 3";
else {
	$sql = "select idGenGeoSenplades,gen_idGenGeoSenplades,idGenTipoGeoSenplades,descripcion,siglasGeoSenplades from genGeoSenplades where gen_idGenGeoSenplades is null " . $condip . " order by 3";
}


//echo $sql;
$rs = $conn->query($sql);
while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
	$node = array();
	$node['id'] = $row[FuncionesGenerales::upc('idGenGeoSenplades')];
	$p = array('/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/');
	$r = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'n', 'N');
	$x = preg_replace($p, $r, $row[FuncionesGenerales::upc('descripcion')]);
	$node['text'] = $x;
	$node['attributes'] = $row[FuncionesGenerales::upc('siglasGeoSenplades')];
	//$node['tipo'] = $row[FuncionesGenerales::upc('idGenTipoGeoSenplades')];
	$node['attributes'] = array($row[FuncionesGenerales::upc('siglasGeoSenplades')], $row[FuncionesGenerales::upc('idGenTipoGeoSenplades')]);
	$node['state'] = has_child($row[FuncionesGenerales::upc('idGenGeoSenplades')], $conn) ? 'closed' : 'open';
	array_push($result, $node);
}

echo json_encode($result);

function has_child($id, $conn)
{
	$sql = "select count(*) numreg  from genGeoSenplades where gen_idGenGeoSenplades=" . $id;
	//echo $sql;
	$rs = $conn->query($sql);
	$row = $rs->fetch(PDO::FETCH_ASSOC);
	if ($row[FuncionesGenerales::upc('numreg')] == 0)
		return false;
	else
		return true;
}
