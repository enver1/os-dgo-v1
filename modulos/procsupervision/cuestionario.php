<?php
//echo $_SESSION['cdg'];
session_start();
//print_r($_SESSION);
include_once('../../php/db_connect.inc.php');
include_once('../../php/listaSELECT.php');
$cdgUsuario=0;
if(isset($_SESSION['cdg']))
	$cdgUsuario=$_SESSION['cdg'];
$puede=true;
$msj='';
/*-----------------------------------------------------------------------------------------------------------------------
	Verifica que se hayan enviado correctamente los GETS de Codigo de Prueba TP y Codigo de Postulante AS 
-----------------------------------------------------------------------------------------------------------------------*/
//if(!isset($_GET['tp']) or !isset($_GET['as']) or !isset($_GET['tap']))
if(!isset($_GET['tp']) or !isset($_GET['as']))
	{$puede=false;
	$msj='Lo siento Ud. no tiene autorizacion para rendir esta prueba, Consulte al Administrador del proceso';}
else
{
	$usuario=$_GET['as'];
	$_GET['tp']=isset($_GET['tap'])?$_GET['tap']:$_GET['tp'];
	$prueba=$_GET['tp'];
	/*para los primeros casos antes de cambiar el sistema */
	$sq="select cdg,test_prueba from test_aspirantePrueba where sha1(aspirante)='$usuario' and sha1(cdg)='$prueba'  order by estado,fecha desc limit 1";
	//echo ($sq);
	$tap='no';
	$rw=mysql_fetch_array(mysql_query($sq));
	$tap=sha1($rw['cdg']);
	$pruebacdg=sha1($rw['test_prueba']);
	if ($tap=='no')
	/*---------------------------------------*/
		$tap=$_GET['tap'];
}
$block="";
/*-----------------------------------------------------------------------------------------------------------------------
	Verifica que el aspirante haya hecho login a su cuenta por lo tanto la SESSION sha1(cdg) debe ser igual al GET AS 
-----------------------------------------------------------------------------------------------------------------------*/
//echo $usuario.' --- '.sha1($cdgUsuario).'<br>';
if($puede)
{	if($usuario!=sha1($cdgUsuario))
	{$puede=false;
	$msj='El Usuario no coincide con la codificacion interna de la prueba Ud. no tiene autorizacion para rendirla, Consulte al Administrador del proceso';}
}
/*-----------------------------------------------------------------------------------------------------------------------
	Verifica que exista el registro de ACTIVO del usuario para rendir la prueba en la tabla test_aspirantePruena o si 
	ya la rindio una vez
------------------------------------------------------------------------------------------------------------------------*/
if($puede)
{
	$sql="select * from test_aspirantePrueba where sha1(cdg)='$prueba' order by estado limit 1";
	//echo $sql;
	$rs=mysql_query($sql);
	if($rowt=mysql_fetch_array($rs))
		{if ($rowt['estado']!='A')
			{$puede=false;
			$msj='Ud. ya rindi&oacute; esta prueba y no la puede repetir, gracias por participar en este proceso, pronto le enviaremos los resultados de su prueba';}
		}
	else
		{$puede=false;
		$msj='Ud. no tiene autorizacion para rendir esta prueba, Consulte al Administrador del proceso';}
	if($puede)
	{		
	/*-----------------------------------------------------------------------------------------------------------------------
		recupera los datos del test y arma la prueba para el usuario con tiempo limite
	------------------------------------------------------------------------------------------------------------------------*/
	$sql="select a.codigo descripcion,tiempo_limite,ayuda,b.descripcion empresa,b.usuario,a.orientacion from test_prueba a,empresa b where a.empresa=b.cdg and sha1(a.cdg)='".$pruebacdg."'";
	$rowp=mysql_fetch_array(mysql_query($sql));
	$title=$rowp['descripcion'];
	$ori=$rowp['orientacion'];
	$tiempo=$rowp['tiempo_limite'];
	$sql="select a.*,b.orientacion from test_pregunta a,test_prueba b where a.test_prueba=b.cdg and sha1(test_prueba)='".$pruebacdg."' order by rand();";
	$rs=mysql_query($sql);
	$rand='';
	if($ori=='V')
		$rand=' order by rand() ';
	$sql="select * from test_respuesta where test_pregunta in (select cdg from test_pregunta where  sha1(test_prueba)='".$pruebacdg."') ".$rand;
	$rsr=mysql_query($sql);
	$fila=0;
	$aRespuesta=false;
	while ($dato=mysql_fetch_assoc($rsr)){
		$aClaves=array_keys($dato);
		$aNames=mysql_field_name($rsr,0);
		//print_r($dato);
		foreach ($aClaves as $campos => $descri){
			$aRespuesta[$fila][$descri]=$dato[$descri];
		}
		$fila++;
	}
	}
}
//print_r($aRespuesta);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Talento humano, desarrollo organizacional, seleccion de personal, capacitacion, clima laboral, trabajo, evaluacion de desempeno, busco empleo, dho.com.ec, </title>
<meta name="description" content="dho.com.ec - Talento humano, desarrollo organizacional, seleccion de personal, capacitacion, clima laboral, trabajo, evaluacion de desempeno, busco empleo, dho.com.ec, ">
<meta name="keywords" content="Talento humano, desarrollo organizacional, seleccion de personal, capacitacion, clima laboral, trabajo, evaluacion de desempeno, busco empleo, dho.com.ec, ">
<meta name="robots" content="index,all">
<meta name="revisit-after" content="15 days">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link href="../../css/pagesQ.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-1.11.1.min.js" ></script>
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
	$('#pre'+c).css('color','#000000');
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
<?php if($puede) {		?>
<body onload="display_c(<?php echo $tiempo ?>)">
<?php } else { ?>
<body> <?php } ?>
<div id="wrapper1" style="background-image:none">
	<div id="wrapper">
		<div id="header">
      		<div id="headerleft"></div>
				<div id="headerright" 
            <?php
					$nombreEmpresa="";
					$file=isset($rowp['usuario'])?$rowp['usuario']:'no';
					if(file_exists('../../logos/'.$file.'.jpg'))
					{
						echo 'style="background-image:url(../../logos/'.$file.'.jpg)"'; }
					else
					$nombreEmpresa=isset($rowp['empresa'])?$rowp['empresa']:'';
				?>
            >
            <?php echo $nombreEmpresa; ?>
            </div>
      </div>
	</div>
	<div id="wrapper">
		<div id="faux">
<div id="contenido_ancho" style="text-align:justify;width:100%">
<?php if($puede) {		?>
<div id="top">Tiempo Restante: <label id="ct" style="font-size:12px"></label></div>
<form id="form1" name="form1" method="post" action="enviarespuesta.php" onsubmit="return validate_form(this)">
  <table width="100%" border="0" style="border:solid 1px #CCC" cellspacing="0">
    <tr>
		<td colspan="6" style="background-color:#5A6571;color:#fff;font-size:18px;text-align:center;height:35px;letter-spacing:0.3em" valign="middle"><?php echo $title ?> </td>
    </tr>
    <tr>
    <td style="font-size:10px; color:#fff; background-color:#5A6571; font-weight:bold;height:20px"><span style="font-family:Verdana; font-weight:bold;color:#000000; font-size:12px">
			<a href="javascript:void(0)"  class="tt" style="font-size:10px;border: dotted 1px;color:#fff;vertical-align:bottom;font-weight:bold">Ayuda
			<span class="tooltip" style="font-size:11px;left:0px;font-weight:normal">
				<span class="top">AYUDA TESTS DH&amp;O</span>
				<span class="middle">
					<?php echo $rowp['ayuda'] ?></span>
				<span class="bottom">
					Nota: Verifique el tiempo restante de su prueba</span>
			</span></a></span></td>
    <td colspan="5" style="font-size:10px; color:#fff; background-color:#5A6571; font-weight:bold" align="right">
    <input type="hidden" name="as" value="<?php echo $usuario ?>" />
    <input type="hidden" name="tp" value="<?php echo $pruebacdg ?>" />
    <input type="hidden" name="empresa" value="<?php echo $rowp['usuario'] ?>" />
    <input type="hidden" name="pruebaid" value="<?php echo $rowt['cdg'] ?>" />
    <input type="hidden" name="minuto" id="minuto" value="" />
    <input type="hidden" name="segundo" id="segundo" value="" />
    <input type="hidden" name="tiempo" value="<?php echo $tiempo ?>" />
    </td></tr>
    <?php
	 	$alter=true;
		$j=0;
			while ($row=mysql_fetch_array($rs))
			{
				$j++; 
				if($alter)
				{ $estilo='background-color:#E5E8ED';
					$alter=false;
					}
				else
				{	$estilo='background-color:#E5E8ED';
					$alter=true;
					}
			?>
	<tr>
		<td colspan="6" id="pre<?php echo $row['cdg'] ?>" style="font-weight:bold;font-size:12px; <?php echo $estilo ?>;padding:6px 10px; font-family:Verdana, Geneva, sans-serif"><img src="../../images/info.png" alt="" border="0" />&nbsp;<?php echo $j.'. '.$row['descripcion'] ?></td>
  </tr>
    <?php echo opcionLista('nombre',$aRespuesta,'',0,$row['cdg'],$row['orientacion']) ?>
  <? } ?>
    <tr>
		<td colspan="6" style="background-color:#E5E8ED;font-size:14px;text-align:center">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" style="text-align:center"><label>
        <input type="submit" name="Submit" value="Enviar Respuestas" style="height:40px" <?php echo $block ?> />
      </label></td>
    </tr>
    <tr><td colspan="6" style="height:20px">&nbsp;</td></tr>
  </table>
</form>
</div>
<?php } else { ?>
	<div class="warningmess"><p><?php echo $msj ?></p></div>
<?php } ?>
</div>
</div>
</div>
</body>
</html>	
	
