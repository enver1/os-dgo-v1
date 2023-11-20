<?php
class DgoEjemplarOrden extends Transaccion
{
    private $tabla   = 'dgoEjemplarOrden';
    private $idTabla = 'idDgoEjemplarOrden';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaDgoEjemplarOrden()
    {
        return $this->tabla;
    }
    public function getSqlDgoEjemplarOrden($idDgoOrdenServicio)
    {
        $sql = "SELECT a.idDgoEjemplarOrden,a.descripcion,a.destino
        FROM  dgoEjemplarOrden a 
         WHERE a.delLog='N' AND a.idDgoOrdenServicio=" . $idDgoOrdenServicio . " ORDER BY a.destino DESC";
        return $sql;
    }
    public function getDgoEjemplarOrden($idDgoOrdenServicio)
    {
        return $this->consultarAll($this->getSqlDgoEjemplarOrden($idDgoOrdenServicio));
    }

    public function getEditDgoEjemplarOrden($idDgoEjemplarOrden)
    {
        $sql = "SELECT a.idDgoEjemplarOrden,a.descripcion,a.destino
        from dgoEjemplarOrden a 
        WHERE a.idDgoEjemplarOrden={$idDgoEjemplarOrden}";
        return $this->consultar($sql);
    }

    public function registrarDgoEjemplarOrden($datos)
    {
        $tabla      = 'dgoEjemplarOrden';
        $tStructure = array(
            'destino' => 'destino',
            'idDgoOrdenServicio' => 'idDgoOrdenServicio',
            'descripcion' => 'descripcion',
            'delLog'      => 'delLog',
        );
        $datos['delLog'] = 'N';
        $descripcion     = 'descripcion,delLog';

        if (empty($datos['idDgoEjemplarOrden'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoEjemplarOrden != " . $datos['idDgoEjemplarOrden'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarDgoEjemplarOrden($idDgoEjemplarOrden)
    {
        if (!empty($idDgoEjemplarOrden)) {
            $respuesta = $this->delete($this->tabla, $idDgoEjemplarOrden);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlDgoEjemplarOrdenPdf()
    {
        $sql = "SELECT a.idDgoEjemplarOrden cero,a.descripcion uno,a.idGenEstado,ge.descripcion dos
                FROM dgoEjemplarOrden a
                WHERE a.delLog='N'";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlDgoEjemplarOrdenPdf());
    }
}
