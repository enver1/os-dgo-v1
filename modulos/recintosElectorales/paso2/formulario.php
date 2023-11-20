<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include_once '../../../../clases/autoload.php';
include_once 'config.php';

$Comisios     = new Comisios;
$formComisios = new FormComisios;
$encriptar    = new Encriptar;
$dt           = new DateTime('now', new DateTimeZone('America/Guayaquil'));

$rowt = array();
$opc  = strip_tags($_GET['opc']);
$id   = strip_tags($encriptar->getDesencriptar($_GET['c'], $_SESSION['usuarioAuditar']));
/*-------------------------------------------------*/
if ($id > 0) {
    $rowt = $Comisios->getEditComisios($id);
}

?>
<br>
<fieldset style="border-color:#336699">
    <legend><strong>DETALLE RECINTOS:</strong></legend>
    <form name="edita" id="edita" method="post">
        <table width="100%" border="0">
            <?php
            $formComisios->getFormularioComisios($rowt, $Comisios->getIdCampoComisios(), $opc);
            ?>
            <script type="text/javascript">
                $(function() {
                    $('#idDgoReciElect').val($('#idRecinto').val());
                    var id = $('#idDgoT').val();

                    getCamposRecinto(id);
                });
            </script>


            <script type="text/javascript">
                function getCamposRecinto(resultado) {

                    if (resultado == 1) {
                        $('#etNumero').css('display', 'block');
                        $('#numElectores').css('display', 'block');
                        $('#etJuntasH').css('display', 'block');
                        $('#numJuntMascu').css('display', 'block');
                        $('#etJuntasM').css('display', 'block');
                        $('#numJuntFeme').css('display', 'block');

                    } else {
                        $('#etNumero').css('display', 'none');
                        $('#numElectores').css('display', 'none');
                        $('#etJuntasH').css('display', 'none');
                        $('#numJuntMascu').css('display', 'none');
                        $('#etJuntasM').css('display', 'none');
                        $('#numJuntFeme').css('display', 'none');

                    }
                }
            </script>