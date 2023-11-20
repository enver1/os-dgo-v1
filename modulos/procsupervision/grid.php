<?php
session_start();
require_once("../../../funciones/funcion_select.php");
include_once '../../../clases/autoload.php';
$conn = DB::getConexionDB(); // include the database connection
$estilo = "";
/*=============*/

$htblock = '';
$htblocked = '';

$nuevo = 0;
$imagen = ' <img src="../../../imagenes/accept.png" border="0" alt="Activa">';
?>
<div style="width:800px; display:block">
</div>
<p style="font-size:15px; color:#900; text-align:left;padding:15px 5px 0 5px;margin:0; font-weight:bold;">ACTIVIDADES</p>
<?php
/*----------------------ACTIVIDADES------------------------------*/


$sql = "SELECT a.idDgoActividad, a.descDgoActividad
FROM dgoActividad a
INNER JOIN dgoInstrucci b ON a.idDgoActividad=b.idDgoActividad
INNER JOIN dgoActUniIns c ON b.idDgoInstrucci=c.idDgoInstrucci
INNER JOIN dgoActUnidad d ON c.idDgoActUnidad=d.idDgoActUnidad
WHERE d.idDgoActUnidad='" . $_GET['b'] . "' AND a.idDgoEjeProcSu='" . $_GET['a'] . "' GROUP BY a.idDgoActividad;";
$rs = $conn->query($sql);
?>

<table id='my-tbl' width="100%">
  <tr>
    <th class="data-th" style="background-color:#05A" width="75%">Descripcion</th>
    <!--<th class="data-th">Seleccionar</th>
             <th class="data-th">Editar</th>-->
    <th class="data-th" style="background-color:#05A">Responsables</th>
    <th class="data-th" style="background-color:#05A">Ver</th>
  </tr>
  <?php
  //loop por cada registro
  $i = 1;
  while ($rowB = $rs->fetch()) {
    echo "<tr class='data-tr' align='center'>";
    $prot = 0;
    $sty = (isset($_GET['c']) and $_GET['c'] == $rowB['idDgoActividad']) ? 'style="font-weight:bold;font-size:13px"' : '';
    echo '<td ' . $sty . ">" .
      $rowB['descDgoActividad'] . ((isset($_GET['c']) and $_GET['c'] == $rowB['idDgoActividad']) ? $imagen : '') . "</td>";

    // echo '<td><a href="modulos/procsupervision/responsables/responsables.php?prueba='.$rowB['idDgoActividad'].'&acun='.$_GET['b'].'"  onclick="return GB_showPage(\'RESPONSABLES\', this.href)"><span>Responsables</span></a></td>';
    echo '<td><a href="modulos/procsupervision/responsables/aplicacion.php?prueba=' . $rowB['idDgoActividad'] . '&vst=' . $_GET['vst'] . '"  onclick="return GB_showPage(\'RESPONSABLES\', this.href)"><span>Responsables</span></a></td>';
    echo '<td><a href="modulos/procsupervision/previewTest.php?prueba=' . sha1($rowB['idDgoActividad']) . '&acun=' . sha1($_GET['b']) . '" target="_blank" >Instrucciones<img src="../imagenes/ver.png" alt="" border="0"></a></td>';
    echo "</tr>";
  }
  ?>
</table>