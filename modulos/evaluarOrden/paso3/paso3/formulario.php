<?php
session_start();
include_once '../../../../../clases/autoload.php';
$formDgoOperacionesInforme = new FormDgoOperacionesInforme;
$DgoOperacionesInforme     = new DgoOperacionesInforme;
$encriptar       = new Encriptar;
$opc                  = strip_tags($_GET['opc']);
$idDgoOperacionesInforme     = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt                 = array();
if ($idDgoOperacionesInforme > 0) {
    $rowt = $DgoOperacionesInforme->getEditDgoOperacionesInforme($idDgoOperacionesInforme);
}
$formDgoOperacionesInforme->getFormularioDgoOperacionesInforme($rowt, $DgoOperacionesInforme->getIdCampo(), $opc);
?>
<script type="text/javascript">
    $(function() {
        $('#idDgoInfOrdenServicio').val($('#idOrden').val());
    });
</script>