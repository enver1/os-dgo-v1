<?php
class Comisios extends Transaccion
{
    private $tabla   = 'dgoComisios';
    private $idTabla = 'idDgoComisios';
    public function getIdCampoComisios()
    {
        return $this->idTabla;
    }
    public function getTablaComisios()
    {
        return $this->tabla;
    }
    public function getSqlComisios($idDgoReciElect)
    {
        $sql = "SELECT
                    a.idDgoComisios,
                    a.idDgoProcElec,
                    a.idDgoReciElect,
                    a.numElectores,
                    a.numJuntMascu,
                    a.numJuntFeme,
                    b.descProcElecc,
                    c.codRecintoElec,
                    c.nomRecintoElec,
                    c.direcRecintoElec
                FROM
                    dgoComisios a
                    INNER JOIN dgoProcElec b ON b.idDgoProcElec = a.idDgoProcElec
                    INNER JOIN dgoReciElect c ON c.idDgoReciElect = a.idDgoReciElect
                WHERE
                    a.delLog = 'N'
                     AND
                    c.delLog='N'  
                    AND a.idDgoReciElect = {$idDgoReciElect} ORDER BY a.idDgoComisios DESC";

        return $sql;
    }
    public function getComisios($idDgoReciElect)
    {
        return $this->consultarAll($this->getSqlComisios($idDgoReciElect));
    }

    public function getEditComisios($idDgoComisios)
    {
        $sql = "SELECT a.idDgoComisios,a.idDgoProcElec,a.idDgoReciElect,a.numElectores,a.numJuntMascu,a.numJuntFeme  FROM dgoComisios a
         WHERE a.idDgoComisios={$idDgoComisios}";
        return $this->consultar($sql);
    }

    public function registrarComisios($datos)
    {

        $tabla      = 'dgoComisios';
        $tStructure = array(
            'idDgoProcElec'  => 'idDgoProcElec',
            'idDgoReciElect' => 'idDgoReciElect',
            'numElectores'   => 'numElectores',
            'numJuntMascu'   => 'numJuntMascu',
            'numJuntFeme'    => 'numJuntFeme',
            'delLog'         => 'delLog',

        );
        $datos['delLog']       = 'N';
        $descripcion           = 'idDgoProcElec,idDgoReciElect,delLog';
        $datos['numElectores'] = (!empty($datos['numElectores'])) ? $datos['numElectores'] : 0;
        $datos['numJuntMascu'] = (!empty($datos['numJuntMascu'])) ? $datos['numJuntMascu'] : 0;
        $datos['numJuntFeme']  = (!empty($datos['numJuntFeme'])) ? $datos['numJuntFeme'] : 0;
        if (empty($datos['idDgoComisios'])) {

            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoComisios != " . $datos['idDgoComisios'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }

    public function eliminarComisios($idDgoComisios)
    {
        if (!empty($idDgoComisios)) {
            $respuesta = $this->delete($this->tabla, $idDgoComisios);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlComisiosPdf()
    {
        $sql = "SELECT a.idDgoComisios cero,a.descProcElecc uno ,a.fechaInici dos,a.fechaFin tres,a.idGenEstado,b.descripcion cuatro  FROM dgoComisios a
        INNER JOIN genEstado b on b.idGenEstado=a.idGenEstado
         WHERE a.delLog='N'";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlComisiosPdf());
    }

    public function verificaProcesoActivo()
    {
        $sql = "SELECT
                    COUNT(*) cuantos
                FROM
                    dgoComisios a
                WHERE
                    a.delLog = 'N'
                AND a.idGenEstado=1";
        return $this->consultar($sql);
    }

    public function getInformacionRecinto($idDgoReciElect)
    {
        $sql = "SELECT
                    a.idDgoProcElec,
                    a.idDgoReciElect,
                    a.numElectores,
                    a.numJuntMascu,
                    a.numJuntFeme
                FROM
                    dgoComisios a
                WHERE
                    a.delLog = 'N'
                AND a.idDgoReciElect ={$idDgoReciElect} ";
        return $this->consultar($sql);
    }
    public function getSqlComisiosEnProceso($idDgoProcElec, $idDgoReciElect)
    {
        $sql = "SELECT
                    a.idDgoComisios,
                    a.idDgoProcElec,
                    a.idDgoReciElect,
                    a.numElectores,
                    a.numJuntMascu,
                    a.numJuntFeme,
                    b.descProcElecc,
                    c.codRecintoElec,
                    c.nomRecintoElec,
                    c.direcRecintoElec
                FROM
                    dgoComisios a
                    INNER JOIN dgoProcElec b ON b.idDgoProcElec = a.idDgoProcElec
                    INNER JOIN dgoReciElect c ON c.idDgoReciElect = a.idDgoReciElect
                WHERE
                    a.delLog = 'N'
                    AND
                    c.delLog='N'  
                    AND a.idDgoReciElect={$idDgoReciElect} ORDER BY a.idDgoReciElect DESC LIMIT 1";

        return $sql;
    }
    public function getComisiosEnProceso($idDgoProcElec, $idDgoReciElect)
    {
        return $this->consultar($this->getSqlComisiosEnProceso($idDgoProcElec, $idDgoReciElect));
    }

    public function registrarComisiosProceso($datos, $seleccionados, $isRecinto)
    {
        $sele    = array();
        $sele    = explode(',', $seleccionados);
        $nombres = explode(',', $isRecinto);

        if (!empty($sele) && $sele[0] > 0) {


            if ($sele[0] == 1) {
                $recintos = $this->getRecintosElectorales();
                foreach ($recintos as $key => $value) {

                    $comisios = $this->getComisiosEnProceso($datos['idDgoProcElec'], $value['idDgoReciElect']);
                    //  print_r($comisios);
                    if (empty($comisios)) {
                        $datos['idDgoProcElec']  = $datos['idDgoProcElec'];
                        $datos['idDgoReciElect'] = $value['idDgoReciElect'];;
                        $datos['numElectores']   = 0;
                        $datos['numJuntMascu']   = 0;
                        $datos['numJuntFeme']    = 0;
                        $datos['delLog']         = 'N';
                    } else {
                        $datos['idDgoProcElec']  = $datos['idDgoProcElec'];
                        $datos['idDgoReciElect'] = $value['idDgoReciElect'];
                        $datos['numElectores']   = $comisios['numElectores'];
                        $datos['numJuntMascu']   = $comisios['numJuntMascu'];
                        $datos['numJuntFeme']    = $comisios['numJuntFeme'];
                        $datos['delLog']         = 'N';
                    }

                    $tabla      = 'dgoComisios';
                    $tStructure = array(
                        'idDgoProcElec'  => 'idDgoProcElec',
                        'idDgoReciElect' => 'idDgoReciElect',
                        'numElectores'   => 'numElectores',
                        'numJuntMascu'   => 'numJuntMascu',
                        'numJuntFeme'    => 'numJuntFeme',
                        'delLog'         => 'delLog',

                    );

                    $descripcion = 'idDgoProcElec,idDgoReciElect,delLog';
                    if (empty($datos['idDgoComisios'])) {

                        $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
                    } else {
                        $conDupli  = " and idDgoComisios != " . $datos['idDgoComisios'];
                        $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
                    }
                }
            } else {
                for ($i = 0; $i < sizeof($sele); $i++) {
                    $verificar = $this->verifica($sele[$i], $nombres[$i]);
                    if ($verificar == 1) {
                        $respuesta = (array(false, 'UNO DE LOS DATOS SELECCIONADOS NO TIENE UNA UNIDAD CREADA', 0));
                    } else {
                        $comisios = $this->getComisiosEnProceso($datos['idDgoProcElec'], $sele[$i]);
                        if (empty($comisios)) {
                            $datos['idDgoProcElec']  = $datos['idDgoProcElec'];
                            $datos['idDgoReciElect'] = $sele[$i];
                            $datos['numElectores']   = 0;
                            $datos['numJuntMascu']   = 0;
                            $datos['numJuntFeme']    = 0;
                            $datos['delLog']         = 'N';
                        } else {
                            $datos['idDgoProcElec']  = $datos['idDgoProcElec'];
                            $datos['idDgoReciElect'] = $sele[$i];
                            $datos['numElectores']   = $comisios['numElectores'];
                            $datos['numJuntMascu']   = $comisios['numJuntMascu'];
                            $datos['numJuntFeme']    = $comisios['numJuntFeme'];
                            $datos['delLog']         = 'N';
                        }

                        $tabla      = 'dgoComisios';
                        $tStructure = array(
                            'idDgoProcElec'  => 'idDgoProcElec',
                            'idDgoReciElect' => 'idDgoReciElect',
                            'numElectores'   => 'numElectores',
                            'numJuntMascu'   => 'numJuntMascu',
                            'numJuntFeme'    => 'numJuntFeme',
                            'delLog'         => 'delLog',

                        );

                        $descripcion = 'idDgoProcElec,idDgoReciElect,delLog';
                        if (empty($datos['idDgoComisios'])) {

                            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
                        } else {
                            $conDupli  = " and idDgoComisios != " . $datos['idDgoComisios'];
                            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
                        }
                    }
                }
            }
        } else {
            $respuesta = (array(false, "SLECCIONE UNA UNAIDAD", 0));
        }
        return $respuesta;
    }
    public function getRecintosElectorales()
    {
        $sql = "   SELECT       c.idDgoReciElect,
                            c.codRecintoElec,
                            c.nomRecintoElec,
                            c.direcRecintoElec
                        FROM
                            dgoReciElect c
                        WHERE
                            c.delLog = 'N'
                            AND c.idDgoTipoEje =1";
        return $this->consultarAll($sql);
    }
    public function getSqlComisiosP($idDgoProcElec)
    {
        $sql = "SELECT
                    a.idDgoComisios,
                    a.idDgoProcElec,
                    a.idDgoReciElect,
                    a.numElectores,
                    a.numJuntMascu,
                    a.numJuntFeme,
                    b.descProcElecc,
                    c.codRecintoElec,
                    c.nomRecintoElec,
                    c.direcRecintoElec
                FROM
                    dgoComisios a
                    INNER JOIN dgoProcElec b ON b.idDgoProcElec = a.idDgoProcElec
                    INNER JOIN dgoReciElect c ON c.idDgoReciElect = a.idDgoReciElect
                WHERE
                    a.delLog = 'N'
                     AND
                    c.delLog='N'                    
                    AND b.idDgoProcElec = {$idDgoProcElec} ORDER BY a.idDgoComisios DESC";


        return $sql;
    }
    public function getComisiosP($idDgoProcElec)
    {
        return $this->consultarAll($this->getSqlComisiosP($idDgoProcElec));
    }

    public function verifica($id, $nombres)
    {
        $recinto = $this->evaluaRecinto($id);
        $eje     = $this->evaluaEje($id);

        if ($eje['idDgoTipoEje'] == 0) {
            return 0;
        }
        if ($recinto['idDgoTipoEje'] != $eje['idDgoTipoEje']) {
            if ($eje['descripcion'] == $nombres) {
                return 1;
            } else {
                return 0;
            }
        }
        if ($recinto['idDgoTipoEje'] == $eje['idDgoTipoEje']) {
            return 0;
        }
    }

    public function evaluaEje($id)
    {
        $sql = "SELECT  a.idDgoTipoEje,
                        a.descripcion
                    FROM
                        dgoTipoEje a
                    WHERE
                    a.delLog='N'
                    AND
                        a.idDgoTipoEje ='{$id}'";

        $var = $this->consultar($sql);
        if (empty($var)) {
            $var['idDgoTipoEje'] = 0;
        } else {
            $var;
        }

        return $var;
    }

    public function evaluaRecinto($id)
    {
        $sql = "SELECT  b.idDgoReciElect,
                        b.idDgoTipoEje,
                        b.nomRecintoElec AS descripcion
                    FROM
                        dgoReciElect b
                        INNER JOIN dgoTipoEje a ON a.idDgoTipoEje=b.idDgoTipoEje
                        WHERE
                        b.delLog='N'
                        AND
                        b.idDgoReciElect = '{$id}'";

        return $this->consultar($sql);
    }
}
