     <?php

        session_start();
        include_once('../../../../clases/autoload.php');
        include_once('../../../../funciones/funciones_generales.php');
        $conn = DB::getConexionDB();
        $sql = "SELECT
                    pa.idDgoCreaOpReci,
                    rt.nomRecintoElec,
                    pa.estado,
                    CONCAT( a.siglas, '. ', a.apenom )AS jefe_operativo,
                    pa.fechaIni,
                    pa.FechaFin,
                    geo.descripcion AS subcircuito,
                    geoS.descripcion AS circuito,
                    geoD.descripcion AS Distrito,
                    geoSb.descripcion AS Subzona,
                    geoZ.descripcion AS Zona
                FROM
                    dgoCreaOpReci pa
                   INNER JOIN dgoPerAsigOpe gs ON gs.idDgoCreaOpReci = pa.idDgoCreaOpReci
                    LEFT JOIN v_personal_simple a ON a.idGenPersona = gs.idGenPersona
                    INNER JOIN dgoReciElect rt ON rt.idDgoReciElect=pa.idDgoReciElect
                    LEFT JOIN genGeoSenplades geo ON geo.idGenGeoSenplades = rt.idGenGeoSenplades
                    LEFT JOIN genGeoSenplades geoS ON geoS.idGenGeoSenplades = geo.gen_idGenGeoSenplades
                    LEFT JOIN genGeoSenplades geoD ON geoD.idGenGeoSenplades = geoS.gen_idGenGeoSenplades
                    LEFT JOIN genGeoSenplades geoSb ON geoSb.idGenGeoSenplades = geoD.gen_idGenGeoSenplades
                    LEFT JOIN genGeoSenplades geoZ ON geoZ.idGenGeoSenplades = geoSb.gen_idGenGeoSenplades
                    WHERE
                    pa.idDgoCreaOpReci ='" . $_GET['id'] . "'";


        $rs = $conn->query($sql);
        $row = $rs->fetch(PDO::FETCH_ASSOC);

        ?>
     <div class="formaper" style="width:95%;text-align:left;font-size:11px;background-color:#EAF4FF;color:#666;margin:5px auto;border-width:1px;font-weight:normal" align="left">
         <table width="100%" border="0">
             <tr>
                 <td class="etiqueta">Código de Recinto:</td>
                 <td style="padding-top:3px" align="left"><?php echo $row[upc('idDgoCreaOpReci')] ?>
                 </td>
                 <td class="etiqueta">Nombre del Recinto:</td>
                 <td><?php echo $row[upc('nomRecintoElec')] ?></td>
             </tr>
             <tr>
                 <td class="etiqueta">Jefe o Encargado:</td>
                 <td><?php echo $row[upc('jefe_operativo')] ?>
                 </td>
                 <td class="etiqueta">Fecha de Inicio:</td>
                 <td><?php echo $row[upc('fechaIni')] ?>
                 </td>
             </tr>
             <tr>
                 <td colspan="4">
                     <input type="hidden" id="usercdg_up" name="usercdg_up" value="<?php echo $row[upc('idDgoReciElect')] ?>" />
                 </td>

             </tr>
         </table>
     </div>