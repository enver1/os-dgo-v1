<?php
class DgoOperacionesInforme extends Transaccion
{
    private $tabla   = 'dgoOperacionesInf';
    private $idTabla = 'idDgoOperacionesInf';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaDgoOperacionesInforme()
    {
        return $this->tabla;
    }
    public function getSqlDgoOperacionesInforme($idDgoInfOrdenServicio)
    {
        $sql = "SELECT a.idDgoOperacionesInf,a.descripcion
        FROM  dgoOperacionesInf a 
        WHERE a.delLog='N' AND a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . " ORDER BY a.idDgoOperacionesInf DESC";
        return $sql;
    }
    public function getDgoOperacionesInforme($idDgoInfOrdenServicio)
    {
        return $this->consultarAll($this->getSqlDgoOperacionesInforme($idDgoInfOrdenServicio));
    }

    public function getEditDgoOperacionesInforme($idDgoOperacionesInf)
    {
        $sql = "SELECT a.idDgoOperacionesInf,a.descripcion
        FROM dgoOperacionesInf a WHERE a.idDgoOperacionesInf={$idDgoOperacionesInf}";
        return $this->consultar($sql);
    }

    public function registrarDgoOperacionesInforme($datos)
    {
        $tabla      = 'dgoOperacionesInf';
        $tStructure = array(
            'idDgoInfOrdenServicio' => 'idDgoInfOrdenServicio',
            'descripcion' => 'descripcion',
            'delLog'      => 'delLog',
        );
        $datos['delLog'] = 'N';
        $descripcion     = 'descripcion,delLog';

        if (empty($datos['idDgoOperacionesInf'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoOperacionesInf != " . $datos['idDgoOperacionesInf'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarDgoOperacionesInforme($idDgoOperacionesInf)
    {
        if (!empty($idDgoOperacionesInf)) {
            $respuesta = $this->delete($this->tabla, $idDgoOperacionesInf);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlDgoOperacionesInformePdf($idDgoInfOrdenServicio)
    {
        $sql = "SELECT a.idDgoOperacionesInf cero,a.descripcion uno
                FROM dgoOperacionesInf a
                WHERE a.delLog='N'";
        return $sql;
    }
    public function getDatosImprimirDgoOperacionesInformePdf($idDgoInfOrdenServicio)
    {
        return $this->consultarAll($this->getSqlDgoOperacionesInformePdf($idDgoInfOrdenServicio));
    }
}
