<?php
include_once('../../../clases/autoload.php');
$conn = DB::getConexionDB();
$color = array('V' => '#063', 'A' => '#ff3', 'N' => '#f93', 'R' => '#f00');
$sql = "select a.*,
			b.siglas,
			b.descripcion desctipo 
			from 
			hdrEvento a,
			genTipoTipificacion b 
			where a.idGenTipoTipificacion=b.idGenTipoTipificacion 
			and 
			idHdrEvento=" . $_GET['id'];
$rs = $conn->query($sql);
$st = '<table style="font-size:9px" border="0" cellspacing="0" width="100%">';

if ($row = $rs->fetch()) {
	$sqlJefeO = "select 
				v.siglas siglas, 
				v.apenom apenom 
				from 
				v_persona v, 
				genUsuario u 
				where 
				v.idGenPersona=u.idGenPersona 
				and 
				u.idGenUsuario=" . $row['usuario'];
	//echo $sqlJefeO;
	$rsJefeO = $conn->query($sqlJefeO);
	if ($rowJefeO = $rsJefeO->fetch()) {
		$JefeOperativo = $rowJefeO['siglas'] . ' ' . $rowJefeO['apenom'];
	}

	$st .= '<tr><td style="background:' . $color[$row['nivelAlerta']] . ';height:25px;border:solid 1px #111" colspan="2">&nbsp;</td></tr>';
	$st .= '<tr><td style="background:#fff;font-weight:bold" colspan="2">Evento Nro: ' . $row['codigoEvento'] . '</td></tr>';
	$st .= '<tr><td style="background:#ccc;font-weight:bold" valign="top">Operativo de:</td><td style="background:#ccc">' . $row['siglas'] . ' / ' . $row['desctipo'] . '</td></tr>';
	$st .= '<tr><td style="background:#fff;font-weight:bold" valign="top">Descripci&oacute;n:</td><td style="background:#fff">' . $row['descripcion'] . '</td></tr>';
	$st .= '<tr><td style="background:#fff;font-weight:bold" valign="top">Persona que Registr&oacute; el Operativo:</td><td style="background:#fff">' . $JefeOperativo . '</td></tr>';
	$st .= '<tr><td style="background:#fff;font-weight:bold" valign="top">Fecha:</td><td style="background:#fff">' . $row['fechaEvento'] . '</td></tr>';
	$st .= '<tr><td style="background:#ccc;font-weight:bold" valign="top" align="center" colspan="2">R E S U M E N</td></tr>';
	$st .= '</table><table style="font-size:9px" border="0" cellspacing="0" width="100%">';
	$sql = "select b.idHdrTipoResum,b.desHdrTipoResum,count(*) cuantos from hdrEventoResum a,hdrTipoResum b where a.idHdrTipoResum=b.idHdrTipoResum and a.idHdrEvento=" . $_GET['id'] . " group by a.idHdrTipoResum ";
	//	echo $sql;
	$rsD = $conn->query($sql);
	while ($rowD = $rsD->fetch()) {
		$st .= '<tr><td style="background:#fff;font-weight:bold"><a href="javascript:void(0)" onclick="muestraResumen(\'' . $row['idHdrEvento'] . '\',\'' . $rowD['idHdrTipoResum'] . '\')"><span style="color:#06c">' . $rowD['desHdrTipoResum'] . '</span></a></td><td style="background:#fff;padding-right:10px" align="right">' . $rowD['cuantos'] . '</td></tr>';
	}
}
$st .= '</table>';
echo $st;
