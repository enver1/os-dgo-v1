<?php
session_start();
include_once '../../../../clases/autoload.php';
$formDgoAntecedentesOrden = new FormDgoAntecedentesOrden;
$dgoAntecedentesOrden     = new DgoAntecedentesOrden;
$encriptar       = new Encriptar;
$opc                  = strip_tags($_GET['opc']);
$idUcpPpl     = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt                 = array();
if ($idUcpPpl > 0) {
    $rowt = $dgoAntecedentesOrden->getEditDgoAntecedentesOrden($idUcpPpl);
}
$formDgoAntecedentesOrden->getFormularioDgoAntecedentesOrden($rowt, $dgoAntecedentesOrden->getIdCampo(), $opc);
?>
<script type="text/javascript">
    $(function() {
        $('#idDgoOrdenServicio').val($('#idOrden').val());
    });
</script>