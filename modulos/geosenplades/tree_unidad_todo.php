<?php
// para obtener todo el arbol de unidades cambiar el 1094 por el cero 0 2660
include '../../../funciones/db_connect.inc.php';
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$result = array();
//print"antes del if";
if ($id<>0)
{
$sql="Select a.idGenGeoSenplades,a.gen_idGenGeoSenplades,a.descripcion,b.siglasGeoSenplades siglasPadre,a.siglasGeoSenplades siglasHijo,a.codigoSenplades codigoSenplades,a.idGenTipoGeoSenplades TipoGeoSenplades from genGeoSenplades a, genGeoSenplades b, genTipoGeoSenplades c where a.gen_idGenGeoSenplades=b.idGenGeoSenplades and	a.idGenTipoGeoSenplades=c.idGenTipoGeoSenplades and a.gen_idGenGeoSenplades=".$id."";
	}
else
	$sql="Select a.descripcion,a.idGenGeoSenplades,a.gen_idGenGeoSenplades,a.siglasGeoSenplades siglasHijo,a.codigoSenplades codigoSenplades,	a.idGenTipoGeoSenplades TipoGeoSenplades from genGeoSenplades a, genTipoGeoSenplades c where a.idGenTipoGeoSenplades=c.idGenTipoGeoSenplades and 	
	a.gen_idGenGeoSenplades is null";

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
	if ($id<>0)
	$node['attributes']=array($row['siglasHijo'],$row['codigoSenplades'],$row['TipoGeoSenplades'],$row['siglasPadre']);
	else
	$node['attributes']=array($row['siglasHijo'],$row['codigoSenplades'],$row['TipoGeoSenplades']);
	
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

