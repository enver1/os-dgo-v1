<?php 
class Configuraciones{
	/**
	 * consulta de vehiculos
	 * @var string
	 */
	//const urlAnt = "http://sistemaunico.ant.gob.ec:7025/WebServices-WSVEH-context-root/MetodosPort?WSDL";
	//const urlAnt = "http://186.46.185.241:7027/BASEUNIF-BASEUNIF-context-root/MetodosPort?WSDL";
	const urlAnt="http://172.17.0.158:6033/WebServices-WSVEH-context-root/MetodosPort?wsdl";
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
	/**
	 * codigo del proceso hoja de ruta
	 * @var number
	 */
	const idTipoActividadHojaRuta = 6;
	/**
	 * codigo del proceso segob
	 * @var number
	 */
	const idTipoActividadSegob = 12;
	/**
	 * codigo del estado activo
	 * @var number
	 */
	const idGenEstado = 1;
	
	/**
	 * codigo de la geosemplades subcircuitos
	 * @var unknown
	 */
	const idGenTipoGeoSenpladesSubcircuitos = 4;
}
?>