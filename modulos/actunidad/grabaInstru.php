<?php
session_start();
include '../../../funciones/db_connect.inc.php';
//print_r($_POST);
//die('');
$sqlI="delete from dgoActUniIns where idDgoActUnidad=".$_POST['idUni'];
//echo $sqlI;
$conn->beginTransaction();
$sentencia=$conn->prepare($sqlI);
$sentencia->execute();
for ($j=1;$j<$_POST['campos'];$j++)
{ 
	if($_POST['instru'.$j]>0)
	{
		$sql="select a.idDgoActividad,b.descDgoActividad from dgoInstrucci a,dgoActividad b where a.idDgoActividad=b.idDgoActividad and idDgoInstrucci=".$_POST['instru'.$j];
		$rsS=$conn->query($sql);
		$rowS=$rsS->fetch();
		if(empty($_POST['plazoI'.$rowS['idDgoActividad']]))
			die('La actividad: **['.$rowS['descDgoActividad'].']** no tiene fecha Inicial del Plazo, ** Corrija **');	else
			if(empty($_POST['plazo'.$rowS['idDgoActividad']]))
				die('La actividad: **['.$rowS['descDgoActividad'].']** no tiene fecha Final del Plazo, ** Corrija **');
			else
			{
				if($_POST['plazo'.$rowS['idDgoActividad']]<$_POST['fechaInicioPlazo']
				or $_POST['plazo'.$rowS['idDgoActividad']]>$_POST['fechaFinPlazo']
				or $_POST['plazoI'.$rowS['idDgoActividad']]>$_POST['plazo'.$rowS['idDgoActividad']])
					die('La fecha de Plazo Final de la Actividad: **['.$rowS['descDgoActividad'].']** no Puede ser menor que la fecha de inicio de la Actividad ni menor que el Plazo inicial ni Mayor que el plazo Final');

				if($_POST['plazoI'.$rowS['idDgoActividad']]<$_POST['fechaInicioPlazo']
				or $_POST['plazoI'.$rowS['idDgoActividad']]>$_POST['fechaFinPlazo']
				or $_POST['plazoI'.$rowS['idDgoActividad']]>$_POST['plazo'.$rowS['idDgoActividad']])
					die('La fecha de Plazo inicial de la Actividad: **['.$rowS['descDgoActividad'].']** no Puede ser menor que el la fecha de Inicio de la actividad ni Mayor que la fecha Final de la actividad ni tampoco mayor que la fecha del plazo Final');

			}
		$sqlI="insert into dgoActUniIns (idDgoActUnidad,idDgoInstrucci,usuario,ip,fechaInicioPlazo,fechaFinPlazo) values(?,?,?,?,?,?)";
		$sentencia= $conn->prepare($sqlI);
		$i=0; 
		/* Construye la lista de parametros a partir del arreglo $tStructure */
		$sentencia->bindParam(++$i, $_POST['idUni']);
		$sentencia->bindParam(++$i, $_POST['instru'.$j]);
		$sentencia->bindParam(++$i, $_SESSION['usuarioAuditar']);
		$sentencia->bindParam(++$i, $ip);
		$sentencia->bindParam(++$i, $_POST['plazoI'.$rowS['idDgoActividad']]);
		$sentencia->bindParam(++$i, $_POST['plazo'.$rowS['idDgoActividad']]);
		$sentencia->execute() or die('error');
	}
}
$conn->commit();
?>