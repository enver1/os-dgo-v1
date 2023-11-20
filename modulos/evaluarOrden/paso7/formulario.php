<?php
session_start();
include_once '../../../../clases/autoload.php';
$formAnexosOrden = new FormDgoAnexosInforme;
$DgoAnexosInforme     = new DgoAnexosInforme;
$encriptar       = new Encriptar;
$opc                  = strip_tags($_GET['opc']);
$idUcpPpl     = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt                 = array();
if ($idUcpPpl > 0) {
    $rowt = $DgoAnexosInforme->getEditDgoAnexosInforme($idUcpPpl);
}
$formAnexosOrden->getFormularioDgoAnexosInforme($rowt, $DgoAnexosInforme->getIdCampo(), $opc);
?>
<script type="text/javascript">
    $(function() {
        $('#idDgoInfOrdenServicio').val($('#idOrden').val());
    });
</script>