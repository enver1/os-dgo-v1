<?php
// para obtener todo el arbol de unidades cambiar el 1094 por el cero 0 2660
include '../../../funciones/db_connect.inc.php';
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$result = array();

if ($id<>0)
	/*$sql="select a.idGenGeoSenplades,a.gen_idGenGeoSenplades,a.descripcion,b.siglasGeoSenplades siglasPadre, a.siglasGeoSenplades siglasHijo,
a.codigoSenplades codigoSenplades, b.idGenTipoGeoSenplades TipoGeoSenplades from genGeoSenplades a
join genGeoSenplades b on a.gen_idGenGeoSenplades=b.idGenGeoSenplades and a.gen_idGenGeoSenplades = ".$id." join genTipoGeoSenplades c on a.idGenGeoSenplades=c.idGenTipoGeoSenplades
order by 1";*/
$sql="select idGenGeoSenplades,gen_idGenGeoSenplades,descripcion from genGeoSenplades where gen_idGenGeoSenplades =".$id." order by 3";
else
	/*$sql="Select a.idGenGeoSenplades,a.gen_idGenGeoSenplades,a.descripcion, a.siglasGeoSenplades siglasPadre, a.siglasGeoSenplades siglasHijo, a.codigoSenplades codigoSenplades, b.idGenTipoGeoSenplades TipoGeoSenplades
from genGeoSenplades a, genTipoGeoSenplades b where a.idGenTipoGeoSenplades=b.idGenTipoGeoSenplades and gen_idGenGeoSenplades is null";*/
$sql="select idGenGeoSenplades,gen_idGenGeoSenplades,descripcion from genGeoSenplades where gen_idGenGeoSenplades is null order by 3"	;

$rs = $conn->query($sql);
while($row=$rs->fetch(PDO::FETCH_ASSOC)){
	$node = array();
	$node['id'] = $row['idGenGeoSenplades'];
	$p = array('/á/','/é/','/í/','/ó/','/ú/','/Á/','/É/','/Í/','/Ó/','/Ú/','/à/','/è/','/ì/','/ò/','/ù/','/ñ/','/Ñ/');
  	$r = array('a','e','i','o','u','A','E','I','O','U','a','e','i','o','u','n','N');
  	$x=preg_replace($p, $r, $row['descripcion']);
	$node['text'] = $x;
	//$node['text'] = $row['descripcion'];
	//$node['attribute']=array($row['siglasHijo']);
	//$node['attributes']=array($row['siglasPadre'],$row['siglasHijo'],$row['codigoSenplades'],$row['TipoGeoSenplades']);
	$node['state'] = has_child($row['idGenGeoSenplades'],$conn) ? 'closed' : 'open';
	array_push($result,$node);
}

echo json_encode($result);

function has_child($id,$conn){
	$sql = "select count(*) numreg from genGeoSenplades where gen_idGenGeoSenplades=".$id." ";
	//echo $sql;
	$rs = $conn->query($sql);
	$row=$rs->fetch(PDO::FETCH_ASSOC);
	if ($row['numreg']==0)
		return false;
		else
		{			
		return true;}
}
 
?>

