<?php
session_start();
include_once '../../../../../clases/autoload.php';
$formDgoMediosLogisticosInf = new FormDgoMediosLogisticosInf;
$DgoMediosLogisticosInf     = new DgoMediosLogisticosInf;
$encriptar       = new Encriptar;
$opc                  = strip_tags($_GET['opc']);
$idDgoMediosLogisticosInf     = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt                 = array();
if ($idDgoMediosLogisticosInf > 0) {
    $rowt = $DgoMediosLogisticosInf->getEditDgoMediosLogisticosInf($idDgoMediosLogisticosInf);
}
$formDgoMediosLogisticosInf->getFormularioDgoMediosLogisticosInf($rowt, $DgoMediosLogisticosInf->getIdCampo(), $opc);
?>
<script type="text/javascript">
    $(function() {
        $('#idDgoInfOrdenServicio').val($('#idOrden').val());
        $('#cantidad').on('input', function() {
            this.value = this.value.replace(/[^0-9,]/g, '');
        });
    });
</script>