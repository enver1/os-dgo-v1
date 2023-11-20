<?php
class DgoInstruccionesOrden extends Transaccion
{
    private $tabla   = 'dgoDetalleInstrucciones';
    private $idTabla = 'idDgoDetalleInstrucciones';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaDgoInstruccionesOrden()
    {
        return $this->tabla;
    }
    public function getSqlDgoInstruccionesOrden($idDgoOrdenServicio, $tipo)
    {
        $sql = "SELECT a.idDgoDetalleInstrucciones,a.descripcion,a.temporalidad,a.tipo
        FROM  dgoDetalleInstrucciones a 
       
         WHERE a.delLog='N' AND a.tipo='" . $tipo . "' 
         AND a.idDgoOrdenServicio=" . $idDgoOrdenServicio . " ORDER BY a.temporalidad ";
        return $sql;
    }
    public function getDgoInstruccionesOrden($idDgoOrdenServicio, $tipo)
    {
        return $this->consultarAll($this->getSqlDgoInstruccionesOrden($idDgoOrdenServicio, $tipo));
    }

    public function getEditDgoInstruccionesOrden($idDgoDetalleInstrucciones)
    {
        $sql = "SELECT a.idDgoDetalleInstrucciones,a.descripcion,a.temporalidad,a.tipo
        FROM dgoDetalleInstrucciones a WHERE a.idDgoDetalleInstrucciones={$idDgoDetalleInstrucciones}";
        return $this->consultar($sql);
    }

    public function registrarDgoInstruccionesOrden($datos, $tipo)
    {
        $tabla      = 'dgoDetalleInstrucciones';
        $tStructure = array(
            'descripcion' => 'descripcion',
            'idDgoOrdenServicio' => 'idDgoOrdenServicio',
            'temporalidad' => 'temporalidad',
            'tipo'      => 'tipo',
            'delLog'      => 'delLog',
        );
        $datos['delLog'] = 'N';
        $descripcion     = 'descripcion,delLog';
        $datos['tipo'] = $tipo;
        if (empty($datos['idDgoDetalleInstrucciones'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoDetalleInstrucciones != " . $datos['idDgoDetalleInstrucciones'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarDgoInstruccionesOrden($idDgoDetalleInstrucciones)
    {
        if (!empty($idDgoDetalleInstrucciones)) {
            $respuesta = $this->delete($this->tabla, $idDgoDetalleInstrucciones);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlDgoInstruccionesOrdenPdf($tipo)
    {
        $sql = "SELECT a.idDgoDetalleInstrucciones as cero,a.temporalidad as uno,a.tipo,a.descripcion as dos
                FROM dgoDetalleInstrucciones a
                WHERE a.delLog='N' AND a.tipo=$tipo ORDER BY a.temporalidad";
        return $sql;
    }
    public function getDatosImprimirPdf($tipo)
    {
        return $this->consultarAll($this->getSqlDgoInstruccionesOrdenPdf($tipo));
    }
}
