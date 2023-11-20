<?php
session_start();
include_once '../../../../clases/autoload.php';
$conn = DB::getConexionDB();
$encriptar = new Encriptar;
$id = strip_tags($encriptar->getDesencriptar($_GET['idDnaInfoApp'], $_SESSION['usuarioAuditar']));
$sql = "SELECT icono from dnaInfoApp  where idDnaInfoApp=" . $id;
$rs = $conn->query($sql);
$row = $rs->fetch();
$imagen = $row['icono'];

if (!empty($imagen)) {
	echo "<img src=../../../../descargas/operaciones/appDgscop/imagenes/" . $imagen . " width=35%>";
} else {
	echo "NO EXISTE UNA IMAGEN SELLECIONADA PARA ESTE RESGISTRO";
}
