<?php
class NovedadesElect extends Transaccion
{
    private $tabla   = 'dgoNovedadesElect';
    private $idTabla = 'idDgoNovedadesElect';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaNovedadesElect()
    {
        return $this->tabla;
    }

    public function getSqlNovedadesElect()
    {
        $sql = "SELECT
                    a.idDgoNovedadesElect,
                    a.dgo_idDgoNovedadesElect,
                    a.descripcion,
                IF (a.dgo_idDgoNovedadesElect=0,'RAIZ',(SELECT n.descripcion from dgoNovedadesElect n WHERE n.idDgoNovedadesElect =a.dgo_idDgoNovedadesElect  AND n.delLog='N')) as descrip1,b.descripcion as estado
                FROM
                    dgoNovedadesElect a
                     INNER JOIN genEstado b on b.idGenEstado=a.idGenEstado
                WHERE a.delLog='N'
                 AND a.idDgoNovedadesElect<>1  AND a.idDgoNovedadesElect<>38  AND a.idDgoNovedadesElect<>39  AND a.idDgoNovedadesElect<>40
                ORDER BY dgo_idDgoNovedadesElect";

        return $sql;
    }
    public function getNovedadesElect()
    {
        return $this->consultarAll($this->getSqlNovedadesElect());
    }

    public function getEditNovedadesElect($idDgoNovedadesElect)
    {
        /*$sql = "SELECT a.idDgoNovedadesElect,IF (a.idDgoNovedadesElect>= 0,a.idDgoNovedadesElect,'') as aux1,
        IF (a.dgo_idDgoNovedadesElect=0,0,a.dgo_idDgoNovedadesElect) aux,a.dgo_idDgoNovedadesElect as idPadre,a.descripcion,
        b.descripcion as estado, a.nomCorto,b.idGenEstado
        FROM dgoNovedadesElect a
        INNER JOIN genEstado b on b.idGenEstado=a.idGenEstado
        WHERE a.idDgoNovedadesElect={$idDgoNovedadesElect}";
        return $this->consultar($sql);*/

        $sql = "SELECT  a.idDgoNovedadesElect,
        IF( isnull(a.idDgoNovedadesElect) , a.idDgoNovedadesElect, '' ) as aux1,
        IF( isnull(a.dgo_idDgoNovedadesElect), null, a.dgo_idDgoNovedadesElect ) as aux,
            a.dgo_idDgoNovedadesElect,
            a.descripcion,
            a.nomCorto,
            sc.descripcion AS descripcionPadre,
            ge.idGenEstado,
            ge.descripcion as estado
        FROM
            dgoNovedadesElect a
            LEFT JOIN dgoNovedadesElect sc ON sc.idDgoNovedadesElect = a.dgo_idDgoNovedadesElect 
            INNER JOIN genEstado ge ON ge.idGenEstado=a.idGenEstado
        WHERE
            a.idDgoNovedadesElect = {$idDgoNovedadesElect}";
        return $this->consultar($sql);
    }





    public function registrarNovedadesElect($datos)
    {
        $tStructure = array(
            'dgo_idDgoNovedadesElect' => 'dgo_idDgoNovedadesElect',
            'idGenEstado'     => 'idGenEstado',
            'descripcion'     => 'descripcion',
            'nomCorto'        => 'nomCorto',
            'delLog'          => 'delLog',
        );
        $descripcion = 'dgo_idDgoNovedadesElect,descripcion,idGenEstado';
        $datos['delLog'] = 'N';

        if (empty($datos['idDgoNovedadesElect'])) {
            if (empty($datos['dgo_idDgoNovedadesElect'])) {
                $datos['dgo_idDgoNovedadesElect'] = null;
            }
            $respuesta = $this->insert($this->tabla, $tStructure, $datos, $descripcion);
        } else {
            if (empty($datos['dgo_idDgoNovedadesElect'])) {
                $datos['dgo_idDgoNovedadesElect'] = null;
            }
            $conDupli  = " and idDgoNovedadesElect != " . $datos['idDgoNovedadesElect'];
            $respuesta = $this->update($this->tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }


    public function eliminarNovedadesElect($conn, $idDgoNovedadesElect)
    {
        if (!empty($idDgoNovedadesElect)) {
            $respuesta = $this->delete($this->tabla, $idDgoNovedadesElect);
            $this->borraDependientes($conn, $idDgoNovedadesElect);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlNovedadesElectPdf()
    {
        $sql = "SELECT
                    a.idDgoNovedadesElect cero,
                    a.dgo_idDgoNovedadesElect,
                    a.descripcion dos,
                IF (a.dgo_idDgoNovedadesElect=0,'RAIZ',(SELECT n.descripcion from dgoNovedadesElect n WHERE n.idDgoNovedadesElect =a.dgo_idDgoNovedadesElect  AND n.delLog='N')) uno
                FROM
                    dgoNovedadesElect a
                WHERE a.delLog='N'
                ORDER BY dgo_idDgoNovedadesElect";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlNovedadesElectPdf());
    }

    public function borraDependientes($conn, $idDgoNovedadesElect)
    {
        $sql = "SELECT
                    count(a.idDgoNovedadesElect) cuantos
                FROM
                    dgoNovedadesElect a
                WHERE a.delLog='N'
                AND a.dgo_idDgoNovedadesElect='" . $idDgoNovedadesElect . "'";

        $rs   = $conn->query($sql);
        $rowB = $rs->fetch();
        if ($rowB['cuantos'] == 0) {
        } else {
            $sql1 = "UPDATE dgoNovedadesElect SET delLog='S' WHERE dgo_idDgoNovedadesElect='" . $idDgoNovedadesElect . "'";
            $conn->query($sql1);
        }
    }
    ////////////////////////////PARA ARBOL FUNCIONES PAR ARBOL 
    public function getSqlArbolTipoNovedadesElectorales($idDgoNovedadesElect)
    {
        if (!empty($idDgoNovedadesElect)) {
            $sql = "SELECT a.idDgoNovedadesElect,a.dgo_idDgoNovedadesElect,a.descripcion ,ge.idGenEstado,ge.descripcion as estado 
            FROM dgoNovedadesElect a  
            INNER JOIN genEstado ge ON ge.idGenEstado=a.idGenEstado
            where  a.dgo_idDgoNovedadesElect ='{$idDgoNovedadesElect}' AND a.delLog='N'   AND a.idDgoNovedadesElect<>1  AND a.idDgoNovedadesElect<>38  AND a.idDgoNovedadesElect<>39  AND a.idDgoNovedadesElect<>40
                 order by 1";
        } else {
            $sql = "SELECT  a.idDgoNovedadesElect,a.dgo_idDgoNovedadesElect,a.descripcion,ge.idGenEstado,ge.descripcion as estado 
               FROM dgoNovedadesElect a 
               INNER JOIN genEstado ge ON ge.idGenEstado=a.idGenEstado
             where  a.dgo_idDgoNovedadesElect is null  AND a.delLog='N'    AND a.idDgoNovedadesElect<>1  AND a.idDgoNovedadesElect<>38  AND a.idDgoNovedadesElect<>39  AND a.idDgoNovedadesElect<>40
                 order by 2";
        }

        return $sql;
    }
    public function getDatosArbolTipoNovedadesElectorales($idDgoNovedadesElect)
    {
        return $this->consultarAll($this->getSqlArbolTipoNovedadesElectorales($idDgoNovedadesElect));
    }
    public function getSqlTotalArbolTipoNovedadesElectorales($idDgoNovedadesElect)
    {
        $sql = "SELECT count(*) numreg FROM dgoNovedadesElect 
        WHERE dgo_idDgoNovedadesElect='{$idDgoNovedadesElect}'";
        return $sql;
    }
}
