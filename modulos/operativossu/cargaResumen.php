<?php
//echo $_GET['idEv'].' '.$_GET['tipT'];
include_once('../../../clases/autoload.php');
$conn = DB::getConexionDB();
$sql = "select *, a.detBusqueda busqueda from hdrEventoResum a,hdrTipoResum b where a.idHdrTipoResum=b.idHdrTipoResum and idHdrEvento=" . $_GET['idEv'] . " and a.idHdrTipoResum=" . $_GET['tipT'];
//echo $sql;
$rs = $conn->query($sql);
$first = true;
while ($row = $rs->fetch()) {
	if ($first) {
		echo '<span style="color:#337AB7;font-weight:bold">' . $row['descTipoResum'] . '</span><br><br>';
		$first = false;
	}

	if (($row['busqueda'] == 'No existen boletas') || ($row['busqueda'] == 'NO EXISTEN BOLETAS') || ($row['busqueda'] == 'NO EXISTE RESTRICCIÓN') || ($row['busqueda'] == 'No existen restricciones') || ($row['busqueda'] == '') || ($row['busqueda'] == 'null')) {
		echo '<p>' . $row['descEventoResum'] . '</p>';
	} else {
		echo '<p>' . $row['descEventoResum'] . '<font color="red">' . ' ' . $row['busqueda'] . '</font>' . '</p>';
	}
	//echo $busqueda;

}
