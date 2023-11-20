<?php
header('Content-Type: text/html; charset=UTF-8');
include '../../../clases/autoload.php';
$conn = DB::getConexionDB();

//$sql="SELECT fechaInicio, fechaFin FROM dgoActUnidad WHERE idDgoActUnidad='".$_GET['c']."'";

$sql = "SELECT b.fechaInicio, b.fechaFinal FROM dgoActUnidad a, dgoProcSuper b WHERE a.idDgoProcSuper=b.idDgoProcSuper AND a.idDgoActUnidad='" . $_GET['c'] . "'";

$rs = $conn->query($sql);
if ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
	echo '<table width="100%">
			<tr>
				<td>
					<input type="hidden" name="fini" id="fini" value="' . $row['fechaInicio'] . '">
					<input type="hidden" name="ffin" id="ffin" value="' . $row['fechaFinal'] . '">
				</td>
			</tr>
		</table>';
}
