<script type="text/javascript">
	$(document).ready(function() {
		var value = $('#idTS').val();
		if (value != "") {
			$("#idIgpTSancion option[value=" + value + "]").attr("selected", true);
		}
	});
</script>
<!-- <input type="hidden" name="idTS" id="idTS" value="<?php echo $_GET['ts'] ?>" /> -->

<?php
$codigo = $_GET['codigo'];
include_once('../../../clases/autoload.php');
$conn = DB::getConexionDB();
include_once('../../../funciones/funciones_generales.php');
function comboEjes($pdo, $nombretabla = '', $indice = '', $valor = '', $sql, $onclick = '', $estilo = 'width:300px', $clase = 'inputSombra', $lectura = '')
{
	$consulta = $pdo->query($sql);
	echo '<select class="' . $clase . '" style="' . $estilo . '" ' . " name='$indice' id='$indice' " . $onclick . " " . $lectura . ">";
	echo "<option value=''>Todos los Ejes</option>";
	while ($dato = $consulta->fetch()) {
		echo "<option value='" . $dato[upc($indice)] . "'  >" . $dato[upc($valor)] . "</option>";
	}
	echo "</select>";
}

$sqlV = "SELECT idDgoVisita FROM dgoVisita WHERE sha1(idDgoActUnidad)='$codigo'";
$rs = $conn->query($sqlV);

if ($rowt = $rs->fetch(PDO::FETCH_ASSOC)) {
	$idDgoVisita = $rowt['idDgoVisita'];
} else {
	$idDgoVisita = 0;
}

echo '<input type="hidden" name="idDgoVisita"  id="idDgoVisita" value="' . $idDgoVisita . '" />';

$sql = "SELECT b.idDgoEjeProcSu, a.descDgoEje descripcion
FROM dgoEje a
INNER JOIN dgoEjeProcSu b ON a.idDgoEje=b.idDgoEje
INNER JOIN dgoActividad c ON b.idDgoEjeProcSu=c.idDgoEjeProcSu
INNER JOIN dgoInstrucci d ON c.idDgoActividad=d.idDgoActividad
INNER JOIN dgoActUniIns e ON d.idDgoInstrucci=e.idDgoInstrucci
INNER JOIN dgoActUnidad f ON e.idDgoActUnidad=f.idDgoActUnidad
WHERE sha1(f.idDgoActUnidad)='$codigo' GROUP BY b.idDgoEjeProcSu ORDER BY 2";

$onclick = '';
$nombretabla = 'dgoEjeProcSu';
$indice = 'idDgoEjeProcSu';
$title = 'Caracter&iacute;sticas del tipo de evidencia';
//$valoractual=$_GET['idc'];

comboEjes($conn, $nombretabla, 'idDgoEjeProcSu', 'descripcion', $sql, $onclick, $estilo = 'width:250px', $clase = 'inputSombra', $lectura = '', $title);


?>