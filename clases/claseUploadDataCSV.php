<?php 

/**
 * Clase para cargar datos csv a la tabla genTablaAuxiliar
 * Autor: Cristhian Lojan
 * Version: 1.0
 */
class UploadDataCSV 
{

	/**
	 * Description
	 * @param type|object $conn conexion a la base de datos
	 * @param type|string $ambsiipne tipo de ambiente del sistema
	 * @param type|string $serverarch servidor  
	 * @param type|string $username usuario servidor
	 * @param type|string $claveuser clave usuario
	 * @param type|string $pathFile path del archivo
	 * @param type|string $nameFile nombre del archivo
	 * @param type|string $camposaux campos de la tabla genTablaAuxiliar 
	 * @param type|array $datos datos enviados desde el formulario
	 * @param type|array $tStructure estructura de los datos extras hacer almacenados
	 * @return type|array si se insertaron bien los datos
	 */
	public function subirDatos($conn, $ambsiipne, $serverarch, $username, $claveuser, $pathFile, $nameFile,$camposaux,$datos,$tStructure=array())
	{

		$pathServerApp = $pathFile.$nameFile;
		$pathServerBD = '/var/descargas/personal/'.$nameFile;
		/*--Se sube el archivo al Servidor de Base de Datos para su lectura en Producción--*/	
		if($ambsiipne=='P')
		{
		  $connection = ssh2_connect($serverarch, 22);
		  ssh2_auth_password($connection, $username, $claveuser);
		  ssh2_scp_send($connection, $pathServerApp, $pathServerBD, 0777);
		}

		/*--Se insertan los datos del archivo subido, en la tabla genTablaAuxiliar--*/	
		try{
			//chmod($pathServerApp, 0777);

			//$temp = dirname(__DIR__).$pathServerApp;
			$temp = $pathServerApp;
			//$temp=addslashes($temp);

			/*--Se cambia la variable $temp en Producción--*/	
			if($ambsiipne=='P')
			{
				$temp=$pathServerApp;
			}

			if (file_exists($temp)) {

				$conn->beginTransaction();

			    //Borra los datos ingresados por el usuario anteriormente
				$sentencia = $conn->prepare("delete from genTablaAuxiliar where usuario=?");
				$sentencia->bindParam(1, $datos['usuarioAuditar']);
				$sentencia->execute();

				$set = '';

				foreach ($tStructure as $campos => $value) {
					$set.= $campos.'=?, ';
				}

				//Sentencia Sql que permite subir los datos desde el archivo CSV
				if($ambsiipne=='C'){
					$sqlstatement="LOAD DATA LOCAL INFILE '$temp' INTO TABLE genTablaAuxiliar FIELDS TERMINATED BY '".$datos['separador']."' OPTIONALLY ENCLOSED BY '\"' IGNORE ".$datos['filasCabecera']." LINES (".$camposaux.") SET ".$set." usuario=".$datos['usuarioAuditar'].""; 
				}else{
					$sqlstatement="LOAD DATA LOCAL INFILE '$temp' INTO TABLE genTablaAuxiliar FIELDS TERMINATED BY '".$datos['separador']."' OPTIONALLY ENCLOSED BY '\"' IGNORE ".$datos['filasCabecera']." LINES (".$camposaux.") SET ".$set." usuario=".$datos['usuarioAuditar'].""; 
				}

				//die($sqlstatement);

				$sentencia = $conn->prepare($sqlstatement);
				$i=1;
				
				/* Construye la lista de parametros a partir del arreglo $campos */
				foreach($tStructure as $campo=>$valor){
					$sentencia->bindParam($i,$datos[$valor]);
					$i++;
				}

				$sentencia->execute();
				$conn->commit();
				return $repuesta = array('success' => true,'message' => 'Datos cargados correctamente.');

			} else {
			    return $repuesta = array('success' => false,'message' => 'ERROR: El fichero '.$temp.' no existe');
			}
			
		}
		catch(Exception $e)
		{
			$conn->rollBack();
			//$msj=$e->getMessage();
			//die (json_encode(array(0,'No se pudo Cargar los datos a la Tabla Auxiliar')));
			return $repuesta = array('success' => false,'message' => 'ERROR: '.$e->getMessage());
			//die (json_encode(array(0,'ERROR: '.$e->getMessage())));
		}
	}
}

 ?>