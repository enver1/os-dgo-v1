<?php
session_start();
include_once '../../../clases/autoload.php';
if (isset($_SESSION['usuarioAuditar'])) {
    $Asignacion   = new Asignacion;
    $FormAsignacion   = new FormAsignacion;
    $encriptar           = new Encriptar;
    $opc                  = strip_tags($_GET['opc']);
    $idDgoAsignacion     = (int) strip_tags($_GET['c']);
    $rowt                 = array();
    $dt = new DateTime('now', new DateTimeZone('America/Guayaquil'));
    $fechaHoy = $dt->format('Y-m-d');
    $anioActal = $dt->format('Y');
    if ($idDgoAsignacion > 0) {
        $rowt = $Asignacion->getEditAsignacion($idDgoAsignacion);
    }
?>
    <table style="font-size:10px" class="formaper" border="0" width="90%">
        <tr>
            <td class="etiqueta">Cédula Cursante:</td>
            <td align="left">
                <input type="hidden" name="idGenUsuario" id="idGenUsuario" value="" />
                <input type="hidden" name="idGenPersona" id="idGenPersona" value="" />
                <input type="text" name="cedula" id="cedula" class="inputSombra" style="width:100px" value="<?= isset($rowt['documento']) ? $rowt['documento'] : ''; ?>">
            </td>
            <td>
                <input type="button" onclick="buscaCursante()" class="boton_general" id="Buscar" value="Buscar" style="display:block">
            </td>
            <td>
                <a href="modulos/asignacion/includes/persona_list.php" onclick="return GB_showPage('Busca Servidor Policial', this.href)" class="button"><span><img src="../imagenes/ver.png" alt="0" border="0"> Buscar por Nombres</span></a>
            </td>
            <td>
            </td>
        </tr>
        <tr>
            <td class="etiqueta">Nombres y Apellidos</td>
            <td colspan="2">
                <input type="text" class="inputSombra" readonly name="apenom" id="apenom" value="<?= isset($rowt['apenom']) ? $rowt['apenom'] : ''; ?>">
            </td>
            <td class="etiqueta">E-Mail</td>
            <td>
                <input type="text" style="width:90%" class="inputSombra" readonly name="email" id="email" value="<?= isset($rowt['email']) ? $rowt['email'] : ''; ?>">
            </td>
        </tr>
        <tr>
            <td class="etiqueta">Teléfono</td>
            <td colspan="2">
                <input type="text" class="inputSombra" readonly name="fono" id="fono" value="<?= isset($rowt['fono']) ? $rowt['fono'] : ''; ?>">
            </td>
        </tr>
    </table>
    <?php
    $FormAsignacion->getFormularioFormAsignacion($rowt, $Asignacion->getIdCampo(), $opc);
    ?>
<?php
} else {
    header('Location: indexSiipne.php');
}
?>
<script type="text/javascript">
    $(function() {
        $('#anio').val(<?php echo $anioActal ?>);

    });
</script>