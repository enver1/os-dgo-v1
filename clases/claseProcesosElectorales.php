<?php
class ProcesosElectorales extends Transaccion
{
    private $tabla   = 'dgoProcElec';
    private $idTabla = 'idDgoProcElec';
    public function getIdCampoProcesosElectorales()
    {
        return $this->idTabla;
    }
    public function getTablaProcesosElectorales()
    {
        return $this->tabla;
    }
    public function getSqlProcesosElectorales()
    {
        $sql = "SELECT a.idDgoProcElec,a.descProcElecc,a.fechaInici,a.fechaFin,a.idGenEstado,b.descripcion as estado, IF(a.tipo='N','NACIONAL','LOCAL') as  tipo,a.idGenGeoSenplades,g.descripcion

        FROM dgoProcElec a
        INNER JOIN genEstado b on b.idGenEstado=a.idGenEstado
        LEFT JOIN genGeoSenplades g ON g.idGenGeoSenplades=a.idGenGeoSenplades
         WHERE a.delLog='N' ORDER BY a.idDgoProcElec DESC";
        return $sql;
    }
    public function getProcesosElectorales()
    {
        return $this->consultarAll($this->getSqlProcesosElectorales());
    }

    public function getEditProcesosElectorales($idDgoProcElec)
    {
        $sql = "SELECT a.idDgoProcElec,a.descProcElecc,a.fechaInici,a.fechaFin,a.idGenEstado,b.descripcion as estado,b.idGenEstado aux,a.idGenGeoSenplades,g.descripcion as senpladesDescripcion,a.tipo
        FROM dgoProcElec a
        INNER JOIN genEstado b on b.idGenEstado=a.idGenEstado
        LEFT JOIN genGeoSenplades g ON g.idGenGeoSenplades=a.idGenGeoSenplades
         WHERE a.idDgoProcElec={$idDgoProcElec}";
        return $this->consultar($sql);
    }

    public function registrarProcesosElectorales($datos)
    {
        $tabla      = 'dgoProcElec';
        $tStructure = array(

            'descProcElecc'     => 'descProcElecc',
            'fechaInici'        => 'fechaInici',
            'fechaFin'          => 'fechaFin',
            'idGenEstado'       => 'idGenEstado',
            'idGenGeoSenplades' => 'idGenGeoSenplades',
            'tipo'              => 'tipo',
            'delLog'            => 'delLog',
        );
        $datos['delLog']            = 'N';
        $descripcion                = 'descProcElecc,delLog,idGenEstado';
        $datos['idGenGeoSenplades'] = (!empty($datos['idGenGeoSenplades'])) ? $datos['idGenGeoSenplades'] : null;
        $datos['fechaFin']          = (!empty($datos['fechaFin'])) ? $datos['fechaFin'] : null;
        if (empty($datos['idDgoProcElec'])) {

            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoProcElec != " . $datos['idDgoProcElec'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }
        return $respuesta;
    }

    public function eliminarProcesosElectorales($idDgoProcElec)
    {
        if (!empty($idDgoProcElec)) {
            $respuesta = $this->delete($this->tabla, $idDgoProcElec);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;

    }

    public function getSqlProcesosElectoralesPdf()
    {
        $sql = "SELECT a.idDgoProcElec cero,a.descProcElecc tres ,a.fechaInici cuatro,a.fechaFin cinco,a.idGenEstado,b.descripcion seis, IF(a.tipo='N','NACIONAL','LOCAL') as  uno,a.idGenGeoSenplades,g.descripcion dos

        FROM dgoProcElec a
        INNER JOIN genEstado b on b.idGenEstado=a.idGenEstado
           LEFT JOIN genGeoSenplades g ON g.idGenGeoSenplades=a.idGenGeoSenplades
         WHERE a.delLog='N'";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlProcesosElectoralesPdf());
    }

    public function verificaProcesoActivo()
    {
        $sql = "SELECT
                    COUNT(*) cuantos
                FROM
                    dgoProcElec a
                WHERE
                    a.delLog = 'N'
                AND a.idGenEstado=1";
        return $this->consultar($sql);

    }

}
