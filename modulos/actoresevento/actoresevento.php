<?php
if (isset($_GET['idHdrGrupResum'])) {
	$conn = DB::getConexionDB();
	$sql = "SELECT idHdrGrupResum,desHdrGrupResum,categorizacion FROM hdrGrupResum WHERE idHdrGrupResum = {$_GET['idHdrGrupResum']}";
	$rs = $conn->query($sql);
	$rowt = $rs->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE table PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<script type="text/javascript">
/**
 * eliminar registro
 */
function delregistro(id) {
    if (confirm('Confirmar', 'Desea eliminar el registro')) {
        $.ajax({
            type: "GET",
            url: "modulos/actoresevento/borraresumen.php?id=" + id,
            success: function(result) {
                targetURL = 'modulos/actoresevento/grupo_resumen.php?opc=<?php echo $_GET['opc']; ?>';
                $('#retrieved-data').load(targetURL).hide().fadeIn('slow');
            }
        });
    }
}
</script>
<form action="modulos/actoresevento/grabaresumen.php" method="post" id="frmGrupoResumen">
    <table width="100%" align="left">
        <tr>
            <td class="etiqueta">C&oacute;digo:</td>
            <td>
                <input type="text" name="idHdrGrupResum" readonly="readonly"
                    value="<?php echo isset($rowt['idHdrGrupResum']) ? $rowt['idHdrGrupResum'] : '' ?>"
                    class="inputSombra" style="width:80px" />
            </td>
        </tr>
        <tr>
            <td class="etiqueta">Descripci&oacute;n:</td>
            <td>
                <input type="text" name="desHdrGrupResum"
                    value="<?php echo isset($rowt['desHdrGrupResum']) ? $rowt['desHdrGrupResum'] : '' ?>"
                    class="inputSombra" style="width:320px" />
            </td>
        </tr>
        <tr>
            <td class="etiqueta">Categorizaci&oacute;n</td>
            <td>
                <input type="text" name="categorizacion"
                    value="<?php echo isset($rowt['categorizacion']) ? $rowt['categorizacion'] : '' ?>"
                    class="inputSombra" style="width:320px" />
            </td>
        </tr>
    </table>
    <table width="100%" align="left">
        <tr>
            <td></td>
            <td colspan="2" align="center"><input type="submit" value="Enviar" class="boton_save"></td>
            <td colspan="2" align="center">
                <a href="index.php?opc=<?php echo $_GET['opc'] ?>" class="button"
                    style="width:100px"><span>Nuevo</span></a>
            </td>
        </tr>
    </table>
    <input type="hidden" name="opc" value="<?php echo $_GET['opc']; ?>">
</form>

<div id='retrieved-data'>
    <img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>
<script type="text/javascript">
targetURL = 'modulos/actoresevento/grupo_resumen.php?opc=<?php echo $_GET['opc']; ?>';
$('#retrieved-data').load(targetURL).hide().fadeIn('slow');
</script>