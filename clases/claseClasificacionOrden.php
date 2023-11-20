<?php
class ClasificacionOrden extends Transaccion
{
    private $tabla   = 'dgoTipoCalificacion';
    private $idTabla = 'idDgoTipoCalificacion';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaClasificacionOrden()
    {
        return $this->tabla;
    }
    public function getSqlClasificacionOrden()
    {
        $sql = "SELECT a.idDgoTipoCalificacion,a.descripcion,a.idGenEstado,ge.descripcion as estado 
        FROM  dgoTipoCalificacion a 
        INNER JOIN genEstado ge on ge.idGenEstado=a.idGenEstado 
         WHERE a.delLog='N' ORDER BY a.idDgoTipoCalificacion DESC";
        return $sql;
    }
    public function getClasificacionOrden()
    {
        return $this->consultarAll($this->getSqlClasificacionOrden());
    }

    public function getEditClasificacionOrden($idDgoTipoCalificacion)
    {
        $sql = "SELECT a.idDgoTipoCalificacion,a.descripcion,a.idGenEstado,ge.descripcion estado from dgoTipoCalificacion a INNER JOIN genEstado ge on ge.idGenEstado=a.idGenEstado AND a.idDgoTipoCalificacion={$idDgoTipoCalificacion}  AND a.delLog='N'";
        return $this->consultar($sql);
    }

    public function registrarClasificacionOrden($datos)
    {
        $tabla      = 'dgoTipoCalificacion';
        $tStructure = array(
            'idGenEstado' => 'idGenEstado',
            'descripcion' => 'descripcion',
            'delLog'      => 'delLog',
        );
        $datos['delLog'] = 'N';
        $descripcion     = 'descripcion,delLog';

        if (empty($datos['idDgoTipoCalificacion'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoTipoCalificacion != " . $datos['idDgoTipoCalificacion'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarClasificacionOrden($idDgoTipoCalificacion)
    {
        if (!empty($idDgoTipoCalificacion)) {
            $respuesta = $this->delete($this->tabla, $idDgoTipoCalificacion);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlClasificacionOrdenPdf()
    {
        $sql = "SELECT a.idDgoTipoCalificacion cero,a.descripcion uno,a.idGenEstado,ge.descripcion dos
                FROM dgoTipoCalificacion a
                INNER JOIN genEstado ge on ge.idGenEstado=a.idGenEstado
                WHERE a.delLog='N'";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlClasificacionOrdenPdf());
    }
}
