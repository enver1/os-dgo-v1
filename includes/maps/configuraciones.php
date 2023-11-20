<?php 
class Configuraciones{
	/**
	 * consulta de vehiculos
	 * @var string
	 */
	const urlAnt = "http://sistemaunico.ant.gob.ec:7025/WebServices-WSVEH-context-root/MetodosPort?WSDL";
	/**
	 * valor por defecto del canal de consulta
	 * @var string
	 */
	const canalAnt = "VIR";
	/**
	 * valor de usuario por defecto
	 * @var string
	 */
	const usuarioAnt = "CONSULTA";
	/**
	 * consulta de fichas
	 * @var string
	 */
	const urlECU911 = "http://190.214.21.185:8086/SIS-ECU/Service.svc?wsdl";
}
?>