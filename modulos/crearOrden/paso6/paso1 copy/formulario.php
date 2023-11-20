<?php
session_start();
include_once '../../../../../clases/autoload.php';
$formDgoFuerzasPropias = new FormDgoFuerzasPropias;
$DgoFuerzasPropias     = new DgoFuerzasPropias;
$encriptar       = new Encriptar;
$opc                  = strip_tags($_GET['opc']);
$idDgoFuerzasPropias     = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt                 = array();
if ($idDgoFuerzasPropias > 0) {
    $rowt = $DgoFuerzasPropias->getEditDgoFuerzasPropias($idDgoFuerzasPropias);
}
$formDgoFuerzasPropias->getFormularioDgoFuerzasPropias($rowt, $DgoFuerzasPropias->getIdCampo(), $opc);
?>
<script type="text/javascript">
    $(function() {
        $('#idDgoOrdenServicio').val($('#idOrden').val());
        $('#superiores').on('input', function() {
            this.value = this.value.replace(/[^0-9,]/g, '');
        });
        $('#subalternos').on('input', function() {
            this.value = this.value.replace(/[^0-9,]/g, '');
        });
        $('#clases').on('input', function() {
            this.value = this.value.replace(/[^0-9,]/g, '');
        });
    });
</script>