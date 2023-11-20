<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include_once '../../../../clases/autoload.php';
include_once 'config.php';

$formProcesosElectorales  = new FormProcesosElectorales;
$ProcesosElectorales      = new ProcesosElectorales;
$encriptar                = new Encriptar;
$opc                      = strip_tags($_GET['opc']);
$rowt                     = array();
$idDgoProcElec = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));

if ($idDgoProcElec > 0) {
    $rowt = $ProcesosElectorales->getEditProcesosElectorales($idDgoProcElec);
}
$formProcesosElectorales->getFormularioProcesosElectorales($rowt, $ProcesosElectorales->getIdCampoProcesosElectorales(), $opc);
?>
<script type="text/javascript">
    $(function() {
        $('#idProceso').val($('#idDgoProcElec').val());
    });
</script>