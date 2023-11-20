<?php
session_start();
//print_r($_GET);
require_once("../../../funciones/funcion_select.php");
require_once('../../../funciones/db_connect.inc.php'); // include the database connection
$estilo = "";
/*=============*/

$htblock = '';
$htblocked = '';

$nuevo = 0;
$imagen = ' <img src="../../../imagenes/accept.png" border="0" alt="Activa">';
//print_r($_POST);
?>
<script>
$('#fechaInicioPlazo').val($('#fechaInicio').val());
$('#fechaFinPlazo').val($('#fechaFin').val());

function enciende(a) {
    $('#sCh' + a).css('background-color', 'transparent');
    if ($('#instru' + a).prop('checked')) {
        //alert('Ch');
        $('#sCh' + a).css('background-color', '#c66');
    }

}
</script>
<div style="width:880px; display:block;margin-left:50px">
    <p style="font-size:15px;color:#900;text-align:left;padding:5px;margin:0;font-weight:bold">ACTIVIDADES</p>
    <form id="detalleI">
        <input type="hidden" id="idUni" name="idUni" value="<?php echo $_GET['opc'] ?>" />
        <input type="hidden" id="fechaInicioPlazo" name="fechaInicioPlazo" value="" />
        <input type="hidden" id="fechaFinPlazo" name="fechaFinPlazo" value="" />
        <table border="0" id='my-tbl' style="width:100%;">
            <?php
			$sql = "select ac.idDgoActividad,ac.descDgoActividad,a.idDgoActUnidad,ej.idDgoEje,ej.descDgoEje 
		from dgoActUnidad a
		join dgoProcSuper ps on a.idDgoProcSuper=ps.idDgoProcSuper
		join dgoEjeProcSu eps on ps.idDgoProcSuper=eps.idDgoProcSuper
		join dgoEje ej on eps.idDgoEje=ej.idDgoEje
		join dgoActividad ac on eps.idDgoEjeProcSu=ac.idDgoEjeProcSu
		where a.idDgoActUnidad=" . $_GET['opc'] . " ";
			$rsP = $conn->query($sql);
			$k = 1;
			$eje = 0;
			while ($rowB = $rsP->fetch()) {
				if ($eje != $rowB['idDgoEje']) {
					echo '<tr><td style="font-weight:bold;letter-spacing:0.26em;background-color:#c36;color:#fff; border-bottom:solid 2px #aaa; font-size:16px;padding:10px;text-align:center">
			EJE: ' . $rowB['descDgoEje'] . '</td></tr>';
					$eje = $rowB['idDgoEje'];
				}

				echo '<tr><td style="font-weight:normal; font-style:italic; background-color:#004262;color:#fff; border-bottom:solid 2px #aaa; font-size:14px;padding:10px">
			' . $rowB['descDgoActividad'] . '</td></tr>';
				$sql = "select b.fechaFinPlazo,b.fechaInicioPlazo from dgoInstrucci a
				left join dgoActUniIns b on a.idDgoInstrucci=b.idDgoInstrucci 
				and b.idDgoActUnidad=" . $_GET['opc'] . " 
				where a.idDgoActividad=" . $rowB['idDgoActividad'] . ' limit 1';
				//echo $sql;
				$rsXX = $conn->query($sql);
				$rowXX = $rsXX->fetch();



				if ($rowXX != null) {
					$fechaPlazo = $rowXX['fechaFinPlazo'];
					$fechaPlazoI = $rowXX['fechaInicioPlazo'];
				}



				$sql = "select a.idDgoInstrucci,a.descDgoInstrucci,b.idDgoActUniIns from dgoInstrucci a
				left join dgoActUniIns b on a.idDgoInstrucci=b.idDgoInstrucci 
				and b.idDgoActUnidad=" . $_GET['opc'] . " where a.idDgoActividad=" . $rowB['idDgoActividad'];
			?>
            <tr>
                <td colspan="3">

                    <table>
                        <tr>
                            <td class="etiqueta">Plazo Inicial:</td>
                            <td>
                                <input type="text" name="plazoI<?php echo $rowB['idDgoActividad']  ?>"
                                    id="plazoI<?php echo $rowB['idDgoActividad']  ?>"
                                    value="<?php echo isset($fechaPlazoI) ? $fechaPlazoI : '' ?>" class="inputSombra"
                                    style="width:100px" />
                                <input type="button" value=""
                                    onclick="displayCalendar(document.forms[1].plazoI<?php echo $rowB['idDgoActividad']  ?>,'yyyy-mm-dd',this)"
                                    class="calendario" />
                            </td>
                            <td class="etiqueta">Plazo Final:</td>
                            <td>
                                <input type="text" name="plazo<?php echo $rowB['idDgoActividad']  ?>"
                                    id="plazo<?php echo $rowB['idDgoActividad']  ?>"
                                    value="<?php echo isset($fechaPlazo) ? $fechaPlazo : '' ?>" class="inputSombra"
                                    style="width:100px" />
                                <input type="button" value=""
                                    onclick="displayCalendar(document.forms[1].plazo<?php echo $rowB['idDgoActividad']  ?>,'yyyy-mm-dd',this)"
                                    class="calendario" />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <?php
				echo '<tr><td><table width="100%"><tr><td width="5%"></td>
				<td colspan="2" style="font-weight:normal;color:#336699">INSTRUCCIONES</td></tr>';

				$rsI = $conn->query($sql);

				while ($rowI = $rsI->fetch()) {
					$che = '';
					$td = '';
					if (!empty($rowI['idDgoActUniIns'])) {
						$che = ' checked="checked" ';
						$td = 'style="background-color:#c66"';
					}
					echo '<tr class="data-tr"><td width="5%"></td><td width="90%">' . $rowI['descDgoInstrucci'] . '</td><td id="sCh' . $k . '" ' . $td . '>';
				?>
            <input type="checkbox" value="<?php echo $rowI['idDgoInstrucci']  ?>" name="instru<?php echo $k ?>"
                id="instru<?php echo $k ?>" <?php echo $che ?> onclick="enciende('<?php echo $k ?>')" />
            <?php
					$k++;
					echo '</td></tr>';
				}
				echo '</table></td></tr>';
			}
			?>
            <tr>
                <td>
                    <input type="hidden" name="campos" value="<?php echo $k ?>" />
                    <input type="button" value="Actualizar" name="actu" onclick="detaInstru()"
                        style="padding:5px 15px;cursor:pointer" />
                </td>
            </tr>
        </table>
    </form>
</div>