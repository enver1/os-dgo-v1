<?php
// para obtener todo el arbol de unidades cambiar el 1094 por el cero 0 2660
include '../../../funciones/db_connect.inc.php';
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$result = array();
if ($id<>0)
	$sql="select idDgpUnidad,dgp_idDgpUnidad,descripcion,nomenclatura,geografia from dgpUnidad where dgp_idDgpUnidad =".$id."  and idGenEstado=1  order by 3"	;
else
	$sql="select idDgpUnidad,dgp_idDgpUnidad,descripcion,nomenclatura,geografia from dgpUnidad where dgp_idDgpUnidad is null  and idDgpUnidad>0  and idGenEstado=1   order by 3"	;

//echo $sql;
$rs = $conn->query($sql);
while($row=$rs->fetch(PDO::FETCH_ASSOC)){
	$node = array();
	$node['id'] = $row['idDgpUnidad'];
	$p = array('/á/','/é/','/í/','/ó/','/ú/','/Á/','/É/','/Í/','/Ó/','/Ú/','/à/','/è/','/ì/','/ò/','/ù/','/ñ/','/Ñ/');
  	$r = array('a','e','i','o','u','A','E','I','O','U','a','e','i','o','u','n','N');
  	$x=preg_replace($p, $r, $row['descripcion']);
	$node['text'] = $x;
//	$node['text'] = $row['descripcion'];
	$node['attributes']=array($row['nomenclatura'],$row['geografia']);
	$node['state'] = has_child($row['idDgpUnidad'],$conn) ? 'closed' : 'open';
	array_push($result,$node);
}

echo json_encode($result);

function has_child($id,$conn){
	$sql = "select count(*) numreg from dgpUnidad where dgp_idDgpUnidad=".$id." and idGenEstado=1  ";
	//echo $sql;
	$rs = $conn->query($sql);
	$row=$rs->fetch(PDO::FETCH_ASSOC);
	if ($row['numreg']==0)
		return false;
	else
		return true;
}
 
?>

