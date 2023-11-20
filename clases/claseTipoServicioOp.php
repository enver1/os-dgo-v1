<?php
class TipoServicioOp extends Transaccion
{
    private $tabla   = 'hdrTipoServicio';
    private $idTabla = 'idHdrTipoServicio';
    public function getIdCampoTipoServicioOp()
    {
        return $this->idTabla;
    }
    public function getTablaTipoServicioOp()
    {
        return $this->tabla;
    }
    public function getSqlTipoServicioOp()
    {
        $sql = "SELECT a.idHdrTipoServicio,a.descripcion  from hdrTipoServicio a WHERE  a.delLog='N' ORDER BY a.idHdrTipoServicio DESC";
        return $sql;
    }
    public function getTipoServicioOp()
    {
        return $this->consultarAll($this->getSqlTipoServicioOp());
    }

    public function getEditTipoServicioOp($idHdrTipoServicio)
    {
        $sql = "SELECT a.idHdrTipoServicio,a.descripcion  from hdrTipoServicio a
        WHERE a.idHdrTipoServicio={$idHdrTipoServicio}";
        return $this->consultar($sql);
    }

    public function registrarTipoServicioOp($datos)
    {

        $tabla = 'hdrTipoServicio';

        $tStructure = array(

            'descripcion' => 'descripcion',


        );

        $descripcion     = 'descripcion';

        if (empty($datos['idHdrTipoServicio'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idHdrTipoServicio != " . $datos['idHdrTipoServicio'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }

    public function eliminarTipoServicioOp($idHdrTipoServicio)
    {

        if (!empty($idHdrTipoServicio)) {
            $respuesta = $this->delete($this->tabla, $idHdrTipoServicio);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlTipoServicioOpPdf()
    {
        $sql = "SELECT a.idHdrTipoServicio cero,a.descripcion uno FROM hdrTipoServicio a";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlTipoServicioOpPdf());
    }
}