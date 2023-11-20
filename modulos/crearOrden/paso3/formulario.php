<?php
session_start();
include_once '../../../../clases/autoload.php';
$formDgoMisionOrden = new FormDgoMisionOrden;
$DgoMisionOrden     = new DgoMisionOrden;
$encriptar       = new Encriptar;
$opc                  = strip_tags($_GET['opc']);
$idDgoMisionOrden     = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt                 = array();
if ($idDgoMisionOrden > 0) {
    $rowt = $DgoMisionOrden->getEditDgoMisionOrden($idDgoMisionOrden);
}
$formDgoMisionOrden->getFormularioDgoMisionOrden($rowt, $DgoMisionOrden->getIdCampo(), $opc);
?>
<script type="text/javascript">
    $(function() {
        $('#idDgoOrdenServicio').val($('#idOrden').val());
    });
</script>