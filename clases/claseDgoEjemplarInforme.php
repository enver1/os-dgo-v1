<?php
class DgoEjemplarInforme extends Transaccion
{
    private $tabla   = 'DgoEjemplarInforme';
    private $idTabla = 'idDgoEjemplarInforme';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaDgoEjemplarInforme()
    {
        return $this->tabla;
    }
    public function getSqlDgoEjemplarInforme($idDgoInfOrdenServicio)
    {
        $sql = "SELECT a.idDgoEjemplarInforme,a.descripcion,a.destino
        FROM  dgoEjemplarInforme a 
         WHERE a.delLog='N' AND a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . " ORDER BY a.destino DESC";
        return $sql;
    }
    public function getDgoEjemplarInforme($idDgoInfOrdenServicio)
    {
        return $this->consultarAll($this->getSqlDgoEjemplarInforme($idDgoInfOrdenServicio));
    }

    public function getEditDgoEjemplarInforme($idDgoEjemplarInforme)
    {
        $sql = "SELECT a.idDgoEjemplarInforme,a.descripcion,a.destino
        from dgoEjemplarInforme a 
        WHERE a.idDgoEjemplarInforme={$idDgoEjemplarInforme}";
        return $this->consultar($sql);
    }

    public function registrarDgoEjemplarInforme($datos)
    {
        $tabla      = 'dgoEjemplarInforme';
        $tStructure = array(
            'destino' => 'destino',
            'idDgoInfOrdenServicio' => 'idDgoInfOrdenServicio',
            'descripcion' => 'descripcion',
            'delLog'      => 'delLog',
        );
        $datos['delLog'] = 'N';
        $descripcion     = 'descripcion,delLog';

        if (empty($datos['idDgoEjemplarInforme'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoEjemplarInforme != " . $datos['idDgoEjemplarInforme'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarDgoEjemplarInforme($idDgoEjemplarInforme)
    {
        if (!empty($idDgoEjemplarInforme)) {
            $respuesta = $this->delete($this->tabla, $idDgoEjemplarInforme);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlDgoEjemplarInformePdf()
    {
        $sql = "SELECT a.idDgoEjemplarInforme cero,a.descripcion uno,a.idGenEstado,ge.descripcion dos
                FROM dgoEjemplarInforme a
                WHERE a.delLog='N'";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlDgoEjemplarInformePdf());
    }
}
