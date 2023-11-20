<?php
session_start();
include_once('../../../clases/autoload.php');
include_once('../../../funciones/funciones_generales.php');
$conn = DB::getConexionDB();
$encriptar = new Encriptar;
$sql = "select * from dgoProcSuper where idDgoProcSuper=" . $_GET['id'];
$rsS = $conn->query($sql);
$descr = '';
if ($rowS = $rsS->fetch()) {
	$descr = $rowS['descripcion'];
}


$sql = "SELECT a.idDgoActUnidad,un.nombreComun unidad,un.nomenclatura,un.codigoSenplades,a.descDgoActUnidad causaVisita,a.recursoHumano,a.recursoFinanciero,a.recursoMaterial,
a.fechaInicio,a.fechaFin,v.fechaVisita,v.fechaInicio inicioVisita,v.horaInicio,v.fechaFin finVisita,v.horaFin,
gr.siglas,pe.apenom,im.pathImagen
from dgoActUnidad a
join dgoVisita v on a.idDgoActUnidad=v.idDgoActUnidad
join dgpUnidad un on a.idDgpUnidad=un.idDgpUnidad
join genPersona pe on v.idGenPersona=pe.idGenPersona
join dgpResumenPersonal rp on pe.idGenPersona=rp.idGenPersona
join dgpAscenso ae on rp.idDgpAscenso=ae.idDgpAscenso
join dgpGrado gr on ae.idDgpGrado=gr.idDgpGrado
left join genImagen im on pe.idGenPersona=im.idGenPersona and im.idGenTipoImagen=1 and im.idGenModulo=3
where a.idDgoProcSuper=" . $_GET['id'];


$rsB = $conn->query($sql);

$i = 1; ?>
<a class="return" href="javascript:void(0)" onClick="inicio()"></a>
<table border="0" cellspacing="6" cellpadding="0" style="920px">
	<tr>
		<th colspan="4" class="data-th">UNIDADES POLICIALES VISITADAS DURANTE <?php echo $descr ?></td>
	</tr>
	<tr>
		<?php
		while ($rowB = $rsB->fetch()) {

			$path = FuncionesGenerales::getPathAlmacenamiento('descargas/personal/fotos/') . $rowB['pathImagen'];
			//	$foto = explode('', $rowB['pathImagen']);
			$tipo = $encriptar->getEncriptar('jpg', $_SESSION['usuarioAuditar']);
			$param = $encriptar->getEncriptar($path, $_SESSION['usuarioAuditar']);
			$imagen   = '/includes/visualiza.php?tipo=' . $tipo . '&param=' . $param;

		?>
			<td class="marcoUni" style="vertical-align:top;"><a href="javascript:void(0)" onClick="ejes(<?php echo $rowB['idDgoActUnidad'] ?>,<?php echo $_GET['id'] ?>)">
					<table width="100%">
						<?php echo '<tr><td colspan="2" align="center" style="background-color:#000;color:#fff;padding:10px 3px"><strong style="font-size:14px">' . $rowB['unidad'] . '</strong></td></tr>' .
							'<tr><td colspan="2">' . $rowB['nomenclatura'] . '</td></tr>' .
							'<tr><td style="font-weight:bold" colspan="2">Supervisor(a)</td></tr>' .
							'<tr><td align="center" colspan="2"><img src="' . $imagen . ' " class="fotoR" style="width:100px;height:120px"></td></tr>' .
							'<tr><td colspan="2">' . $rowB['siglas'] . ' ' . $rowB['apenom'] . '</td></tr>' .
							'<tr><td colspan="2"><strong>CAUSA DE LA SUPERVISION</strong></td></tr>' .
							'<tr><td colspan="2" style="border-bottom:solid 2px #3f3f3f">' . $rowB['causaVisita'] . '</td></tr>' .
							'<tr><td style="font-size:10px"><strong>Recursos Humanos:</strong></td>' .
							'<td align="right">' . $rowB['recursoHumano'] . '</td></tr>' .
							'<tr><td><strong>Recursos Financieros:</strong></td>' .
							'<td align="right">' . $rowB['recursoFinanciero'] . '</td></tr>' .
							'<tr><td><strong>Recursos Materiales:</strong></td>' .
							'<td align="right">' . ($rowB['recursoMaterial']) . '</td></tr>'
						?>
					</table>
				</a>
			</td>
		<?php
			if ($i > 3) {
				$i = 0;
				echo '</tr><tr><td colspan="4" style="height:30px"></td></tr><tr>';
			}
			$i++;
		}
		echo '</tr>';
		?>
</table>