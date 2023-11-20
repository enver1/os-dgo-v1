<?php
class TipoEjeComisios extends Transaccion
{
    private $tabla   = 'dgoTipoEje';
    private $idTabla = 'idDgoTipoEje';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaTipoEjeComisios()
    {
        return $this->tabla;
    }

    public function getSqlTipoEjeComisios()
    {
        $sql = "SELECT
                    a.idDgoTipoEje,
                    a.dgo_idDgoTipoEje,
                    a.descripcion,
                    a.idGenEstado,
                    gg.descripcion as estado,
                IF (a.dgo_idDgoTipoEje=0,'RAIZ',(SELECT n.descripcion from dgoTipoEje n WHERE n.idDgoTipoEje =a.dgo_idDgoTipoEje  AND n.delLog='N')) as descrip1
                FROM
                    dgoTipoEje a
                INNER JOIN genEstado gg on gg.idGenEstado=a.idGenEstado
                WHERE a.delLog='N'
                ORDER BY dgo_idDgoTipoEje";

        return $sql;
    }
    public function getTipoEjeComisios()
    {
        return $this->consultarAll($this->getSqlTipoEjeComisios());
    }

    public function getEditTipoEjeComisios($idDgoTipoEje)
    {
        $sql = "SELECT  a.idDgoTipoEje,
                        a.dgo_idDgoTipoEje,
                        a.descripcion,
                        a.idGenEstado,
                        b.descripcion AS descripcionPadre,
                        gg.descripcion as estado
                    FROM
                        dgoTipoEje a 
                        LEFT JOIN dgoTipoEje b ON b.idDgoTipoEje=a.dgo_idDgoTipoEje
                        INNER JOIN genEstado gg on gg.idGenEstado=a.idGenEstado
                    WHERE
                    a.idDgoTipoEje ={$idDgoTipoEje}
                    AND a.delLog = 'N'";
        return $this->consultar($sql);
    }


    public function registrarTipoEjeComisios($datos)
    {
        $tStructure = array(
            'dgo_idDgoTipoEje' => 'dgo_idDgoTipoEje',
            'descripcion'      => 'descripcion',
            'idGenEstado'      => 'idGenEstado',
            'delLog'           => 'delLog',
        );
        $datos['delLog'] = 'N';
        $descripcion = 'dgo_idDgoTipoEje,descripcion,idGenEstado,delLog';

        if (empty($datos['idDgoTipoEje'])) {
            if (empty($datos['dgo_idDgoTipoEje'])) {
                $datos['dgo_idDgoTipoEje'] = null;
            }
            $respuesta = $this->insert($this->tabla, $tStructure, $datos, $descripcion);
        } else {
            if (empty($datos['dgo_idDgoTipoEje'])) {
                $datos['dgo_idDgoTipoEje'] = null;
            }
            $conDupli  = " and idDgoTipoEje != " . $datos['idDgoTipoEje'];
            $respuesta = $this->update($this->tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }


    public function eliminarTipoEjeComisios($conn, $idDgoTipoEje)
    {
        if (!empty($idDgoTipoEje)) {
            $respuesta = $this->delete($this->tabla, $idDgoTipoEje);
            $this->borraDependientes($conn, $idDgoTipoEje);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlTipoEjeComisiosPdf()
    {
        $sql = "SELECT
                    a.idDgoTipoEje cero,
                    a.dgo_idDgoTipoEje,
                    a.descripcion dos,
                    a.idGenEstado,
                    gg.descripcion as estado,
                IF (a.dgo_idDgoTipoEje=0,'RAIZ',(SELECT n.descripcion from dgoTipoEje n WHERE n.idDgoTipoEje =a.dgo_idDgoTipoEje  AND n.delLog='N')) uno
                FROM
                    dgoTipoEje a
                    INNER JOIN genEstado gg on gg.idGenEstado=a.idGenEstado
                WHERE a.delLog='N'
                
                ORDER BY dgo_idDgoTipoEje";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlTipoEjeComisiosPdf());
    }

    public function borraDependientes($conn, $idDgoTipoEje)
    {
        $sql = "SELECT
                    count(a.idDgoTipoEje) cuantos
                FROM
                    dgoTipoEje a
                WHERE a.delLog='N'
                AND a.dgo_idDgoTipoEje='" . $idDgoTipoEje . "'";

        $rs   = $conn->query($sql);
        $rowB = $rs->fetch();
        if ($rowB['cuantos'] == 0) {
        } else {
            $sql1 = "UPDATE dgoTipoEje SET delLog='S' WHERE dgo_idDgoTipoEje='" . $idDgoTipoEje . "'";
            $conn->query($sql1);
        }
    }

    ////////////////////////////PARA ARBOL FUNCIONES PAR ARBOL 
    public function getSqlArbolTipoEje($idDgoTipoEje)
    {
        if (!empty($idDgoTipoEje)) {
            $sql = "SELECT a.idDgoTipoEje,a.dgo_idDgoTipoEje,a.descripcion ,ge.idGenEstado,ge.descripcion as estado 
            FROM dgoTipoEje a  
            INNER JOIN genEstado ge ON ge.idGenEstado=a.idGenEstado
            where  a.dgo_idDgoTipoEje ='{$idDgoTipoEje}' AND a.delLog='N'  order by 1";
        } else {
            $sql = "SELECT  a.idDgoTipoEje,a.dgo_idDgoTipoEje,a.descripcion,ge.idGenEstado,ge.descripcion as estado 
               FROM dgoTipoEje a 
               INNER JOIN genEstado ge ON ge.idGenEstado=a.idGenEstado
             where  a.dgo_idDgoTipoEje is null  AND a.delLog='N'    order by 2";
        }
        return $sql;
    }
    public function getDatosArbolTipoEje($idDgoTipoEje)
    {
        return $this->consultarAll($this->getSqlArbolTipoEje($idDgoTipoEje));
    }
    public function getSqlTotalArbolTipoEje($idDgoTipoEje)
    {
        $sql = "SELECT count(*) numreg FROM dgoTipoEje 
        WHERE dgo_idDgoTipoEje='{$idDgoTipoEje}'";
        return $sql;
    }
}
