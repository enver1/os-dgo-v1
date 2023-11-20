<?php
set_time_limit(1800);
ob_start("ob_gzhandler");
if (!isset($_SESSION)) {
  session_start();
}

include "../../../clases/autoload.php";
include "../../../funciones/funciones_generales.php";
include 'clases/calificacion.php';
$conn = DB::getConexionDB();

$calificacion = new calificacion;
$dgoAsignacion = new DgoAsignacion();

$anio = (empty($_GET['anio'])) ? null : $_GET['anio'];
$geo = (empty($_GET['geo'])) ? null : $_GET['geo'];


function specialChars($texto = '')
{
  $p = array('/á/', '/é/', '/í/', '/ó/', '/ú/', '/Á/', '/É/', '/Í/', '/Ó/', '/Ú/', '/à/', '/è/', '/ì/', '/ò/', '/ù/', '/ñ/', '/Ñ/');
  $r = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'n', 'N');
  $x = preg_replace($p, $r, $texto);
  return $x;
}


function imprimeTabla($rowT, $tCuadro, $funcion, $fecha, $cols = 0, $headers = array(), $data = array())
{

  $ht = '<table id="my-tbl" width="100%" border="1">
	<tr><td colspan="" align="center"><span style="font-size:14px;font-weight:bold;color:#d61818">CURSANTES</span></td>
		<td colspan="13" align="center"><span style="font-size:14px;font-weight:bold;color:#d61818">NIVEL VIOLENCIA E INSEGURIDAD</span></td>
		<td colspan="13" align="center"><span style="font-size:14px;font-weight:bold;color:#d61818">PRODUCTIVIDAD</span></td>
	<tr>';
  foreach ($headers as $head) {
    $ht .= '<th class="data-th">' . $head . '</th>';
  }
  $ht .= '</tr>';

  //loop por cada registro tomando los campos delarreglo $gridS
  foreach ($rowT as $key => $cursante) {
    //for ($i=0; $i < count($rowT); $i++) { 
    $sumaVioDelin = 0;
    $sumaProduc = 0;
    $totalVioDelin = 0;
    $totalProduc = 0;
    $ht .= '<tr>';

    $nombre = current(array_column($cursante, 'apenom'));
    $ht .= '<td align="left">' . $nombre . '</td>';

    for ($i = 1; $i <= 12; $i++) {

      if (array_key_exists($i, $cursante)) {

        $ht .= '<td align="left">' . number_format($cursante[$i]['resultVioDelin'], 3) . '</td>';

        if (!empty($cursante[$i]['resultVioDelin'])) {
          $totalVioDelin++;
          $sumaVioDelin += $cursante[$i]['resultVioDelin'];
        }
      } else {

        $ht .= '<td align="left">0</td>';
      }

      if ($i + 1 == 13) {
        $notaVioDelin = $sumaVioDelin / $totalVioDelin;
        $ht .= '<td align="left" bgcolor="#F7FE2E">' . number_format($notaVioDelin, 3) . '</td>';
      }
    }

    for ($i = 1; $i <= 12; $i++) {

      if (array_key_exists($i, $cursante)) {

        $ht .= '<td align="left">' . number_format($cursante[$i]['resultProduc'], 3) . '</td>';

        if (!empty($cursante[$i]['resultProduc'])) {
          $totalProduc++;
          $sumaProduc += $cursante[$i]['resultProduc'];
        }
      } else {

        $ht .= '<td align="left">0</td>';
      }

      if ($i + 1 == 13) {
        $notaProduc = $sumaProduc / $totalProduc;
        $ht .= '<td align="left" bgcolor="#F7FE2E">' . number_format($notaProduc, 3) . '</td>';
      }
    }

    $notaFinal = (11 * ($notaVioDelin + $notaProduc)) / 20;
    $ht .= '<td align="left" bgcolor="#00FF00">' . number_format($notaFinal, 3) . '</td>';
    $ht .= '</tr>';
  }

  echo $ht;
}

$nArchivo = "Notas_Cursantes_{$anio}.xls";
if ($anio <= 2020 && !empty($_GET['geo'])) {
  $ini = 0;
  $fin = 0;
  $fecha = "";
  $funcion = "FUNCION";
  $tCuadro = 'TRASLADO DE VALORES DESDE ' . $ini . ' HASTA ' . $fin;
  $header = array('Apellidos y Nombres', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre', 'Promedio', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre', 'Promedio', 'Nota Final');

  $arrayCursCalif = $calificacion->obtenerCalificacionesCursantes($conn, $_GET['anio'], $_GET['geo']);

  imprimeTabla($arrayCursCalif, $tCuadro, $funcion, $fecha, 20, $header, $data = array());
} elseif ($anio >= 2021) {
  $cursantes = $dgoAsignacion->getNotasCursantesAnio($anio);
  $header = array('APELLIDOS Y NOMBRES', 'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE', 'NOTA FINAL');
} else {
  echo 'No ha seleccionado opciones';
}
header('Content-type: application/vnd.ms-excel charset=utf-8');
header("Content-Disposition: attachment;filename={$nArchivo}");
header("Pragma: no-cache");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
?>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<table id="my-tbl" width="100%" border="1">
  <tr>
    <th colspan="0" align="center" style="background-color:#1A5276;font-weight:bold;color:#FDFEFE">CURSANTES</th>
    <th colspan="97" align="center" style="background-color:#1A5276;font-weight:bold;color:#FDFEFE">CALIFICACIONES</th>
  </tr>
  <tr>
    <?php foreach ($header as $head) { ?>
    <?php if ($head == 'APELLIDOS Y NOMBRES' || $head == 'NOTA FINAL') : ?>
    <th align="center" colspan="0" rowspan="2" style="background-color:#0061A8;color:#FDFEFE"><?= $head ?></th>
    <?php else : ?>
    <th align="center" colspan="8" style="background-color:#0061A8;color:#FDFEFE"><?= $head ?></th>
    <?php endif; ?>
    <?php } ?>
  </tr>
  <tr>
    <?php for ($i = 0; $i < 12; $i++) { ?>
    <th style="background-color:#717D7E;color:#FDFEFE">DESIGNACION TERRITORIO</th>
    <th style="background-color:#717D7E;color:#FDFEFE">CODIGO SENPLADES</th>
    <th style="background-color:#717D7E;color:#FDFEFE">NOTA CMI DELITOS</th>
    <th style="background-color:#717D7E;color:#FDFEFE">NOTA DETENIDOS CMI</th>
    <th style="background-color:#717D7E;color:#FDFEFE">NOTA DETENIDOS CONTRAVENCIONES</th>
    <th style="background-color:#717D7E;color:#FDFEFE">NOTA ARMAS DE FUEGO</th>
    <th style="background-color:#717D7E;color:#FDFEFE">NOTA VEHICULOS RECUPERADOS</th>
    <th style="background-color:#717D7E;color:#FDFEFE">NOTA FINAL</th>
    <?php } ?>
  </tr>
  <?php foreach ($cursantes as $key => $cursante) { ?>
  <tr>
    <td style="background-color:#D6EAF8;"><?= $cursante['nombre']; ?></td>
    <?php $i = 0 ?>
    <?php $cn = 0 ?>
    <?php $notaFinal = 0 ?>
    <?php foreach ($cursante['notas'] as $nota) { ?>
    <td><?= $nota['descripcion']; ?></td>
    <td><?= $nota['codigo'] ?></td>
    <td><?= number_format($nota['cmi_delito'], 3, ",", ".") ?></td>
    <td><?= number_format($nota['det_cmi'], 3, ",", ".") ?></td>
    <td><?= number_format($nota['det_cont'], 3, ",", ".") ?></td>
    <td><?= number_format($nota['arma_fuego'], 3, ",", ".") ?></td>
    <td><?= number_format($nota['veh_recu'], 3, ",", ".") ?></td>
    <td style="background-color:#FCF3CF;"><?= number_format($nota['nota'], 3, ",", ".") ?></td>
    <?php $i++ ?>
    <?php $notaFinal += (!empty($nota['nota'])) ? $nota['nota'] : 0; ?>
    <?php $cn += (!empty($nota['nota'])) ? 1 : 0; ?>
    <?php } ?>
    <?php for ($c = 0; $c < 12 - $i; $c++) { ?>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td style="background-color:#FCF3CF;"></td>
    <?php } ?>
    <td style="background-color:#D4EFDF;"><?= (empty($cn))?0:number_format($notaFinal / $cn, 3, ",", ".") ?></td>
  </tr>
  <?php } ?>
</table>
<?php ob_end_flush(); ?>