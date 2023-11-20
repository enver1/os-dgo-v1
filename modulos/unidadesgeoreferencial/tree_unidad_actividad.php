<?php
// para obtener todo el arbol de unidades cambiar el 1094 por el cero 0 2660
include '../../../clases/autoload.php';
$conn = DB::getConexionDB();


$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

/**
 * id de la fila con el proceso hoja de ruta
 * de la tabla genTipoActividad
 */
$idHojaRuta = 6;
$idCGOP = 12;

$result = array();
if ($id <> 0)
	$sql = "SELECT a.idGenGestionAdmin idGenGestionAdmin,idGenGestionAdminH,g.idGenActividadGA idGenActividadGA,descGestionAdmin,descGenTipoActividad
	FROM genGestionAdmin a
	LEFT JOIN genActividadGA g ON a.idGenGestionAdmin=g.idGenGestionAdmin
	LEFT JOIN genTipoActividad c ON g.idGenTipoActividad=c.idGenTipoActividad
	WHERE idGenGestionAdminH = $id AND (c.idGenTipoActividad = $idHojaRuta OR c.idGenTipoActividad = $idCGOP)"; //

else
	$sql = "SELECT 
  a.idGenGestionAdmin idGenGestionAdmin,
  idGenGestionAdminH,
  g.idGenActividadGA idGenActividadGA,
  descGestionAdmin,
  descGenTipoActividad 
FROM
  genGestionAdmin a 
  LEFT JOIN genActividadGA g 
    ON a.idGenGestionAdmin = g.idGenGestionAdmin 
  LEFT JOIN genTipoActividad c 
    ON g.idGenTipoActividad = c.idGenTipoActividad 
WHERE -- idGenGestionAdminH IS NULL 
  -- (c.idGenTipoActividad = $idHojaRuta OR c.idGenTipoActividad = $idCGOP) AND 
   NOT 
  (SELECT 
    COUNT(*) 
  FROM
    genGestionAdmin 
  WHERE idGenGestionAdminH = a.idGenGestionAdminH) > 1";


//echo $sql;
$rs = $conn->query($sql);
while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
	$node = array();
	$node['id'] = $row['idGenGestionAdmin'];
	$p = array('/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/');
	$r = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'n', 'N');
	$x = preg_replace($p, $r, $row['descGestionAdmin'] . ' - ' . $row['descGenTipoActividad']);
	$node['text'] = $x;
	//	$node['text'] = $row['descripcion'];
	$node['attributes'] = array($row['idGenActividadGA'], 'ko');
	$node['state'] = has_child($row['idGenGestionAdmin'], $conn, $idHojaRuta) ? 'closed' : 'open';
	array_push($result, $node);
}

echo json_encode($result);

function has_child($id, $conn, $idHojaRuta)
{
	$sql = "SELECT count(*) numreg FROM genGestionAdmin a
	LEFT JOIN genActividadGA g ON a.idGenGestionAdmin=g.idGenGestionAdmin
	LEFT JOIN genTipoActividad c ON g.idGenTipoActividad=c.idGenTipoActividad
	WHERE idGenGestionAdminH = $id "; //AND c.idGenTipoActividad = $idHojaRuta
	//echo $sql;
	$rs = $conn->query($sql);
	$row = $rs->fetch(PDO::FETCH_ASSOC);
	if ($row['numreg'] == 0)
		return false;
	else
		return true;
}
