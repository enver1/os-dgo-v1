<?php
class NovedadesEje extends Transaccion
{
    private $tabla   = 'dgoNovedadesEje';
    private $idTabla = 'idDgoNovedadesEje';
    public function getIdCampoNovedadesEje()
    {
        return $this->idTabla;
    }
    public function getTablaNovedadesEje()
    {
        return $this->tabla;
    }
    public function getSqlNovedadesEje()
    {

        $sql = "SELECT a.idDgoNovedadesEje,
                        a.idDgoNovedadesElect,
                        a.idGenEstado,
                        a.idDgoTipoEje,
                        te.descripcion as tipoEje,
                        ne.descripcion,
                        g.descripcion as estado
                        FROM
                        dgoNovedadesEje a
                        INNER JOIN dgoTipoEje te ON te.idDgoTipoEje=a.idDgoTipoEje
                        INNER JOIN dgoNovedadesElect ne on ne.idDgoNovedadesElect=a.idDgoNovedadesElect
                        INNER JOIN genEstado g on g.idGenEstado=a.idGenEstado
                        WHERE
                        a.delLog='N'
                        AND
                        te.delLog='N'
                        AND
                        ne.delLog='N' 
                        ORDER BY te.idDgoTipoEje,ne.idDgoNovedadesElect";

        return $sql;
    }
    public function getNovedadesEje()
    {
        return $this->consultarAll($this->getSqlNovedadesEje());
    }

    public function getEditNovedadesEje($idDgoNovedadesEje)
    {
        $sql = "SELECT      a.idDgoNovedadesEje,
                            a.idDgoNovedadesElect,
                            a.idGenEstado,
                            a.idDgoTipoEje,
                            IF((t1.idDgoTipoEje is null),a.idDgoTipoEje,t1.idDgoTipoEje) as idDgoTipoEje2,
                            IF((t2.idDgoTipoEje is null), IF((t1.idDgoTipoEje is null),a.idDgoTipoEje,t1.idDgoTipoEje),t2.idDgoTipoEje) as idDgoTipoEje1, 
                            te.descripcion AS TipoEje,
                            ne.descripcion AS descripcion,
                            g.descripcion AS estado 
                        FROM
                            dgoNovedadesEje a
                            INNER JOIN dgoTipoEje te ON te.idDgoTipoEje = a.idDgoTipoEje
                            LEFT JOIN dgoTipoEje t1 ON t1.idDgoTipoEje = te.dgo_idDgoTipoEje
                            LEFT JOIN dgoTipoEje t2 ON t2.idDgoTipoEje = t1.dgo_idDgoTipoEje
                            INNER JOIN dgoNovedadesElect ne ON ne.idDgoNovedadesElect = a.idDgoNovedadesElect
                            INNER JOIN genEstado g ON g.idGenEstado = a.idGenEstado 
                            
                        WHERE
                            a.idDgoNovedadesEje ='{$idDgoNovedadesEje}'";
        return $this->consultar($sql);
    }

    public function registrarNovedadesEje($datos, $seleccionado)
    {
        $idDgoNovedadesElect = explode(',', $seleccionado);

        $tabla      = 'dgoNovedadesEje';
        $tStructure = array(
            'idDgoNovedadesElect' => 'idDgoNovedadesElect',
            'idDgoTipoEje'        => 'idDgoTipoEje',
            'idGenEstado'         => 'idGenEstado',
            'delLog'              => 'delLog',

        );
        $datos['delLog'] = 'N';
        $descripcion     = 'idDgoTipoEje,idDgoNovedadesElect,delLog';
        if (empty($datos['idDgoTipoEje'])) {
            if ((!empty($datos['auxiliar']))) {
                $datos['idDgoTipoEje'] = $datos['auxiliar'];
            } else {
                $datos['idDgoTipoEje'] = $datos['idDgoTipoEje2'];
            }
        }

        if (empty($datos['idDgoNovedadesEje'])) {
            foreach ($idDgoNovedadesElect as $key => $value) {
                $datos['idDgoNovedadesElect'] = $value;
                $datos['idGenEstado']         = 1;
                $respuesta                    = $this->insert($this->tabla, $tStructure, $datos, $descripcion);
            }
        } else {

            $conDupli  = " and idDgoNovedadesEje != " . $datos['idDgoNovedadesEje'];
            $respuesta = $this->update($this->tabla, $tStructure, $datos, $descripcion, $conDupli);
        }
        return $respuesta;
    }

    public function registrarNovedadesEjeEditar($datos)
    {
        $sql1 = "UPDATE dgoNovedadesEje SET idGenEstado=" . $datos['idGenEstado'] . "   WHERE idDgoNovedadesEje=" . $datos['idDgoNovedadesEje'];
        $this->conn->query($sql1);
        return  array(true, 'Estado Actualizado Correctamente', 1);
    }


    public function eliminarNovedadesEje($idDgoNovedadesEje)
    {
        if (!empty($idDgoNovedadesEje)) {
            $respuesta = $this->delete($this->tabla, $idDgoNovedadesEje);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlNovedadesEjePdf()
    {
        $sql = "SELECT
                    a.idDgoNovedadesEje cero,
                    a.dgo_idDgoNovedadesEje,
                    a.descripcion dos,
                IF (a.dgo_idDgoNovedadesEje=0,'RAIZ',(SELECT n.descripcion from dgoNovedadesEje n WHERE n.idDgoNovedadesEje =a.dgo_idDgoNovedadesEje  AND n.delLog='N')) uno
                FROM
                    dgoNovedadesEje a
                WHERE a.delLog='N'
                ORDER BY dgo_idDgoNovedadesEje";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlNovedadesEjePdf());
    }
    /*  public function getSqlArbolNovedadesEje($idDgoTipoEje)
    {
        if (!empty($idDgoTipoEje)) {
            return "SELECT idDgoNovedadesElect,descripcion,dgo_idDgoNovedadesElect
                    FROM dgoNovedadesElect
                    WHERE dgo_idDgoNovedadesElect is not null  ORDER BY  idDgoNovedadesElect";
        } else {
            return "SELECT idDgoNovedadesElect,descripcion,dgo_idDgoNovedadesElect
                    FROM dgoNovedadesElect
                    WHERE dgo_idDgoNovedadesElect is not null  ORDER BY  idDgoNovedadesElect";
        }
    }

    public function getDatosArbolNovedadesEje($idDgoNovedadesElect)
    {

        return $this->consultarAll($this->getSqlArbolNovedadesEje($idDgoNovedadesElect));
    }

    public function getTotalArbolNovedadesEje($idDgoNovedadesElect)
    {
        return "SELECT count(*) numreg FROM dgoNovedadesElect WHERE  ISNULL(idDgoNovedadesElect)    ORDER BY  idDgoNovedadesElect";

    }*/


    public function getSqlArbolNovedadesEje($idDgoNovedadesElect)
    {
        if (!empty($idDgoNovedadesElect)) {
            return "SELECT a.idDgoNovedadesElect,a.dgo_idDgoNovedadesElect,a.descripcion
                    FROM dgoNovedadesElect a
                    WHERE a.dgo_idDgoNovedadesElect ='{$idDgoNovedadesElect}' AND a.idDgoNovedadesElect<>38 AND a.idDgoNovedadesElect<>1 AND a.idDgoNovedadesElect<>39 AND a.idDgoNovedadesElect<>40 AND a.delLog='N'  ORDER BY  dgo_idDgoNovedadesElect";
        } else {
            return "SELECT idDgoNovedadesElect,dgo_idDgoNovedadesElect,descripcion
                    FROM dgoNovedadesElect
                    WHERE dgo_idDgoNovedadesElect is null AND idDgoNovedadesElect<>1 AND idDgoNovedadesElect<>38 AND idDgoNovedadesElect<>39 AND idDgoNovedadesElect<>40  AND delLog='N' ORDER BY  idDgoNovedadesElect";
        }
    }

    public function getDatosArbolNovedadesEje($idDgoNovedadesElect)
    {

        return $this->consultarAll($this->getSqlArbolNovedadesEje($idDgoNovedadesElect));
    }

    public function getTotalArbolNovedadesEje($idDgoNovedadesElect)
    {
        return "SELECT count(*) numreg FROM dgoNovedadesElect WHERE dgo_idDgoNovedadesElect='{$idDgoNovedadesElect}'";
    }
}
