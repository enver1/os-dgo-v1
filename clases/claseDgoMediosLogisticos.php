<?php
class DgoMediosLogisticos extends Transaccion
{
    private $tabla   = 'dgoDetalleMediosLogisticos';
    private $idTabla = 'idDgoDetalleMediosLogisticos';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaDgoMediosLogisticos()
    {
        return $this->tabla;
    }
    public function getSqlDgoMediosLogisticos($idDgoOrdenServicio)
    {
        $sql = "SELECT      a.idDgoMediosLogisticos,
                            a.idDgoOrdenServicio,
                            a.cantidad,
                            a.idDgoDetalleMediosLogisticos,
                            du.descripcion                            
                        FROM
                        dgoDetalleMediosLogisticos a
                            INNER JOIN dgoMediosLogisticos du ON du.idDgoMediosLogisticos= a.idDgoMediosLogisticos 
                        WHERE
                            a.delLog = 'N' AND a.idDgoOrdenServicio=" . $idDgoOrdenServicio . "
                        ORDER BY
                            a.idDgoDetalleMediosLogisticos DESC";
        return $sql;
    }
    public function getDgoMediosLogisticos($idDgoOrdenServicio)
    {
        return $this->consultarAll($this->getSqlDgoMediosLogisticos($idDgoOrdenServicio));
    }

    public function getEditDgoMediosLogisticos($idDgoDetalleMediosLogisticos)
    {
        $sql = "SELECT      a.idDgoMediosLogisticos,
                            a.idDgoOrdenServicio,
                            a.cantidad,
                            a.idDgoDetalleMediosLogisticos,
                            du.descripcion                            
                        FROM
                        dgoDetalleMediosLogisticos a
                            INNER JOIN dgoMediosLogisticos du ON du.idDgoMediosLogisticos= a.idDgoMediosLogisticos 
                        WHERE
                        a.idDgoDetalleMediosLogisticos={$idDgoDetalleMediosLogisticos}";
        return $this->consultar($sql);
    }

    public function registrarDgoMediosLogisticos($datos)
    {
        $tabla      = 'dgoDetalleMediosLogisticos';
        $tStructure = array(
            'idDgoOrdenServicio' => 'idDgoOrdenServicio',
            'cantidad'  => 'cantidad',
            'idDgoMediosLogisticos' => 'idDgoMediosLogisticos',
            'delLog'      => 'delLog',
        );
        $datos['delLog'] = 'N';
        $descripcion     = 'idDgoOrdenServicio,idDgoMediosLogisticos,delLog';

        if (empty($datos['idDgoDetalleMediosLogisticos'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoDetalleMediosLogisticos != " . $datos['idDgoDetalleMediosLogisticos'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarDgoMediosLogisticos($idDgoMediosLogisticos)
    {
        if (!empty($idDgoMediosLogisticos)) {
            $respuesta = $this->delete($this->tabla, $idDgoMediosLogisticos);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlDgoMediosLogisticosPdf()
    {
        $sql = "SELECT      a.idDgoMediosLogisticos,
                            a.idDgoOrdenServicio,
                            a.idDgpUnidad,
                            a.numericoJefes,
                            a.numericoSubalternos,
                            a.idDgoTipoMediosLogisticos,
                            du.descripcion,
                            du1.descripcion as Unidad
                        FROM
                        dgoDetalleMediosLogisticos a
                            INNER JOIN dgpUnidad du ON du.idDgpUnidad= a.idDgpUnidad";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlDgoMediosLogisticosPdf());
    }
}
