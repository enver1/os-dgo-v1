<?php
class DgoMediosLogisticosInf extends Transaccion
{
    private $tabla   = 'dgoMediosLogisticosInf';
    private $idTabla = 'idDgoMediosLogisticosInf';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaDgoMediosLogisticosInf()
    {
        return $this->tabla;
    }
    public function getSqlDgoMediosLogisticosInf($idDgoInfOrdenServicio)
    {
        $sql = "SELECT      a.idDgoMediosLogisticosInf,
                            a.idDgoInfOrdenServicio,
                            a.cantidad,
                            a.idDgoMediosLogisticosInf,
                            du.descripcion                            
                        FROM
                        dgoMediosLogisticosInf a
                            INNER JOIN dgoMediosLogisticos du ON du.idDgoMediosLogisticos= a.idDgoMediosLogisticos
                        WHERE
                            a.delLog = 'N' AND a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . "
                        ORDER BY
                            a.idDgoMediosLogisticosInf DESC";
        return $sql;
    }
    public function getDgoMediosLogisticosInf($idDgoInfOrdenServicio)
    {
        return $this->consultarAll($this->getSqlDgoMediosLogisticosInf($idDgoInfOrdenServicio));
    }

    public function getEditDgoMediosLogisticosInf($idDgoMediosLogisticosInf)
    {
        $sql = "SELECT      a.idDgoMediosLogisticosInf,
                            a.idDgoInfOrdenServicio,
                            a.cantidad,
                            a.idDgoMediosLogisticos,
                            du.descripcion                            
                        FROM
                        dgoMediosLogisticosInf a
                            INNER JOIN dgoMediosLogisticos du ON du.idDgoMediosLogisticos= a.idDgoMediosLogisticos
                        WHERE
                        a.idDgoMediosLogisticosInf={$idDgoMediosLogisticosInf}";
        return $this->consultar($sql);
    }

    public function registrarDgoMediosLogisticosInf($datos)
    {
        $tabla      = 'dgoMediosLogisticosInf';
        $tStructure = array(
            'idDgoInfOrdenServicio' => 'idDgoInfOrdenServicio',
            'cantidad'  => 'cantidad',
            'idDgoMediosLogisticos' => 'idDgoMediosLogisticos',
            'delLog'      => 'delLog',
        );
        $datos['delLog'] = 'N';
        $descripcion     = 'idDgoInfOrdenServicio,idDgoMediosLogisticos,delLog';

        if (empty($datos['idDgoMediosLogisticosInf'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoMediosLogisticosInf != " . $datos['idDgoMediosLogisticosInf'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarDgoMediosLogisticosInf($idDgoMediosLogisticosInf)
    {
        if (!empty($idDgoMediosLogisticosInf)) {
            $respuesta = $this->delete($this->tabla, $idDgoMediosLogisticosInf);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlDgoMediosLogisticosInfPdf()
    {
        $sql = "SELECT      a.idDgoMediosLogisticosInf,
                            a.idDgoInfOrdenServicio,
                            a.idDgpUnidad,
                            a.numericoJefes,
                            a.numericoSubalternos,
             
                            du.descripcion,
                            du1.descripcion as Unidad
                        FROM
                        dgoMediosLogisticosInf a
                            INNER JOIN dgpUnidad du ON du.idDgpUnidad= a.idDgpUnidad";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlDgoMediosLogisticosInfPdf());
    }
}
