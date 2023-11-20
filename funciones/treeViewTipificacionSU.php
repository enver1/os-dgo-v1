<?php
// para obtener todo el arbol de unidades cambiar el 1094 por el cero 0 2660
include '../../funciones/db_connect.inc.php';
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$result = array(); 
/*if($parroquia==0)
	$condParroquia=" and idGenTipoDivision<>5 ";
else
	$condParroquia="";
*/
if ($id<>0)
	$sql="select idGenTipoTipificacion,gen_idGenTipoTipificacion,descripcion,siglas from genTipoTipificacion where gen_idGenTipoTipificacion =".$id." order by 3"	;
else
{
	$sql="select idGenTipoTipificacion,gen_idGenTipoTipificacion,descripcion,siglas from genTipoTipificacion where siglas='OPSU' and gen_idGenTipoTipificacion is null order by 3"	;
}


//echo $sql;
$rs = $conn->query($sql);
while($row=$rs->fetch(PDO::FETCH_ASSOC)){
	$node = array();
	$node['id'] = $row[upc('idGenTipoTipificacion')];
	$p = array('/�/','/�/','/�/','/�/','/�/','/�/','/�/','/�/','/�/','/�/','/�/','/�/','/�/','/�/','/�/','/�/','/�/');
  	$r = array('a','e','i','o','u','A','E','I','O','U','a','e','i','o','u','n','N');
  	$x=preg_replace($p, $r, $row[upc('descripcion')]);
	$node['text'] = $x;
        $node['attributes']=$row[upc('siglas')];
	$node['state'] = has_child($row[upc('idGenTipoTipificacion')],$conn) ? 'closed' : 'open';
	array_push($result,$node);
}

echo json_encode($result);

function has_child($id,$conn){
	$sql = "select count(*) numreg  from genTipoTipificacion where gen_idGenTipoTipificacion=".$id;
	//echo $sql;
	$rs = $conn->query($sql);
	$row=$rs->fetch(PDO::FETCH_ASSOC);
	if ($row[upc('numreg')]==0)
		return false;
	else
		return true;
}
 
?>

