<?php
session_start();
include_once '../../../../clases/autoload.php';
$formDgoInstruccionesOrden  = new FormDgoInstruccionesOrden;
$DgoInstruccionesOrden      = new DgoInstruccionesOrden;
$encriptar       = new Encriptar;
$opc                  = strip_tags($_GET['opc']);
$idDgoInstruccionesOrden      = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt                 = array();
if ($idDgoInstruccionesOrden  > 0) {
    $rowt = $DgoInstruccionesOrden->getEditDgoInstruccionesOrden($idDgoInstruccionesOrden);
}
$formDgoInstruccionesOrden->getFormularioDgoInstruccionesOrden($rowt, $DgoInstruccionesOrden->getIdCampo(), $opc);
?>
<script type="text/javascript">
    $(function() {
        $('#idDgoOrdenServicio').val($('#idOrden').val());
    });
</script>