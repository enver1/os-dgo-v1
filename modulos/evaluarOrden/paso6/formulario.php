<?php
session_start();
include_once '../../../../clases/autoload.php';
$formDgoEjemplarInforme = new FormDgoEjemplarInforme;
$DgoEjemplarInforme     = new DgoEjemplarInforme;
$encriptar       = new Encriptar;
$opc                  = strip_tags($_GET['opc']);
$idUcpPpl     = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt                 = array();
if ($idUcpPpl > 0) {
    $rowt = $DgoEjemplarInforme->getEditDgoEjemplarInforme($idUcpPpl);
}
$formDgoEjemplarInforme->getFormularioDgoEjemplarInforme($rowt, $DgoEjemplarInforme->getIdCampo(), $opc);
?>
<script type="text/javascript">
    $(function() {
        $('#idDgoInfOrdenServicio').val($('#idOrden').val());
    });
</script>