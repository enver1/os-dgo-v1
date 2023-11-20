<?php
session_start();
include_once('../../../funciones/db_connect.inc.php');
$pruebacdg = $_GET['id'];
$acuncdg = $_GET['activ'];

$sql = "select idGenUsuario,a.idDgoVisita from dgoVisita a,genUsuario b where a.idDgoActUnidad=" . $acuncdg . "  and a.idGenPersona=b.idgenPersona";
//echo $sql;
$rsS = $conn->query($sql);
if ($rowS = $rsS->fetch()) {
	$usuario = $rowS['idGenUsuario'];
	$laVisita = $rowS['idDgoVisita'];
} else
	die('NO EXISTE UN RESPONSABLE DE LA VISITA O EL RESPONSABLE NO ES USUARIO DEL SIIPNE 3w');

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
	where u.idGenUsuario=" . $usuario . "  
	and (a.idDgoActividad)='" . $pruebacdg . "' 
	and (c.idDgoActUnidad)='" . $acuncdg . "' group by a.idDgoInstrucci";
//echo $sql.'<br>';
$rsAC = $conn->query($sql);
$maximo = 0;
$puntos = 0;
$instru = 0;
while ($rowAC = $rsAC->fetch()) {
	$maximo += $rowAC['puntos'];
}

$sql = "select ec.puntaje,b.peso,c.fechaCumplimiento 
	from dgoInstrucci a
	join dgoActividad b on a.idDgoActividad=b.idDgoActividad
	join dgoActUniIns c on a.idDgoInstrucci=c.idDgoInstrucci 
	join dgoVisita v on c.idDgoActUnidad=v.idDgoActUnidad
	join genUsuario u on v.idGenPersona=u.idGenPersona 
	join dgoEncuesta ec on a.idDgoInstrucci=ec.idDgoInstrucci
	join dgoEncVisita ev on ec.idDgoEncuesta=ev.idDgoEncuesta and v.idDgoVisita=ev.idDgoVisita
	where u.idGenUsuario=" . $usuario . "  
	and (a.idDgoActividad)='" . $pruebacdg . "' 
	and (c.idDgoActUnidad)='" . $acuncdg . "' ";
//echo $sql;
$rsAC = $conn->query($sql);
while ($rowAC = $rsAC->fetch()) {
	$puntos += $rowAC['puntaje'];
	$instru = $rowAC['peso'];
	$cumple = $rowAC['fechaCumplimiento'];
}

if ($puntos > 0) {
	$rt = $puntos * 100 / $maximo;
	$porce = round($rt, 2);
} else {
	$porce = 0.00;
}






echo '<span style="font-size:14px;color:#336"><strong>Porcentaje de Cumplimiento:</strong>' . $porce . '%  (Peso/Coeficiente: ' . $instru . ')</span>';


echo '<br><p class="texto_gris">Responsables</p>';
$sql = "select distinct descDgoCargo
	from dgoInstrucci a
	join dgoActividad b on a.idDgoActividad=b.idDgoActividad
	join dgoActUniIns c on a.idDgoInstrucci=c.idDgoInstrucci 
	join dgoVisita v on c.idDgoActUnidad=v.idDgoActUnidad
	join dgoResAct ra on v.idDgoVisita=ra.idDgoVisita  
	join dgoCargo ca on ra.idDgoCargo=ca.idDgoCargo
	join genUsuario u on v.idGenPersona=u.idGenPersona 
	join dgoEncuesta ec on a.idDgoInstrucci=ec.idDgoInstrucci
	join dgoEncVisita ev on ec.idDgoEncuesta=ev.idDgoEncuesta and v.idDgoVisita=ev.idDgoVisita
	where u.idGenUsuario=" . $usuario . "  
	and (a.idDgoActividad)='" . $pruebacdg . "' 
	and (c.idDgoActUnidad)='" . $acuncdg . "'  
	and (ra.idDgoActividad)='" . $pruebacdg . "' ";
//	echo $sql;
$rsAC = $conn->query($sql);
while ($rowAC = $rsAC->fetch()) {
	echo $rowAC['descDgoCargo'] . '<br>';
}

echo '<p class="texto_gris" style="font-size:14px;color:#336;margin-left:30px"><strong>Instrucciones Enviadas:</strong></p>';
echo '<br><table id="my-tbl" style="width:550px;margin-left:30px">';
$sql = "select descDgoInstrucci,a.idDgoInstrucci
	from dgoInstrucci a
	join dgoActUniIns c on a.idDgoInstrucci=c.idDgoInstrucci 
	where 
	(c.idDgoActUnidad)='" . $acuncdg . "' and a.idDgoActividad='" . $pruebacdg . "' ";
$rsAC = $conn->query($sql);
$n = 1;
$alter = true;
while ($rowAC = $rsAC->fetch()) {
	if ($alter) {
		$alter = false;
		$color = ' style="background-color:#fff;color:#000" ';
	} else {
		$alter = true;
		$color = ' style="background-color:#fff;color:#000" ';
	}
	echo '<tr class="data-tr"><td ' . $color . ' width="10%">' . $n . '.</td><td ' . $color . '>' . $rowAC['descDgoInstrucci'] . '</td></tr>';
	$n++;
	$sql = "select concat(descEncuesta,' [',puntaje,' pts]') descEncuesta from dgoEncVisita a,dgoEncuesta b where a.idDgoEncuesta=b.iddgoEncuesta 
		and idDgoInstrucci=" . $rowAC['idDgoInstrucci'] . " and a.idDgoVisita=" . $laVisita;
	$rsS = $conn->query($sql);
	if ($rowS = $rsS->fetch()) {
		echo '<tr><td style="text-align:right;color:#556699">R.</td><td style="color:#556699;font-style:italic;border-bottom:solid 1px #ddd">' . $rowS['descEncuesta'] . '</td></tr>';
	} else {
		echo '<tr><td style="text-align:right;color:#556699">R.</td><td style="color:#556699;font-style:italic;border-bottom:solid 1px #ddd">*** Encuesta no realizada ***</td></tr>';
	}
}

echo '</table>';