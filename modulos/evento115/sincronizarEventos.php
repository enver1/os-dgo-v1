<?php
try{
	ini_set("soap.wsdl_cache_enabled","0");
	$client = new SoapClient("http://190.214.21.185:8086/SIS-ECU/Service.svc?wsdl");
	$return = objectToArray($client->GetDataEvento());
	$array = json_decode($return["GetDataEventoResult"], true);
	
	$usuario = $_SESSION['usuarioAuditar'];
	$ip = realIP();
	//echo print_r($array);
	$logica->insertarEventoEcu($array, $usuario, $ip);
	
}catch (SoapFault $exception){
	echo '<br>'.$exception->getMessage();
}

function objectToArray($d) {
	if (is_object($d)) {
		$d = get_object_vars($d);
	}

	if (is_array($d)) {
		return array_map(__FUNCTION__, $d);
	}
	else {
		return $d;
	}
}