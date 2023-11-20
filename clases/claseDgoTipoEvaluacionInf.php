<?php
class DgoTipoEvaluacionInf extends Transaccion
{
    private $tabla   = 'dgoTipoEvaluacionInf';
    private $idTabla = 'idDgoTipoEvaluacionInf';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaDgoTipoEvaluacionInf()
    {
        return $this->tabla;
    }
    public function getSqlDgoTipoEvaluacionInf()
    {
        $sql = "SELECT a.idDgoTipoEvaluacionInf,a.descripcion,a.idGenEstado,ge.descripcion as estado 
        FROM  dgoTipoEvaluacionInf a 
        INNER JOIN genEstado ge on ge.idGenEstado=a.idGenEstado 
         WHERE a.delLog='N' ORDER BY a.idDgoTipoEvaluacionInf DESC";
        return $sql;
    }
    public function getDgoTipoEvaluacionInf()
    {
        return $this->consultarAll($this->getSqlDgoTipoEvaluacionInf());
    }

    public function getEditDgoTipoEvaluacionInf($idDgoTipoEvaluacionInf)
    {
        $sql = "SELECT a.idDgoTipoEvaluacionInf,a.descripcion,a.idGenEstado,ge.descripcion estado from dgoTipoEvaluacionInf a INNER JOIN genEstado ge on ge.idGenEstado=a.idGenEstado AND a.idDgoTipoEvaluacionInf={$idDgoTipoEvaluacionInf}  AND a.delLog='N'";
        return $this->consultar($sql);
    }

    public function registrarDgoTipoEvaluacionInf($datos)
    {
        $tabla      = 'dgoTipoEvaluacionInf';
        $tStructure = array(
            'idGenEstado' => 'idGenEstado',
            'descripcion' => 'descripcion',
            'delLog'      => 'delLog',
        );
        $datos['delLog'] = 'N';
        $descripcion     = 'descripcion,delLog';

        if (empty($datos['idDgoTipoEvaluacionInf'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoTipoEvaluacionInf != " . $datos['idDgoTipoEvaluacionInf'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarDgoTipoEvaluacionInf($idDgoTipoEvaluacionInf)
    {
        if (!empty($idDgoTipoEvaluacionInf)) {
            $respuesta = $this->delete($this->tabla, $idDgoTipoEvaluacionInf);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlDgoTipoEvaluacionInfPdf()
    {
        $sql = "SELECT a.idDgoTipoEvaluacionInf cero,a.descripcion uno,a.idGenEstado,ge.descripcion dos
                FROM dgoTipoEvaluacionInf a
                INNER JOIN genEstado ge on ge.idGenEstado=a.idGenEstado
                WHERE a.delLog='N'";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlDgoTipoEvaluacionInfPdf());
    }
}
