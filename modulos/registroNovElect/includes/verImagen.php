<?php
session_start();

include_once '../../../../clases/autoload.php';
$conn = DB::getConexionDB();
$id = $_GET['idDgoNovReciElec'];
$sql = "SELECT idDgoNovReciElec,imagen from dgoNovReciElec  where idDgoNovReciElec=" . $id;
$rs = $conn->query($sql);
$row = $rs->fetch();
$imagen = $row['imagen'];
if (empty($imagen) || is_null($imagen) || $imagen == null || $imagen == '' || $imagen == 'null') {
	echo "NO EXISTE IMAGEN REGISTRADA PARA ESTA OPCIÓN";
} else {
	echo "<img src=../../../../descargas/movil/operaciones/elecciones2021/" . $imagen . " width=35%>";
}
