<?php
class DgoAntecedentesInforme extends Transaccion
{
    private $tabla   = 'dgoAntecedentesInforme';
    private $idTabla = 'idDgoAntecedentesInforme';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaDgoAntecedentesInforme()
    {
        return $this->tabla;
    }
    public function getSqlDgoAntecedentesInforme($idDgoInfOrdenServicio)
    {
        $sql = "SELECT a.idDgoAntecedentesInforme,a.descripcion
        FROM  dgoAntecedentesInforme a 
        WHERE a.delLog='N' AND a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . " ORDER BY a.idDgoAntecedentesInforme DESC";
        return $sql;
    }
    public function getDgoAntecedentesInforme($idDgoInfOrdenServicio)
    {
        return $this->consultarAll($this->getSqlDgoAntecedentesInforme($idDgoInfOrdenServicio));
    }

    public function getEditDgoAntecedentesInforme($idDgoAntecedentesInforme)
    {
        $sql = "SELECT a.idDgoAntecedentesInforme,a.descripcion
        FROM dgoAntecedentesInforme a WHERE a.idDgoAntecedentesInforme={$idDgoAntecedentesInforme}";
        return $this->consultar($sql);
    }

    public function registrarDgoAntecedentesInforme($datos)
    {
        $tabla      = 'dgoAntecedentesInforme';
        $tStructure = array(
            'idDgoInfOrdenServicio' => 'idDgoInfOrdenServicio',
            'descripcion' => 'descripcion',
            'delLog'      => 'delLog',
        );
        $datos['delLog'] = 'N';
        $descripcion     = 'descripcion,delLog';

        if (empty($datos['idDgoAntecedentesInforme'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoAntecedentesInforme != " . $datos['idDgoAntecedentesInforme'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarDgoAntecedentesInforme($idDgoAntecedentesInforme)
    {
        if (!empty($idDgoAntecedentesInforme)) {
            $respuesta = $this->delete($this->tabla, $idDgoAntecedentesInforme);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlDgoAntecedentesInformePdf($idDgoInfOrdenServicio)
    {
        $sql = "SELECT a.idDgoAntecedentesInforme cero,a.descripcion uno
                FROM dgoAntecedentesInforme a
                WHERE a.delLog='N'";
        return $sql;
    }
    public function getDatosImprimirDgoAntecedentesInformePdf($idDgoInfOrdenServicio)
    {
        return $this->consultarAll($this->getSqlDgoAntecedentesInformePdf($idDgoInfOrdenServicio));
    }
}
