<?php
class DgoAnexosInforme extends Transaccion
{
    private $tabla   = 'dgoAnexosInforme';
    private $idTabla = 'idDgoAnexosInforme';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaDgoAnexosInforme()
    {
        return $this->tabla;
    }
    public function getSqlDgoAnexosInforme($idDgoInfOrdenServicio)
    {
        $sql = "SELECT a.idDgoAnexosInforme,a.descripcion
        FROM  dgoAnexosInforme a 
         WHERE a.delLog='N' AND a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . " ORDER BY a.idDgoAnexosInforme DESC";
        return $sql;
    }
    public function getDgoAnexosInforme($idDgoInfOrdenServicio)
    {
        return $this->consultarAll($this->getSqlDgoAnexosInforme($idDgoInfOrdenServicio));
    }

    public function getEditDgoAnexosInforme($idDgoAnexosInforme)
    {
        $sql = "SELECT a.idDgoAnexosInforme,a.descripcion
        from dgoAnexosInforme a 
        WHERE a.idDgoAnexosInforme={$idDgoAnexosInforme}";
        return $this->consultar($sql);
    }

    public function registrarDgoAnexosInforme($datos)
    {
        $tabla      = 'dgoAnexosInforme';
        $tStructure = array(
            'idDgoInfOrdenServicio' => 'idDgoInfOrdenServicio',
            'descripcion' => 'descripcion',
            'delLog'      => 'delLog',
        );
        $datos['delLog'] = 'N';
        $descripcion     = 'descripcion,delLog';

        if (empty($datos['idDgoAnexosInforme'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoAnexosInforme != " . $datos['idDgoAnexosInforme'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarDgoAnexosInforme($idDgoAnexosInforme)
    {
        if (!empty($idDgoAnexosInforme)) {
            $respuesta = $this->delete($this->tabla, $idDgoAnexosInforme);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlDgoAnexosInformePdf()
    {
        $sql = "SELECT a.idDgoAnexosInforme cero,a.descripcion uno,a.idGenEstado,ge.descripcion dos
                FROM dgoAnexosInforme a
                INNER JOIN genEstado ge on ge.idGenEstado=a.idGenEstado
                WHERE a.delLog='N'";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlDgoAnexosInformePdf());
    }
}
