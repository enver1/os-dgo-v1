<?php
include_once '../../../funciones/db_connect.inc.php';
include_once '../../../clases/autoload.php';
include_once 'config.php';
$formInfoAppDgscop = new FormInfoAppDgscop;
$InfoAppDgscop     = new InfoAppDgscop;
$encriptar           = new Encriptar;
$opc                 = strip_tags($_GET['opc']);
$idDinaLevCadaver    = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
$rowt                = array();

if ($idDinaLevCadaver > 0) {
    $rowt = $InfoAppDgscop->getEditInfoAppDgscop($idDinaLevCadaver);
}
$formInfoAppDgscop->getFormularioInfoAppDgscop($rowt, $InfoAppDgscop->getIdCampo(), $opc);


?>
<script type="text/javascript">
    function cargaOpcionesUnidad(idDnaUnidadApp) {
        $.post("modulos/detalleInfoAppDgscop/includes/cmbMuestraOpcionUnidad.php", {
                idDnaUnidadApp: idDnaUnidadApp
            },
            function(resultado) {
                document.getElementById("dna_IdDnaInfoApp").innerHTML = resultado
            }
        );
    }
</script>