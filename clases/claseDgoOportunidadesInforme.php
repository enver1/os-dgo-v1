<?php
class DgoOportunidadesInforme extends Transaccion
{
    private $tabla   = 'dgoOportunidadesInf';
    private $idTabla = 'idDgoOportunidadesInf';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaDgoOportunidadesInforme()
    {
        return $this->tabla;
    }
    public function getSqlDgoOportunidadesInforme($idDgoInfOrdenServicio)
    {
        $sql = "SELECT a.idDgoOportunidadesInf,a.descripcion
        FROM  dgoOportunidadesInf a 
        WHERE a.delLog='N' AND a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . " ORDER BY a.idDgoOportunidadesInf DESC";
        return $sql;
    }
    public function getDgoOportunidadesInforme($idDgoInfOrdenServicio)
    {
        return $this->consultarAll($this->getSqlDgoOportunidadesInforme($idDgoInfOrdenServicio));
    }

    public function getEditDgoOportunidadesInforme($idDgoOportunidadesInf)
    {
        $sql = "SELECT a.idDgoOportunidadesInf,a.descripcion
        FROM dgoOportunidadesInf a WHERE a.idDgoOportunidadesInf={$idDgoOportunidadesInf}";
        return $this->consultar($sql);
    }

    public function registrarDgoOportunidadesInforme($datos)
    {
        $tabla      = 'dgoOportunidadesInf';
        $tStructure = array(
            'idDgoInfOrdenServicio' => 'idDgoInfOrdenServicio',
            'descripcion' => 'descripcion',
            'delLog'      => 'delLog',
        );
        $datos['delLog'] = 'N';
        $descripcion     = 'descripcion,delLog';

        if (empty($datos['idDgoOportunidadesInf'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoOportunidadesInf != " . $datos['idDgoOportunidadesInf'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarDgoOportunidadesInforme($idDgoOportunidadesInf)
    {
        if (!empty($idDgoOportunidadesInf)) {
            $respuesta = $this->delete($this->tabla, $idDgoOportunidadesInf);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlDgoOportunidadesInformePdf($idDgoInfOrdenServicio)
    {
        $sql = "SELECT a.idDgoOportunidadesInf cero,a.descripcion uno
                FROM dgoOportunidadesInf a
                WHERE a.delLog='N'";
        return $sql;
    }
    public function getDatosImprimirDgoOportunidadesInformePdf($idDgoInfOrdenServicio)
    {
        return $this->consultarAll($this->getSqlDgoOportunidadesInformePdf($idDgoInfOrdenServicio));
    }
}
