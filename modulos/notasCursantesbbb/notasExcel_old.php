<?php
//print_r($_GET);
//die("ok");
ob_start("ob_gzhandler");
if (!isset($_SESSION)){ session_start();}
$nArchivo="Encargo_".$_GET['fini']."_".$_GET['ffin'].".xls";
header('Content-type: application/vnd.ms-excel charset=utf-8');
header("Content-Disposition: attachment;filename=".$nArchivo);
header("Pragma: no-cache");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
include '../../../funciones/db_connect.inc.php';

//ini_set('max_execution_time', '1200');
function specialChars($texto='')
{
	$p = array('/á/','/é/','/í/','/ó/','/ú/','/Á/','/É/','/Í/','/Ó/','/Ú/','/à/','/è/','/ì/','/ò/','/ù/','/ñ/','/Ñ/');
  	$r = array('a','e','i','o','u','A','E','I','O','U','a','e','i','o','u','n','N');
  	$x=preg_replace($p, $r, $texto);
	return $x;
}


function imprimeTabla($rowT,$tCuadro,$funcion,$fecha,$cols=0,$headers=array(),$data=array())
{

	$ht='<table id="my-tbl" width="100%" border="1">
	<tr><td colspan="" align="center"><span style="font-size:14px;font-weight:bold;color:#d61818">CURSANTES</span></td>
		<td colspan="13" align="center"><span style="font-size:14px;font-weight:bold;color:#d61818">NIVEL VIOLENCIA E INSEGURIDAD</span></td>
		<td colspan="13" align="center"><span style="font-size:14px;font-weight:bold;color:#d61818">PRODUCTIVIDAD</span></td>
	<tr>';
	foreach($headers as $head) 
	{
		$ht.='<th class="data-th">'.$head.'</th>';
	}
	$ht.='</tr>';

	//loop por cada registro tomando los campos delarreglo $gridS
	foreach ($rowT as $key => $cursante) {
	//for ($i=0; $i < count($rowT); $i++) { 
		$sumaVioDelin=0;
		$sumaProduc=0;
		$totalVioDelin=0;
		$totalProduc=0;
		$ht.='<tr>';

		$nombre = current(array_column($cursante,'apenom'));
		$ht.='<td align="left">'.$nombre.'</td>';

		for ($i=1; $i <=12 ; $i++) {

			if (array_key_exists($i, $cursante)) {

				$ht.='<td align="left">'.number_format($cursante[$i]['resultVioDelin'],3).'</td>';
				
				if (!empty($cursante[$i]['resultVioDelin'])) {
					$totalVioDelin++;
				  	$sumaVioDelin+=$cursante[$i]['resultVioDelin'];
				}

			}else{

				$ht.='<td align="left">0</td>';

			}

			if ($i+1==13) {
				$notaVioDelin = $sumaVioDelin/$totalVioDelin;
				$ht.='<td align="left" bgcolor="#F7FE2E">'.number_format($notaVioDelin,3).'</td>';
			}
		}

		for ($i=1; $i <=12 ; $i++) {

			if (array_key_exists($i, $cursante)) {

				$ht.='<td align="left">'.number_format($cursante[$i]['resultProduc'],3).'</td>';
				
				if (!empty($cursante[$i]['resultProduc'])) {
					$totalProduc++;
				  	$sumaProduc+=$cursante[$i]['resultProduc'];
				}

			}else{

				$ht.='<td align="left">0</td>';

			}

			if ($i+1==13) {
				$notaProduc = $sumaProduc/$totalProduc;
				$ht.='<td align="left" bgcolor="#F7FE2E">'.number_format($notaProduc,3).'</td>';
			}
		}

		$notaFinal = (11*($notaVioDelin+$notaProduc))/20;
		$ht.='<td align="left" bgcolor="#00FF00">'.number_format($notaFinal,3).'</td>';
	$ht.='</tr>';
}

echo $ht;
}





if(!empty($_GET['anio'])) {

	$ini=$_GET['fini'];
	$fin=$_GET['ffin'];
	$fini=$ini." "."00:00:01";
	$ffin=$fin.' 23:59:59';
	$geo=$_GET['geosem'];

	$sqlI="SELECT a.campoTabla, b.regla, a.datoCalif FROM dgoIndicador a, dgoEjeNivel b WHERE a.idDgoEjeNivel=b.idDgoEjeNivel";
	$rsI=$conn->query($sqlI);
	$rowI=$rsI->fetchAll(PDO::FETCH_ASSOC);

	for ($x=0; $x < count($rowI); $x++) { 
		if($rowI[$x]['regla']==='I'){
			$indicadores[0][]=$rowI[$x];	
		}
		elseif($rowI[$x]['regla']==='D'){
			$indicadores[1][]=$rowI[$x];
		}	
	}


	$datos=array();

	$i=0;
	$d=0;

	$grupo5=0;
	$stG5='';
	$grupo4=0;
	$stG4='';
	$grupo3=0;
	$stG3='';
	$grupo2=0;
	$stG2='';
	$grupo1=0;
	$stG1='';


	$calculo=false;
	$concat='';

	$vioDelin='';
	$productividad='';

	$sqlR='select a.idGenGeoSenplades,gp.codigoSenplades, ';

	for ($x=0; $x < count($indicadores); $x++) { 

		for ($y=0; $y < count($indicadores[$x]); $y++) {

			if($indicadores[$x][$y]['regla']==='I'){
				$i++;
				$calculo=true;
				if ($y==0) {
					$vioDelin.=" ( IF(c.".$indicadores[$x][$y]['campoTabla']."<=((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2),".$indicadores[$x][$y]['datoCalif'].",((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2)*".$indicadores[$x][$y]['datoCalif']."/c.".$indicadores[$x][$y]['campoTabla'].") ";
				} else {
					$vioDelin.=" + IF(c.".$indicadores[$x][$y]['campoTabla']."<=((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2),".$indicadores[$x][$y]['datoCalif'].",((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2)*".$indicadores[$x][$y]['datoCalif']."/c.".$indicadores[$x][$y]['campoTabla'].") ";
				}
			}
			elseif($indicadores[$x][$y]['regla']==='D'){

				$calculo=false;

				switch ($indicadores[$x][$y]['datoCalif']) {
							case 5:
								$grupo5++;

								if ($y==0 or $grupo5==1) {
									$stG5.="IF(c.".$indicadores[$x][$y]['campoTabla'].">=((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2),".$indicadores[$x][$y]['datoCalif'].",".$indicadores[$x][$y]['datoCalif']." * c.".$indicadores[$x][$y]['campoTabla']." / ((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2)) ";
								} else {
									$stG5.=" + IF(c.".$indicadores[$x][$y]['campoTabla'].">=((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2),".$indicadores[$x][$y]['datoCalif'].",".$indicadores[$x][$y]['datoCalif']." * c.".$indicadores[$x][$y]['campoTabla']." / ((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2)) ";
								}

								break;
							case 4:
								$grupo4++;

								if ($y==0 or $grupo4==1) {
									$stG4.="IF(c.".$indicadores[$x][$y]['campoTabla'].">=((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2),".$indicadores[$x][$y]['datoCalif'].",".$indicadores[$x][$y]['datoCalif']." * c.".$indicadores[$x][$y]['campoTabla']." / ((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2)) ";
								} else {
									$stG4.=" + IF(c.".$indicadores[$x][$y]['campoTabla'].">=((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2),".$indicadores[$x][$y]['datoCalif'].",".$indicadores[$x][$y]['datoCalif']." * c.".$indicadores[$x][$y]['campoTabla']." / ((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2)) ";
								}

								break;
							case 3:
								$grupo3++;

								if ($y==0 or $grupo3==1) {
									$stG3.="IF(c.".$indicadores[$x][$y]['campoTabla'].">=((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2),".$indicadores[$x][$y]['datoCalif'].",".$indicadores[$x][$y]['datoCalif']." * c.".$indicadores[$x][$y]['campoTabla']." / ((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2)) ";
								} else {
									$stG3.=" + IF(c.".$indicadores[$x][$y]['campoTabla'].">=((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2),".$indicadores[$x][$y]['datoCalif'].",".$indicadores[$x][$y]['datoCalif']." * c.".$indicadores[$x][$y]['campoTabla']." / ((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2)) ";
								}

								break;
							case 2:
								$grupo2++;

								if ($y==0 or $grupo2==1) {
									$stG2.="IF(c.".$indicadores[$x][$y]['campoTabla'].">=((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2),".$indicadores[$x][$y]['datoCalif'].",".$indicadores[$x][$y]['datoCalif']." * c.".$indicadores[$x][$y]['campoTabla']." / ((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2)) ";
								} else {
									$stG2.=" + IF(c.".$indicadores[$x][$y]['campoTabla'].">=((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2),".$indicadores[$x][$y]['datoCalif'].",".$indicadores[$x][$y]['datoCalif']." * c.".$indicadores[$x][$y]['campoTabla']." / ((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2)) ";
								}

								break;
							case 1:
								$grupo1++;

								if ($y==0 or $grupo1==1) {
									$stG1.="IF(c.".$indicadores[$x][$y]['campoTabla'].">=((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2),".$indicadores[$x][$y]['datoCalif'].",".$indicadores[$x][$y]['datoCalif']." * c.".$indicadores[$x][$y]['campoTabla']." / ((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2)) ";
								} else {
									$stG1.=" + IF(c.".$indicadores[$x][$y]['campoTabla'].">=((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2),".$indicadores[$x][$y]['datoCalif'].",".$indicadores[$x][$y]['datoCalif']." * c.".$indicadores[$x][$y]['campoTabla']." / ((a.".$indicadores[$x][$y]['campoTabla']." + b.".$indicadores[$x][$y]['campoTabla'].") / 2)) ";
								}

								break;
						}

				
			}
		}


		if (!empty($stG5)) {
			$productividad.=" ((".$stG5.")/".$grupo5.") + ";
		} 
		if (!empty($stG4)) {
			$productividad.=" ((".$stG4.")/".$grupo4.") + ";
		} 
		if (!empty($stG3)) {
			$productividad.=" ((".$stG3.")/".$grupo3.") + ";
		} 
		if (!empty($stG2)) {
			$productividad.=" ((".$stG2.")/".$grupo2.") + ";
		}	
		if (!empty($stG1)) {
			$productividad.=" ((".$stG1.")/".$grupo1.")  ";
		}	
	}

	$vioDelin.=" )/".$i." as resultVioDelin, ";
	$productividad.="  as resultProduc ";

	$sqlR.="".$vioDelin." ".$productividad.", a.idGenMes from dgoDatos a
	left join dgoDatos b on a.idGenGeoSenplades=b.idGenGeoSenplades and a.idGenMes=b.idGenMes and b.anio=".($_GET['anio']-1)."
	LEFT JOIN dgoDatos c ON a.idGenGeoSenplades = c.idGenGeoSenplades AND a.idGenMes = c.idGenMes AND c.anio = ".($_GET['anio'])." 
	join genGeoSenplades gp on a.idGenGeoSenplades=gp.idGenGeoSenplades
	where a.anio=".($_GET['anio']-2)." ORDER BY gp.codigoSenplades, a.idGenMes";

	$rsR=$conn->query($sqlR);
			
	$datos=array_chunk($rsR->fetchAll(PDO::FETCH_ASSOC), 12);

	//SQL trae los datos de las asignaciones de los cursantes
	$sqlC="SELECT
			a.idGenGeoSenplades,
			a.idGenPersona,
			CONCAT_WS(' ', gr.siglas, gp.apenom) apenom,
			a.senplades,
			a.meses
		FROM
			dgoAsignacion a
		LEFT JOIN genPersona gp ON gp.idGenPersona = a.idGenPersona
		LEFT JOIN dgpResumenPersonal rp ON rp.idGenPersona = gp.idGenPersona
		LEFT JOIN dgpAscenso pa ON pa.idDgpAscenso = rp.idDgpAscenso
		LEFT JOIN dgpGrado gr ON gr.idDgpGrado = pa.idDgpGrado
		WHERE
			a.idGenPersona = gp.idGenPersona
		ORDER BY
			a.idGenPersona";

	$rsC=$conn->query($sqlC);
	$cursantes=$rsC->fetchAll(PDO::FETCH_ASSOC);


	$arrayCursantes=array();

	//Extrae los Key del arreglo cursantes
	$keyCursante=array_unique(array_column($cursantes, 'idGenPersona'));

	//Crea un arreglo ordenando la informacion de asignaciones por cursante
	foreach ($keyCursante as $keyC => $valueC) {
		$keyDC=array(); 
		$keyDC=array_keys(array_column($cursantes,'idGenPersona'),$keyCursante[$keyC]);
		for ($j=0; $j < count($keyDC); $j++) { 
			$arrayCursantes[$valueC][]=$cursantes[$keyDC[$j]];
		}
	}

	$arrayCursCalif = array();

	foreach ($arrayCursantes as $key => $value) {

		//Recorre el arreglo del cursante
		for ($i=0; $i < count($arrayCursantes[$key]); $i++) {

			if ($arrayCursantes[$key][$i]['senplades']==5) {
				//Recorre el arreglo de calificaciones de los subcircuitos
				for ($j=0; $j < count($datos); $j++) { 
					$senpladesArray = array();
					$senpladesArray = array_keys(array_column($datos[$j], 'idGenGeoSenplades'), $arrayCursantes[$key][$i]['idGenGeoSenplades']);

				//Si encuentra el idGenGeoSenplades forma el arreglo con las calificaciones
					if (!empty($senpladesArray)) {
						$arrayMeses = array();
						$arrayMeses = explode(',', $arrayCursantes[$key][$i]['meses']);

				//Recorre los meses que ha sido asignado el cursante en ese subcircuito
						foreach ($arrayMeses as $keyM => $valueM) {
							$keyMes = array_search($valueM, array_column($datos[$j], 'idGenMes'));
							//$arrayCursCalif[$key][$valueM]=$datos[$j][$keyMes];
							$arrayCursCalif[$key][$valueM]=array(
												'idGenGeoSenplades'=>$datos[$j][$keyMes]['idGenGeoSenplades'],
												'apenom'=>$arrayCursantes[$key][$i]['apenom'],
												'resultVioDelin'=>$datos[$j][$keyMes]['resultVioDelin'],
												'resultProduc'=>$datos[$j][$keyMes]['resultProduc'],
												'idGenMes'=>$valueM
											);
						}
					
					}
				
				}
			} elseif($arrayCursantes[$key][$i]['senplades']==4) {
				$sqlCir="SELECT idGenGeoSenplades FROM genGeoSenplades WHERE gen_idGenGeoSenplades=".$arrayCursantes[$key][$i]['idGenGeoSenplades']."";

				$rsCir=$conn->query($sqlCir);
				$arraySubCir=$rsCir->fetchAll(PDO::FETCH_ASSOC);

				$arrayMeses = array();
				$arrayMeses = explode(',', $arrayCursantes[$key][$i]['meses']);

				//Recorre los meses que ha sido asignado el cursante en ese subcircuito
				foreach ($arrayMeses as $keyM => $valueM) {

					$califMesVD=0;
					$califMesPro=0;

					foreach ($arraySubCir as $keySubCir => $valueSubCir) {

						//Recorre el arreglo de calificaciones de los subcircuitos
						for ($j=0; $j < count($datos); $j++) { 
							
							$senpladesArray = array();
							$senpladesArray = array_keys(array_column($datos[$j], 'idGenGeoSenplades'), $arraySubCir[$keySubCir]['idGenGeoSenplades']);

							//Si encuentra el idGenGeoSenplades extrae el valor y lo suma
							if (!empty($senpladesArray)) {
								
								$keyMes = array_search($valueM, array_column($datos[$j], 'idGenMes'));

								$califMesVD  += $datos[$j][$keyMes]['resultVioDelin'];
								$califMesPro += $datos[$j][$keyMes]['resultProduc'];
							
							}
							
						}
						
					}

					$arrayCursCalif[$key][$valueM]=array(
												'idGenGeoSenplades'=>$arrayCursantes[$key][$i]['idGenGeoSenplades'],
												'apenom'=>$arrayCursantes[$key][$i]['apenom'],
												'resultVioDelin'=>$califMesVD/count($arraySubCir),
												'resultProduc'=>$califMesPro/count($arraySubCir),
												'idGenMes'=>$valueM
											);	
				}

			}

		}	
	}


	$fecha="";
	$funcion="FUNCION";
	$tCuadro='TRASLADO DE VALORES DESDE '.$ini.' HASTA '.$fin;
	$header=array('Apellidos y Nombres','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre','Promedio','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre','Promedio','Nota Final');
	//$data=array('idUpcTrasladoV','zona','subzona','distrito','circuito','subcircuito','descripcion','documento','apenom','siglas','nomPolicia','observacion','fechaOrigen','horaOrigen','fechaDestino','horaDestino','longitudOrigen','latitudOrigen','longitudDestino','latitudDestino');
	//$rs=$conn->query($sql);
	//$rowT=$rs->fetchAll();
	imprimeTabla($arrayCursCalif,$tCuadro,$funcion,$fecha,20,$header,$data);

}
else
{
	echo 'No ha seleccionado opciones';
}
ob_end_flush();
?>