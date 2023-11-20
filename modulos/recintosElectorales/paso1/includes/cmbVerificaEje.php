<?php
session_start();
include_once '../../../../../clases/autoload.php';
$idTipoEje1       = (!empty($_POST["idTipoEje1"])) ? strip_tags($_POST["idTipoEje1"]) : 0;
$RecintoElectoral = new RecintoElectoral;
$rs               = $RecintoElectoral->getVerificaEje($idTipoEje1);
if($rs['idDgoTipoEje']>0){
	$options=$rs['idDgoTipoEje'];
}else{
	$options=0;
}
echo $options;
