<?php
class MediosLogisticosOrden extends Transaccion
{
    private $tabla   = 'dgoMediosLogisticos';
    private $idTabla = 'idDgoMediosLogisticos';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaMediosLogisticosOrden()
    {
        return $this->tabla;
    }
    public function getSqlMediosLogisticosOrden()
    {
        $sql = "SELECT a.idDgoMediosLogisticos,a.descripcion,a.idGenEstado,ge.descripcion as estado 
        FROM  dgoMediosLogisticos a 
        INNER JOIN genEstado ge on ge.idGenEstado=a.idGenEstado 
         WHERE a.delLog='N' ORDER BY a.idDgoMediosLogisticos DESC";
        return $sql;
    }
    public function getMediosLogisticosOrden()
    {
        return $this->consultarAll($this->getSqlMediosLogisticosOrden());
    }

    public function getEditMediosLogisticosOrden($idDgoMediosLogisticos)
    {
        $sql = "SELECT a.idDgoMediosLogisticos,a.descripcion,a.idGenEstado,ge.descripcion estado from dgoMediosLogisticos a INNER JOIN genEstado ge on ge.idGenEstado=a.idGenEstado AND a.idDgoMediosLogisticos={$idDgoMediosLogisticos}  AND a.delLog='N'";
        return $this->consultar($sql);
    }

    public function registrarMediosLogisticosOrden($datos)
    {
        $tabla      = 'dgoMediosLogisticos';
        $tStructure = array(
            'idGenEstado' => 'idGenEstado',
            'descripcion' => 'descripcion',
            'delLog'      => 'delLog',
        );
        $datos['delLog'] = 'N';
        $descripcion     = 'descripcion,delLog';

        if (empty($datos['idDgoMediosLogisticos'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoMediosLogisticos != " . $datos['idDgoMediosLogisticos'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarMediosLogisticosOrden($idDgoMediosLogisticos)
    {
        if (!empty($idDgoMediosLogisticos)) {
            $respuesta = $this->delete($this->tabla, $idDgoMediosLogisticos);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlMediosLogisticosOrdenPdf()
    {
        $sql = "SELECT a.idDgoMediosLogisticos cero,a.descripcion uno,a.idGenEstado,ge.descripcion dos
                FROM dgoMediosLogisticos a
                INNER JOIN genEstado ge on ge.idGenEstado=a.idGenEstado
                WHERE a.delLog='N'";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlMediosLogisticosOrdenPdf());
    }
}
