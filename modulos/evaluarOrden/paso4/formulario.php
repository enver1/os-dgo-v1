<?php
session_start();
include_once '../../../../clases/autoload.php';
$formDgoEvaluacionInf  = new FormDgoEvaluacionInf;
$DgoEvaluacionInf      = new DgoEvaluacionInf;
$encriptar       = new Encriptar;
$opc                  = strip_tags($_GET['opc']);
$idDgoEvaluacionInf      = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt                 = array();
if ($idDgoEvaluacionInf  > 0) {
    $rowt = $DgoEvaluacionInf->getEditDgoEvaluacionInf($idDgoEvaluacionInf);
}
$formDgoEvaluacionInf->getFormularioDgoEvaluacionInf($rowt, $DgoEvaluacionInf->getIdCampo(), $opc);
?>
<script type="text/javascript">
    $(function() {
        $('#idDgoInfOrdenServicio').val($('#idOrden').val());
    });
</script>