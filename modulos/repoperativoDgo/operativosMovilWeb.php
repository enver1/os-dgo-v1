<?php
if (!isset($_SESSION)) {
	session_start();
}
$nArchivo = "Operativos_" . $_GET['fini'] . "_" . $_GET['ffin'] . ".xlsx";
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=" . $nArchivo);
header("Pragma: no-cache");
header("Expires: 0");
include '../../../clases/autoload.php';
$conn = DB::getConexionDB();
?>
<style type="text/css">
<!--
.xl65
 {mso-style-parent:style0;
 mso-number-format:"\@";}
 .texto_Anun {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: #000000;
	text-decoration: none;
	text-align: center;
	vertical-align: middle;
	height: 18px;
	letter-spacing: 2px;
}


</style>

<?php
function specialChars($texto = '')
{
	$p = array('/á/', '/é/', '/í/', '/ó/', '/ú/', '/Á/', '/É/', '/Í/', '/Ó/', '/Ú/', '/à/', '/è/', '/ì/', '/ò/', '/ù/', '/ñ/', '/Ñ/');
	$r = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'n', 'N');
	$x = preg_replace($p, $r, $texto);
	return $x;
}
function imprimeTabla($rowT, $tCuadro, $funcion, $fecha, $cols = 0, $headers = array(), $data = array())
{
	$ht = '<table id="my-tbl" width="100%" border="1">
<tr><td colspan="' . $cols . '"><span style="font-size:14px;font-weight:bold;color:#d61818">' . $tCuadro . '</span></td>
<tr >';
	foreach ($headers as $head) {
		$ht .= '<th class="data-th">' . $head . '</th>';
	}

	$ht .= '</tr>';
	//loop por cada registro tomando los campos delarreglo $gridS
	$tot = 0;

	foreach ($rowT as $row) {
		$co = 0;
		foreach ($data as $datos) {
			if ($co < 14) {
				$ht .= '<td  align="left" class="xl65">' . specialChars($row[$datos]) . '</td>';
			} else {
				$ht .= '<td  align="left" >' . specialChars($row[$datos]) . '</td>';
			}
			$co++;
		}
		$ht .= '</tr>';
	}
	$ht .= '</table>';
	echo $ht;
}




if (!empty($_GET['op']) and !empty($_GET['fini']) and !empty($_GET['ffin'])) {
	$ini = $_GET['fini'];
	$fin = $_GET['ffin'];
	$fini = $ini . " " . "00:00:01";
	$ffin = $fin . ' 23:59:59';


	//print_r($_GET['cuadro']);
	$cuadro = "";
	if (!empty($_GET['cuadro'])) {
		$cuadro = " and idDntJefTransi=" . $_GET['cuadro'];
	}
	$tCuadro = '';

	switch ($_GET['op']) {
		case 1:



			break;

		case 4: /* Reporte encabezado de operativos*/
			$sql = "select e.idHdrEvento,t.descripcion tipo,ts.descripcion forma,g.idGenGeoSenplades,z.descripcion zona,sz.descripcion subzona,d.descripcion distrito,c.descripcion circuito,g.descripcion subcir , ";
			$sql .= "p.apenom,date(e.fechaEvento) fecha,time(e.fechaEvento)hora,e.latitud,e.longitud,concat_ws(' ',e.callePrincipal,e.calleSecundaria) dir ";
			$sql .= ",0 personas,0 vehiculos,0 perregis,0 perindo,0 perdet,0 citaentre,0 vehirevi,0 vehireteni,0 vehirecup,0 retpolari,0 placnoregla,0 motorevizada ";
			$sql .= "from hdrEvento e left join genGeoSenplades g on g.idGenGeoSenplades=e.idGenGeoSenplades ";
			$sql .= "inner join genGeoSenplades AS c ON g.gen_idGenGeoSenplades=c.idGenGeoSenplades ";
			$sql .= "inner join genGeoSenplades AS d ON c.gen_idGenGeoSenplades=d.idGenGeoSenplades ";
			$sql .= "inner join genGeoSenplades AS sz ON d.gen_idGenGeoSenplades=sz.idGenGeoSenplades ";
			$sql .= "inner join genGeoSenplades AS z ON sz.gen_idGenGeoSenplades=z.idGenGeoSenplades ";
			$sql .= "inner join genPersona p on p.idGenPersona=e.idGenPersona ";
			$sql .= "inner join  hdrTipoServicio ts on e.idHdrTipoServicio=ts.idHdrTipoServicio ";
			$sql .= "inner join genTipoTipificacion t on t.idGenTipoTipificacion=e.idGenTipoTipificacion  where e.fechaEvento between '$fini' and '$ffin' and e.idHdrTipoServicio=4 order by e.idHdrEvento desc";
			$fecha = "FECHA NACIMIENTO";
			$funcion = "FUNCION";
			$header = array('FROT', 'TIPO DE OPERATIVO', 'FORMA', 'CODIGO SUBCIRCUITO', 'ZONA', 'SUBZONA', 'DISTRITO', 'CIRCUITO', 'SUBCIRCUITO', 'QUIEN HACE OPERATIVO', 'FECHA OPERATIVO', 'HORA', 'LATITUD', 'LONGITUD', 'DIRECCION', 'PERSONAS', 'VHEÍCULOS', 'PERSONAS REGISTRADAS', 'PERSONAS INDOCUMENTADAS', 'PERSONAS DETENIDAS', 'PERSONAS CITACITADAS', 'VEHÍCULOS REVIZADOS', 'VEHÍCULOS RETENIDOS', 'VEHÍCULOS REVIZADOS RECUPERADOS', 'RETIRO DE POLARIZADOS', 'PLACAS NO REGLAMENTARIAS', 'MOTOCICLETAS REVIZADAS');
			$data = array('idHdrEvento', 'tipo', 'forma', 'idGenGeoSenplades', 'zona', 'subzona', 'distrito', 'circuito', 'subcir', 'apenom', 'fecha', 'hora', 'latitud', 'longitud', 'dir', 'personas', 'vehiculos', 'perregis', 'perindo', 'perdet', 'citaentre', 'vehirevi', 'vehireteni', 'vehirecup', 'retpolari', 'placnoregla', 'motorevizada');
			$rs = $conn->query($sql);
			$rowT = $rs->fetchAll();


			for ($i = 0; $i < count($rowT); $i++) {
				$sqlC = "select count(r.idGenPersona) totper from hdrEvento e inner join hdrEventoResum r on e.idHdrEvento=r.idHdrEvento where e.idHdrEvento=" . $rowT[$i]['idHdrEvento'];

				//echo $sqlC;
				$rsC = $conn->query($sqlC);
				if ($rowC = $rsC->fetch())
					$rowT[$i]['personas'] = $rowC['totper'];
			}

			for ($i = 0; $i < count($rowT); $i++) {
				$sqlC = "select count(r.idGenVehiculo) totveh from hdrEvento e inner join hdrEventoResum r on e.idHdrEvento=r.idHdrEvento where e.idHdrEvento=" . $rowT[$i]['idHdrEvento'];

				//echo $sqlC;
				$rsC = $conn->query($sqlC);
				if ($rowC = $rsC->fetch())
					$rowT[$i]['vehiculos'] = $rowC['totveh'];
			}

			for ($i = 0; $i < count($rowT); $i++) {
				$sqlC = "select count(r.idHdrTipoResum) numero from hdrEvento e inner join hdrEventoResum r on e.idHdrEvento=r.idHdrEvento where r.idHdrTipoResum='56' and e.idHdrEvento=" . $rowT[$i]['idHdrEvento'];

				//echo $sqlC;
				$rsC = $conn->query($sqlC);
				if ($rowC = $rsC->fetch())
					$rowT[$i]['perregis'] = $rowC['numero'];
			}


			for ($i = 0; $i < count($rowT); $i++) {
				$sqlC = "select count(r.idHdrTipoResum) numero from hdrEvento e inner join hdrEventoResum r on e.idHdrEvento=r.idHdrEvento where r.idHdrTipoResum='57' and e.idHdrEvento=" . $rowT[$i]['idHdrEvento'];

				//echo $sqlC;
				$rsC = $conn->query($sqlC);
				if ($rowC = $rsC->fetch())
					$rowT[$i]['perindo'] = $rowC['numero'];
			}

			for ($i = 0; $i < count($rowT); $i++) {
				$sqlC = "select count(r.idHdrTipoResum) numero from hdrEvento e inner join hdrEventoResum r on e.idHdrEvento=r.idHdrEvento where r.idHdrTipoResum='65' and e.idHdrEvento=" . $rowT[$i]['idHdrEvento'];

				//echo $sqlC;
				$rsC = $conn->query($sqlC);
				if ($rowC = $rsC->fetch())
					$rowT[$i]['perdet'] = $rowC['numero'];
			}

			for ($i = 0; $i < count($rowT); $i++) {
				$sqlC = "select count(r.idHdrTipoResum) numero from hdrEvento e inner join hdrEventoResum r on e.idHdrEvento=r.idHdrEvento where r.idHdrTipoResum='61' and e.idHdrEvento=" . $rowT[$i]['idHdrEvento'];

				//echo $sqlC;
				$rsC = $conn->query($sqlC);
				if ($rowC = $rsC->fetch())
					$rowT[$i]['citaentre'] = $rowC['numero'];
			}

			for ($i = 0; $i < count($rowT); $i++) {
				$sqlC = "select count(r.idHdrTipoResum) numero from hdrEvento e inner join hdrEventoResum r on e.idHdrEvento=r.idHdrEvento where r.idHdrTipoResum='58' and e.idHdrEvento=" . $rowT[$i]['idHdrEvento'];

				//echo $sqlC;
				$rsC = $conn->query($sqlC);
				if ($rowC = $rsC->fetch())
					$rowT[$i]['vehirevi'] = $rowC['numero'];
			}



			for ($i = 0; $i < count($rowT); $i++) {
				$sqlC = "select count(r.idHdrTipoResum) numero from hdrEvento e inner join hdrEventoResum r on e.idHdrEvento=r.idHdrEvento where r.idHdrTipoResum='64' and e.idHdrEvento=" . $rowT[$i]['idHdrEvento'];

				//echo $sqlC;
				$rsC = $conn->query($sqlC);
				if ($rowC = $rsC->fetch())
					$rowT[$i]['vehireteni'] = $rowC['numero'];
			}


			for ($i = 0; $i < count($rowT); $i++) {
				$sqlC = "select count(r.idHdrTipoResum) numero from hdrEvento e inner join hdrEventoResum r on e.idHdrEvento=r.idHdrEvento where r.idHdrTipoResum='69' and e.idHdrEvento=" . $rowT[$i]['idHdrEvento'];

				//echo $sqlC;
				$rsC = $conn->query($sqlC);
				if ($rowC = $rsC->fetch())
					$rowT[$i]['vehirecup'] = $rowC['numero'];
			}

			for ($i = 0; $i < count($rowT); $i++) {
				$sqlC = "select count(r.idHdrTipoResum) numero from hdrEvento e inner join hdrEventoResum r on e.idHdrEvento=r.idHdrEvento where r.idHdrTipoResum='4' and e.idHdrEvento=" . $rowT[$i]['idHdrEvento'];

				//echo $sqlC;
				$rsC = $conn->query($sqlC);
				if ($rowC = $rsC->fetch())
					$rowT[$i]['retpolari'] = $rowC['numero'];
			}

			for ($i = 0; $i < count($rowT); $i++) {
				$sqlC = "select count(r.idHdrTipoResum) numero from hdrEvento e inner join hdrEventoResum r on e.idHdrEvento=r.idHdrEvento where r.idHdrTipoResum='60' and e.idHdrEvento=" . $rowT[$i]['idHdrEvento'];

				//echo $sqlC;
				$rsC = $conn->query($sqlC);
				if ($rowC = $rsC->fetch())
					$rowT[$i]['placnoregla'] = $rowC['numero'];
			}
			for ($i = 0; $i < count($rowT); $i++) {
				$sqlC = "select count(r.idHdrTipoResum) numero from hdrEvento e inner join hdrEventoResum r on e.idHdrEvento=r.idHdrEvento where r.idHdrTipoResum='59' and e.idHdrEvento=" . $rowT[$i]['idHdrEvento'];

				//echo $sqlC;
				$rsC = $conn->query($sqlC);
				if ($rowC = $rsC->fetch())
					$rowT[$i]['motorevizada'] = $rowC['numero'];
			}


			$tCuadro = 'Reportes de Operativos <br>Fecha Inicial: ' . $_GET['fini'] . ' Fecha Final: ' . $_GET['ffin'];
			//print_r($rowT['tipo']);
			imprimeTabla($rowT, $tCuadro, $funcion, $fecha, 25, $header, $data);


			$tCuadro = '<br><br>Anexo de Personas';
			$sql = "select e.idHdrEvento,p.documento,p.apenom,p.sexo,p.fechaNacimiento,r.descEventoResum,t.desHdrTipoResum,concat_ws('-',ar.descMarcJurid,mj.descMarcJurid)articulo,case r.detBusqueda ";
			$sql .= "when 'TIENE ORDEN DE CAPTURA' then 'TIENE ORDEN DE CAPTURA' ";
			$sql .= "when 'ORDEN DE CAPTURA VIGENTE' then 'ORDEN DE CAPTURA VIGENTE' ";
			$sql .= "end as prioridad from hdrEvento e ";
			$sql .= "inner join hdrEventoResum r on e.idHdrEvento=r.idHdrEvento ";
			$sql .= "left  join genMarcJurid mj on mj.idGenMarcJurid=r.idGenMarcJurid ";
			$sql .= "left join genMarcJurid ar on mj.gen_idGenMarcJurid=ar.idGenMarcJurid ";
			$sql .= "inner join hdrTipoResum t  on t.idHdrTipoResum=r.idHdrTipoResum ";
			$sql .= "inner join v_persona p on r.idGenPersona=p.idGenPersona where  e.fechaEvento between '$fini' and '$ffin' and e.idHdrTipoServicio=4 order by e.idHdrEvento desc ";
			//echo $sql;
			$header = array('ID OPERATIVO', 'CEDULA', 'NOMBRES', 'SEXO', 'FECHA DE NACIMIENTO', 'DATOS LICENCIA', 'ACCIÓN DE REGISTRO', 'ARTICULO', 'NOVEDAD');
			$data = array('idHdrEvento', 'documento', 'apenom', 'sexo', 'fechaNacimiento', 'descEventoResum', 'desHdrTipoResum', 'articulo', 'prioridad');
			$rs = $conn->query($sql);
			$rowT = $rs->fetchAll();
			imprimeTabla($rowT, $tCuadro, $funcion, $fecha, 9, $header, $data);

			$tCuadro = '<br><br>Anexo de vehiculos';
			$sql = "select e.idHdrEvento,v.placa,v.motor,v.chasis,v.marca,v.modelo,v.anoFabricacion,v.clase,v.descServicio,t.desHdrTipoResum, case r.detBusqueda ";
			$sql .= "when 'ROBADO' then 'ROBADO' ";
			$sql .= "end as prio from hdrEvento e inner join hdrEventoResum r on e.idHdrEvento=r.idHdrEvento ";
			$sql .= "inner join hdrTipoResum t  on t.idHdrTipoResum=r.idHdrTipoResum ";
			$sql .= "inner join v_vehiculo_gen v on r.idGenVehiculo=v.idGenVehiculo where e.fechaEvento between '$fini' and '$ffin' and  e.idHdrTipoServicio=4 order by e.idHdrEvento desc ";
			//echo $sql;
			$header = array('ID OPERATIVO', 'PLACA', 'MOTOR', 'CHASIS', 'MARCA', 'MODELO', 'FABRICA', 'CLASE', 'SERVICIO', 'TIPO DE ACCION', 'NOVEDAD');
			$data = array('idHdrEvento', 'placa', 'motor', 'chasis', 'marca', 'modelo', 'anoFabricacion', 'clase', 'descServicio', 'desHdrTipoResum', 'prio');
			$rs = $conn->query($sql);
			$rowT = $rs->fetchAll();
			imprimeTabla($rowT, $tCuadro, $funcion, $fecha, 10, $header, $data);
			$tCuadro = '<br><br>Anexo de Totales de Novedades';
			$sql = "select r.detBusqueda, count(r.detBusqueda) cantidad from hdrEvento e inner join  hdrEventoResum r on e.idHdrEvento=r.idHdrEvento ";
			$sql .= "inner join hdrTipoResum t on r.idHdrTipoResum=t.idHdrTipoResum ";
			$sql .= "where  e.fechaEvento between '$fini' and '$ffin' and e.idHdrTipoServicio=4 ";
			$sql .= "and (r.detBusqueda='ROBADO' or r.detBusqueda='TIENE ORDEN DE CAPTURA' or r.detBusqueda='ORDEN DE CAPTURA VIGENTE') group by r.detBusqueda ";

			$header = array('NOMBRE NOVEDAD', 'CANTIDAD');
			$data = array('detBusqueda', 'cantidad');
			$rs = $conn->query($sql);
			$rowT = $rs->fetchAll();
			imprimeTabla($rowT, $tCuadro, $funcion, $fecha, 2, $header, $data);

			break;
	}
} else {
	echo 'No ha seleccionado opciones';
}

?>