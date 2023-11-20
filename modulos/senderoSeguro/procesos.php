<?php
class procesos
{

	public function getDatosUser($datos){


		//DATOS DEL USUARIO
		$documento=$datos['docuGoeUsuReg'];
		$nombres=$datos['nomGoeUsuReg']." ".$datos['apeGoeUsuReg'];
		$celular= $datos['celuGoeUsuReg'];
		$contactoFamiliar= $datos['conFamiGoeUsuReg'];
		$email=$datos['mailGoeUsuReg'];
		$pais=$datos['pais'];


		$camposDatos = array(
			'Documento:' => $documento,
			'Nombres y Apellidos:' => $nombres,
			'Celular:' => $celular, 
			'Contacto Familiar:' => $contactoFamiliar,
			'Email/Correo:' =>$email,
			'País:' => $pais
		);

		return $camposDatos;

	}

}