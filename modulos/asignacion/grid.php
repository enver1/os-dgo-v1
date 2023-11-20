<?php
/* MUESTRA LA GRILLA EN LA PARTE INFERIOR DEL FORMULARIO */
include_once('config.php');
if (!empty($rs)) {
?>
	<table id='my-tbl'>
		<tr>
			<?php foreach ($gridS as $campos => $valor) { ?>
				<th class="data-th"><?php echo $campos ?></th>
			<?php } ?>
			<th class="data-th">Editar</th>
			<th class="data-th">Eliminar</th>
		</tr>
		<?php
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
	<br />
<?php } ?>