<?php
session_start();

include_once '../../../clases/autoload.php';
$conn = DB::getConexionDB();
include_once('../../../funciones/funcion_select.php');
$sql = "SELECT a.idDgoInstrucci from dgoInstrucci a,dgoActividad b, dgoActUniIns c 
where a.idDgoActividad=b.idDgoActividad and a.idDgoInstrucci=c.idDgoInstrucci 
and (a.idDgoActividad)=" . $_POST['idDgoActividad'] . " and (c.idDgoActUnidad)=" . $_POST['idDgoActUnidad'];
//echo $sql;
$rs = $conn->query($sql);
$j = 0;
$aFalta = array();
while ($row = $rs->fetch()) {
	if (!isset($_POST['preg' . $row['idDgoInstrucci']])) {
		$aFalta[$j] = $row['idDgoInstrucci'];
		$j++;
	}
}
if (empty($aFalta))
	$aFalta = array('NO');
echo json_encode($aFalta);
