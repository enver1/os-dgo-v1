<?php
session_start();
include_once '../../../../clases/autoload.php';
$formDgoEjemplarOrden = new FormDgoEjemplarOrden;
$DgoEjemplarOrden     = new DgoEjemplarOrden;
$encriptar       = new Encriptar;
$opc                  = strip_tags($_GET['opc']);
$idUcpPpl     = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt                 = array();
if ($idUcpPpl > 0) {
    $rowt = $DgoEjemplarOrden->getEditDgoEjemplarOrden($idUcpPpl);
}
$formDgoEjemplarOrden->getFormularioDgoEjemplarOrden($rowt, $DgoEjemplarOrden->getIdCampo(), $opc);
?>
<script type="text/javascript">
    $(function() {
        $('#idDgoOrdenServicio').val($('#idOrden').val());
    });
</script>