<?php
class CrearOperativoReci extends Transaccion
{
    private $tabla   = 'dgoCreaOpReci';
    private $idTabla = 'idDgoCreaOpReci';
    public function getIdCampoCrearOperativoReci()
    {
        return $this->idTabla;
    }
    public function getTablaCrearOperativoReci()
    {
        return $this->tabla;
    }
    public function getSqlCrearOperativoReci()
    {

        $sql = "SELECT
                    pa.idDgoCreaOpReci,
                    rt.nomRecintoElec,
                    IF(pa.estado='A','ACTIVO','CERRADO') as estado,
                    CONCAT( a.siglas, '. ', a.apenom )AS jefe_operativo,
                    pa.fechaIni,
                    pa.FechaFin,
                    p.descProcElecc,
                    gs.telefono,
                    geo.descripcion AS subcircuito,
                    geoS.descripcion AS circuito,
                    geoD.descripcion AS Distrito,
                    geoSb.descripcion AS Subzona,
                    geoZ.descripcion AS Zona
                FROM
                    dgoCreaOpReci pa
                    INNER JOIN dgoPerAsigOpe gs ON gs.idDgoCreaOpReci = pa.idDgoCreaOpReci
                    LEFT JOIN v_personal_simple a ON a.idGenPersona = gs.idGenPersona
                    INNER JOIN dgoComisios c ON c.idDgoComisios=pa.idDgoComisios
                    INNER JOIN dgoReciElect rt ON rt.idDgoReciElect=c.idDgoReciElect
                    INNER JOIN dgoProcElec p ON p.idDgoProcElec=c.idDgoProcElec
                    LEFT JOIN genGeoSenplades geo ON geo.idGenGeoSenplades = rt.idGenGeoSenplades
                    LEFT JOIN genGeoSenplades geoS ON geoS.idGenGeoSenplades = geo.gen_idGenGeoSenplades
                    LEFT JOIN genGeoSenplades geoD ON geoD.idGenGeoSenplades = geoS.gen_idGenGeoSenplades
                    LEFT JOIN genGeoSenplades geoSb ON geoSb.idGenGeoSenplades = geoD.gen_idGenGeoSenplades
                    LEFT JOIN genGeoSenplades geoZ ON geoZ.idGenGeoSenplades = geoSb.gen_idGenGeoSenplades
                    WHERE
                    pa.delLog='N'
                    AND gs.cargo='J'
                    AND c.delLog='N'
                    AND rt.delLog='N'
                    AND p.idGenEstado=1
					AND p.delLog='N'
                    ORDER BY  pa.idDgoCreaOpReci DESC";

        return $sql;
    }
    public function getCrearOperativoReci()
    {
        return $this->consultarAll($this->getSqlCrearOperativoReci());
    }

    public function getEditCrearOperativoReci($idDgoCreaOpReci)
    {
        $sql = "SELECT
                    pa.idDgoCreaOpReci,
                    rt.nomRecintoElec,
                    pa.estado,
                    CONCAT( a.siglas, '. ', a.apenom )AS nombrePersonaC,
                    a.documento AS cedulaPersonaC,
                    a.documento AS auxC,
                    pa.fechaFin,
                    pa.fechaIni,
                    rt.idDgoReciElect,
                    rt.idDgoReciElect as idRecintoElec,
                    c.idDgoComisios as auxR,
                    pa.latitud,
                    pa.longitud,
                    gs.telefono,
                    c.idDgoComisios,
                    p.descProcElecc,
                    p.idDgoProcElec,
                    gs.idGenPersona,
                    gs.idDgoPerAsigOpe as idPer,
                    gss.descripcion AS senpladesDescripcion,
                    rt.idDgoTipoEje,
                    IF((t1.idDgoTipoEje is null),rt.idDgoTipoEje,t1.idDgoTipoEje) as idDgoTipoEje2,
                    IF((t2.idDgoTipoEje is null), IF((t1.idDgoTipoEje is null),rt.idDgoTipoEje,t1.idDgoTipoEje),t2.idDgoTipoEje) as idDgoTipoEje1
                FROM
                    dgoCreaOpReci pa
                    INNER JOIN dgoPerAsigOpe gs ON gs.idDgoCreaOpReci = pa.idDgoCreaOpReci
                    LEFT JOIN v_personal_simple a ON a.idGenPersona = gs.idGenPersona
                    INNER JOIN dgoComisios c ON c.idDgoComisios=pa.idDgoComisios
                    INNER JOIN dgoReciElect rt ON rt.idDgoReciElect=c.idDgoReciElect
                    INNER JOIN dgoProcElec p ON p.idDgoProcElec=c.idDgoProcElec
                    LEFT JOIN genGeoSenplades gss ON gss.idGenGeoSenplades=rt.idGenGeoSenplades
                    LEFT JOIN dgoTipoEje t ON t.idDgoTipoEje=rt.idDgoTipoEje
                    LEFT JOIN dgoTipoEje t1 ON t1.idDgoTipoEje=t.dgo_idDgoTipoEje
                    LEFT JOIN dgoTipoEje t2 ON t2.idDgoTipoEje=t1.dgo_idDgoTipoEje
                    WHERE
                     pa.idDgoCreaOpReci ='{$idDgoCreaOpReci}'";
        return $this->consultar($sql);
    }

    public function registrarCrearOperativoReci($datos)
    {

        $tabla      = 'dgoCreaOpReci';
        $tStructure = array(
            'idDgoReciElect' => 'idDgoReciElect',
            'idDgoComisios'  => 'idDgoComisios',
            'estado'         => 'estado',
            'fechaIni'       => 'fechaIni',
            'fechaFin'       => 'fechaFin',
            'latitud'        => 'latitud',
            'longitud'       => 'longitud',
            'delLog'         => 'delLog',
        );
        $datos['delLog']         = 'N';
        $dt                      = new DateTime('now', new DateTimeZone('America/Guayaquil'));
        $hoy                     = $dt->format('Y-m-d H:i:s');
        $datos['idDgoReciElect'] = null;
        if ($datos['estado'] == 'A') {
            $datos['fechaIni'] = (empty($datos['fechaIni'])) ? $hoy : null;
            $datos['fechaFin'] = null;
        }
        if ($datos['estado'] == 'C') {
            $datos['fechaFin'] = (!empty($datos['fechaFin'])) ? $datos['fechaFin'] : $hoy;

            //if ($datos['estado'] == 'C') {$respuestaNov = $this->registraPrimeraNovedad($datos['idPer'], 'REGISTRO FINAL', 38, $datos['latitud'], $datos['longitud']);}
        }
        $descripcion = '';
        if (empty($datos['idDgoCreaOpReci'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $datos['fechaIni'] = (!empty($datos['fechaIni'])) ? $datos['fechaIni'] : $hoy;
            $conDupli          = " and idDgoCreaOpReci != " . $datos['idDgoCreaOpReci'];
            $respuesta         = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);

            if ($respuesta[2] > 0) {
                $md = $this->updateLatitudLogintud($datos['latitud'], $datos['longitud'], $datos['idDgoCreaOpReci']);
                $modifica = $this->updateFinalizaProceso($datos['idDgoCreaOpReci']);
                $mdn = $this->updateLatitudLogintudNovedad($datos['latitud'], $datos['longitud'], $datos['idDgoCreaOpReci']);
            }
        }
        return $respuesta;
    }
    public function registrarJefe($idDgoCreaOpReci, $idGenPersona, $latitud, $longitud, $idDgoReciElect, $telefono, $idDgoTipoEje)
    {
        $tabla      = 'dgoPerAsigOpe';
        $tStructure = array(
            'idDgoCreaOpReci' => 'idDgoCreaOpReci',
            'idGenPersona'    => 'idGenPersona',
            'cargo'           => 'cargo',
            'idDgoReciElect'  => 'idDgoReciElect',
            'telefono'        => 'telefono',
            'latitud'         => 'latitud',
            'longitud'        => 'longitud',
            'idDgoTipoEje'        => 'idDgoTipoEje',
            'idGenGeoSenplades'        => 'idGenGeoSenplades',
            'delLog'          => 'delLog',
        );
        $datos['delLog']          = 'N';
        $datos['cargo']           = 'J';
        $datos['latitud']         = $latitud;
        $datos['longitud']        = $longitud;
        $datos['idGenPersona']    = $idGenPersona;
        $datos['idDgoCreaOpReci'] = $idDgoCreaOpReci;
        $datos['idDgoReciElect']  = $idDgoReciElect;
        $datos['idDgoTipoEje']    = isset($idDgoTipoEje) ? $idDgoTipoEje : 1;
        $datos['telefono']        = $telefono;
        $descripcion = '';

        if (empty($datos['idDgoTipoEje'])) {
            $datos['idDgoTipoEje'] = 1;
        }
        $rowD =        $this->getCircuitoGeoespacial($latitud, $longitud);
        $datos['idGenGeoSenplades'] =  $rowD;
        if (empty($datos['idDgoPerAsigOpe'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoPerAsigOpe != " . $datos['idDgoPerAsigOpe'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }
        return $respuesta;
    }
    public function eliminarCrearOperativoReci($idDgoReciElect)
    {
        if (!empty($idDgoReciElect)) {
            $respuesta = $this->delete($this->tabla, $idDgoReciElect);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getDetalleRecintos($idGenGeoSenplades, $idDgoProcElec)
    {
        $sql = "SELECT a.idDgoReciElect,
                        a.nomRecintoElec as descripcion
                    FROM
                        dgoReciElect a
                        INNER JOIN dgoComisios c on c.idDgoReciElect=a.idDgoReciElect
                        INNER JOIN dgoProcElec p on p.idDgoProcElec=c.idDgoProcElec
                    WHERE
                        a.idGenGeoSenplades ={$idGenGeoSenplades}
                        AND
                        c.delLog='N'
                        AND
                        a.delLog='N'
                        AND
                        p.idGenEstado=1
                      AND
                        c.idDgoProcElec={$idDgoProcElec}";
        return $this->consultarAll($sql);
    }
    public function getVerificaRecintoActivo($idDgoReciElect, $idDgoProcElec)
    {
        $sql = "SELECT
                    pa.idDgoCreaOpReci,
                    rt.nomRecintoElec,
                    gs.cargo,
                    p.descProcElecc,
                    CONCAT( a.siglas, '. ', a.apenom ) AS personal,
                    pa.fechaIni
                FROM
                    dgoCreaOpReci pa
                    INNER JOIN dgoPerAsigOpe gs ON gs.idDgoCreaOpReci = pa.idDgoCreaOpReci
                    INNER JOIN v_personal_simple a ON a.idGenPersona = gs.idGenPersona
                    INNER JOIN dgoComisios c ON c.idDgoComisios=pa.idDgoComisios
                    INNER JOIN dgoReciElect rt ON rt.idDgoReciElect=c.idDgoReciElect
                    INNER JOIN dgoProcElec p ON p.idDgoProcElec=c.idDgoProcElec
                WHERE
                gs.cargo='J'
                    AND pa.delLog = 'N'
                    AND pa.estado = 'A'
                    AND c.delLog='N'
                    AND rt.idDgoReciElect ={$idDgoReciElect} 
                    AND c.idDgoProcElec={$idDgoProcElec}";

        return $this->consultar($sql);
    }

    public function getVerificaServidorActivo($documento, $idDgoProcElec)
    {
        $sql = "SELECT  pa.idDgoCreaOpReci,
                        p.descProcElecc,
                        rt.nomRecintoElec,
                        gs.cargo,
                        CONCAT( a.siglas, '. ', a.apenom ) AS personal,
                        pa.fechaIni
                    FROM
                        dgoCreaOpReci pa
                        INNER JOIN dgoPerAsigOpe gs ON gs.idDgoCreaOpReci = pa.idDgoCreaOpReci
                        INNER JOIN v_personal_simple a ON a.idGenPersona = gs.idGenPersona
                        INNER JOIN dgoComisios c ON c.idDgoComisios=pa.idDgoComisios
                        INNER JOIN dgoReciElect rt ON rt.idDgoReciElect=c.idDgoReciElect
                        INNER JOIN dgoProcElec p ON p.idDgoProcElec=c.idDgoProcElec
                        WHERE
                        pa.delLog='N'
                        AND
                        pa.estado = 'A'
                        AND
                        c.delLog='N'
                        AND 
                        gs.idGenEstado=1
                        AND
                        a.documento ={$documento}";

        return $this->consultar($sql);
    }

    public function registraPrimeraNovedad($idDgoPerAsigOpe, $novedad, $id, $latitud, $longitud)
    {
        $tabla      = 'dgoNovReciElec';
        $tStructure = array(
            'idDgoNovedadesElect' => 'idDgoNovedadesElect',
            'idDgoPerAsigOpe'     => 'idDgoPerAsigOpe',
            'observacion'         => 'observacion',
            'fechaNovedad'        => 'fechaNovedad',
            'latitud'             => 'latitud',
            'idGenGeoSenplades'   => 'idGenGeoSenplades',
            'longitud'            => 'longitud',
            'delLog'              => 'delLog',
        );

        $dt  = new DateTime('now', new DateTimeZone('America/Guayaquil'));
        $hoy = $dt->format('Y-m-d H:i:s');
        $rowD =        $this->getCircuitoGeoespacial($latitud, $longitud);
        $datos['idGenGeoSenplades'] =  $rowD;
        $datos['fechaNovedad']        = $hoy;
        $datos['idDgoPerAsigOpe']     = $idDgoPerAsigOpe;
        $datos['delLog']              = 'N';
        $datos['idDgoNovedadesElect'] = $id;
        $datos['latitud']             = $latitud;
        $datos['longitud']            = $longitud;
        $datos['observacion']         = $novedad;
        $descripcion                  = '';

        $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);

        return $respuesta;
    }
    public function modificarEstadoRecinto($idDgoCreaOpReci)
    {
        $tabla      = 'dgoCreaOpReci';
        $tStructure = array(
            'estado'   => 'estado',
            'fechaFin' => 'fechaFin',
        );
        $dt                       = new DateTime('now', new DateTimeZone('America/Guayaquil'));
        $hoy                      = $dt->format('Y-m-d H:i:s');
        $datos['estado']          = 'E';
        $datos['idDgoCreaOpReci'] = $idDgoCreaOpReci;
        $descripcion              = '';
        $datos['fechaFin']        = (!empty($datos['fechaFin'])) ? $datos['fechaFin'] : $hoy;
        $conDupli                 = " and idDgoCreaOpReci != " . $datos['idDgoCreaOpReci'];
        $respuesta                = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);

        return $respuesta;
    }
    public function getDetalleRecintosPorEje($idDgoTipoEje, $idDgoProcElec)
    {
        $sql = "SELECT a.idDgoReciElect,
                        a.nomRecintoElec descripcion
                    FROM
                        dgoReciElect a
                        INNER JOIN dgoComisios c on c.idDgoReciElect=a.idDgoReciElect
                    WHERE
                        a.idDgoTipoEje ={$idDgoTipoEje}
                        AND
                        c.delLog='N'
                        AND
                        a.delLog='N'
                      AND
                        c.idDgoProcElec={$idDgoProcElec}";
        return $this->consultarAll($sql);
    }
    public function getLatLong($idDgoReciElect, $idDgoProcElec)
    {
        $sql = "SELECT a.latitud,
                        a.longitud,
                        c.idDgoComisios
                    FROM
                        dgoReciElect a
                        INNER JOIN dgoComisios c on c.idDgoReciElect=a.idDgoReciElect
                    WHERE
                        a.idDgoReciElect ={$idDgoReciElect}
                        AND
                        c.delLog='N'
                        AND
                        a.delLog='N'
                      AND
                        c.idDgoProcElec={$idDgoProcElec}";
        return $this->consultarAll($sql);
    }

    public function verificaProcesoFinalizado($idDgoCreaOpReci)
    {
        $sql = "SELECT a.idDgoCreaOpReci
                    FROM
                        dgoCreaOpReci a
                    WHERE
                    a.estado='C'
                    AND
                    a.idDgoCreaOpReci={$idDgoCreaOpReci}";
        return $this->consultar($sql);
    }

    public function updateLatitudLogintud($lat, $long, $id)
    {
        $sql1 = "UPDATE dgoPerAsigOpe SET latitud=$lat,longitud=$long   WHERE idDgoCreaOpReci={$id}";
        $this->conn->query($sql1);
    }
    public function updateLatitudLogintudNovedad($lat, $long, $id)
    {
        $sql = 'SELECT a.idDgoPerAsigOpe from dgoPerAsigOpe a where a.idDgoCreaOpReci=' . $id;
        $idd = $this->consultar($sql);
        $sql1 = "UPDATE dgoNovReciElec SET latitud=$lat,longitud=$long   WHERE idDgoPerAsigOpe=" . $idd['idDgoPerAsigOpe'];

        $this->conn->query($sql1);
    }
    public function updateFinalizaProceso($idDgoCreaOpReci)
    {
        $sql  = "SELECT a.idDgoPerAsigOpe,
                        a.idDgoNovReciElec,
                        a.idDgoNovedadesElect,
                        b.cargo
                    FROM
                        dgoNovReciElec a
                        INNER JOIN dgoPerAsigOpe b ON b.idDgoPerAsigOpe = a.idDgoPerAsigOpe
                        INNER JOIN dgoCreaOpReci c ON c.idDgoCreaOpReci = b.idDgoCreaOpReci
                    WHERE c.idDgoCreaOpReci={$idDgoCreaOpReci}
                AND b.delLog='N' AND a.idDgoNovedadesElect=1 ";

        $datos = $this->consultarAll($sql);

        foreach ($datos as $key => $value) {
            $idDgoPerAsigOpe  = $value['idDgoPerAsigOpe'];
            $idDgoNovReciElec = $value['idDgoNovReciElec'];
            if ($value['cargo'] == 'J') {
                $sql1 = "UPDATE dgoNovReciElec SET idDgoNovedadesElect=38,fecha=now()   WHERE idDgoPerAsigOpe={$idDgoPerAsigOpe} AND idDgoNovReciElec={$idDgoNovReciElec} AND delLog='N'";
                $this->conn->query($sql1);
            }
            if ($value['cargo'] == 'I') {
                $sql1 = "UPDATE dgoNovReciElec SET idDgoNovedadesElect=40,fecha=now()  WHERE idDgoPerAsigOpe={$idDgoPerAsigOpe} AND idDgoNovReciElec={$idDgoNovReciElec} AND delLog='N'";
                $this->conn->query($sql1);
            }
        }
    }
    public function updateCerrarOperativos($datos)
    {
        $sql = "SELECT  b.idDgoCreaOpReci 
                        FROM
                            dgoCreaOpReci b
                            INNER JOIN dgoComisios d ON d.idDgoComisios = b.idDgoComisios
                            INNER JOIN dgoProcElec c ON c.idDgoProcElec = d.idDgoProcElec
                            WHERE
                            b.estado='A'
                            AND
                            c.idDgoProcElec=" . $datos['idDgoProcElec'];
        $rsGeo = $this->conn->query($sql);
        $row = $rsGeo->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($row)) {
            try {
                foreach ($row as $row1) {
                    $sql = "UPDATE dgoCreaOpReci SET estado='C',fechaFin=now() WHERE idDgoCreaOpReci=" . $row1['idDgoCreaOpReci'];
                    $this->conn->query($sql);
                }
                $respuesta = array(1, 'OPERATIVOS CERRADOS CORRECTAMENTE', true);
                return $respuesta;
            } catch (PDOException $e) {

                echo "imposible conectarse : " . $e->getMessage() . "\n";
                exit;
            }
        } else {
            $respuesta = array(0, 'NO EXISTE OPERATIVOS EN ESTE PROCESO', false);
            return $respuesta;
        }
    }
    public function updateIdgenGeosenpladesAnexados($datos)
    {
        $sql = "SELECT  a.idDgoPerAsigOpe,
                        a.latitud,
                        a.longitud,
                        a.idGenGeosenplades
                    FROM
                     dgoPerAsigOpe a
                        INNER JOIN dgoCreaOpReci b ON b.idDgoCreaOpReci = a.idDgoCreaOpReci
                        INNER JOIN dgoComisios d ON d.idDgoComisios = b.idDgoComisios
                        INNER JOIN dgoProcElec c ON c.idDgoProcElec = d.idDgoProcElec 
                    WHERE
                     d.idDgoProcElec =" . $datos['idDgoProcElec'];

        $rsGeo = $this->conn->query($sql);
        $row = $rsGeo->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($row)) {
            try {
                foreach ($row as $row1) {
                    $rowD = $this->getCircuitoGeoespacial($row1['longitud'], $row1['latitud']);
                    if ($rowD != 0) {
                        $sql = "UPDATE dgoPerAsigOpe SET idGengeoSenplades=" . $rowD . "  WHERE idDgoPerAsigOpe=" . $row1['idDgoPerAsigOpe'];
                        $this->conn->query($sql);
                    }
                }
                ob_clean();
                $respuesta = array(1, 'UBICACIÓN ACTUALIZADA ', true);
                return $respuesta;
            } catch (PDOException $e) {

                echo "imposible conectarse : " . $e->getMessage() . "\n";
                exit;
            }
        } else {
            ob_clean();
            $respuesta = array(0, 'NO EXISTE PERSONAL PARA ACTUALIZAR UBICACIÓN EN ESTE PROCESO', false);
            return $respuesta;
        }
    }
    public static function Cone()
    {

        try {
            $pdo = new PDO("mysql:host=182.16.0.77;dbname=geografica", "siipnegeo", "2022..BDD", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_PERSISTENT => false));

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;
        } catch (PDOException $e) {

            echo "imposible conectarse : " . $e->getMessage() . "\n";
            exit;
        }
    }
    public static function getCircuitoGeoespacial($latitud, $longitud)
    {
        $connexion = DB::getConexionDB();
        try {
            $conne   = CrearOperativoReci::Cone();
            $sqlGeo = "SELECT cod_subcir FROM senplades WHERE ST_Within(POINT('" . $longitud . "','" . $latitud . "'),geom)";
            if (($rsGeo = $conne->query($sqlGeo)) != false) {
                $row = $rsGeo->fetch(PDO::FETCH_ASSOC);
                if ($latitud == 0.0 || $longitud == 0.0) {
                    return 0;
                } else {
                    $sql = "SELECT s.idGenGeoSenplades AS 's',c.idGenGeoSenplades AS 'c',
                        d.idGenGeoSenplades AS 'd', sz.idGenGeoSenplades AS 'sz',z.idGenGeoSenplades AS 'z'
                          FROM genGeoSenplades AS s
                          INNER JOIN genGeoSenplades AS c ON s.gen_idGenGeoSenplades=c.idGenGeoSenplades
                          INNER JOIN genGeoSenplades AS d ON c.gen_idGenGeoSenplades=d.idGenGeoSenplades
                          INNER JOIN genGeoSenplades AS sz ON d.gen_idGenGeoSenplades=sz.idGenGeoSenplades
                          INNER JOIN genGeoSenplades AS z ON sz.gen_idGenGeoSenplades=z.idGenGeoSenplades
                          WHERE s.codigoSenplades='" . $row['cod_subcir'] . "'";


                    $rsGeoSemplades = $connexion->query($sql);
                    $row = $rsGeoSemplades->fetch(PDO::FETCH_ASSOC);
                    if (!empty($row)) {
                        return $row['s'];
                    } else {
                        return 0; //$return['getCodigoSubcircuitoResult'].'=> Codigo no encontrado';
                    }
                }
            } else {
                return 0;
            }
        } catch (SoapFault $exception) {
            return 0; //'<br>'.$exception->getMessage();
        }
    }
    public function updateIdGenGeosenpladeRecintos()
    {
        $sql = "SELECT * FROM dgoReciElect";

        $rsGeo = $this->conn->query($sql);
        $row = $rsGeo->fetchAll(PDO::FETCH_ASSOC);


        if (!empty($row)) {
            try {
                foreach ($row as $row1) {

                    $rowD = $this->getCircuitoGeoespacial($row1['latitud'], $row1['longitud']);

                    if ($rowD != 0) {
                        $sql = "UPDATE dgoReciElect SET idGenGeoSenplades=" . $rowD . "  WHERE idDgoReciElect=" . $row1['idDgoReciElect'];
                        $this->conn->query($sql);
                    }
                }
                ob_clean();
                $respuesta = array(1, 'UBICACIÓN ACTUALIZADA ', true);
                return $respuesta;
            } catch (PDOException $e) {

                echo "imposible conectarse : " . $e->getMessage() . "\n";
                exit;
            }
        } else {
            ob_clean();
            $respuesta = array(0, 'NO EXISTE PERSONAL PARA ACTUALIZAR UBICACIÓN EN ESTE PROCESO', false);
            return $respuesta;
        }
    }
}
