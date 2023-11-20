<?php
session_start();
include_once '../../../../clases/autoload.php';
$formDgoAntecedentesInforme = new FormDgoAntecedentesInforme;
$DgoAntecedentesInforme     = new DgoAntecedentesInforme;
$encriptar       = new Encriptar;
$opc                  = strip_tags($_GET['opc']);
$idUcpPpl     = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt                 = array();
if ($idUcpPpl > 0) {
    $rowt = $DgoAntecedentesInforme->getEditDgoAntecedentesInforme($idUcpPpl);
}
$formDgoAntecedentesInforme->getFormularioDgoAntecedentesInforme($rowt, $DgoAntecedentesInforme->getIdCampo(), $opc);
?>
<script type="text/javascript">
    $(function() {
        $('#idDgoInfOrdenServicio').val($('#idOrden').val());
    });
</script>