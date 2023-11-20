<?php
class TipoAspectoCg extends Transaccion
{
    private $tabla   = 'cgTipoAspecto';
    private $idTabla = 'idCgTipoAspecto';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTabla()
    {
        return $this->tabla;
    }
    public function getSqlTipoAspectoCg()
    {
        $sql = "SELECT
                        a.idCgTipoAspecto,
                    IF (isnull (a.cg_idCgTipoAspecto),'RAIZ',sc.descripcion) as descrip1,
                        a.cg_idCgTipoAspecto,
                        a.descripcion,
                        sc.descripcion AS descripcionPadre 
                    FROM
                        cgTipoAspecto a
                        LEFT JOIN cgTipoAspecto sc ON sc.idCgTipoAspecto = a.cg_idCgTipoAspecto
                        INNER JOIN genEstado ge ON ge.idGenEstado=a.idGenEstado
                WHERE a.delLog='N'
                ORDER BY cg_idCgTipoAspecto";

        return $sql;
    }
    public function getTipoAspectoCg()
    {
        return $this->consultarAll($this->getSqlTipoAspectoCg());
    }

    public function getEditTipoAspectoCg($idCgTipoAspecto)
    {

        $sql = "SELECT  a.idCgTipoAspecto,
                        IF( isnull(a.idCgTipoAspecto) , a.idCgTipoAspecto, '' ) as aux1,
                        IF( isnull(a.cg_idCgTipoAspecto), null, a.cg_idCgTipoAspecto ) as aux,
                            a.cg_idCgTipoAspecto,
                            a.descripcion,
                            sc.descripcion AS descripcionPadre,
                            ge.idGenEstado,
                            ge.descripcion as estado
                        FROM
                            cgTipoAspecto a
                            LEFT JOIN cgTipoAspecto sc ON sc.idCgTipoAspecto = a.cg_idCgTipoAspecto 
                            INNER JOIN genEstado ge ON ge.idGenEstado=a.idGenEstado
                        WHERE
                            a.idCgTipoAspecto = {$idCgTipoAspecto}";
        return $this->consultar($sql);
    }

    public function registrarTipoAspectoCg($datos)
    {
        $tStructure = array(
            'cg_idCgTipoAspecto' => 'cg_idCgTipoAspecto',
            'idGenEstado'     => 'idGenEstado',
            'descripcion'     => 'descripcion',
            'delLog'            => 'delLog',
        );
        $descripcion = 'cg_idCgTipoAspecto,descripcion,idGenEstado';
        $datos['delLog'] = 'N';

        if (empty($datos['idCgTipoAspecto'])) {
            if (empty($datos['cg_idCgTipoAspecto'])) {
                $datos['cg_idCgTipoAspecto'] = null;
            }
            $respuesta = $this->insert($this->tabla, $tStructure, $datos, $descripcion);
        } else {
            if (empty($datos['cg_idCgTipoAspecto'])) {
                $datos['cg_idCgTipoAspecto'] = null;
            }
            $conDupli  = " and idCgTipoAspecto != " . $datos['idCgTipoAspecto'];
            $respuesta = $this->update($this->tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }

    public function eliminarTipoAspectoCg($idCgTipoAspecto)
    {
        if (!empty($idCgTipoAspecto)) {
            $respuesta = $this->delete($this->tabla, $idCgTipoAspecto);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlTipoAspectoCgPdf()
    {
        $sql = "SELECT
                    a.idCgTipoAspecto as cero,
                    a.cg_idCgTipoAspecto,
                    ge.descripcion as tres,
                    a.descripcion as dos,     
                IF (ISNULL(a.cg_idCgTipoAspecto),'RAIZ',(SELECT n.descripcion from cgTipoAspecto n WHERE n.idCgTipoAspecto =a.cg_idCgTipoAspecto  AND n.delLog='N')) as uno
                FROM
                    cgTipoAspecto a   
                    INNER JOIN genEstado ge ON ge.idGenEstado=a.idGenEstado    
                WHERE a.delLog='N'
                ORDER BY a.cg_idCgTipoAspecto";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlTipoAspectoCgPdf());
    }

    ////////////////////////////PARA ARBOL
    //FUNCIONES PAR ARBOL 
    public function getSqlArbolTipoAspectoCg($idCgTipoAspecto)
    {
        if (!empty($idCgTipoAspecto)) {
            $sql = "SELECT a.idCgTipoAspecto,a.cg_idCgTipoAspecto,a.descripcion ,ge.idGenEstado,ge.descripcion as estado 
            FROM cgTipoAspecto a  
            INNER JOIN genEstado ge ON ge.idGenEstado=a.idGenEstado
            where  a.cg_idCgTipoAspecto ='{$idCgTipoAspecto}' AND a.delLog='N' order by 1";
        } else {
            $sql = "SELECT  a.idCgTipoAspecto,a.cg_idCgTipoAspecto,a.descripcion,ge.idGenEstado,ge.descripcion as estado 
               FROM cgTipoAspecto a 
               INNER JOIN genEstado ge ON ge.idGenEstado=a.idGenEstado
             where  a.cg_idCgTipoAspecto is null  AND a.delLog='N'  order by 2";
        }

        return $sql;
    }
    public function getDatosArbolTipoAspectoCg($idCgTipoAspecto)
    {
        return $this->consultarAll($this->getSqlArbolTipoAspectoCg($idCgTipoAspecto));
    }
    public function getSqlTotalArbolTipoAspectoCg($idCgTipoAspecto)
    {
        $sql = "SELECT count(*) numreg FROM cgTipoAspecto 
        WHERE cg_idCgTipoAspecto='{$idCgTipoAspecto}' AND delLog='N'";
        return $sql;
    }
}
