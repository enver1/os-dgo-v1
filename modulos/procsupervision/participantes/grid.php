<?php
session_start();
require_once("../../../../funciones/funcion_select.php");
include '../../../../clases/autoload.php';
$conn = DB::getConexionDB(); // include the database connection
$estilo = "";
$idcampo = "idDgoParticipa";
/*=============*/

$htblock = '';
$htblocked = '';

$nuevo = 0;
$imagen = ' <img src="../../../imagenes/accept.png" border="0" alt="Activa">';

$gridS = array(
	'Código' => 'idDgoParticipa',
	'Siglas' => 'siglas',
	'Apellidos y Nombres' => 'apenom',
	'Tipo Participacion' => 'tipoParticipacion',
	'Observacion' => 'obsDgoParticipa',
);
?>
<div style="width:800px; display:block">
</div>
<p style="font-size:15px; color:#900; text-align:left;padding:15px 5px 0 5px;margin:0; font-weight:bold;">PARTICIPANTES <span style="color:#06F;font-size:11px;font-weight:normal">(Nota:La lista de los participantes es la misma para todos los ejes)</span></p>
<?php
/*----------------------RESPONSABLES------------------------------*/

$sql = "SELECT a.idDgoParticipa, case a.tipoParticipacion when 'A' then 'APROBACIÓN' when 'E' then 'EJECUCIÓN' else 'PARTICIPANTE' end as tipoParticipacion, c.siglas, c.apenom, a.obsDgoParticipa from dgoParticipa a, dgoVisita b, v_personal_simple c
WHERE a.idGenPersona=c.idGenPersona AND b.idDgoVisita=a.idDgoVisita
AND b.idDgoVisita='" . $_GET['opc'] . "'";

//$sql="SELECT a.idDgoParticipa, case a.tipoParticipacion when 'A' then 'APROBACIÓN' when 'E' then 'EJECUCIÓN' else 'PARTICIPANTE' end as tipoParticipacion, c.siglas, c.apenom, a.obsDgoParticipa from dgoParticipa a, dgoVisita b, v_personal_simple c, dgoEjeProcSu d 
//WHERE a.idGenPersona=c.idGenPersona AND a.idDgoEjeProcSu=d.idDgoEjeProcSu AND b.idDgoVisita=a.idDgoVisita
//AND b.idDgoVisita='".$_GET['opc']."' AND d.idDgoEjeProcSu='".$_GET['eje']."'";
$rs = $conn->query($sql);
?>

<table id='my-tbl' width="100%">
	<tr>
		<th class="data-th" style="background-color:#05A">C&oacute;digo</th>
		<th class="data-th" style="background-color:#05A">Siglas</th>
		<th class="data-th" style="background-color:#05A">Apellidos y Nombres</th>
		<th class="data-th" style="background-color:#05A">Tipo Participaci&oacute;n</th>
		<th class="data-th" style="background-color:#05A">Observacion</th>
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