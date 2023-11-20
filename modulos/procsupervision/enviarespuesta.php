<?php
session_start();
include_once('../../../clases/autoload.php');
include_once('../../../funciones/funcion_select.php');
$conn = DB::getConexionDB();
if (empty($_POST['plazo']))
	$_POST['plazo'] = NULL;
else {
	if ($_POST['fechaInicioPlazo'] > $_POST['plazo']) {
		$resulta = array('Error: La fecha de Finalizacion de la Actividad no Puede ser menor que la Fecha de Inicio:' . $_POST['fechaInicioPlazo'], 0, 0, 0, 0);
		die(json_encode($resulta));
	}
}
$sql = "select a.idDgoInstrucci,b.peso,c.idDgoActUniIns from dgoInstrucci a,dgoActividad b, dgoActUniIns c 
where a.idDgoActividad=b.idDgoActividad and a.idDgoInstrucci=c.idDgoInstrucci 
and (a.idDgoActividad)=" . $_POST['idDgoActividad'] . " and (c.idDgoActUnidad)=" . $_POST['idDgoActUnidad'];
//echo $sql;
$rs = $conn->query($sql);
$suma = 0;
while ($row = $rs->fetch()) {
	$peso = $row['peso'];
	$sql = "delete from dgoEncVisita where idDgoVisita=? and idDgoEncuesta in (select idDgoEncuesta from dgoEncuesta where idDgoInstrucci=?)";
	$i = 0;
	$conn->beginTransaction();
	$sente = $conn->prepare($sql);
	$sente->bindParam(++$i, $_POST['idDgoVisita']);
	$sente->bindParam(++$i, $row['idDgoInstrucci']);
	$sente->execute() or die('Error al eliminar registros');
	if (isset($_POST['preg' . $row['idDgoInstrucci']])) {
		if (empty($_POST['obs' . $row['idDgoInstrucci']]))
			$_POST['obs' . $row['idDgoInstrucci']] = NULL;
		$sql = "insert into dgoEncVisita (idDgoVisita,idDgoEncuesta,usuario,ip,obsDgoEncVisita) values (?,?,?,?,?)";
		//print_r($sql);
		$i = 0;
		$sente = $conn->prepare($sql);
		$sente->bindParam(++$i, $_POST['idDgoVisita']);
		$sente->bindParam(++$i, $_POST['preg' . $row['idDgoInstrucci']]);
		$sente->bindParam(++$i, $_SESSION['usuarioAuditar']);
		$sente->bindParam(++$i, $ip);
		$sente->bindParam(++$i, $_POST['obs' . $row['idDgoInstrucci']]);
		$sente->execute() or die('Error al insertar registros');

		$sql = "update dgoActUniIns set fechaCumplimiento=?,usuario=?,ip=?,fecha=now() where idDgoActUniIns=?";
		$sentencia = $conn->prepare($sql);
		$i = 0;
		$sentencia->bindParam(++$i, $_POST['plazo']);
		$sentencia->bindParam(++$i, $_SESSION['usuarioAuditar']);
		$sentencia->bindParam(++$i, $ip);
		$sentencia->bindParam(++$i, $row['idDgoActUniIns']);
		$sentencia->execute() or die('Error al actualizar');
	}
	$sql = "select puntaje from dgoEncuesta where idDgoEncuesta=" . $_POST['preg' . $row['idDgoInstrucci']];
	$rsT = $conn->query($sql);
	$rowT = $rsT->fetch();
	$suma += $rowT['puntaje'];
	$conn->commit();
}
$sql = "select a.idDgoInstrucci,max(puntaje) puntos from dgoEncuesta a 
where exists (select * from dgoInstrucci b where a.idDgoInstrucci=b.idDgoInstrucci and b.idDgoActividad=" . $_POST['idDgoActividad'] . ")
group by a.idDgoInstrucci";
//echo $sql;
$rs = $conn->query($sql);
$ptotal = 0;
while ($row = $rs->fetch())
	$ptotal += $row['puntos'];
$nota = round($suma * 100 / $ptotal, 2);
echo json_encode(array('Las respuestas fueron registradas correctamente', $ptotal, $suma, $nota, $peso));
//echo 'respuestas grabadas';
