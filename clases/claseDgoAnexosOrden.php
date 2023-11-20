<?php
class DgoAnexosOrden extends Transaccion
{
    private $tabla   = 'dgoAnexosOrden';
    private $idTabla = 'idDgoAnexosOrden';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaDgoAnexosOrden()
    {
        return $this->tabla;
    }
    public function getSqlDgoAnexosOrden($idDgoOrdenServicio)
    {
        $sql = "SELECT a.idDgoAnexosOrden,a.descripcion
        FROM  dgoAnexosOrden a 
         WHERE a.delLog='N' AND a.idDgoOrdenServicio=" . $idDgoOrdenServicio . " ORDER BY a.idDgoAnexosOrden DESC";
        return $sql;
    }
    public function getDgoAnexosOrden($idDgoOrdenServicio)
    {
        return $this->consultarAll($this->getSqlDgoAnexosOrden($idDgoOrdenServicio));
    }

    public function getEditDgoAnexosOrden($idDgoAnexosOrden)
    {
        $sql = "SELECT a.idDgoAnexosOrden,a.descripcion
        from dgoAnexosOrden a 
        WHERE a.idDgoAnexosOrden={$idDgoAnexosOrden}";
        return $this->consultar($sql);
    }

    public function registrarDgoAnexosOrden($datos)
    {
        $tabla      = 'dgoAnexosOrden';
        $tStructure = array(
            'idDgoOrdenServicio' => 'idDgoOrdenServicio',
            'descripcion' => 'descripcion',
            'delLog'      => 'delLog',
        );
        $datos['delLog'] = 'N';
        $descripcion     = 'descripcion,delLog';

        if (empty($datos['idDgoAnexosOrden'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoAnexosOrden != " . $datos['idDgoAnexosOrden'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarDgoAnexosOrden($idDgoAnexosOrden)
    {
        if (!empty($idDgoAnexosOrden)) {
            $respuesta = $this->delete($this->tabla, $idDgoAnexosOrden);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlDgoAnexosOrdenPdf()
    {
        $sql = "SELECT a.idDgoAnexosOrden cero,a.descripcion uno,a.idGenEstado,ge.descripcion dos
                FROM dgoAnexosOrden a
                INNER JOIN genEstado ge on ge.idGenEstado=a.idGenEstado
                WHERE a.delLog='N'";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlDgoAnexosOrdenPdf());
    }
}
