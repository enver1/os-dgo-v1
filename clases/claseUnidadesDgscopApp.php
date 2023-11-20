<?php
class UnidadesDgscopApp extends Transaccion
{
    private $tabla   = 'dnaUnidadApp';
    private $idTabla = 'idDnaUnidadApp';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaDgscopUnidadApp()
    {
        return $this->tabla;
    }
    public function getSqlUnidadesDgscopApp($filtro)
    {
        $sql = "SELECT
                a.idDnaUnidadApp,
                a.descripcionUnidad,
                a.idGenEstado,
                a.imagenUnidad,
                ge.descripcion as estado
            FROM
                dnaUnidadApp a
                INNER JOIN genEstado ge ON ge.idGenEstado = a.idGenEstado
            WHERE
                a.delLog = 'N'
                AND a.filtro='{$filtro}' 
            ORDER BY
                a.idDnaUnidadApp DESC";
        return $sql;
    }
    public function getUnidadesDgscopApp($filtro)
    {
        return $this->consultarAll($this->getSqlUnidadesDgscopApp($filtro));
    }

    public function getEditUnidadesDgscopApp($idDnaUnidadApp)
    {
        $sql = "SELECT
                a.idDnaUnidadApp,
                a.descripcionUnidad,
                a.imagenUnidad,
                a.idGenEstado
            FROM
                dnaUnidadApp a
                INNER JOIN genEstado ge ON ge.idGenEstado = a.idGenEstado
                WHERE a.idDnaUnidadApp={$idDnaUnidadApp}";
        return $this->consultar($sql);
    }

    public function registrarUnidadesDgscopApp($datos, $file)
    {
        $FormUnidadesDgscopApp = new FormUnidadesDgscopApp;
        $tabla = 'dnaUnidadApp';

        $tStructure = array(
            'idGenEstado'  => 'idGenEstado',
            'descripcionUnidad'  => 'descripcionUnidad',
            'imagenUnidad'  => 'imagenUnidad',
            'delLog'       => 'delLog',
            'filtro' => 'filtro',
        );
        $datos['delLog']       = 'N';
        $datos['filtro']       = 'APP_DGSCOP';
        $descripcion           = 'descripcionUnidad,delLog,filtro';

        if (empty($datos['idDnaUnidadApp'])) {
            $respuesta = $this->insertArchivo($tabla, $tStructure, $datos, $FormUnidadesDgscopApp->getCamposUnidadesDgscopApp(), $file, $descripcion);
        } else {
            $conDupli  = " and idDnaUnidadApp != {$datos['idDnaUnidadApp']}";
            $respuesta = $this->updateArchivo($tabla, $tStructure, $datos, $FormUnidadesDgscopApp->getCamposUnidadesDgscopApp(), $file, $descripcion, $conDupli);
        }
        return $respuesta;
    }

    public function eliminarUnidadesDgscopApp($idDnaUnidadApp)
    {
        if (!empty($idDnaUnidadApp)) {
            $respuesta = $this->delete($this->tabla, $idDnaUnidadApp);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlUnidadesDgscopAppPdf($filtro)
    {
        $sql = "SELECT
                a.idDnaUnidadApp as cero,
                a.descripcionUnidad as uno ,
                a.idGenEstado,
                ge.descripcion as dos
            FROM
                dnaUnidadApp a
                INNER JOIN genEstado ge ON ge.idGenEstado = a.idGenEstado
                    WHERE a.delLog='N'
                    AND a.filtro='{$filtro}' 
                    ORDER BY a.idDnaUnidadApp DESC";
        return $sql;
    }
    public function getDatosImprimirUnidadesDgscopAppPdf($filtro)
    {
        return $this->consultarAll($this->getSqlUnidadesDgscopAppPdf($filtro));
    }
}
