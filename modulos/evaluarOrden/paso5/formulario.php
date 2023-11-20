<?php
session_start();
include_once '../../../../clases/autoload.php';
$formDgoOportunidadesInforme  = new FormDgoOportunidadesInforme;
$DgoOportunidadesInforme      = new DgoOportunidadesInforme;
$encriptar       = new Encriptar;
$opc                  = strip_tags($_GET['opc']);
$idDgoOportunidadesInforme      = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt                 = array();
if ($idDgoOportunidadesInforme  > 0) {
    $rowt = $DgoOportunidadesInforme->getEditDgoOportunidadesInforme($idDgoOportunidadesInforme);
}
$formDgoOportunidadesInforme->getFormularioDgoOportunidadesInforme($rowt, $DgoOportunidadesInforme->getIdCampo(), $opc);
?>
<script type="text/javascript">
    $(function() {
        $('#idDgoInfOrdenServicio').val($('#idOrden').val());
    });
</script>