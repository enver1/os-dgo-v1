<?php
class DgoEvaluacionInf extends Transaccion
{
    private $tabla   = 'dgoEvaluacionInf';
    private $idTabla = 'idDgoEvaluacionInf';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaDgoEvaluacionInf()
    {
        return $this->tabla;
    }
    public function getSqlDgoEvaluacionInf($idDgoInfOrdenServicio)
    {
        $sql = "SELECT a.idDgoEvaluacionInf,a.descripcion,a.idDgoTipoEvaluacionInf,b.descripcion as tipo
        FROM  dgoEvaluacionInf a 
      		INNER JOIN dgoTipoEvaluacionInf b ON a.idDgoTipoEvaluacionInf = b.idDgoTipoEvaluacionInf 
         WHERE a.delLog='N' 
      
         AND a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . " ORDER BY a.idDgoTipoEvaluacionInf ";
        return $sql;
    }
    public function getDgoEvaluacionInf($idDgoInfOrdenServicio)
    {
        return $this->consultarAll($this->getSqlDgoEvaluacionInf($idDgoInfOrdenServicio));
    }

    public function getEditDgoEvaluacionInf($idDgoEvaluacionInf)
    {
        $sql = "SELECT a.idDgoEvaluacionInf,a.descripcion,a.idDgoTipoEvaluacionInf,b.descripcion as tipo
        FROM  dgoEvaluacionInf a 
      		INNER JOIN dgoTipoEvaluacionInf b ON a.idDgoTipoEvaluacionInf = b.idDgoTipoEvaluacionInf 
         WHERE a.delLog='N' 
             
        WHERE a.idDgoEvaluacionInf={$idDgoEvaluacionInf}";
        return $this->consultar($sql);
    }

    public function registrarDgoEvaluacionInf($datos)
    {
        $tabla      = 'dgoEvaluacionInf';
        $tStructure = array(
            'descripcion' => 'descripcion',
            'idDgoInfOrdenServicio' => 'idDgoInfOrdenServicio',
            'idDgoTipoEvaluacionInf' => 'idDgoTipoEvaluacionInf',
            'delLog'      => 'delLog',
        );
        $datos['delLog'] = 'N';
        $descripcion     = 'descripcion,delLog';

        if (empty($datos['idDgoEvaluacionInf'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoEvaluacionInf != " . $datos['idDgoEvaluacionInf'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarDgoEvaluacionInf($idDgoEvaluacionInf)
    {
        if (!empty($idDgoEvaluacionInf)) {
            $respuesta = $this->delete($this->tabla, $idDgoEvaluacionInf);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlDgoEvaluacionInfPdf($tipo)
    {
        $sql = "SELECT a.idDgoEvaluacionInf as cero,a.idDgoTipoEvaluacionInf as uno,a.tipo,a.descripcion as dos
                FROM dgoEvaluacionInf a
                WHERE a.delLog='N' AND a.tipo=$tipo ORDER BY a.idDgoTipoEvaluacionInf";
        return $sql;
    }
    public function getDatosImprimirPdf($tipo)
    {
        return $this->consultarAll($this->getSqlDgoEvaluacionInfPdf($tipo));
    }
}
