<?php

ob_start("ob_gzhandler");
if (!isset($_SESSION)){ session_start();}
$nArchivo="Operativos_".$_GET['fini']."_".$_GET['ffin'].".xls";
header('Content-type: application/vnd.ms-excel charset=utf-8');
header("Content-Disposition: attachment;filename=".$nArchivo);
header("Pragma: no-cache");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);

include '../../../funciones/db_connect.inc.php';
?>
<style type="text/css">

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
ini_set('max_execution_time', '5000');
 	
ini_set('memory_limit', '512M');
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
<tr><td colspan="'.$cols.'"><span style="font-size:14px;font-weight:bold;color:#d61818">'.$tCuadro.'</span></td>
<tr>';
	foreach($headers as $head)
	{
		$ht.='<th class="data-th">'.$head.'</th>';
		}

$ht.='</tr>';
	//loop por cada registro tomando los campos delarreglo $gridS
	$tot=0;
	foreach($rowT as $row){
		$co=0;
		foreach($data as $datos)
		{

			if($co<3 || $co >9){
			$ht.='<td  align="left" class="xl65">'.specialChars($row[$datos]).'</td>';
		}else{
			$ht.='<td  align="left" >'.specialChars($row[$datos]).'</td>';
		}
		$co++;

			}
		$ht.='</tr>';
	}
$ht.='</table>';
echo $ht;
}




if (!empty($_GET['op']) and !empty($_GET['fini']) and !empty($_GET['ffin'])) {
    $ini=$_GET['fini'];
    $fin=$_GET['ffin'];
    $fini=$ini." "."00:00:01";
    $ffin=$fin.' 23:59:59';
    $geo=$_GET['geosem'];
    $hdrEvento="hdrEvento2018";
    $hdrEventoResum="hdrEventoResum2018";


    //print_r($_GET['cuadro']);
    $cuadro="";
    if (!empty($_GET['cuadro'])) {
        $cuadro=" and idDntJefTransi=".$_GET['cuadro'];
    }
    $tCuadro='';

    /* Reporte encabezado de operativos*/
    $sql="select e.idHdrEvento,t.descripcion tipo,ts.descripcion forma,z.descripcion zona,sz.descripcion subzona,d.descripcion distrito,c.descripcion circuito, ";
    $sql.="docu.documento,p.apenom,date(e.fechaEvento) fecha,time(e.fechaEvento)hora,e.latitud,e.longitud,concat_ws(' ',e.callePrincipal,e.calleSecundaria) dir ";
    $sql.="from hdrEvento e left join genGeoSenplades g on g.idGenGeoSenplades=e.idGenGeoSenplades ";
    $sql.="INNER JOIN genGeoSenplades AS c ON g.gen_idGenGeoSenplades=c.idGenGeoSenplades ";
    $sql.="INNER JOIN genGeoSenplades AS d ON c.gen_idGenGeoSenplades=d.idGenGeoSenplades ";
    $sql.="INNER JOIN genGeoSenplades AS sz ON d.gen_idGenGeoSenplades=sz.idGenGeoSenplades ";
    $sql.="INNER JOIN genGeoSenplades AS z ON sz.gen_idGenGeoSenplades=z.idGenGeoSenplades ";
    $sql.="inner join genPersona p on p.idGenPersona=e.idGenPersona ";
    $sql.="inner join genDocumento docu on p.idGenPersona = docu.idGenPersona and docu.idGenTipoDocu = 1 ";
    $sql.="inner join  hdrTipoServicio ts on e.idHdrTipoServicio=ts.idHdrTipoServicio ";
    $sql.="inner join genTipoTipificacion t on t.idGenTipoTipificacion=e.idGenTipoTipificacion  where e.fechaEvento between '$fini' and '$ffin' and e.idHdrTipoServicio=4 and (g.idGenGeoSenplades='$geo' or c.idGenGeoSenplades='$geo' or d.idGenGeoSenplades='$geo' or sz.idGenGeoSenplades='$geo' or z.idGenGeoSenplades='$geo') order by e.idHdrEvento desc";
    $fecha="";
    $funcion="FUNCION";
    $header=array('FROT','TIPO DE OPERATIVO','FORMA','ZONA','SUBZONA','DISTRITO','CIRCUITO','DOCUMENTO','QUIEN HACE OPERATIVO','FECHA OPERATIVO','HORA','LATITUD','LONGITUD','DIRECCION');
    $data=array('idHdrEvento','tipo','forma','zona','subzona','distrito','circuito','documento','apenom','fecha','hora','latitud','longitud','dir');
    $rs=$conn->query($sql);
    $rowT=$rs->fetchAll();

    $tCuadro='Reportes de Operativos <br>Fecha Inicial: '.$_GET['fini'].' Fecha Final: '.$_GET['ffin'];
    //print_r($rowT['tipo']);
    imprimeTabla($rowT, $tCuadro, $funcion, $fecha, 10, $header, $data);


    $tCuadro='<br><br>Anexo de Personas';
    $sql="select e.idHdrEvento,p.documento,p.apenom,p.sexo,p.fechaNacimiento,r.descEventoResum, ";
    $sql.="ifnull(ti.desHdrTipoResum,tp.descripcion)as tipo,t.desHdrTipoResum,case r.detBusqueda ";
    $sql.="when 'TIENE ORDEN DE CAPTURA' then 'TIENE ORDEN DE CAPTURA' ";
    $sql.="end as prioridad from hdrEvento e ";
    $sql.="left join genGeoSenplades g on g.idGenGeoSenplades=e.idGenGeoSenplades ";
    $sql.="INNER JOIN genGeoSenplades AS c ON g.gen_idGenGeoSenplades=c.idGenGeoSenplades ";
    $sql.="INNER JOIN genGeoSenplades AS d ON c.gen_idGenGeoSenplades=d.idGenGeoSenplades ";
    $sql.="INNER JOIN genGeoSenplades AS sz ON d.gen_idGenGeoSenplades=sz.idGenGeoSenplades ";
    $sql.="INNER JOIN genGeoSenplades AS z ON sz.gen_idGenGeoSenplades=z.idGenGeoSenplades ";
    $sql.="inner join genTipoTipificacion tp on tp.idGenTipoTipificacion=e.idGenTipoTipificacion ";
    $sql.="inner join hdrEventoResum r on e.idHdrEvento=r.idHdrEvento ";
    $sql.="inner join hdrTipoResum t  on t.idHdrTipoResum=r.idHdrTipoResum ";
    $sql.="LEFT JOIN hdrTipoResum ti ON t.hdr_idHdrTipoResum=ti.idHdrTipoResum ";
    $sql.="inner join v_persona p on r.idGenPersona=p.idGenPersona where  e.fechaEvento between '$fini' and '$ffin' and e.idHdrTipoServicio=4 and (g.idGenGeoSenplades='$geo' or c.idGenGeoSenplades='$geo' or d.idGenGeoSenplades='$geo' or sz.idGenGeoSenplades='$geo' or z.idGenGeoSenplades='$geo') order by e.idHdrEvento desc ";
    //echo $sql;
    $header=array('ID OPERATIVO','CEDULA','NOMBRES','SEXO','FECHA DE NACIMIENTO','TIPO ACCIÓN','ACCIÓN DE REGISTRO','NOVEDAD');
    $data=array('idHdrEvento','documento','apenom','sexo','fechaNacimiento','tipo','desHdrTipoResum','prioridad');
    $rs=$conn->query($sql);
    $rowT=$rs->fetchAll();
    imprimeTabla($rowT, $tCuadro, $funcion, $fecha, 10, $header, $data);

    $tCuadro='<br><br>Anexo de vehiculos';
    $sql="select e.idHdrEvento,v.placa,v.motor,v.chasis,v.marca,v.modelo,v.anoFabricacion,v.clase,v.descServicio,t.desHdrTipoResum, case r.detBusqueda ";
    $sql.="when 'ROBADO' then 'ROBADO' ";
    $sql.="end as prio from hdrEvento e ";
    $sql.="left join genGeoSenplades g on g.idGenGeoSenplades=e.idGenGeoSenplades ";
    $sql.="INNER JOIN genGeoSenplades AS c ON g.gen_idGenGeoSenplades=c.idGenGeoSenplades ";
    $sql.="INNER JOIN genGeoSenplades AS d ON c.gen_idGenGeoSenplades=d.idGenGeoSenplades ";
    $sql.="INNER JOIN genGeoSenplades AS sz ON d.gen_idGenGeoSenplades=sz.idGenGeoSenplades ";
    $sql.="INNER JOIN genGeoSenplades AS z ON sz.gen_idGenGeoSenplades=z.idGenGeoSenplades ";
    $sql.="inner join hdrEventoResum r on e.idHdrEvento=r.idHdrEvento ";
    $sql.="inner join hdrTipoResum t  on t.idHdrTipoResum=r.idHdrTipoResum ";
    $sql.="inner join v_vehiculo_gen v on r.idGenVehiculo=v.idGenVehiculo where e.fechaEvento between '$fini' and '$ffin' and e.idHdrTipoServicio=4 and (g.idGenGeoSenplades='$geo' or c.idGenGeoSenplades='$geo' or d.idGenGeoSenplades='$geo' or sz.idGenGeoSenplades='$geo' or z.idGenGeoSenplades='$geo') order by e.idHdrEvento desc ";
    //echo $sql;
    $header=array('ID OPERATIVO','PLACA','MOTOR','CHASIS','MARCA','MODELO','FABRICA','CLASE','SERVICIO','NOVEDAD');
    $data=array('idHdrEvento','placa','motor','chasis','marca','modelo','anoFabricacion','clase','desHdrTipoResum','prio');
    $rs=$conn->query($sql);
    $rowT=$rs->fetchAll();
    imprimeTabla($rowT, $tCuadro, $funcion, $fecha, 13, $header, $data);

    $tCuadro='<br><br>Anexo de Totales';
    $sql="select ifnull(ti.desHdrTipoResum,tp.descripcion) tipo,t.desHdrTipoResum,count(r.idHdrTipoResum) cantidad from hdrEvento e ";
    $sql.="left join genGeoSenplades g on g.idGenGeoSenplades=e.idGenGeoSenplades ";
    $sql.="INNER JOIN genGeoSenplades AS c ON g.gen_idGenGeoSenplades=c.idGenGeoSenplades ";
    $sql.="INNER JOIN genGeoSenplades AS d ON c.gen_idGenGeoSenplades=d.idGenGeoSenplades ";
    $sql.="INNER JOIN genGeoSenplades AS sz ON d.gen_idGenGeoSenplades=sz.idGenGeoSenplades ";
    $sql.="INNER JOIN genGeoSenplades AS z ON sz.gen_idGenGeoSenplades=z.idGenGeoSenplades ";
    $sql.="inner join genTipoTipificacion tp on tp.idGenTipoTipificacion=e.idGenTipoTipificacion ";
    $sql.="inner join hdrEventoResum r on e.idHdrEvento=r.idHdrEvento ";
    $sql.="inner join hdrTipoResum t on r.idHdrTipoResum=t.idHdrTipoResum ";
    $sql.="left JOIN hdrTipoResum ti ON t.hdr_idHdrTipoResum=ti.idHdrTipoResum";
    $sql.=" where  e.fechaEvento between '$fini' and '$ffin' and e.idHdrTipoServicio=4 ";
    $sql.="and (g.idGenGeoSenplades='$geo' or c.idGenGeoSenplades='$geo' or d.idGenGeoSenplades='$geo' or sz.idGenGeoSenplades='$geo' or z.idGenGeoSenplades='$geo')";
    $sql.="group BY  ti.idHdrTipoResum,t.idHdrTipoResum ";
    //echo $sql;
    $header=array('TIPO','PROCEDIMIEMTO','CANTIDAD');
    $data=array('tipo','desHdrTipoResum','cantidad');
    $rs=$conn->query($sql);
    $rowT=$rs->fetchAll();
    imprimeTabla($rowT, $tCuadro, $funcion, $fecha, 2, $header, $data);


    $tCuadro='<br><br>Anexo de Totales de Novedades';
    $sql="select r.detBusqueda, count(r.detBusqueda) cantidad from hdrEvento e ";
    $sql.="left join genGeoSenplades g on g.idGenGeoSenplades=e.idGenGeoSenplades ";
    $sql.="INNER JOIN genGeoSenplades AS c ON g.gen_idGenGeoSenplades=c.idGenGeoSenplades ";
    $sql.="INNER JOIN genGeoSenplades AS d ON c.gen_idGenGeoSenplades=d.idGenGeoSenplades ";
    $sql.="INNER JOIN genGeoSenplades AS sz ON d.gen_idGenGeoSenplades=sz.idGenGeoSenplades ";
    $sql.="INNER JOIN genGeoSenplades AS z ON sz.gen_idGenGeoSenplades=z.idGenGeoSenplades ";
    $sql.="inner join  hdrEventoResum r on e.idHdrEvento=r.idHdrEvento ";
    $sql.="inner join hdrTipoResum t on r.idHdrTipoResum=t.idHdrTipoResum ";
    $sql.="where  e.fechaEvento between '$fini' and '$ffin' and e.idHdrTipoServicio=4 and (g.idGenGeoSenplades='$geo' or c.idGenGeoSenplades='$geo' or d.idGenGeoSenplades='$geo' or sz.idGenGeoSenplades='$geo' or z.idGenGeoSenplades='$geo')";
    $sql.="and (r.detBusqueda='ROBADO' or r.detBusqueda='TIENE ORDEN DE CAPTURA') group by r.detBusqueda ";

    $header=array('NOMBRE NOVEDAD','CANTIDAD');
    $data=array('detBusqueda','cantidad');
    $rs=$conn->query($sql);
    $rowT=$rs->fetchAll();
    imprimeTabla($rowT, $tCuadro, $funcion, $fecha, 2, $header, $data);
}
else
{
	echo 'No ha seleccionado opciones';
	}
ob_end_flush();
?>
