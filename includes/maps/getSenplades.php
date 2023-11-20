<?php
session_start();
include_once '../../../funciones/db_connect.inc.php';
include_once 'configuraciones.php';
function objectToArray($d)
{
    if (is_object($d)) {
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        return array_map(__FUNCTION__, $d);
    } else {
        return $d;
    }
}

try
{
    ini_set("soap.wsdl_cache_enabled", "0");
    $client = new SoapClient(Configuraciones::urlECU911);
    $return = objectToArray($client->getCodigoSubcircuito(array('latitud' => $_GET['latitud'], 'longitud' => $_GET['longitud'])));
    $sqlZ   = "select * from genGeoSenplades where codigoSenplades='{$return['getCodigoSubcircuitoResult']}'";
    //echo $sqlZ;
    $rsZ         = $conn->query($sqlZ);
    $subcircuito = array('', '', 0);
    if ($rowZ = $rsZ->fetch()) {
        $subcircuito = array($rowZ['descripcion'], $rowZ['siglasGeoSenplades'], $rowZ['idGenGeoSenplades']);
    }

} catch (SoapFault $exception) {
    $subcircuito = array('', '', 0);
}

echo json_encode($subcircuito);
