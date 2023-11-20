<?php
include_once('../../../clases/autoload.php');
$conn = DB::getConexionDB();

$sql = "SELECT descDgoEje from dgoEjeProcSu a
join dgoEje j on a.idDgoEje=j.idDgoEje where idDgoEjeProcSu=" . $_GET['id'];
$rsS = $conn->query($sql);
$eje = '';
if ($rowS = $rsS->fetch()) {
    $eje = $rowS['descDgoEje'];
}
$sql = "select nombreComun from dgoActUnidad a
join dgpUnidad un on a.idDgpUnidad=un.idDgpUnidad where idDgoActUnidad=" . $_GET['v'];
$rsS = $conn->query($sql);
$nc = '';
if ($rowS = $rsS->fetch()) {
    $nc = $rowS['nombreComun'];
}


$sql = "SELECT distinct c.idDgoActividad,c.descDgoActividad from dgoActUniIns a
join dgoInstrucci b on a.idDgoInstrucci=b.idDgoInstrucci
join dgoActUniIns au on a.idDgoInstrucci=au.idDgoInstrucci and au.idDgoActUnidad=" . $_GET['v'] . " 
join dgoActividad c on b.idDgoActividad=c.idDgoActividad
where c.idDgoEjeProcSu=" . $_GET['id'];

$rsB = $conn->query($sql);
$i = 1; ?>
<a class="return" href="javascript:void(0)" onClick="ejes(<?php echo $_GET['v'] ?>,<?php echo $_GET['j'] ?>)"></a>
<table border="0" cellspacing="6" cellpadding="0" style="width:920px;border:solid 1px #666;margin-top:10px;-webkit-border-radius:5px;	-moz-border-radius:5px;	border-radius:5px;">
    <tr>
        <th colspan="4" class="data-th"><?php echo $nc ?>, ACTIVIDADES A EVALUAR DEL EJE: <?php echo $eje ?></td>
    </tr>
    <tr>
        <?php
        while ($rowB = $rsB->fetch()) {
        ?>
    <tr>
        <td class="marcoUni" style="vertical-align:top;background:#ddd;padding:5px 10px;font-size:15px">
            <?php echo $rowB['descDgoActividad'];
            ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left:10px;font-weight:bold">Instrucciones:</td>
    </tr>
    <tr>
        <td>
            <table width="100%">
                <?php
                $sql = "SELECT * from dgoInstrucci a,dgoActUniIns b where 
				a.idDgoInstrucci=b.idDgoInstrucci and
				b.idDgoActUnidad=" . $_GET['v'] . " and idDgoActividad=" . $rowB['idDgoActividad'];
                $rsS = $conn->query($sql);
                while ($rowS = $rsS->fetch()) { ?>

                    <tr>
                        <td>.</td>
                        <td style="vertical-align:top;color:#696969;padding:5px 10px;font-size:14px">
                            <?php echo $rowS['descDgoInstrucci'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding-left:10px;font-weight:bold;color:#92C1F1">Encuesta:</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <table width="100%">
                                <?php
                                $sql = "select * from dgoEncuesta a where 
                        a.idDgoInstrucci=" . $rowS['idDgoInstrucci'];
                                $rsT = $conn->query($sql);
                                while ($rowT = $rsT->fetch()) { ?>
                                    <tr class="data-tr">
                                        <td>.</td>
                                        <td style="vertical-align:top;color:#696969;padding:5px 10px">
                                            <?php echo $rowT['descEncuesta']; ?>
                                        </td>
                                        <td><?php echo $rowT['puntaje']; ?> pts.</td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
<?php
        }
?>
</table>