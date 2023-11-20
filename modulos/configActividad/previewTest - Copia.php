<?php
//echo $_SESSION['cdg'];
session_start();
//print_r($_SESSION);
include_once('../../../funciones/db_connect.inc.php');
include_once('../../../funciones/funcion_select.php');
function opcionLista($conn,$pregunta=0,$orienta='V')
{
	$letra=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
	$rand='';
//	if($orienta=='V')
//		$rand=' order by rand() ';
	$sql="select a.* from dgoEncuesta a where exists (select * from dgoInstrucci b where a.idDgoInstrucci=b.idDgoInstrucci and b.idDgoInstrucci=".$pregunta.") ".$rand;
	$rsr=$conn->query($sql);
	$fila=0;
	$aRespuesta=false;
	$cHtmlSelect='';
	$i=0;
	$tr='';$tr2='';$cHtmlSelectX='';
	while ($rowD=$rsr->fetch()){
	if($orienta=='H')
		{
			$tr='<tr><td colspan="6"><table width="100%"><tr><td style="width:80px">&nbsp;</td>';$tr2='</tr></table></td></tr>';}
	if($orienta=='V')
	{
		$cHtmlSelectX.='<tr><td valign="middle" width="5%" align="right" style="height:30px;font-size:11px;font-family:Verdana">'.$letra[$i].'.)</td>';
		$cHtmlSelectX.='<td style="font-size:11px;font-family:Verdana"><input type="radio" value="'.$rowD['idDgoEncuesta'].'" name="preg'.$pregunta.'" onclick="color(\''.$pregunta.'\')"  />';
		$cHtmlSelectX.=$rowD['descEncuesta'].'</td></tr>';
		$i++;
	}
	else
	{
		//$cHtmlSelectX.='<td width="5%" align="right" style="height:20px;font-size:11px;">'.$aLetras[$i].'.)</td>';
		$cHtmlSelectX.='<td style="font-size:11px;font-family:Verdana">'.$letra[$i].'<input type="radio" value="'.$rowD['idDgoEncuesta'].'" name="preg'.$pregunta.'" onclick="color(\''.$pregunta.'\')"  />';
		$cHtmlSelectX.=$rowD['descEncuesta'].'</td>';
		$i++;
	}
}
	$cHtmlSelect.=$tr.$cHtmlSelectX.$tr2;
	
	
	return $cHtmlSelect;
}

$cdgUsuario=0;
$puede=true;
$msj='';
$pruebacdg=sha1($_GET['prueba']);
/*-----------------------------------------------------------------------------------------------------------------------
		recupera los datos del test y arma la prueba para el usuario con tiempo limite
------------------------------------------------------------------------------------------------------------------------*/
	$sql="select a.descDgoActividad descripcion,600 tiempoLimite,'De acuerdo a la visita realizada por Ud. a la Unidad Policial en fechas anteriores, conteste el siguiente cuestionario seleccionando una de las respuestas por cada pregunta<br>Lea detenidamente y conteste todas las preguntas' ayuda,'V' orientacion 
	from dgoActividad a where sha1(a.idDgoActividad)='".$pruebacdg."'";
	//die($sql);
	$rs=$conn->query($sql);
	$rowp=$rs->fetch();
	$title=$rowp['descripcion'];
	$ori=$rowp['orientacion'];
	$tiempo=$rowp['tiempoLimite'];
	$sql="select a.*,'V' orientacion from dgoInstrucci a,dgoActividad b where a.idDgoActividad=b.idDgoActividad and sha1(a.idDgoActividad)='".$pruebacdg."' order by 1;";
	//echo $sql;
	$rs=$conn->query($sql);
	//print_r($aRespuesta);
//die('');
//print_r($aRespuesta);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta name="description" content="">
<meta name="robots" content="index,all">
<meta name="revisit-after" content="15 days">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link href="../../../css/siipne3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../js/jquery-1.11.1.min.js" ></script>
<style type="text/css">
#top {
	position: fixed;
	top: 5px;
	z-index: 999;
	width: 350px;
	height: 23px;
	font-weight:normal;
	font-family:Verdana;
	background-color:#D74B4B;
	color:#FFF;
	float:right;
	font-size:11px;
	padding:3px 0 0 25px;
	border-radius:7px;
	box-shadow: 6px 6px 6px #444;
	background-image:url(../../images/clock.png);
	background-position:left;
	background-repeat:no-repeat;
}
</style>
<script type="text/JavaScript">
function color(c)
{
	//alert(c);
	$('#pre'+c).css('color','#336699');
}
function validate_form(thisform)
{
	var respuesta=confirm('Desea enviar sus respuestas? asegurese de haber respondido a todas las preguntas');
	if(respuesta==false)
		return false;
	else
	{
		
		 var $inputs = $('#form1 :input');
		 var values = {};
		 $inputs.each(function() {
			if(this.type == 'radio')
			{
//					alert(this.value);
				if(this.checked)
					{ 
						values[this.name] = this.value;}
				}	
			else
			  {values[this.name] = $(this).val();}
		 });
		/* Valida permisos y privilegios sobre la BDD*/
		$.ajax({
		type: "POST",
		url: "verificaRespuestas.php",
		data: values,		
		async: false,
		success: function(response){
			result = eval(response);
			}
		});
		if (result[0]==1)
		{	//alert(result);
			return true; }
		else 
		{	alert('Aun no ha contestado todas las preguntas, revise la que esta en color rojo');
			
			//var preg=document.getElementById(result[1]);
			$('#pre'+result[1]).css('color','#ff0000');
			$('html, body').animate({
				 scrollTop: $("#pre"+result[1]).offset().top
			}, 800);
			//$("html, body").animate({ scrollTop: 0 }, "slow");
			return false;}
		
	}
}

//courtesy of BoogieJack.com
function killCopy(e){
return false
}
function reEnable(){
return true
}
document.onselectstart=new Function ("return false")
if (window.sidebar){
document.onmousedown=killCopy
document.onclick=reEnable
}

</script>

<script>
function display_c(start){
window.start = parseFloat(start);
var end = 0 // change this to stop the counter at a higher value
var refresh=1000; // Refresh rate in milli seconds
if(window.start >= end ){
mytime=setTimeout('display_ct()',refresh)
}
else {
	alert("Tiempo Finalizado ");
	document.form1.submit()}
}

function display_ct() {
// Calculate the number of days left
var days=Math.floor(window.start / 86400);
// After deducting the days calculate the number of hours left
var hours = Math.floor((window.start - (days * 86400 ))/3600)
// After days and hours , how many minutes are left
var minutes = Math.floor((window.start - (days * 86400 ) - (hours *3600 ))/60)
// Finally how many seconds left after removing days, hours and minutes.
var secs = Math.floor((window.start - (days * 86400 ) - (hours *3600 ) - (minutes*60)))

var x = "(" + minutes + " Minutos y " + secs + " Segundos " + ")";
document.getElementById('minuto').value=minutes;
document.getElementById('segundo').value=secs;


document.getElementById('ct').innerHTML = x;
window.start= window.start- 1;

tt=display_c(window.start);
}
function stop() {
    clearTimeout(mytime);
}

</script>
</head>
<body onload="display_c(<?php echo $tiempo ?>)">
<div id="wrapper1" style="background-image:none">
	<div id="wrapper">
		<div id="header" style="margin:0 auto">
      </div>
	</div>
	<div id="wrapper">
		<div id="faux">
<div id="contenido_ancho" style="text-align:justify;width:100%">
<div id="top">Tiempo Restante: <label id="ct" style="font-size:12px"></label></div>
<form id="form1" name="form1" method="post" action="enviarespuesta.php">
  <table width="100%" border="0" style="border:solid 1px #CCC" cellspacing="0">
    <tr>
		<td colspan="6"  style="background-color:#5A6571;color:#fff;font-family:Verdana;font-size:15px;text-align:justify;height:35px;" valign="middle"><strong>ACTIVIDAD:</strong><?php echo $title ?> </td>
    </tr>
    <tr>
    <td style="font-size:10px; color:#fff; background-color:#5A6571; font-weight:bold;height:20px"><span style="font-family:Verdana; font-weight:bold;color:#000000; font-size:12px">
			<a href="javascript:void(0)"  class="tt" style="font-size:10px;border: dotted 1px;color:#fff;vertical-align:bottom;font-weight:bold">Ayuda
			<span class="tooltip" style="font-size:11px;left:0px;font-weight:normal">
				<span class="top">AYUDA</span>
				<span class="middle">
					<?php echo $rowp['ayuda'] ?></span>
				<span class="bottom">
					Nota: Verifique el tiempo restante de la Evaluacion</span>
			</span></a></span></td>
    <td colspan="5" style="font-size:10px; color:#fff; background-color:#5A6571; font-weight:bold" align="right">
    <input type="hidden" name="minuto" id="minuto" value="" />
    <input type="hidden" name="segundo" id="segundo" value="" />
    <input type="hidden" name="tiempo" value="<?php echo $tiempo ?>" />
    </td></tr>
    <?php
	 	$alter=true;
		$j=0;
		while ($row=$rs->fetch())
		{
			$j++; 
			if($alter)
			{ 
				$estilo='background-color:#E5E8ED';
				$alter=false;
				}
			else
			{	
				$estilo='background-color:#E5E8ED';
				$alter=true;
			}
			?>
	<tr>
		<td colspan="6" id="pre<?php echo $row['idDgoInstrucci'] ?>" style="font-weight:bold;font-size:12px; <?php echo $estilo ?>;padding:6px 10px; font-family:Verdana, Geneva, sans-serif">
        <img src="../../images/info.png" alt="" border="0" />&nbsp;<?php echo $j.'. '.$row['descDgoInstrucci'] ?></td>
  </tr>
    <?php 
		//echo $row['idGenEncPregun'].' '.$row['orientacion'];
		echo opcionLista($conn,$row['idDgoInstrucci'],$row['orientacion']); 
	?>
  <?php } ?>
    <tr>
		<td colspan="6" style="background-color:#E5E8ED;font-size:14px;text-align:center">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" style="text-align:center"><label>
      </label></td>
    </tr>
    <tr><td colspan="6" style="height:20px">&nbsp;</td></tr>
  </table>
</form>
</div>
</div>
</div>
</div>
</body>
</html>	
	
