     <?php

        session_start();
        include_once '../../../../clases/autoload.php';
        $conn = DB::getConexionDB();
        $sql = "SELECT
                    pa.idDgoCreaOpReci, rt. idDgoReciElect,
                    rt.nomRecintoElec,
                    pa.estado,
                    CONCAT( a.siglas, '. ', a.apenom ) AS jefe_operativo,
                    p.descProcElecc

                FROM
                    dgoCreaOpReci pa
                    INNER JOIN dgoComisios c ON c.idDgoComisios = pa.idDgoComisios
                    INNER JOIN dgoReciElect rt ON rt.idDgoReciElect = c.idDgoReciElect
                    INNER JOIN dgoProcElec p ON p.idDgoProcElec = c.idDgoProcElec
                    INNER JOIN dgoPerAsigOpe gs ON gs.idDgoCreaOpReci = pa.idDgoCreaOpReci
                    INNER JOIN v_personal_simple a ON a.idGenPersona = gs.idGenPersona
                    WHERE
                    gs.cargo='J'
                    AND
                    pa.idDgoCreaOpReci ='" . $_GET['id'] . "'";
        //print_r($sql);
        $rs  = $conn->query($sql);
        $row = $rs->fetch(PDO::FETCH_ASSOC);

        ?>
     <div class="formaper" style="width:95%;text-align:left;font-size:11px;background-color:#EAF4FF;color:#666;margin:5px auto;border-width:1px;font-weight:normal" align="left">
         <table width="100%" border="0">
             <tr>
                 <td class="etiqueta">Código de Recinto:</td>
                 <td style="padding-top:3px" align="left"><?php echo $row[FuncionesGenerales::upc('idDgoCreaOpReci')] ?>
                 </td>
                 <td class="etiqueta">Nombre del Recinto:</td>
                 <td><?php echo $row[FuncionesGenerales::upc('nomRecintoElec')] ?></td>
             </tr>
             <tr>
                 <td class="etiqueta">Jefe o Encargado:</td>
                 <td><?php echo $row[FuncionesGenerales::upc('jefe_operativo')] ?>
                 </td>
                 <td class="etiqueta">Proceso:</td>
                 <td><?php echo $row[FuncionesGenerales::upc('descProcElecc')] ?>
                 </td>
             </tr>
             <tr>
                 <td colspan="4">
                     <input type="hidden" id="usercdg_up" name="usercdg_up" value="<?php echo $row[FuncionesGenerales::upc('idDgoReciElect')] ?>" />
                 </td>

             </tr>
         </table>
     </div>