<?php
$dt         = new DateTime('now', new DateTimeZone('America/Guayaquil'));
$hoyA       = $dt->format('Y');
$directorio = 'operativossu';
$encuentra  = false;
if (file_exists('../funciones/db_connect.inc.php')) {
    //die('path1');
    //    echo 'Path 1';
    include_once '../funciones/db_connect.inc.php';
    include_once '../funciones/funcion_select.php';
    include_once '../clases/autoload.php';
}
if (file_exists('../../../funciones/db_connect.inc.php')) {
//    echo 'Path 3';
    include_once '../../../funciones/db_connect.inc.php';
    include_once '../../../funciones/funcion_select.php';
    include_once '../../../clases/autoload.php';
    $encuentra = true;
}

$formPareto = new FormPareto();
$hdrEvento  = new HdrEvento();
$senplades = new Senplades();

$gen_idGenGeoSenplades = ((isset($_GET['id'])) ? $_GET['id'] : 0);


$idGenGeoSenplades = 0;

if ($gen_idGenGeoSenplades > 0) {
	$data = $senplades->getGenGeoSenplades($conn, $gen_idGenGeoSenplades);
	$idGenGeoSenplades = (!empty($data['gen_idGenGeoSenplades']))?$data['gen_idGenGeoSenplades']:0;
}


$siglas                = 'OPSU%';
$anio                  = ((isset($_GET['anio'])) ? $_GET['anio'] : $dt->format('Y'));
$mes                   = ((isset($_GET['mes'])) ? $_GET['mes'] : 0);
$idGenTipoTipificacion = ((isset($_GET['tipo'])) ? $_GET['tipo'] : 0);
$estadoPolicia         = ((isset($_GET['estado'])) ? $_GET['estado'] : 0);
$titulo                = 'ESTADISTICAS DE OPERATIVOS POLICIALES DE SERVICIO URBANO';

$data = $hdrEvento->getTotalHdrEventoOSU($conn, $gen_idGenGeoSenplades, $siglas, $anio, $mes, $idGenTipoTipificacion, $estadoPolicia);

if (isset($_GET['tipo']) and $_GET['tipo'] > 0) {
    $sqlT = "select idGenTipoTipificacion, descripcion descTipoTipificacion from genTipoTipificacion where idGenTipoTipificacion=" . $_GET['tipo'];
    $rsT  = $conn->query($sqlT);
    $rowt = $rsT->fetch();
}

?>
<style>
.baret
{
	width:100px;
	height:20px;
	background-color:#bbb;
	color:#000;
	font-family:Verdana, Geneva, sans-serif;
	font-size:10px;
	text-align:center;
	border:solid 1px #333;
	 border-radius:8px;
	-moz-border-radius:8px;
	-webkit-border-radius:8px;
	}

.bar
{
	width:500px;
	height:40px;
	background-color:#F33;
	color:#111;
	font-family:Verdana, Geneva, sans-serif;
	font-size:10px;
	text-align:center;
	border:solid 2px #444;
	 border-radius:0 4px 4px 0;
	-moz-border-radius:0 4px 4px 0;
	-webkit-border-radius:0 4px 4px 0;
	-webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
	-moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
	box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);	}
a.barra
{
	text-decoration:none;
	border:none;
	color:#fff;
	}
.bar:hover
{
	background-color:#F9F;
	font-size:12px;
	}
.cuantos
{
	font-family:Verdana, Geneva, sans-serif;
	font-size:12px;
	font-weight:bold;
	padding-right:5px;
	}
.barMes
{
	width:500px;
	height:20px;
	background-color:#F33;
	color:#111;
	font-family:Verdana, Geneva, sans-serif;
	font-size:10px;
	text-align:center;
	border:solid 2px #444;
	 border-radius:0 4px 4px 0;
	-moz-border-radius:0 4px 4px 0;
	-webkit-border-radius:0 4px 4px 0;
}
.barMes:hover
{
	background-color:#F9F;
	font-size:12px;
	}

	</style>
<script>
$(function() {
	colorButon(<?php echo $anio ?>, <?php echo $mes ?>);
});

function colorButon(anio, mes) {
	for(i=0;i<=12;i++) {
		$('#b'+i).css('background-color','#555');
	}

	for(i=2014;i<=2050;i++) {
		$('#c'+i).css('background-color','#333');
	}

	$('#b'+mes).css('background-color','#F33');
	$('#c'+anio).css('background-color','#F33');
}

function selectAnio(a) {
 	$('#tAnio').val(a);
 	$('#subir').val(0);
 	entrar(0);
}

function selectMes(m) {
	$('#tMes').val(m);
	$('#subir').val(0);
	entrar(0);
}

function selectRadio()
{
	entrar(0);
}

function selectTipo()
{
	entrar(0);
}


function entrar(c)
{
	var id = c;
	var anio = $('#tAnio').val();
	var mes = $('#tMes').val();
	var estado = $('input[name=opera]:checked', '#edita').val();
	var tipo = $('#idGenTipoTipificacion').val();
	var subir = $('#subir').val();

	$('#forma').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
	$('#forma').load( 'modulos/operativossu/aplicacion.php?id='+c+'&mes='+mes+'&anio='+anio+'&tipo='+tipo+'&estado='+estado+'&subir='+subir);
}

</script>

<div id="forma">
	<?php echo $formPareto->getBotones(); ?>
	<form id="edita">
		<table width="100%" border="0" cellspacing="4" cellpadding="3">
			<tr>
				<td colspan="3">
					<input type="hidden" id="tAnio" value="<?php echo $anio ?>" />
					<input type="hidden" id="tMes" value="<?php echo $mes ?>" />
					<input type="hidden" id="subir" value="<?php echo $idGenGeoSenplades ?>" />
				</td>
			</tr>

			<tr>
				<td colspan="3" align="center">
					<input type="radio"  name="opera" value="3" <?php echo (isset($estadoPolicia) and $estadoPolicia == 3) ? 'checked' : '' ?> onClick="selectRadio()" checked>En Ejecuci&oacuten
					<input type="radio"  name="opera" value="5" <?php echo (isset($estadoPolicia) and $estadoPolicia == 5) ? 'checked' : '' ?> onClick="selectRadio()" >Finalizados
					<input type="radio"  name="opera" value="0" <?php echo (isset($estadoPolicia) and $estadoPolicia == 0) ? 'checked' : '' ?> onClick="selectRadio()">Todos
				</td>
			</tr>

			<tr>
				<td>Tipo de Operativo:</td>
				<td colspan="2">
					<table cellspacing="0"><tr><td>
						<input type="hidden" name="idGenTipoTipificacion"  id="idGenTipoTipificacion"
						value="<?php echo isset($rowt['idGenTipoTipificacion']) ? $rowt['idGenTipoTipificacion'] : '' ?>"/>
						<input type="text" name="descTipoTipificacion" id="descTipoTipificacion"
						value="<?php echo isset($rowt['descTipoTipificacion']) ? $rowt['descTipoTipificacion'] : '' ?>"  class="inputSombra"
						readonly="readonly" style="width: 560px" />
						</td><td><a href="funciones/arbolTipificacionSU.php?id=0&a=<?php echo (isset($_GET['anio']) ? $_GET['anio'] : $hoyA) ?>&m=<?php echo (isset($_GET['mes']) ? $_GET['mes'] : 13) ?>"  onclick="return GB_showPage('TIPOS DE OPERATIVOS', this.href)"><img src="../../../imagenes/treev.png" border="0" alt="Abrir"></a></td></tr>
					</table>
				</td>
			</tr>
		</table>
	</form>

	<?php

$color  = array('#dec8f2', '#f2cbc8', '#ebc8f2', '#c8f2e5', '#c9f2c8', '#fcf57e', '#927efc', '#fcaa7e', '#9ccde7', '#9ce79f', '#e7cc9c', '#e79cdf', '#adafd6', '#d6d4ad', '#f2d2c8', '#c8f2ed');
$maximo = 0;
foreach ($data as $key => $value) {
    if ($value['cuantos'] > $maximo) {
        $maximo = $value['cuantos'];
    }
}

$i = 0;
$total = 0;
?>

    <table width="100%" border="0" cellspacing="0" cellpadding="8">
        <tr><th colspan="3"><span class="texto_gris" style="font-size:18px"><?php echo $titulo ?></span></th></tr>
        <?php if ($gen_idGenGeoSenplades > 0): ?>
        	<tr>
	        	<td>
	        		<a href="javascript:void(0)" onClick="entrar(<?php echo $idGenGeoSenplades ?>)" class="barra"><div class="baret"><span>Subir</span></div></a>
	        	</td>
	        </tr>
        <?php endif?>

		<?php foreach ($data as $key => $value): ?>
            <tr>
            <td width="20%" class="etiqueta" ><span style="font-size:10px;font-family:Verdana"><?php echo $value['descripcion'] ?></span></td>
            <td style="background:url(../imagenes/cuadricula.jpg);border:solid 1px #999">

        <?php if ($value['cuantos'] > 0) {
    			$ancho = floor($value['cuantos'] * 680 / $maximo);
    			$total += $value['cuantos'];
    	?>
                <a href="javascript:void(0)" onClick="entrar(<?php echo $value['idGenGeoSenplades'] ?>)" class="barra">
                <div class="bar" style="text-align:right;background-color:<?php echo $color[$i] ?>;width:<?php echo $ancho ?>px"><p class="cuantos"><?php echo $value['cuantos'] ?></p></div>
                </a>
        <?php } else {
    $ancho = 2;?>
                <div class="bar" style="text-align:right;background-color:<?php echo $color[$i] ?>;width:<?php echo $ancho ?>px"><p class="cuantos"><?php echo $value['cuantos'] ?></p></div>
        <?php }?>

            </td><td>

        <?php if ($value['cuantos'] > 0) {?>
                <a href="modulos/operativossu/gmaps.php?geo=<?php echo $value['idGenGeoSenplades'] ?>&mes=<?php echo $mes ?>&anio=<?php echo $anio ?>&tipo=<?php echo $idGenTipoTipificacion ?>&estado=<?php echo $estadoPolicia ?>" onclick="return GB_showPage('Geolocalizaci&oacute;n de Operativos de Servicio Urbano', this.href)" ><img src="../imagenes/map.png" border="0" alt="0"></a>
         <?php } $i++; ?>

            </td></tr>
        <?php endforeach ?>
    </table>
	<div style="width:100%;border-bottom:solid 2px #777;padding-bottom:40px"><p align="right"><span class="texto_gris">Total Operativos: <?php echo $total ?></span></p></div>
</div>
