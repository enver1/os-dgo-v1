<?php
class TipoOperativoOrden extends Transaccion
{
    private $tabla   = 'genTipoOperativo';
    private $idTabla = 'idGenTipoOperativo';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTabla()
    {
        return $this->tabla;
    }
    public function getSqlTipoOperativoOrden()
    {
        $sql = "SELECT
                        a.idGenTipoOperativo,
                    IF (isnull (a.genTipoOperativo_idGenTipoOperativo),'RAIZ',sc.descripcion) as descrip1,
                        a.genTipoOperativo_idGenTipoOperativo,
                        a.descripcion,
                        sc.descripcion AS descripcionPadre 
                    FROM
                        genTipoOperativo a
                        LEFT JOIN genTipoOperativo sc ON sc.idGenTipoOperativo = a.genTipoOperativo_idGenTipoOperativo
                        INNER JOIN genEstado ge ON ge.idGenEstado=a.idGenEstado
                WHERE a.delLog='N'
                ORDER BY genTipoOperativo_idGenTipoOperativo";

        return $sql;
    }
    public function getTipoOperativoOrden()
    {
        return $this->consultarAll($this->getSqlTipoOperativoOrden());
    }

    public function getEditTipoOperativoOrden($idGenTipoOperativo)
    {

        $sql = "SELECT  a.idGenTipoOperativo,
                        IF( isnull(a.idGenTipoOperativo) , a.idGenTipoOperativo, '' ) as aux1,
                        IF( isnull(a.genTipoOperativo_idGenTipoOperativo), null, a.genTipoOperativo_idGenTipoOperativo ) as aux,
                            a.genTipoOperativo_idGenTipoOperativo,
                            a.descripcion,
                            sc.descripcion AS descripcionPadre,
                            ge.idGenEstado,
                            ge.descripcion as estado
                        FROM
                            genTipoOperativo a
                            LEFT JOIN genTipoOperativo sc ON sc.idGenTipoOperativo = a.genTipoOperativo_idGenTipoOperativo 
                            INNER JOIN genEstado ge ON ge.idGenEstado=a.idGenEstado
                        WHERE
                            a.idGenTipoOperativo = {$idGenTipoOperativo}";
        return $this->consultar($sql);
    }

    public function registrarTipoOperativoOrden($datos)
    {
        $tStructure = array(
            'genTipoOperativo_idGenTipoOperativo' => 'genTipoOperativo_idGenTipoOperativo',
            'idGenEstado'     => 'idGenEstado',
            'descripcion'     => 'descripcion',
            'delLog'            => 'delLog',
        );
        $descripcion = 'genTipoOperativo_idGenTipoOperativo,descripcion,idGenEstado';
        $datos['delLog'] = 'N';

        if (empty($datos['idGenTipoOperativo'])) {
            if (empty($datos['genTipoOperativo_idGenTipoOperativo'])) {
                $datos['genTipoOperativo_idGenTipoOperativo'] = null;
            }
            $respuesta = $this->insert($this->tabla, $tStructure, $datos, $descripcion);
        } else {
            if (empty($datos['genTipoOperativo_idGenTipoOperativo'])) {
                $datos['genTipoOperativo_idGenTipoOperativo'] = null;
            }
            $conDupli  = " and idGenTipoOperativo != " . $datos['idGenTipoOperativo'];
            $respuesta = $this->update($this->tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }

    public function eliminarTipoOperativoOrden($idGenTipoOperativo)
    {
        if (!empty($idGenTipoOperativo)) {
            $respuesta = $this->delete($this->tabla, $idGenTipoOperativo);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlTipoOperativoOrdenPdf()
    {
        $sql = "SELECT
                    a.idGenTipoOperativo as cero,
                    a.genTipoOperativo_idGenTipoOperativo,
                    ge.descripcion as tres,
                    a.descripcion as dos,     
                IF (ISNULL(a.genTipoOperativo_idGenTipoOperativo),'RAIZ',(SELECT n.descripcion from genTipoOperativo n WHERE n.idGenTipoOperativo =a.genTipoOperativo_idGenTipoOperativo  AND n.delLog='N')) as uno
                FROM
                    genTipoOperativo a   
                    INNER JOIN genEstado ge ON ge.idGenEstado=a.idGenEstado    
                WHERE a.delLog='N'
                ORDER BY a.genTipoOperativo_idGenTipoOperativo";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlTipoOperativoOrdenPdf());
    }

    ////////////////////////////PARA ARBOL FUNCIONES PAR ARBOL 
    public function getSqlArbolTipoOperativoOrden($idGenTipoOperativo)
    {
        if (!empty($idGenTipoOperativo)) {
            $sql = "SELECT a.idGenTipoOperativo,a.genTipoOperativo_idGenTipoOperativo,a.descripcion ,ge.idGenEstado,ge.descripcion as estado 
            FROM genTipoOperativo a  
            INNER JOIN genEstado ge ON ge.idGenEstado=a.idGenEstado
            where  a.genTipoOperativo_idGenTipoOperativo ='{$idGenTipoOperativo}' AND a.delLog='N' order by 1";
        } else {
            $sql = "SELECT  a.idGenTipoOperativo,a.genTipoOperativo_idGenTipoOperativo,a.descripcion,ge.idGenEstado,ge.descripcion as estado 
               FROM genTipoOperativo a 
               INNER JOIN genEstado ge ON ge.idGenEstado=a.idGenEstado
             where  a.genTipoOperativo_idGenTipoOperativo is null  AND a.delLog='N'  order by 2";
        }

        return $sql;
    }
    public function getDatosArbolTipoOperativoOrden($idGenTipoOperativo)
    {
        return $this->consultarAll($this->getSqlArbolTipoOperativoOrden($idGenTipoOperativo));
    }
    public function getSqlTotalArbolTipoOperativoOrden($idGenTipoOperativo)
    {
        $sql = "SELECT count(*) numreg FROM genTipoOperativo 
        WHERE genTipoOperativo_idGenTipoOperativo='{$idGenTipoOperativo}' AND delLog='N'";
        return $sql;
    }
}
