<?php
session_start();
require_once("../../../funciones/funcion_select.php");
require_once('../../../clases/autoload.php');
$conn = DB::getConexionDB();
if (isset($_GET['a'])) {

	$sql = "SELECT b.descDgoEje, a.objEspecifico, a.estrategia, a.objOperativo FROM dgoEjeProcSu a, dgoEje b 
	WHERE a.idDgoEje=b.idDgoEje AND a.idDgoEjeProcSu='" . $_GET['a'] . "'";

	$rs = $conn->query($sql);
	$rowB = $rs->fetch();
	include_once('tablaObj.php');
}
