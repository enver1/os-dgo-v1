	<table width="100%" border="0" style="font-family:Verdana, Geneva, sans-serif"  id='my-tbl' cellspacing="0">
<!--    	<tr>
        	<td colspan="3" align="center" class="texto_gris" style="font-size:16px;height:40px">PLAN DE ACCI&Oacute;N</td></tr>
-->		<tr><th class="data-th">No.</th>
        	<th style="width:30%" class="data-th">NIVEL</th>
            <th class="data-th">DESCRIPCI&Oacute;N</th></tr>
		<tr class="data-tr"><td>1</td><td style="border-right:solid 2px #444;border-bottom:solid 2px #444;padding:5px" align="right">OBJETIVO ESPEC&Iacute;FICO:</td>
        	<td style="font-size:10px;text-align:justify;padding:3px 10px;"><?php echo $rowB['objEspecifico']?></td></tr>
		<tr class="data-tr"><td>2</td><td style="border-right:solid 2px #444;border-bottom:solid 2px #444;padding:5px" align="right">ESTRATEGIA AL OBJETIVO ESPEC&Iacute;FICO:</td>
        	<td style="font-size:10px;text-align:justify;padding:3px 10px;"><?php echo $rowB['estrategia'] ?></td></tr>
		<tr class="data-tr"><td>3</td><td style="border-right:solid 2px #444;border-bottom:solid 2px #444;padding:5px" align="right">OBJETIVO OPERATIVO:</td>
        	<td style="font-size:10px;text-align:justify;padding:3px 10px;"><?php echo $rowB['objOperativo'] ?></td></tr>
		<tr class="data-tr"><td>4</td><td style="border-right:solid 2px #444;border-bottom:solid 2px #444;padding:5px" align="right">CATEGORIA DEL PLAN DE ACCI&Oacute;N:</td>
        	<td style="font-size:10px;text-align:justify;padding:3px 10px;"><?php echo isset ($rowB['descDgoEje'] )?($rowB['descDgoEje'] ):'';?></td></tr>
	</table>
