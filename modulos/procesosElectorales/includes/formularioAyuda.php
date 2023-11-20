     <?php

        session_start();
        include_once '../../../../clases/autoload.php';
        $conn = DB::getConexionDB();
        $sql = "SELECT a.idDgoProcElec,a.descProcElecc,a.fechaInici,a.fechaFin,a.idGenEstado,b.descripcion as estado,
        IF(a.tipo='N','NACIONAL','LOCAL') as  tipo,a.idGenGeoSenplades,g.descripcion
        FROM dgoProcElec a
        INNER JOIN genEstado b on b.idGenEstado=a.idGenEstado
        LEFT JOIN genGeoSenplades g ON g.idGenGeoSenplades=a.idGenGeoSenplades
         WHERE a.idDgoProcElec  ='" . $_GET['id'] . "'";

        $rs  = $conn->query($sql);
        $row = $rs->fetch(PDO::FETCH_ASSOC);

        ?>
     <div class="formaper" style="width:95%;text-align:left;font-size:11px;background-color:#EAF4FF;color:#666;margin:5px auto;border-width:1px;font-weight:normal" align="left">
         <table width="100%" border="0">
             <tr>
                 <td class="etiqueta">Código de Proceso:</td>
                 <td><?php echo $row[FuncionesGenerales::upc('idDgoProcElec')] ?>
                 </td>
                 <td class="etiqueta">Proceso:</td>
                 <td><?php echo $row[FuncionesGenerales::upc('descProcElecc')] ?></td>
             </tr>
             <tr>
                 <td class="etiqueta">Fecha Inicio:</td>
                 <td><?php echo $row[FuncionesGenerales::upc('fechaInici')] ?>
                 </td>
                 <td class="etiqueta">Fecha Fin:</td>
                 <td><?php echo $row[FuncionesGenerales::upc('fechaFin')] ?>
                 </td>
             </tr>
             <tr>
                 <td colspan="4">
                     <input type="hidden" id="usercdg_up" name="usercdg_up" value="<?php echo $row[FuncionesGenerales::upc('idDgoProcElec')] ?>" />
                 </td>

             </tr>
         </table>
     </div>