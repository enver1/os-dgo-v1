<?php
session_start();
include_once '../../../../../clases/autoload.php';
$idDgoCreaOpReci = (!empty($_POST["idDgoCreaOpReci"])) ? strip_tags($_POST["idDgoCreaOpReci"]) : 0;

$CrearOperativoReci = new CrearOperativoReci;
$rs                 = $CrearOperativoReci->verificaProcesoFinalizado($idDgoCreaOpReci);
if (!empty($rs)) {

    $options = $rs['idDgoCreaOpReci'];
} else {
    $options = 0;
}

echo $options;
