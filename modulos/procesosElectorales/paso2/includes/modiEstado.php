
<?php

if (file_exists(dirname(dirname(dirname(dirname(__DIR__))))."/clases/controlador/claseDB.php")) {
    include_once dirname(dirname(dirname(dirname(__DIR__)))).'/clases/autoload.php';
    include_once dirname(dirname(dirname(dirname(__DIR__)))).'/funciones/db_connect.inc.php';
    $obj=true;	
    //echo "Objetos";
}
else {
    include_once dirname(dirname(dirname(dirname(__DIR__)))).'/funciones/db_connect.inc.php';
    include_once dirname(dirname(dirname(dirname(__DIR__)))).'/clases/autoload.php';
    $obj=false;
    //echo "Estructurado";
}

$obj=false;

if($obj) $conn = DB::getConexionDB();

date_default_timezone_set('America/Bogota');
$sNtabla='genUsuarioAplicacion';
$idcampo=ucfirst($sNtabla);
$fecha=date('Y-m-d H:i:s');

if($obj) $encriptar = new Encriptar;

$aux = isset($_POST['arg']['cgenEstado10'])? (!empty($_POST['arg']['idGenEstado1']))?($_POST['arg']['idGenEstado1']==1)?"idGenEstado=?,fechaActiva=?,":"idGenEstado=?,fechaDesactiva=?,":"":"";
$aux1=isset($_POST['arg']['cdocuAutorizado10'])?"docuAutorizado=?,":"";

$sql="update ".$sNtabla." set ".$aux.$aux1." usuario=?,fecha=now(),ip=? where id".$idcampo."=?";

	try {
		$sentencia = $conn->prepare($sql);
		$conn->beginTransaction();
		foreach ($_POST as $key => $value) {
			if($key !='arg'){			
				$i=1;
				if($obj) $key = strip_tags($encriptar->getDesencriptar($key, $_SESSION['usuarioAuditar']));
				if(isset($_POST['arg']['cgenEstado10'])){
					if(!empty($_POST['arg']['idGenEstado1'])){
					$sentencia->bindParam($i++, $_POST['arg']['idGenEstado1']);	
					$sentencia->bindParam($i++, $fecha,PDO::PARAM_STR);}
				}
				if(isset($_POST['arg']['cdocuAutorizado10'])){
					$sentencia->bindParam($i++, $_POST['arg']['docuAutorizado1'],PDO::PARAM_STR);	
				}					
				$sentencia->bindParam($i++, $_SESSION['usuarioAuditar']);
				$sentencia->bindParam($i++, realIP());
				$sentencia->bindParam($i, $key);
				$sentencia->execute();
				
			}
		}
		$conn->commit();
	} catch (Exception $e) {
		$conn->rollback();
		print_r($e);
	}


/*if($obj){
	include_once("modiEstado_poo.php");
}else{
	include_once("modiEstado_est.php");
}*/

