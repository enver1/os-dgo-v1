<?php
class DetalleInfoAppDgscop extends Transaccion
{
    private $tabla   = 'dnaInfoDetalleApp';
    private $idTabla = 'idDnaInfoDetalleApp';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaDetalleInfoAppDgscop()
    {
        return $this->tabla;
    }
    public function getSqlDetalleInfoAppDgscop($filtro)
    {
        $sql = "SELECT
                    di.idDnaInfoDetalleApp,
                    di.idDnaInfoApp,
                    di.idGenEstado,
                    di.idDnaPerfilVer,
                    ua.idDnaUnidadApp,
                    dia.dna_IdDnaInfoApp AS idDnaInfoAppHija,
                    ua.descripcionUnidad AS modulo,  
                    IF(LENGTH(dia.`dna_IdDnaInfoApp`)>0,(SELECT dnaI.nombreBoton FROM dnaInfoApp dnaI WHERE dnaI.idDnaInfoApp =dia.`dna_IdDnaInfoApp`  ), dia.nombreBoton ) AS menu,
                    IF(LENGTH((SELECT dnaI.nombreBoton FROM dnaInfoApp dnaI WHERE dnaI.idDnaInfoApp =dia.`dna_IdDnaInfoApp`  ))>0,dia.nombreBoton ,'') AS subMenu,  
                    di.detalle,
                    di.filtro,
                    di.accion,
                    di.iconoDetalle,
                    pv.descripcion AS permiso,
                    ge.descripcion AS estado
                FROM
                    dnaInfoDetalleApp di
                    INNER JOIN genEstado ge ON ge.idGenEstado = di.idGenEstado
                    INNER JOIN dnaInfoApp dia ON dia.idDnaInfoApp = di.idDnaInfoApp
                    INNER JOIN dnaUnidadApp ua ON ua.idDnaUnidadApp = dia.idDnaUnidadApp
                    INNER JOIN dnaPerfilVer pv ON pv.idDnaPerfilVer = di.idDnaPerfilVer
                
            WHERE
            di.delLog = 'N'
            AND dia.filtro='{$filtro}'

                    ORDER BY
            di.idDnaInfoDetalleApp DESC";
        return $sql;
    }
    public function getDetalleInfoAppDgscop($filtro)
    {
        return $this->consultarAll($this->getSqlDetalleInfoAppDgscop($filtro));
    }

    public function getEditDetalleInfoAppDgscop($idDnaInfoDetalleApp)
    {



        $sql = "SELECT
                    di.idDnaInfoDetalleApp,
                    IF(LENGTH(dia.`dna_IdDnaInfoApp`)>0,dia.dna_IdDnaInfoApp,  di.idDnaInfoApp ) AS idDnaInfoApp,
                    IF(LENGTH(dia.`dna_IdDnaInfoApp`)>0,di.idDnaInfoApp,dia.dna_IdDnaInfoApp ) AS idDnaInfoAppHija,
                    di.idGenEstado,
                    di.idDnaPerfilVer,
                    ua.idDnaUnidadApp,
                    
                    ua.descripcionUnidad AS modulo,  

                    IF(LENGTH(dia.`dna_IdDnaInfoApp`)>0,(SELECT dnaI.nombreBoton FROM dnaInfoApp dnaI WHERE dnaI.idDnaInfoApp =dia.`dna_IdDnaInfoApp`  ), dia.nombreBoton ) AS menu,
                    IF(LENGTH((SELECT dnaI.nombreBoton FROM dnaInfoApp dnaI WHERE dnaI.idDnaInfoApp =dia.`dna_IdDnaInfoApp`  ))>0,dia.nombreBoton ,'') AS subMenu,  
                    di.detalle,
                    di.filtro,
                    di.accion,
                    di.accion as accion1,
                    di.iconoDetalle,
                    pv.descripcion AS permiso,
                    ge.descripcion AS estado
                FROM
                    dnaInfoDetalleApp di
                    INNER JOIN genEstado ge ON ge.idGenEstado = di.idGenEstado
                    INNER JOIN dnaInfoApp dia ON dia.idDnaInfoApp = di.idDnaInfoApp
                    INNER JOIN dnaUnidadApp ua ON ua.idDnaUnidadApp = dia.idDnaUnidadApp
                    INNER JOIN dnaPerfilVer pv ON pv.idDnaPerfilVer = di.idDnaPerfilVer
                
            WHERE di.idDnaInfoDetalleApp={$idDnaInfoDetalleApp}";



        return $this->consultar($sql);
    }

    public function registrarDetalleInfoAppDgscop($datos, $file)
    {
        $formDetalleInfoAppDgscop = new FormDetalleInfoAppDgscop;
        $tabla = 'dnaInfoDetalleApp';

        $tStructure = array(

            'idDnaInfoApp'    => 'idDnaInfoApp',
            'idDnaPerfilVer'  => 'idDnaPerfilVer',
            'idGenEstado'     => 'idGenEstado',
            'detalle'         => 'detalle',
            'filtro'          => 'filtro',
            'accion'          => 'accion',
            'iconoDetalle'    => 'iconoDetalle',
            'delLog'          => 'delLog',
        );
        $datos['delLog']       = 'N';
        $descripcion           = 'idDnaInfoApp,detalle,delLog,idDnaInfoApp';

        if ($datos['filtro'] != 'PDF') {
            $datos['accion'] = $datos['accion1'];
        }

        if (empty($datos['idDnaInfoDetalleApp'])) {
            $respuesta = $this->insertArchivo($tabla, $tStructure, $datos, $formDetalleInfoAppDgscop->getCamposDetalleInfoAppDgscop(), $file, $descripcion);
        } else {
            $conDupli  = " and idDnaInfoDetalleApp != {$datos['idDnaInfoDetalleApp']}";
            $respuesta = $this->updateArchivo($tabla, $tStructure, $datos, $formDetalleInfoAppDgscop->getCamposDetalleInfoAppDgscop(), $file, $descripcion, $conDupli);
        }

        return $respuesta;
    }

    public function eliminarDetalleInfoAppDgscop($idDnaInfoDetalleApp)
    {
        if (!empty($idDnaInfoDetalleApp)) {
            $respuesta = $this->delete($this->tabla, $idDnaInfoDetalleApp);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlDetalleInfoAppDgscopPdf($filtro)
    {
        $sql = "SELECT
                        di.idDnaInfoDetalleApp as cero,
                        di.idDnaInfoApp,
                        di.idGenEstado,
                        di.idDnaPerfilVer,
                        ua.idDnaUnidadApp,
                        ua.descripcionUnidad AS uno,
                        dia.nombreBoton AS dos,
                        di.detalle as tres,
                        di.filtro as cuatro,
                        di.accion as cinco,
                        di.iconoDetalle,
                        pv.descripcion AS seis,
                        ge.descripcion AS siete 
                    FROM
                        dnaInfoDetalleApp di
                        INNER JOIN genEstado ge ON ge.idGenEstado = di.idGenEstado
                        INNER JOIN dnaInfoApp dia ON dia.idDnaInfoApp = di.idDnaInfoApp
                        INNER JOIN dnaUnidadApp ua ON ua.idDnaUnidadApp = dia.idDnaUnidadApp
                        INNER JOIN dnaPerfilVer pv ON pv.idDnaPerfilVer = di.idDnaPerfilVer
                    WHERE di.delLog='N'
                    AND dia.filtro='{$filtro}' 
                    ORDER BY di.idDnaInfoDetalleApp DESC";
        return $sql;
    }
    public function getDatosImprimirDetalleInfoAppDgscopPdf($filtro)
    {
        return $this->consultarAll($this->getSqlDetalleInfoAppDgscopPdf($filtro));
    }
    public function getOpcionesUnidades($idDnaUnidadApp)
    {


        $sql = "SELECT
                    a.idDnaInfoApp,
                    a.idDnaUnidadApp,
                    a.nombreBoton,
                    a.idGenEstado,
                    a.icono,
                    ge.descripcion as estado,
                    b.descripcionUnidad
            
                FROM
                    dnaInfoApp a
                    INNER JOIN genEstado ge ON ge.idGenEstado = a.idGenEstado
                    INNER JOIN dnaUnidadApp b ON b.idDnaUnidadApp = a.idDnaUnidadApp
            WHERE
                    a.delLog = 'N'
                    AND a.filtro='APP_DGSCOP' 
                    AND `dna_IdDnaInfoApp`='' OR dna_IdDnaInfoApp=0 OR   ISNULL(`dna_IdDnaInfoApp`)
               AND a.idDnaUnidadApp={$idDnaUnidadApp}";
        return $this->consultarAll($sql);
    }


    public function getOpcionesUnidadesHijas($dna_IdDnaInfoApp)
    {


        $sql = "SELECT
                    a.idDnaInfoApp,
                    a.idDnaUnidadApp,
                    a.nombreBoton,
                    a.idGenEstado,
                    a.icono,
                    ge.descripcion as estado,
                    b.descripcionUnidad
            
                FROM
                    dnaInfoApp a
                    INNER JOIN genEstado ge ON ge.idGenEstado = a.idGenEstado
                    INNER JOIN dnaUnidadApp b ON b.idDnaUnidadApp = a.idDnaUnidadApp
            WHERE
          
             a.`delLog` = 'N'
            AND a.`idGenEstado` = 1
            AND a.filtro='APP_DGSCOP' 
            AND a.`dna_IdDnaInfoApp` IS NOT NULL
            AND a.`dna_IdDnaInfoApp`={$dna_IdDnaInfoApp}
            ORDER BY `orden` ASC";
        return $this->consultarAll($sql);
    }
}
