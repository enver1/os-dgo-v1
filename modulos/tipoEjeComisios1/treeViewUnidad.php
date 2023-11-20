<?php
// para obtener todo el arbol de unidades cambiar el 1094 por el cero 0 2660
include '../../../funciones/db_connect.inc.php';
include_once '../../../clases/autoload.php';
$encriptar = new Encriptar;
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$filtro='';
$result = array();
if ($id<>0)
	$sql="SELECT idDglValCaract,dgl_idDglValCaract,descValCaract,idDglTCaracter,filtro from dglValCaract where  delLog = 'N' and dgl_idDglValCaract =".$id." ".$filtro."  order by 3,1"	;
else
	$sql="SELECT idDglValCaract,dgl_idDglValCaract,descValCaract,idDglTCaracter,filtro from dglValCaract where delLog = 'N' and dgl_idDglValCaract is null  and idDglValCaract>0  ".$filtro." order by 3,1"	;

$rs = $conn->query($sql);
while($row=$rs->fetch(PDO::FETCH_ASSOC)){
	$node = array();
	$node['id'] = $row['idDglValCaract'];
	$p = array('/�/','/�/','/�/','/�/','/�/','/�/','/�/','/�/','/�/','/�/','/�/','/�/','/�/','/�/','/�/','/�/','/�/');
  	$r = array('a','e','i','o','u','A','E','I','O','U','a','e','i','o','u','n','N');
  	$x=preg_replace($p, $r, $row['descValCaract']);
	$node['text'] = $x;
	$node['attributes'] = array($row['descValCaract'], $encriptar->getEncriptar($row['idDglValCaract'], $_SESSION['usuarioAuditar']));
	
	$node['state'] = has_child($row['idDglValCaract'],$conn) ? 'closed' : 'open';

	array_push($result,$node);
}

echo json_encode($result);

function has_child($id,$conn){
	$sql = "select count(*) numreg from dglValCaract where dgl_idDglValCaract='".$id."'  ";
	$rs = $conn->query($sql);
	$row=$rs->fetch(PDO::FETCH_ASSOC);
	if ($row['numreg']==0)
		return false;
	else
		return true;
}
 
?>

