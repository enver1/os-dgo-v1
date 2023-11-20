<?php
class DgoMisionOrden extends Transaccion
{
    private $tabla   = 'dgoDetalleMision';
    private $idTabla = 'idDgoDetalleMision';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaDgoMisionOrden()
    {
        return $this->tabla;
    }
    public function getSqlDgoMisionOrden($idDgoOrdenServicio)
    {
        $sql = "SELECT a.idDgoDetalleMision,a.descripcion
        FROM  dgoDetalleMision a      
        WHERE a.delLog='N' AND a.idDgoOrdenServicio=$idDgoOrdenServicio ORDER BY a.idDgoDetalleMision DESC";
        return $sql;
    }
    public function getDgoMisionOrden($idDgoOrdenServicio)
    {
        return $this->consultarAll($this->getSqlDgoMisionOrden($idDgoOrdenServicio));
    }

    public function getEditDgoMisionOrden($idDgoDetalleMision)
    {
        $sql = "SELECT a.idDgoDetalleMision,a.descripcion
        FROM dgoDetalleMision a WHERE a.idDgoDetalleMision={$idDgoDetalleMision}";
        return $this->consultar($sql);
    }

    public function registrarDgoMisionOrden($datos)
    {
        $tabla      = 'dgoDetalleMision';
        $tStructure = array(
            'descripcion' => 'descripcion',
            'idDgoOrdenServicio' => 'idDgoOrdenServicio',
            'delLog'      => 'delLog',
        );
        $datos['delLog'] = 'N';
        $descripcion     = 'descripcion,delLog';

        if (empty($datos['idDgoDetalleMision'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoDetalleMision != " . $datos['idDgoDetalleMision'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarDgoMisionOrden($idDgoDetalleMision)
    {
        if (!empty($idDgoDetalleMision)) {
            $respuesta = $this->delete($this->tabla, $idDgoDetalleMision);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlDgoMisionOrdenPdf()
    {
        $sql = "SELECT a.idDgoDetalleMision cero,a.descripcion uno
                FROM dgoDetalleMision a
                WHERE a.delLog='N'";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlDgoMisionOrdenPdf());
    }
}
