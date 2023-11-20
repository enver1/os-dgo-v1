<?php
if (!isset($_SESSION)) { session_start(); }
header('Content-Type: text/html; charset=UTF-8');
include '../../funciones/db_connect.inc.php';
include '../../funciones/paginacion/libs/ps_pagination.php';
switch ($_GET['modl'])
{
	case sha1('usuarioapp'):
	$sql = "select a.idGenUsuarioAplicacion,d.descripcion idGenModulo,b.descripcion,c.descripcion  idGenEstado,";
	$sql.= "insercion,modificacion,eliminacion,consulta from genUsuarioAplicacion a,genAplicacion b,genEstado c,genModulo d ";
	$sql.= "where a.idGenAplicacion=b.idGenAplicacion and a.idGenEstado=c.idGenEstado and b.idGenModulo=d.idGenModulo and ";
	$sql.= "idGenUsuario=".(isset($_GET['usuario'])?$_GET['usuario']:0)." order by 2,3";
	break;
	case sha1('modulousuario'):
	$sql = "select a.idGenModuloUsuario,b.descripcion idGenModulo ";
	$sql.= "from genModuloUsuario a,genModulo b ";
	$sql.= "where a.idGenModulo=b.idGenModulo and ";
	$sql.= "idGenUsuario=".(isset($_GET['usuario'])?$_GET['usuario']:0)." order by 2";
	break;
	case sha1('monitor'):
	$sql = "select dm.idDneMonitor, dp.descripcion, (gp.apellido1+' '+gp.apellido2+' '+gp.nombre1+' '+gp.nombre2) as nombres ";
	$sql.= "from dneMonitor dm, dneProcesoEvaluacion dp, genPersona gp ";
	$sql.= "where dm.idGenPersona = gp.idGenPersona and dm.idDneProcesoEvaluacion = dp.idDneProcesoEvaluacion and ";
	$sql.= "gp.idGenPersona=".(isset($_GET['usuario'])?$_GET['usuario']:0)." order by 2";
	break;
    case sha1('personaproceso'):
	$sql = "SELECT d.idDnePersonaProceso,d.idGenPersona,concat(v.apellido1,' ',v.apellido2,' ',v.nombre1,' ',v.nombre2) as   nombre,e.descripcion,d.observacion,es.descripcion as estado ";
	$sql.= "FROM dnePersonaProceso d, v_persona v, dneProcesoEvaluacion e, genEstado es ";
	$sql.= "where d.idGenPersona=v.idGenPersona and d.idDneProcesoEvaluacion=e.idDneProcesoEvaluacion and d.idGenEstado=es.idGenEstado ";
	$sql.= " order by 4,3";
	// and d.idGenPersona=".(isset($_GET['usuario'])?$_GET['usuario']:0)."
	break;

}
//die($sql);
//$conn is a variable from our config_open_db.php
//$sql is our sql statement above
//3 is the number of records retrieved per page
//4 is the number of page numbers rendered below
//null - i used null since in dont have any other
//parameters to pass (i.e. param1=valu1&param2=value2)
//you can use this if you're gonna use this class for search
//results since you will have to pass search keywords
$pager = new PS_Pagination( $conn, $sql, 25, 10, null );

//our pagination class will render new
//recordset (search results now are limited
//for pagination)

if($rs = $pager->paginate())
{
	$num = $rs->rowCount();
}
else
	{$num=0;}

if($num >= 1 ){     
	//creating our table header
	include_once($_GET['grilla']);
	//die($_GET['grilla']);
}else{
	//if no records found
	echo "No hay registros!";
}
//page-nav class to control
//the appearance of our page 
//number navigation
echo "<div class='page-nav'>";
	//display our page number navigation
	echo $pager->renderFullNav();
echo "</div>";

?>