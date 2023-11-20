<?php
session_start();
require_once("../../../../funciones/funcion_select.php");
include '../../../../clases/autoload.php';
$conn = DB::getConexionDB(); // include the database connection
$estilo = "";
$idcampo = "idDgoResAct";
/*=============*/

$htblock = '';
$htblocked = '';

$nuevo = 0;
$imagen = ' <img src="../../../imagenes/accept.png" border="0" alt="Activa">';

$gridS = array(
	'Código' => 'idDgoResAct',
	'Descripcion' => 'descDgoCargo',
);
?>
<div style="width:800px; display:block">
</div>
<p style="font-size:15px; color:#900; text-align:left;padding:15px 5px 0 5px;margin:0; font-weight:bold;">RESPONSABLES</p>
<?php
/*----------------------RESPONSABLES------------------------------*/

$sql = "SELECT a.idDgoResAct, b.descDgoCargo FROM dgoResAct a, dgoCargo b WHERE a.idDgoCargo=b.idDgoCargo AND a.idDgoActividad='" . $_GET['act'] . "' AND a.idDgoVisita='" . $_GET['vst'] . "'
";
$rs = $conn->query($sql);
?>

<table id='my-tbl' width="100%">
	<tr>
		<th class="data-th" style="background-color:#05A">C&oacute;digo</th>
		<th class="data-th" style="background-color:#05A">Responsables</th>
		<th class="data-th" style="background-color:#05A">Editar</th>
		<th class="data-th" style="background-color:#05A">Eliminar</th>
	</tr>
	<?php
	//loop por cada registro tomando los campos delarreglo $gridS
	while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
		echo "<tr class='data-tr' align='center'>";
		foreach ($gridS as $campos => $valor) {
			echo '<td>' . $row[$valor] . '</td>';
		}
		if (isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'], 1, 1) == 1) {
			echo '<td><a href="javascript:void(0);" onclick="getregistro(' . $row[$idcampo] . ')">Editar</a></td>';
		} else {
			echo '<td>&nbsp;</td>';
		}
		if (isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'], 2, 1) == 1) {
			echo '<td><a href="javascript:void(0);" onclick="return delregistro(' . $row[$idcampo] . ')">Eliminar</a></td>';
		} else {
			echo '<td>&nbsp;</td>';
		}
		echo "</tr>";
	}
	?>
</table>