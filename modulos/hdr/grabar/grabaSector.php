<?php
if (!isset($_SESSION)){session_start();}

/**
 * librerias de guardado
 */
include '../../../../funciones/db_connect.inc.php';
include_once('../../../../funciones/redirect.php');

/**
 * obteniendo  los valores que se deberan guardar
 */
$array = explode(",",$_POST['seleccionados']);

/**
 * obtener el codigo del recurso
 */
$sql1="Select idHdrRecurso from hdrRecurso where sha1(idHdrRecurso)='".$_POST['id']."'";

$rs1=$conn->query($sql1);
$rowt = $rs1->fetch(PDO::FETCH_ASSOC);

/**
 * iniciando la transacción
 */
$conn->beginTransaction();

/**
 * Eliminar los antiguos
 */
$sql ="DELETE FROM hdrSectorPatrulla WHERE idHdrRecurso=?";
$sentencia=$conn->prepare($sql);
$sentencia->bindParam(1,$rowt['idHdrRecurso']);
$sentencia->execute() or die(print_r($sentencia->errorInfo()));

/**
 * guardar los nuevos registros
 */
$sql = "INSERT INTO hdrSectorPatrulla(idHdrRecurso,idGenGeoSenplades)VALUES(?,?)";
$sentencia =$conn->prepare($sql);

/**
 * recorriendo lista de datos
 */
foreach($array as $row){
	$sentencia->bindParam(1,$rowt['idHdrRecurso']);
	$sentencia->bindParam(2,$row);
	$sentencia->execute() or die(print_r($sentencia->errorInfo()));
}

/**
 * guardando los cambios sin problemas
 */
$conn->commit();

/**
 * obtener principales
 */
$sql="SELECT GROUP_CONCAT(genGeoSenplades.descripcion)AS'sectorPatrulla' FROM genGeoSenplades
INNER JOIN hdrSectorPatrulla ON genGeoSenplades.idGenGeoSenplades = hdrSectorPatrulla.idGenGeoSenplades
WHERE hdrSectorPatrulla.idHdrRecurso = '{$rowt['idHdrRecurso']}'";

$rs = $conn->query($sql);

$string = '';

while($row = $rs->fetch(PDO::FETCH_ASSOC)){
	$string = $row['sectorPatrulla'];
}

?>
<script>
selectnombre();
function selectnombre()
{
	/**
	 * mostrar el mensaje respectivo
	 */
	alert('<?php echo strtoupper('El recurso va ha cubrir lo siguiente: ').$string;?>');
	
	/**
	 * cargando la información respectiva
	 */
	location.href = "/operaciones/modulos/hdr/sectoresforma.php?Guardar=si&id=<?php echo $_POST['id'];?>&recno=<?php echo $_POST['recno'];?>&pesta=<?php echo $_POST['pesta'];?>&opc=<?php echo $_POST['opc'];?>";
	
	
}
</script>