<?php
// para obtener todo el arbol de unidades cambiar el 1094 por el cero 0 2660
include '../../../funciones/db_connect.inc.php';
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$result = array();
if ($id<>0)
	$sql="select idGenDivPolitica,gen_idGenDivPolitica,descripcion from genDivPolitica where gen_idGenDivPolitica =".$id." order by 1"	;
else
	$sql="select idGenDivPolitica,gen_idGenDivPolitica,descripcion from genDivPolitica where gen_idGenDivPolitica is null order by 1"	;

//echo $sql;
$rs = $conn->query($sql);
while($row=$rs->fetch(PDO::FETCH_ASSOC)){
	$node = array();
	$node['id'] = $row['idGenDivPolitica'];
	$p = array('/á/','/é/','/í/','/ó/','/ú/','/Á/','/É/','/Í/','/Ó/','/Ú/','/à/','/è/','/ì/','/ò/','/ù/','/ñ/','/Ñ/');
  	$r = array('a','e','i','o','u','A','E','I','O','U','a','e','i','o','u','n','N');
  	$x=preg_replace($p, $r, $row['descripcion']);
	$node['text'] = $x;
//	$node['text'] = $row['descripcion'];
	//$node['attributes']=array($row['idGenDivPolitica']);
	$node['state'] = has_child($row['idGenDivPolitica'],$conn) ? 'closed' : 'open';
	array_push($result,$node);
}

echo json_encode($result);

function has_child($id,$conn){
	$sql = "select count(*) numreg from genDivPolitica where gen_idGenDivPolitica=".$id." ";
	//echo $sql;
	$rs = $conn->query($sql);
	$row=$rs->fetch(PDO::FETCH_ASSOC);
	if ($row['numreg']==0)
		return false;
	else
		return true;
}
 
?>

