<?php
class DgoAntecedentesOrden extends Transaccion
{
    private $tabla   = 'dgoAntecedentes';
    private $idTabla = 'idDgoAntecedentes';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaDgoAntecedentesOrden()
    {
        return $this->tabla;
    }
    public function getSqlDgoAntecedentesOrden($idDgoOrdenServicio)
    {
        $sql = "SELECT a.idDgoAntecedentes,a.descripcion
        FROM  dgoAntecedentes a 
        WHERE a.delLog='N' AND a.idDgoOrdenServicio=" . $idDgoOrdenServicio . " ORDER BY a.idDgoAntecedentes DESC";
        return $sql;
    }
    public function getDgoAntecedentesOrden($idDgoOrdenServicio)
    {
        return $this->consultarAll($this->getSqlDgoAntecedentesOrden($idDgoOrdenServicio));
    }

    public function getEditDgoAntecedentesOrden($idDgoAntecedentes)
    {
        $sql = "SELECT a.idDgoAntecedentes,a.descripcion
        FROM dgoAntecedentes a WHERE a.idDgoAntecedentes={$idDgoAntecedentes}";
        return $this->consultar($sql);
    }

    public function registrarDgoAntecedentesOrden($datos)
    {
        $tabla      = 'dgoAntecedentes';
        $tStructure = array(
            'idDgoOrdenServicio' => 'idDgoOrdenServicio',
            'descripcion' => 'descripcion',
            'delLog'      => 'delLog',
        );
        $datos['delLog'] = 'N';
        $descripcion     = 'descripcion,delLog';

        if (empty($datos['idDgoAntecedentes'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoAntecedentes != " . $datos['idDgoAntecedentes'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarDgoAntecedentesOrden($idDgoAntecedentes)
    {
        if (!empty($idDgoAntecedentes)) {
            $respuesta = $this->delete($this->tabla, $idDgoAntecedentes);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlDgoAntecedentesOrdenPdf($idDgoOrdenServicio)
    {
        $sql = "SELECT a.idDgoAntecedentes cero,a.descripcion uno
                FROM dgoAntecedentes a
                WHERE a.delLog='N'";
        return $sql;
    }
    public function getDatosImprimirDgoAntecedentesOrdenPdf($idDgoOrdenServicio)
    {
        return $this->consultarAll($this->getSqlDgoAntecedentesOrdenPdf($idDgoOrdenServicio));
    }
}
