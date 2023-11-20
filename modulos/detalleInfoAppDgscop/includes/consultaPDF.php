<?php
session_start();
include_once '../../../../clases/autoload.php';
$conn = DB::getConexionDB();
$encriptar = new Encriptar;
$id = strip_tags($encriptar->getDesencriptar($_GET['idDnaInfoDetalleApp'], $_SESSION['usuarioAuditar']));
$sql = "SELECT accion,filtro from dnaInfoDetalleApp  where idDnaInfoDetalleApp=" . $id;
$rs = $conn->query($sql);
$row = $rs->fetch();
$accion = $row['accion'];
$filtro = $row['filtro'];
if ($filtro == 'PDF') {
	if (!empty($accion)) {
		echo "<iframe src=../../../../descargas/operaciones/appDgscop/archivos/" . $accion . " width=100% height=100%>";
	} else {
		echo "NO EXISTE UN DOCUMENTO PDF CARGADO PARA ESTE RESGISTRO";
	}
} else {
	echo "ESTA OPCIÓN ES UN " . $filtro;
}
