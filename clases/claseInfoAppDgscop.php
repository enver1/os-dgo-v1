<?php
class InfoAppDgscop extends Transaccion
{
    private $tabla   = 'dnaInfoApp';
    private $idTabla = 'idDnaInfoApp';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaInfoAppDgscop()
    {
        return $this->tabla;
    }
    public function getSqlInfoAppDgscop($filtro)
    {
        $sql = "SELECT
                a.idDnaInfoApp,
                a.idDnaUnidadApp,
                a.nombreBoton,
                a.idGenEstado,
                a.icono,
                a.orden,
                ge.descripcion as estado,
                b.descripcionUnidad,
                IF(a.`dna_IdDnaInfoApp`>0,(SELECT dnaI.nombreBoton FROM dnaInfoApp dnaI WHERE dnaI.idDnaInfoApp =a.`dna_IdDnaInfoApp`  ), a.nombreBoton ) AS menu,
                IF(LENGTH((SELECT dnaI.nombreBoton FROM dnaInfoApp dnaI WHERE dnaI.idDnaInfoApp =a.`dna_IdDnaInfoApp`  ))>0,a.nombreBoton ,'') AS subMenu
           
            FROM
                dnaInfoApp a
                INNER JOIN genEstado ge ON ge.idGenEstado = a.idGenEstado
                INNER JOIN dnaUnidadApp b ON b.idDnaUnidadApp = a.idDnaUnidadApp
           WHERE
                a.delLog = 'N'
                AND a.filtro='{$filtro}' 
          
            ORDER BY ISNULL(a.`orden`), a.`orden` ASC, a.`idDnaInfoApp` DESC ";
        return $sql;
    }
    public function getInfoAppDgscop($filtro)
    {
        return $this->consultarAll($this->getSqlInfoAppDgscop($filtro));
    }

    public function getEditInfoAppDgscop($idDnaInfoApp)
    {
        $sql = "SELECT
                    a.idDnaInfoApp,               
                    a.nombreBoton,
                    a.idGenEstado,
                    a.icono,
                    a.orden,
                    ge.descripcion as estado,
                    b.descripcionUnidad,
                    b.idDnaUnidadApp,
                    IF(LENGTH(a.`dna_IdDnaInfoApp`)>0,a.dna_IdDnaInfoApp,  0) AS dna_IdDnaInfoApp
            
                FROM
                    dnaInfoApp a
                    INNER JOIN genEstado ge ON ge.idGenEstado = a.idGenEstado
                    INNER JOIN dnaUnidadApp b ON b.idDnaUnidadApp = a.idDnaUnidadApp
                WHERE a.idDnaInfoApp={$idDnaInfoApp}";
        return $this->consultar($sql);
    }

    public function registrarInfoAppDgscop($datos, $file)
    {
        $formInfoApp = new FormInfoAppDgscop;
        $tabla = 'dnaInfoApp';

        $tStructure = array(
            'idGenEstado'  => 'idGenEstado',
            'idDnaUnidadApp' => 'idDnaUnidadApp',
            'dna_IdDnaInfoApp' => 'dna_IdDnaInfoApp',
            'nombreBoton'  => 'nombreBoton',
            'orden'  => 'orden',
            'icono'  => 'icono',
            'delLog'       => 'delLog',
            'filtro' => 'filtro',
        );
        $datos['delLog']       = 'N';
        $datos['filtro']       = 'APP_DGSCOP';
        $descripcion           = 'nombreBoton,idDnaUnidadApp,delLog,filtro';




        if (empty($datos['idDnaInfoApp'])) {
            $respuesta = $this->insertArchivo($tabla, $tStructure, $datos, $formInfoApp->getCamposInfoAppDgscop(), $file, $descripcion);
        } else {
            $conDupli  = " and idDnaInfoApp != {$datos['idDnaInfoApp']}";
            $respuesta = $this->updateArchivo($tabla, $tStructure, $datos, $formInfoApp->getCamposInfoAppDgscop(), $file, $descripcion, $conDupli);
        }

        return $respuesta;
    }

    public function eliminarInfoAppDgscop($idDnaInfoApp)
    {
        if (!empty($idDnaInfoApp)) {
            $respuesta = $this->delete($this->tabla, $idDnaInfoApp);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlInfoAppPdfDgscop($filtro)
    {
        $sql = "SELECT
                        a.idDnaInfoApp as cero,
                        a.idDnaUnidadApp,
                        a.nombreBoton as dos,
                        a.idGenEstado,
                        a.icono,
                        ge.descripcion as tres,
                        b.descripcionUnidad as uno
                
                    FROM
                        dnaInfoApp a
                        INNER JOIN genEstado ge ON ge.idGenEstado = a.idGenEstado
                        INNER JOIN dnaUnidadApp b ON b.idDnaUnidadApp = a.idDnaUnidadApp
                WHERE
                        a.delLog = 'N'
                        AND a.filtro='{$filtro}' 
                        ORDER BY ISNULL(a.`orden`), a.`orden` ASC, a.`idDnaInfoApp` DESC ";
        return $sql;
    }
    public function getDatosImprimirInfoAppPdfDgscop($filtro)
    {
        return $this->consultarAll($this->getSqlInfoAppPdfDgscop($filtro));
    }
}