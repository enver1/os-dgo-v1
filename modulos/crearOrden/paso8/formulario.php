<?php
session_start();
include_once '../../../../clases/autoload.php';
$formAnexosOrden = new FormAnexosOrden;
$DgoAnexosOrden     = new DgoAnexosOrden;
$encriptar       = new Encriptar;
$opc                  = strip_tags($_GET['opc']);
$idUcpPpl     = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt                 = array();
if ($idUcpPpl > 0) {
    $rowt = $DgoAnexosOrden->getEditDgoAnexosOrden($idUcpPpl);
}
$formAnexosOrden->getFormularioAnexosOrden($rowt, $DgoAnexosOrden->getIdCampo(), $opc);
?>
<script type="text/javascript">
    $(function() {
        $('#idDgoOrdenServicio').val($('#idOrden').val());
    });
</script>