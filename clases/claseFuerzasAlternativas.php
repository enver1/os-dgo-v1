<?php
class FuerzasAlternativas extends Transaccion
{
    private $tabla   = 'dgoTipoFuerzasAlternativas';
    private $idTabla = 'idDgoTipoFuerzasAlternativas';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaFuerzasAlternativas()
    {
        return $this->tabla;
    }
    public function getSqlFuerzasAlternativas()
    {
        $sql = "SELECT a.idDgoTipoFuerzasAlternativas,a.descripcion,a.idGenEstado,ge.descripcion as estado 
        FROM  dgoTipoFuerzasAlternativas a 
        INNER JOIN genEstado ge on ge.idGenEstado=a.idGenEstado 
         WHERE a.delLog='N' ORDER BY a.idDgoTipoFuerzasAlternativas DESC";
        return $sql;
    }
    public function getFuerzasAlternativas()
    {
        return $this->consultarAll($this->getSqlFuerzasAlternativas());
    }

    public function getEditFuerzasAlternativas($idDgoTipoFuerzasAlternativas)
    {
        $sql = "SELECT a.idDgoTipoFuerzasAlternativas,a.descripcion,a.idGenEstado,ge.descripcion estado from dgoTipoFuerzasAlternativas a INNER JOIN genEstado ge on ge.idGenEstado=a.idGenEstado AND a.idDgoTipoFuerzasAlternativas={$idDgoTipoFuerzasAlternativas}  AND a.delLog='N'";
        return $this->consultar($sql);
    }

    public function registrarFuerzasAlternativas($datos)
    {
        $tabla      = 'dgoTipoFuerzasAlternativas';
        $tStructure = array(
            'idGenEstado' => 'idGenEstado',
            'descripcion' => 'descripcion',
            'delLog'      => 'delLog',
        );
        $datos['delLog'] = 'N';
        $descripcion     = 'descripcion,delLog';

        if (empty($datos['idDgoTipoFuerzasAlternativas'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoTipoFuerzasAlternativas != " . $datos['idDgoTipoFuerzasAlternativas'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarFuerzasAlternativas($idDgoTipoFuerzasAlternativas)
    {
        if (!empty($idDgoTipoFuerzasAlternativas)) {
            $respuesta = $this->delete($this->tabla, $idDgoTipoFuerzasAlternativas);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlFuerzasAlternativasPdf()
    {
        $sql = "SELECT a.idDgoTipoFuerzasAlternativas cero,a.descripcion uno,a.idGenEstado,ge.descripcion dos
                FROM dgoTipoFuerzasAlternativas a
                INNER JOIN genEstado ge on ge.idGenEstado=a.idGenEstado
                WHERE a.delLog='N'";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlFuerzasAlternativasPdf());
    }
}
