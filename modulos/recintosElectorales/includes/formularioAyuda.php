     <?php

        session_start();
        include_once('../../../../clases/autoload.php');
        $conn = DB::getConexionDB();
        $sql = "SELECT
                    a.idDgoReciElect,
                    a.idGenEstado,
                    b.descripcion estado,
                    a.idGenGeoSenplades,
                    a.idGenDivPolitica,
                    a.codRecintoElec,
                    a.nomRecintoElec,
                    a.direcRecintoElec,
                    a.latitud,
                    a.longitud,
                    geo.descripcion AS subcircuito,
                    geoS.descripcion AS circuito,
                    geoD.descripcion AS Distrito,
                    geoSb.descripcion AS Subzona,
                    geoZ.descripcion AS Zona,
                    divp.descripcion AS division,
                     geo.descripcion AS senpladesDescripcion,
                    divp.descripcion AS divPoliticaDescripcion
                FROM
                    dgoReciElect a
                    LEFT JOIN genDivPolitica divp ON divp.idGenDivPolitica = a.idGenDivPolitica
                    LEFT JOIN genGeoSenplades geo ON geo.idGenGeoSenplades = a.idGenGeoSenplades
                    LEFT JOIN genGeoSenplades geoS ON geoS.idGenGeoSenplades = geo.gen_idGenGeoSenplades
                    LEFT JOIN genGeoSenplades geoD ON geoD.idGenGeoSenplades = geoS.gen_idGenGeoSenplades
                    LEFT JOIN genGeoSenplades geoSb ON geoSb.idGenGeoSenplades = geoD.gen_idGenGeoSenplades
                    LEFT JOIN genGeoSenplades geoZ ON geoZ.idGenGeoSenplades = geoSb.gen_idGenGeoSenplades
                    LEFT JOIN genEstado b ON b.idGenEstado = a.idGenEstado
                WHERE
                    a.delLog = 'N'
                AND
				    a.idDgoReciElect ='" . $_GET['id'] . "'";

        $rs = $conn->query($sql);
        $row = $rs->fetch(PDO::FETCH_ASSOC);

        ?>
     <div class="formaper" style="width:95%;text-align:left;font-size:11px;background-color:#EAF4FF;color:#666;margin:5px auto;border-width:1px;font-weight:normal" align="left">
         <table width="100%" border="0">
             <tr>
                 <td class="etiqueta">Código de Recinto:</td>
                 <td style="padding-top:3px" align="left"><?php echo $row[FuncionesGenerales::upc('codRecintoElec')] ?>
                 </td>
                 <td class="etiqueta">Nombre del Recinto:</td>
                 <td><?php echo $row[FuncionesGenerales::upc('nomRecintoElec')] ?></td>
             </tr>
             <tr>
                 <td class="etiqueta">Direcciòn de Recinto:</td>
                 <td><?php echo $row[FuncionesGenerales::upc('direcRecintoElec')] ?>
                 </td>
                 <td class="etiqueta">Ciudad:</td>
                 <td><?php echo $row[FuncionesGenerales::upc('division')] ?>
                 </td>
             </tr>
             <tr>
                 <td colspan="4">
                     <input type="hidden" id="usercdg_up" name="usercdg_up" value="<?php echo $row[FuncionesGenerales::upc('idDgoReciElect')] ?>" />
                 </td>

             </tr>
         </table>
     </div>