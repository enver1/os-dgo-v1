<?php
session_start();
include_once '../../../../../clases/autoload.php';
$formDgoFuerzasAlternativas = new FormDgoFuerzasAlternativas;
$dgoFuerzasAlternativas     = new DgoFuerzasAlternativas;
$encriptar       = new Encriptar;
$opc                  = strip_tags($_GET['opc']);
$idDgoFuerzasAlternativas     = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt                 = array();
if ($idDgoFuerzasAlternativas > 0) {
    $rowt = $dgoFuerzasAlternativas->getEditDgoFuerzasAlternativas($idDgoFuerzasAlternativas);
}
$formDgoFuerzasAlternativas->getFormularioDgoFuerzasAlternativas($rowt, $dgoFuerzasAlternativas->getIdCampo(), $opc);
?>
<script type="text/javascript">
    $(function() {
        $('#idDgoOrdenServicio').val($('#idOrden').val());
        $('#numericoJefes').on('input', function() {
            this.value = this.value.replace(/[^0-9,]/g, '');
        });
        $('#numericoSubalternos').on('input', function() {
            this.value = this.value.replace(/[^0-9,]/g, '');
        });
    });
</script>