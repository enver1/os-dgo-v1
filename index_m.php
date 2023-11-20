<?php
session_start();
include_once('../funciones/db_connect.inc.php');
if (isset($_GET['modulo']))
	$_SESSION['elmodulo']=$_GET['modulo'];
$modulo='';
$fondoModulo='';
if (isset($_GET['modulo']))
	{$sql="select pathImagenModulo from genModulo where sha1(idGenModulo)='".$_GET['modulo']."'";
	$rs=$conn->query($sql);
	$rowm=$rs->fetch();
	$fondoModulo=$rowm[upc('pathImagenModulo')];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SIIPNE 3w OPERACIONES</title>
<script type="text/javascript">
    var GB_ROOT_DIR = "../js/greybox/";
</script>
<link href="../css/siipne3.css" rel="stylesheet" type="text/css" />
<link href="../css/menu.css" rel="stylesheet" type="text/css" />
<link href="../js/greybox/gb_styles.css" rel="stylesheet" type="text/css" />
<link href="../css/easyui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/greybox/AJS.js"></script>
<script type="text/javascript" src="../js/greybox/AJS_fx.js"></script>
<script type="text/javascript" src="../js/greybox/gb_scripts.js"></script>
<script type="text/javascript" src="../js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../js/validaciones.js"></script>
<link type="text/css" rel="stylesheet" href="../js/calendario/calendar/calendar.css?random=20051112" media="screen" />
<script type="text/javascript" src="../js/calendario/calendar/calendar.js?random=20060118"></script>
<script>
function max(txarea,longo,id){total = longo;tam = txarea.value.length;str="";str=str+tam;document.getElementById('Dig'+id).innerHTML = str;document.getElementById('Res'+id).innerHTML = total - str;if (tam > total){aux = txarea.value;txarea.value = aux.substring(0,total);document.getElementById('Dig'+id).innerHTML = totaldocument.getElementById('Res'+id).innerHTML = 0}}
</script>
</head>

<body>
<?php include_once('../funciones/cabecera_modulo.php'); ?>

<?php if (isset($_GET['opc']))
				{
				$modulo=contenido($conn,$_GET['opc']); 
				echo '<script language="javascript">
				document.getElementById("aplicacion").innerHTML="'.$modulo.'";
				</script>';
				} 
else
	{
		if ($fondoModulo<>'')
				include_once('../funciones/fondoModulo.php');
	}
?>
</div>
<div id="regresar" style="height:30px;padding:40px 0 0 30px"><?php //print_r($_GET);echo'<br>';print_r($_SESSION);?><a href="../indexSiipne.php"><img src="../imagenes/botonback.jpg" alt="0" border="0" /></a></div>

<?php include_once('../funciones/pie_modulo.php'); ?>
