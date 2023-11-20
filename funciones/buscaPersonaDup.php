<p style="color:#CC3333;font-size:14px">Este programa elimina duplicados en la tabla Vehiculo
<br>Puede tardar varios segundos ...Espere</p>
<?php
include_once('../../clases/claseConexion.php');

$recno=0;
ini_set('memory_limit', '512M');
$conn=abrirConexion();
$sqlD="select a.idGenPersona,trim(x.documento) documento  from genPersona a,genDocumento x where a.idGenPersona=x.idGenPersona and x.idGenTipoDocu=1 and exists
(select documento from genPersona b,genDocumento y where b.idGenPersona=y.idGenPersona and y.idGenTipoDocu=1 and x.documento=y.documento  having count(*)>1) order by 2 ";
$rsD=$conn->query($sqlD);
$descri='';
$first=true;
while($row=$rsD->fetch())
{	
	//print_r($row);
	//echo $row['documento'];
	//die('');
	if ($descri!=$row['documento'])
	{
		$descri=$row['documento'];
		$id=$row['idGenPersona'];
		//echo($descri.'<br>');
	}
	else
	{
		//die('SS'.$id);
		$sqlT="SELECT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'siipne3' AND  COLUMN_NAME like '%idGenPers%' and TABLE_NAME !='genPersona' and substr(TABLE_NAME,1,2) !='v_' order by 1";
		//die($sqlT);
		$rsT=$conn->query($sqlT);
		while ($rowT=$rsT->fetch())
		{
			//echo $rowT['TABLE_NAME'].'<br><br>';
			//die('');
			switch ($rowT['TABLE_NAME'])
			{
			default:
				$sqlU="select * from ".$rowT['TABLE_NAME']." where ".$rowT['COLUMN_NAME']."=".$row['idGenPersona'];
				//echo $rowT['TABLE_NAME'].'<br><br>';
				$rsDD=$conn->query($sqlU);
				if($rowDD=$rsDD->fetch())
					echo $rowT['TABLE_NAME'].' '.$rowDD['usuario'].' '.$row['idGenPersona'].'<br>'; 
				break;
			}
		}
		$recno++;
		echo '<br>';
	}
}

echo $recno.' Registros procesados... FIN';
?>
