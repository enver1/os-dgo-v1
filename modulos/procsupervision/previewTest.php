<?php
//echo $_SESSION['cdg'];
session_start();
//print_r($_SESSION);
include_once '../../../clases/autoload.php';
$conn = DB::getConexionDB();
include_once('../../../funciones/funcion_select.php');
$dt = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$hoy = $dt->format('Y-m-d');
$fiPlazo = '';
$ffPlazo = '';
$cumple = '';
$directorio		= 'procsupervision'; 				// ** Nombre del directorio donde se encuentra la 
$tgraba			= $directorio . '/graba.php'; 	// ** nombre del php para insertar o actualizar un registro
$directorioC	= 'modulos/' . $directorio;
/*Funcion que arma la evaluacion PREGUNTAS Y RESPUESTAS */
function opcionLista($conn, $pregunta = 0, $orienta = 'V', $visita = 0)
{
	$letra = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
	$rand = ' order by rand() ';
	$sql = "select a.*,ev.idDgoEncVisita,ev.obsDgoEncVisita from dgoEncuesta a
		left join dgoEncVisita ev on a.idDgoEncuesta=ev.idDgoEncuesta and ev.idDgoVisita=" . $visita . "
		where idDgoInstrucci=" . $pregunta . $rand;

	$rsr = $conn->query($sql);
	$fila = 0;
	$aRespuesta = false;
	$cHtmlSelect = '';
	$i = 0;
	$tr = '';
	$tr2 = '';
	$obs = '';
	$cHtmlSelectX = '<tr><td valign="top" width="70%" style="border-right:solid 3px #ddd"><table width="100%">';
	while ($rowD = $rsr->fetch()) {
		$cHtmlSelectX .= '<tr><td valign="middle" width="5%" align="right" style="height:30px;font-size:11px;font-family:Verdana">' . $letra[$i] . '.)</td>';
		$sele = '';
		if (!empty($rowD['idDgoEncVisita'])) {
			$sele = ' checked="checked" ';
			$obs = $rowD['obsDgoEncVisita'];
		}
		$cHtmlSelectX .= '<td style="font-size:11px;font-family:Verdana" colspan="5"><div class="conte">
			<input type="radio" value="' . $rowD['idDgoEncuesta'] . '" name="preg' . $pregunta . '" 
			id="preg' . $rowD['idDgoEncuesta'] . '" onclick="color(\'' . $pregunta . '\')" ' . $sele . ' class="radiopt" />';
		$cHtmlSelectX .= '<label  class="etiopt" for="preg' . $rowD['idDgoEncuesta'] . '" 
			style="width:500px;padding:0 10px 0 35px;	text-indent:0;line-height:22px">'
			. $rowD['descEncuesta'] . '</label></div></td></tr>';
		$i++;
	}
	$cHtmlSelect .= $tr . $cHtmlSelectX . $tr2;
	$cHtmlSelect .= '</table></td><td valign="top"><table>
	<tr style="font-family:Verdana;font-size:10px"><td class="etiqueta" style="text-align:left">Observacion</td></tr><tr><td>
	<textarea name="obs' . $pregunta . '" style="width:300px;height:50px;font-family:Verdana;font-size:11px"
         	onKeyUp="max(this,300,\'' . $pregunta . '\')" 
            onKeyPress="max(this,300,\'' . $pregunta . '\')"
	>' . $obs . '</textarea></td></tr>
	<tr>
	<td style="font-family:Verdana;font-size:10px">
               <font id="Dig' . $pregunta . '" color="red">0</font> Caracteres digitados / Restan 
               <font id="Res' . $pregunta . '" color="red">300</font></td></tr>
	</table></td></tr>';

	return $cHtmlSelect;
}
/*----------------------------------------------------------*/
$cdgUsuario = 0;
$puede = true;
$msj = '';
//$pruebacdg=sha1($_GET['prueba']);
//$acuncdg=sha1($_GET['acun']);
$pruebacdg = $_GET['prueba'];
$acuncdg = $_GET['acun'];
/*-----------------------------------------------------------------------------------------------------------------------
		recupera los Puntajes obtenidos en la evaluacion
------------------------------------------------------------------------------------------------------------------------*/
$sql = "select a.idDgoInstrucci,max(puntaje) puntos
	from dgoInstrucci a
	join dgoActividad b on a.idDgoActividad=b.idDgoActividad
	join dgoActUniIns c on a.idDgoInstrucci=c.idDgoInstrucci 
	join dgoVisita v on c.idDgoActUnidad=v.idDgoActUnidad
	join genUsuario u on v.idGenPersona=u.idGenPersona 
	join dgoEncuesta ec on a.idDgoInstrucci=ec.idDgoInstrucci
	where u.idGenUsuario=" . $_SESSION['usuarioAuditar'] . "  
	and sha1(a.idDgoActividad)='" . $pruebacdg . "' 
	and sha1(c.idDgoActUnidad)='" . $acuncdg . "' group by a.idDgoInstrucci";
$rsAC = $conn->query($sql);
$maximo = 0;
$puntos = 0;
$instru = 0;
while ($rowAC = $rsAC->fetch()) {
	$maximo += $rowAC['puntos'];
}

$sql = "select ec.puntaje,b.peso,c.fechaCumplimiento,c.fechaInicioPlazo,c.fechaFinPlazo 
	from dgoInstrucci a
	join dgoActividad b on a.idDgoActividad=b.idDgoActividad
	join dgoActUniIns c on a.idDgoInstrucci=c.idDgoInstrucci 
	join dgoVisita v on c.idDgoActUnidad=v.idDgoActUnidad
	join genUsuario u on v.idGenPersona=u.idGenPersona 
	join dgoEncuesta ec on a.idDgoInstrucci=ec.idDgoInstrucci
	join dgoEncVisita ev on ec.idDgoEncuesta=ev.idDgoEncuesta and v.idDgoVisita=ev.idDgoVisita
	where u.idGenUsuario=" . $_SESSION['usuarioAuditar'] . "  
	and sha1(a.idDgoActividad)='" . $pruebacdg . "' 
	and sha1(c.idDgoActUnidad)='" . $acuncdg . "' ";
$rsAC = $conn->query($sql);
while ($rowAC = $rsAC->fetch()) {
	$puntos += $rowAC['puntaje'];
	$instru = $rowAC['peso'];
	$cumple = $rowAC['fechaCumplimiento'];
	$fiPlazo = $rowAC['fechaInicioPlazo'];
	$ffPlazo = $rowAC['fechaFinPlazo'];
}

/*-----------------------------------------------------------------------------------------------------------------------
		recupera los datos del test y arma la prueba para el usuario
------------------------------------------------------------------------------------------------------------------------*/
$sql = "select a.descDgoActividad descripcion,600 tiempoLimite,idDgoActividad,'De acuerdo a la visita realizada por Ud. a la Unidad Policial en fechas anteriores, conteste el siguiente cuestionario seleccionando una de las respuestas por cada pregunta<br>Lea detenidamente y conteste <strong>TODAS</strong> las preguntas<br>Si la ACTIVIDAD se encuentra finalizada, ingrese la fecha en la que finaliz&oacute;<br>Puede escribir Observaciones para cada Instrucci&oacute;n' ayuda,'V' orientacion 
	from dgoActividad a where sha1(a.idDgoActividad)='" . $pruebacdg . "'";
//echo ($sql.'<br>');
$rs = $conn->query($sql);
$rowp = $rs->fetch();
$title = $rowp['descripcion'];
$ori = $rowp['orientacion'];
$tiempo = $rowp['tiempoLimite'];
$idDgoActividad = $rowp['idDgoActividad'];
$sql = "select a.*,'V'orientacion,c.idDgoActUnidad,v.idGenPersona,v.idDgoVisita,fechaInicioPlazo,fechaFinPlazo,fechaCumplimiento  from dgoInstrucci a,dgoActividad b, dgoActUniIns c,dgoVisita v,genUsuario u 
	where a.idDgoActividad=b.idDgoActividad and c.idDgoActUnidad=v.idDgoActUnidad and v.idGenPersona=u.idGenPersona and u.idGenUsuario=" . $_SESSION['usuarioAuditar'] . " 
	and a.idDgoInstrucci=c.idDgoInstrucci and sha1(a.idDgoActividad)='" . $pruebacdg . "' and sha1(c.idDgoActUnidad)='" . $acuncdg . "' order by 1;";
//echo $sql;
$rs = $conn->query($sql);
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
	<script type="text/javascript" src="../../../js/jquery-1.11.1.min.js"></script>
	<link type="text/css" rel="stylesheet" href="../../../js/calendario/calendar/calendar.css?random=20051112" media="screen" />
	<script type="text/javascript" src="../../../js/calendario/calendar/calendar.js?random=20060118"></script>
	<style type="text/css">
		#top {
			position: fixed;
			top: 5px;
			z-index: 999;
			width: 350px;
			height: 23px;
			font-weight: normal;
			font-family: Verdana;
			background-color: #D74B4B;
			color: #FFF;
			float: right;
			font-size: 11px;
			padding: 3px 0 0 25px;
			border-radius: 7px;
			box-shadow: 6px 6px 6px #444;
			background-image: url(../../images/clock.png);
			background-position: left;
			background-repeat: no-repeat;
		}

		input.radiopt:checked~label {
			color: #06F;
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
		url: "verificaRespuesta.php",
		data: values,		
		
		success: function(response){
			result = eval(response);
			}
		});
		if (result[0]=='NO')
		{	//alert(result);
			$('#message').html('<p><img src="../../../funciones/paginacion/images/ajax-loader.gif" /></p>');
			$.ajax({
			type: "POST",
			url: "enviarespuesta.php",
			data: values,		
			
			success: function(responde){
				resultado = eval(responde);
					$('#message').html(resultado[0]+'<br>'+resultado[2]+' Puntos de un total de '+resultado[1]+', que equivale a '+resultado[3]+'/100 (Coeficiente :'+resultado[4]+')');
					$('#message').css('display','block');
					$('html, body').animate({
					 scrollTop: $("#message").offset().top
					}, 800);
				}
				
			});
			
		}
		else 
		{	alert('Aun no ha contestado todas las preguntas, revise la que esta en color rojo');
			$('#message').html('Aun no ha contestado todas las preguntas, revise la(s) que esta(n) en color rojo');
			$('#message').css('display','block');
			$('html, body').animate({
			 scrollTop: $("#message").offset().top
			}, 800);
			//var preg=document.getElementById(result[1]);
			for(i=0;i<result.length;i++)
			{
				$('#pre'+result[i]).css('color','#ff0000');
			}
			$('html, body').animate({
				 scrollTop: $("#pre"+result[0]).offset().top
			}, 800);
			//$("html, body").animate({ scrollTop: 0 }, "slow");
			return false;}
		
	}
}
function max(txarea,longo,id){total = longo;tam = txarea.value.length;str="";str=str+tam;document.getElementById('Dig'+id).innerHTML = str;document.getElementById('Res'+id).innerHTML = total - str;if (tam > total){aux = txarea.value;txarea.value = aux.substring(0,total);document.getElementById('Dig'+id).innerHTML = totaldocument.getElementById('Res'+id).innerHTML = 0}}
</script>

</head>

<body>
	<div id="wrapper1" style="background-image:none">
		<div id="wrapper">
			<div id="header" style="margin:0 auto">
			</div>
		</div>
		<div id="wrapper">
			<div id="faux">
				<div id="contenido_ancho" style="text-align:justify;width:100%">


					<form id="form1" name="form1">
						<table width="100%" border="0" style="border:solid 1px #CCC;font-family:Verdana" cellspacing="0">
							<tr>
								<td colspan="6" style="background-color:#5A6571;color:#fff;font-family:Verdana;font-size:16px;text-align:justify;height:55px;padding:0 10px" valign="middle"><strong>ACTIVIDAD:</strong> <?php echo $title ?>
									<input type="hidden" name="idDgoActividad" value="<?php echo $idDgoActividad ?>">
								</td>
							</tr>
							<tr>
								<td style="font-size:11px;background-color:#ddd;color:#555;font-weight:bold">
									<table width="70%">
										<?php
										$d1 = 'Debe';
										$d2 = $d1;
										if ($fiPlazo <= $hoy)
											$d1 = 'Debi&oacute;';
										if ($ffPlazo < $hoy)
											$d2 = 'Debi&oacute;';
										?>
										<tr>
											<td><?php echo $d1 ?> Iniciar el:</td>
											<td><?php echo $fiPlazo ?></td>
											<td><?php echo $d2 ?> Finalizar el:</td>
											<td><?php echo $ffPlazo ?></td>
											<td colspan="2"></td>
										</tr>
									</table>
								</td>
								<td style="font-size:11px;background-color:#ddd;color:#fff"></td>
							</tr>
							<tr>
								<td style="font-size:10px; color:#fff; background-color:#5A6571; font-weight:bold;height:20px">
									<span style="font-family:Verdana; font-weight:bold;color:#000000; font-size:12px">
										<a href="javascript:void(0)" class="tt" style="font-size:10px;border: dotted 1px;color:#fff;vertical-align:bottom;font-weight:bold;padding:5px 20px">Ayuda
											<span class="tooltip" style="font-size:11px;left:0px;font-weight:normal">
												<span class="top">AYUDA</span>
												<span class="middle">
													<?php echo $rowp['ayuda'] ?></span>
												<span class="bottom">Evaluaci&oacute;n de Unidades
												</span>
											</span></a></span>
								</td>
								<td style="font-size:10px; color:#fff; background-color:#5A6571;">
									<table>
										<tr>
											<td class="etiqueta" style="color:#FF6;border-left:solid 5px #F63;padding-left:5px">Fecha de Finalizaci&oacute;n:</td>
											<td>
												<input type="text" name="plazo" id="plazo" value="<?php echo $cumple ?>" class="inputSombra" style="width:100px" />
												<input type="button" value="" onclick="displayCalendar(document.forms[0].plazo,'yyyy-mm-dd',this)" class="calendario" />
											</td>
										</tr>
									</table>

									<input type="hidden" name="minuto" id="minuto" value="" />
									<input type="hidden" name="segundo" id="segundo" value="" />
									<input type="hidden" name="tiempo" value="<?php echo $tiempo ?>" />
								</td>
							</tr>
							<tr>
								<td colspan="6" style="background-color:#5A6571;color:#fff;padding:10px 20px;font-weight:bold;border-top:solid 1px #ddd">INSTRUCCIONES:</td>
							</tr>
							<?php
							$alter = true;
							$j = 0;
							$primera = true;
							while ($row = $rs->fetch()) {
								if ($primera) {
									$primera = false;
									echo '<input type="hidden" name="fechaInicioPlazo" id="fechaInicioPlazo" value="' . $row['fechaInicioPlazo'] . '">
';
								}
								$idDgoActUnidad = $row['idDgoActUnidad'];
								$idGenPersona = $row['idGenPersona'];
								$idDgoVisita = $row['idDgoVisita'];
								$j++;
								if ($alter) {
									$estilo = 'background-color:#E5E8ED';
									$alter = false;
								} else {
									$estilo = 'background-color:#E5E8ED';
									$alter = true;
								}
							?>
								<tr>
									<td colspan="6" id="pre<?php echo $row['idDgoInstrucci'] ?>" style="font-weight:bold;font-size:12px; <?php echo $estilo ?>;padding:8px 10px; font-family:Verdana, Geneva, sans-serif">
										<!--<img src="../../../imagenes/help.png" alt="" border="0" />&nbsp;-->
										<?php echo $j . '. ' . $row['descDgoInstrucci'] ?>
									</td>
								</tr>
								<?php
								//echo $row['idGenEncPregun'].' '.$row['orientacion'];
								echo opcionLista($conn, $row['idDgoInstrucci'], $row['orientacion'], $row['idDgoVisita']);
								?>
							<?php } ?>
							<tr>
								<td colspan="6" style="background-color:#E5E8ED;font-size:14px;text-align:center">
									<input type="hidden" name="idDgoActUnidad" value="<?php echo $idDgoActUnidad ?>">
									<input type="hidden" name="idGenPersona" value="<?php echo $idGenPersona ?>">
								</td>
								<input type="hidden" name="idDgoVisita" value="<?php echo $idDgoVisita ?>"></td>
							</tr>
							<tr>
								<td colspan="6" style="text-align:center"><label>
										<input type="button" name="Submit" value="Enviar Respuestas" onclick="validate_form(this)" style="height:40px" />
									</label></td>
							</tr>
							<tr>
								<td colspan="6" style="height:20px">&nbsp;</td>
							</tr>
						</table>
					</form>
					<div class="col3" style="width:600px;margin:0 auto; background-color:#c33;color:#ffff00;text-align:center;display:block;font-family:Verdana;font-size:12px" id="message">
						<?php
						if ($puntos > 0) {
							$deCien = round($puntos * 100 / $maximo, 2);
							echo $puntos . ' Puntos de un total de ' . $maximo . ', que equivale a ' . $deCien . '/100 (Coeficiente :' . $instru . ')';
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div style="width:100%;height:30px;border-bottom:solid 10px #5A6571">&nbsp;</div>
</body>

</html>