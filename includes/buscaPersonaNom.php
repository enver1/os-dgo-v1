<?php
/*     Busqueda de personas por Apellidos y nombres en la Base de Datos del Registro Civil */
include '../../funciones/db_connect.inc.php';
include '../../funciones/funciones_ws.php';

$sqlV = "SELECT * FROM genUsuarioAplicacion a
	INNER JOIN genAplicacion b ON b.idGenAplicacion=a.idGenAplicacion AND b.idGenModulo='18' AND (b.url='modulos/investigador/wssiexp.php' or b.url='modulos/dna/wssiexp.php')
	WHERE a.idGenUsuario='" . $_SESSION['usuarioAuditar'] . "'";
//echo $_SESSION['usuarioAuditar'];
$rsV = $conn->query($sqlV);
if ($rowV = $rsV->fetch()) {
    ?>
	<link href="../../css/siipne3.css" rel="stylesheet" type="text/css" />
	<script>
	function seleccionar(c,t)
	{
	if(t=='C')
		{
			//parent.parent.document.querySelector("[name=tipoDocumento][value=C]").checked = true;
		}
		parent.parent.document.getElementById('cedulaPersonaC').value=c;
		parent.parent.buscaConductor();
		//parent.parent.document.getElementById('btnconsulta').onclick();
		parent.parent.GB_hide();
	}
	</script>
	<center>
	<div class="warningmess">
		<p>
			<strong> AYUDA: </strong> Para buscar una persona debe ingresar obligatoriamente un Apellido y un Nombre. luego de click en bUSCAR. Para seleccionar una persona de click en la <strong>C&eacute;dula</strong> correspondiente</p>
	</div>
	<div id='formpersona'>
		<!--<form name="persona"  id="persona" method="post" action="busca3.php">-->
		<form name="persona"  id="persona" method="post" action="buscaPersonaNom.php">
		<table width="700" border="0" cellspacing="5">
			<tr>
				<td colspan="4" class="Estilo2">
					<strong>Ejemplos:</strong><br /><strong>1.-</strong> CAYAMBE JUAN CARLOS (Un apellido dos nombres)<br /><strong>2.-</strong> CAYAMBE SUAREZ JUAN (Dos apellidos un nombre)<br /><strong>3.-</strong> CAYAMBRE SUAREZ JUAN CARLOS (Dos apellidos dos nombres)<BR /><strong>NOTA:</strong>Cualquiera de los numerales de busqueda son válidos. Recuerde debe ingresar primero apellidos y luego nombres, el sistema establecera como Apellido paterno al primero ingresado
				</td>
			</tr>
			<tr>
				<td width="151" class="Estilo1">Apellido Paterno:</td>
			  <td width="730"><input type="text" name="ape1" id="ape1" value="" class="inputSombra" style="width:200px;text-transform:uppercase;" onKeyUp="javascript:this.value=this.value.toUpperCase();" /></td>
			</tr>
			<tr>
				<td width="151" class="Estilo1">Apellido Materno:</td>
			  <td width="730"><input type="text" name="ape2" id="ape2" value="" class="inputSombra" style="width:200px;text-transform:uppercase;" onKeyUp="javascript:this.value=this.value.toUpperCase();" /></td>
			</tr>
			<tr>
				<td width="151" class="Estilo1">Primer Nombres:</td>
			  <td width="730"><input type="text" name="nom1" id="nom1" value="" class="inputSombra" style="width:200px;text-transform:uppercase;" onKeyUp="javascript:this.value=this.value.toUpperCase();" /></td>
			</tr>
			<tr>
				<td width="151" class="Estilo1">Segundo Nombre:</td>
			  <td width="730"><input type="text" name="nom2" id="nom2" value="" class="inputSombra" style="width:200px;text-transform:uppercase;" onKeyUp="javascript:this.value=this.value.toUpperCase();" /></td>
			</tr>
			<tr>
				<td colspan="2"><input name="btnBuscar" type="submit" class="boton_general" value="Consultar" /></td>
			</tr>
		</table>
	</form>
	<?php
if (isset($_POST['btnBuscar'])) {
        $cont = 0;
        $ape1 = strip_tags(isset($_POST['ape1']) ? $_POST['ape1'] : '');
        $ape2 = strip_tags(isset($_POST['ape2']) ? $_POST['ape2'] : '');
        $nom1 = strip_tags(isset($_POST['nom1']) ? $_POST['nom1'] : '');
        $nom2 = strip_tags(isset($_POST['nom2']) ? $_POST['nom2'] : '');
        if (!empty($ape1)) {$cont++;}
        if (!empty($ape2)) {$cont++;}
        if (!empty($nom1)) {$cont++;}
        if (!empty($nom2)) {$cont++;}
        if ($cont >= 3) {
            $nombresRc = consultaPorNombresRegistroCivilFN($ape1, $ape2, $nom1, $nom2, $edadI = '', $edadF = '', $sexo = '', $click = true);
            echo $nombresRc;
        } else {
            echo '<center><span class="Estilo2">Consulta no permitida, debe buscar al menos un apellido y dos nombres o dos apellidos y un nombre</span></center>';
        }
    }
    ?>
	</div>
	</center>
	<?php
}
/*}
else
{
echo 'Busco por nombres siipne';
}
 */
?>


