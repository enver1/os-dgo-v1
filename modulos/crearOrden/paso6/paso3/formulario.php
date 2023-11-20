<?php
session_start();
include_once '../../../../../clases/autoload.php';
$formDgoMediosLogisticos = new FormDgoMediosLogisticos;
$dgoMediosLogisticos     = new DgoMediosLogisticos;
$encriptar       = new Encriptar;
$opc                  = strip_tags($_GET['opc']);
$idDgoMediosLogisticos     = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt                 = array();
if ($idDgoMediosLogisticos > 0) {
    $rowt = $dgoMediosLogisticos->getEditDgoMediosLogisticos($idDgoMediosLogisticos);
}
$formDgoMediosLogisticos->getFormularioDgoMediosLogisticos($rowt, $dgoMediosLogisticos->getIdCampo(), $opc);
?>
<script type="text/javascript">
    $(function() {
        $('#idDgoOrdenServicio').val($('#idOrden').val());
        $('#cantidad').on('input', function() {
            this.value = this.value.replace(/[^0-9,]/g, '');
        });
    });
</script>