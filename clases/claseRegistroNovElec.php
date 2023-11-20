<?php
class RegistroNovElec extends Transaccion
{
    private $tabla   = 'dgoNovReciElec';
    private $idTabla = 'idDgoNovReciElec';
    public function getIdCampoRegistroNovElec()
    {
        return $this->idTabla;
    }
    public function getTablaRegistroNovElec()
    {
        return $this->tabla;
    }
    public function getSqlRegistroNovElec()
    {
        //nv.fechaNovedad>=(NOW() - INTERVAL 10 HOUR)
        //         AND
        $sql = "SELECT
                    pa.idDgoCreaOpReci,
                    rt.nomRecintoElec,
                    pa.estado,
                    nv.idDgoNovReciElec,
                    CONCAT( a.siglas, '. ', a.apenom )as jefe_operativo,
                    pa.fechaIni,
                    nv.imagen,
                    nr1.descripcion as Tipo,
                    nr.descripcion as Novedad,
                    nv.observacion,
                    nv.fechaNovedad,
                    p.idDgoProcElec
                FROM
                     dgoNovReciElec nv

                    INNER JOIN dgoPerAsigOpe op ON op.idDgoPerAsigOpe=nv.idDgoPerAsigOpe
                    LEFT JOIN dgoCreaOpReci pa ON pa.idDgoCreaOpReci=op.idDgoCreaOpReci
                    LEFT JOIN v_personal_simple a ON a.idGenPersona = op.idGenPersona
                    INNER JOIN dgoComisios c ON c.idDgoComisios=pa.idDgoComisios
                    INNER JOIN dgoReciElect rt ON rt.idDgoReciElect=c.idDgoReciElect
                    INNER JOIN dgoProcElec p ON p.idDgoProcElec=c.idDgoProcElec
                    LEFT JOIN dgoNovedadesElect nr ON nr.idDgoNovedadesElect=nv.idDgoNovedadesElect
                    LEFT JOIN dgoNovedadesElect nr1 ON nr1.idDgoNovedadesElect=nr.dgo_idDgoNovedadesElect
                    WHERE
                    nr.idDgoNovedadesElect<>1
                    AND nr.idDgoNovedadesElect<>38
                    AND nr.idDgoNovedadesElect<>39
                    AND nr.idDgoNovedadesElect<>40
                    AND p.idGenEstado=1
                    AND p.delLog='N'
                    ORDER BY nv.idDgoNovReciElec DESC";

        return $sql;
    }
    public function getRegistroNovElec()
    {
        return $this->consultarAll($this->getSqlRegistroNovElec());
    }

    public function getEditRegistroNovElec($idDgoNovReciElec)
    {
        $conn   = DB::getConexionDB();
        $carros = array();
        $sql    = "SELECT
                    pa.idDgoCreaOpReci,
                    pa.idDgoCreaOpReci as idOperativo,
                    rt.nomRecintoElec,
                    rt.nomRecintoElec as unidad,
                    pa.estado,
                    nv.idDgoNovReciElec,
                    CONCAT( a.siglas, '. ', a.apenom ) as jefe,
                    pa.fechaIni,
                    pa.FechaFin,
                    pa.latitud,
                    pa.longitud,
                    nv.imagen,
                    p.descProcElecc,
                    op.idDgoPerAsigOpe,
                    op.idGenPersona,
                    a.documento as cedulaPersonaC,
                    CONCAT( a.siglas, '. ', a.apenom ) as nombrePersonaC,
                    rt.idDgoReciElect,
                    nr1.descripcion as Tipo,
                    nr.descripcion as Novedad,
                    nv.observacion,
                    nv.documento,
                    nr.idDgoNovedadesElect ,
                    nr1.idDgoNovedadesElect as idNovedad,
                    nv.fechaNovedad,
                    geo.descripcion AS senpladesDescripcion,
                    t.idDgoTipoEje as idDgoTipoEje2,
                    t1.idDgoTipoEje as idDgoTipoEje1,
                    t2.idDgoTipoEje as idDgoTipoEje,
                    t.descripcion as nomt2,
                    t1.descripcion as nomt1,
                    t2.descripcion as nomt,
                    nv.idGenGeoSenplades,
                    gp.apenom as nombrePersonaD,
                    gp.apenom as nombreDetenido,
                    doc.documento as cedulaPersonaD,
                    gp.idGenPersona as idGenPersonaD,
                    nv.idDgoNovedadesElect as idDgoNovedadesElect1
                FROM
                    dgoNovReciElec nv
                    INNER JOIN dgoPerAsigOpe op ON op.idDgoPerAsigOpe=nv.idDgoPerAsigOpe
                    LEFT JOIN dgoCreaOpReci pa ON pa.idDgoCreaOpReci=op.idDgoCreaOpReci
                    LEFT JOIN v_personal_simple a ON a.idGenPersona = op.idGenPersona
                    INNER JOIN dgoComisios c ON c.idDgoComisios=pa.idDgoComisios
                    INNER JOIN dgoReciElect rt ON rt.idDgoReciElect=c.idDgoReciElect
                    INNER JOIN dgoProcElec p ON p.idDgoProcElec=c.idDgoProcElec
                    LEFT JOIN dgoNovedadesElect nr ON nr.idDgoNovedadesElect=nv.idDgoNovedadesElect
                    LEFT JOIN dgoNovedadesElect nr1 ON nr1.idDgoNovedadesElect=nr.dgo_idDgoNovedadesElect
                    LEFT JOIN genGeoSenplades geo ON geo.idGenGeoSenplades = rt.idGenGeoSenplades
                    LEFT JOIN dgoTipoEje t ON t.idDgoTipoEje=rt.idDgoTipoEje
                    LEFT JOIN dgoTipoEje t1 ON t1.idDgoTipoEje=t.dgo_idDgoTipoEje
                    LEFT JOIN dgoTipoEje t2 ON t2.idDgoTipoEje=t1.dgo_idDgoTipoEje
                    LEFT JOIN genGeoSenplades gss ON gss.idGenGeoSenplades=nv.idGenGeoSenplades
                    LEFT JOIN genPersona gp ON gp.idGenPersona=nv.idGenPersonaD
                    LEFT JOIN genDocumento doc ON doc.idGenPersona=gp.idGenPersona
                WHERE
                    nv.idDgoNovReciElec ='{$idDgoNovReciElec}'";
        $rs   = $conn->query($sql);
        $rowB = $rs->fetch();

        $idDgoNovReciElec = $rowB['idDgoNovReciElec'];

        $observacion = $this->getDatosObservacion($idDgoNovReciElec);

        $editObservacion = $this->getEditObservacion($rowB['idDgoNovedadesElect'], $observacion);
        $data            = array(
            'idDgoNovReciElec'     => $rowB['idDgoNovReciElec'],
            'idDgoCreaOpReci'      => $rowB['idDgoCreaOpReci'],
            'idOperativo'          => $rowB['idOperativo'],
            'nomRecintoElec'       => $rowB['nomRecintoElec'],
            'idDgoReciElect'       => $rowB['idDgoReciElect'],
            'estado'               => $rowB['estado'],
            'jefe'                 => $rowB['jefe'],
            'latitud'              => $rowB['latitud'],
            'longitud'             => $rowB['longitud'],
            'imagen'               => $rowB['imagen'],
            'nombrePersonaC'       => $rowB['nombrePersonaC'],
            'cedulaPersonaC'       => $rowB['cedulaPersonaC'],
            'idGenPersona'         => $rowB['idGenPersona'],
            'descProcElecc'        => $rowB['descProcElecc'],
            'unidad'               => $rowB['unidad'],
            'idDgoPerAsigOpe'      => $rowB['idDgoPerAsigOpe'],
            'idDgoNovedadesElect'  => $rowB['idDgoNovedadesElect'],
            'senpladesDescripcion' => $rowB['senpladesDescripcion'],
            'idNovedad'            => $rowB['idNovedad'],
            'fechaNovedad'         => $rowB['fechaNovedad'],
            'idGenGeoSenplades'    => $rowB['idGenGeoSenplades'],
            'documento'            => $rowB['documento'],
            'cedula'               => isset($editObservacion['cedula']) ? $editObservacion['cedula'] : '',
            'lider'                => isset($editObservacion['lider']) ? $editObservacion['lider'] : '',
            'boleta'               => isset($editObservacion['boleta']) ? $editObservacion['boleta'] : '',
            'idDgoTipoEje2'        => $rowB['idDgoTipoEje2'],
            'idDgoTipoEje1'        => $rowB['idDgoTipoEje1'],
            'idDgoTipoEje'         => $rowB['idDgoTipoEje'],
            'nomt2'                => $rowB['nomt2'],

            'nomt1'                => $rowB['nomt1'],
            'nomt'                 => $rowB['nomt'],
            'idDgoNovedadesElect1' => $rowB['idDgoNovedadesElect1'],
            'nombreDetenido'       => $rowB['nombreDetenido'],
            'nombrePersonaD'       => $rowB['nombrePersonaD'],
            'cedulaPersonaD'       => $rowB['cedulaPersonaD'],
            'idGenPersonaD'         => $rowB['idGenPersonaD'],

        );
        return $data;
    }

    public function registrarRegistroNovElec($datos, $files)
    {

        $formRegistroNovElec = new FormRegistroNovElec;
        $tabla               = 'dgoNovReciElec';
        $tStructure          = array(
            'idDgoNovedadesElect' => 'idDgoNovedadesElect',
            'idDgoPerAsigOpe'     => 'idDgoPerAsigOpe',
            'observacion'         => 'observacion',
            'fechaNovedad'        => 'fechaNovedad',
            'idGenGeoSenplades'   => 'idGenGeoSenplades',
            'documento'           => 'documento',
            'latitud'             => 'latitud',
            'longitud'            => 'longitud',
            'delLog'              => 'delLog',
            'idGenPersonaD'       => 'idGenPersonaD',
            'nombreDetenido'      => 'nombreDetenido',
            'imagen'              => 'imagen',

        );
        $dt                    = new DateTime('now', new DateTimeZone('America/Guayaquil'));
        $hoy                   = $dt->format('Y-m-d H:i:s');
        $datos['delLog']       = 'N';
        $datos['fechaNovedad'] = $hoy;
        $datos['imagen']       = (!empty($datos['imagen'])) ? $datos['imagen'] : null;
        if ($datos['idDgoNovedadesElect'] >= 14 &&  $datos['idDgoNovedadesElect'] <= 16) {
            $datos['documento'] =  $datos['cedulaPersonaD'];
            $datos['nombreDetenido'] =  $datos['nombrePersonaD'];
        }
        if ($datos['idDgoNovedadesElect'] == 15) {
            $datos['idDgoNovedadesElect'] =  $datos['idDgoNovedadesElect1'];
        }

        $datos['observacion'] = $this->getObservacionRecinto($datos['idDgoNovedadesElect'], $datos['cedula'], $datos['boleta'], $datos['lider']);
        $descripcion          = 'documento,idDgoPerAsigOpe';

        if ($datos['idNovedad'] == 5 || $datos['idNovedad'] == 32 || $datos['idDgoNovedadesElect'] == 17 || $datos['idDgoNovedadesElect'] == 18) {

            if ($datos['idDgoNovedadesElect'] == 17 || $datos['idDgoNovedadesElect'] == 18) {
                if (empty($datos['idDgoNovReciElec'])) {
                    $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
                } else {
                    $conDupli  = " and idDgoNovReciElec != " . $datos['idDgoNovReciElec'];
                    $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
                }
            } else {
                if (empty($datos['idDgoNovReciElec'])) {
                    $respuesta = $this->insertArchivo($tabla, $tStructure, $datos, $formRegistroNovElec->getCamposRegistroNovElec(), $files, $descripcion);
                } else {
                    $conDupli  = " and idDgoNovReciElec != " . $datos['idDgoNovReciElec'];
                    $respuesta = $this->updateArchivo($tabla, $tStructure, $datos, $formRegistroNovElec->getCamposRegistroNovElec(), $files, $descripcion, $conDupli);
                }
            }
        } else {
            if (empty($datos['idDgoNovReciElec'])) {
                $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
            } else {
                $conDupli  = " and idDgoNovReciElec != " . $datos['idDgoNovReciElec'];
                $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
            }
        }

        return $respuesta;
    }

    public function eliminarRegistroNovElec($idDgoNovReciElec)
    {
        if (!empty($idDgoNovReciElec)) {
            $respuesta = $this->delete($this->tabla, $idDgoNovReciElec);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getDatosObservacion($idDgoNovReciElec)
    {

        $sql = "SELECT
                    observacion
                FROM
                    dgoNovReciElec
                WHERE
                   idDgoNovReciElec ='{$idDgoNovReciElec}'";

        $respuesta = $this->consultar($sql);

        $rp = json_decode($respuesta['observacion'], true);

        return $rp;
    }
    public function getDetalleJefe($idDgoReciElect)
    {
        $sql = "SELECT
                    pa.idDgoCreaOpReci,
                    rt.nomRecintoElec,
                    op.idDgoPerAsigOpe,
                    pa.estado,
                    CONCAT( a.siglas, '. ', a.apenom ) as jefe_operativo
                FROM
                     dgoNovReciElec nv
                    INNER JOIN dgoPerAsigOpe op ON op.idDgoPerAsigOpe=nv.idDgoPerAsigOpe
                    INNER JOIN dgoCreaOpReci pa ON pa.idDgoCreaOpReci=op.idDgoCreaOpReci
                    INNER JOIN v_personal_simple a ON a.idGenPersona = op.idGenPersona
                    INNER JOIN dgoReciElect rt ON rt.idDgoReciElect=pa.idDgoReciElect
                  WHERE
                     pa.idDgoReciElect ='{$idDgoReciElect}'
                     AND op.cargo='J'
                     AND pa.delLog='N'
                     AND pa.estado='A'";
        return $this->consultar($sql);
    }
    public function getDetalleNovedades($idDgoNovedadesElect, $idDgoTipoEje)
    {
        $sql = "SELECT
                    a.idDgoNovedadesElect,
                    a.descripcion
                FROM
                dgoNovedadesEje nv
                    INNER JOIN dgoNovedadesElect a ON nv.idDgoNovedadesElect=a.idDgoNovedadesElect
                WHERE
                    nv.idDgoTipoEje={$idDgoTipoEje} AND nv.delLog='N' AND a.delLog='N'
                 AND  a.dgo_idDgoNovedadesElect={$idDgoNovedadesElect}";
        return $this->consultarAll($sql);
    }

    public function getObservacionRecinto($novedad, $cedula, $boleta, $lider)
    {
        $observacion = "";
        if (!empty($novedad)) {
            switch ($novedad) {

                case 10:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","numCitacion":"' . $boleta . '"}';
                    break;
                case 11:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","numCitacion":"' . $boleta . '"}';
                    break;
                case 12:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","numCitacion":"' . $boleta . '"}';
                    break;
                case 13:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","numCitacion":"' . $boleta . '"}';
                    break;
                case 14:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","numBoleta": "' . $boleta . '" }';
                    break;
                case 15:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","numBoleta": "' . $boleta . '" }';
                    break;
                case 16:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","numBoleta": "' . $boleta . '" }';
                    break;
                case 17:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '"}';
                    break;
                case 18:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '"}';
                    break;
                case 19:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","hora":"' . $cedula . '"}';
                    break;
                case 20:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","motivo":"' . $cedula . '"}';
                    break;
                case 21:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '"}';
                    break;
                case 22:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","organizacion": "' . $boleta . '", "dirigente": "' . $lider . '" , "cantidad": "' . $cedula . '"}';
                    break;
                case 23:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","organizacion": "' . $boleta . '", "dirigente": "' . $lider . '" , "cantidad": "' . $cedula . '"}';
                    break;
                case 24:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","numCitacion":"' . $boleta . '"}';
                    break;
                case 25:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","numCitacion":"' . $boleta . '"}';
                    break;
                case 26:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","numCitacion":"' . $boleta . '"}';
                    break;
                case 27:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","numCitacion":"' . $boleta . '"}';
                    break;
                case 28:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","organizacion": "' . $boleta . '", "dirigente": "' . $lider . '" , "cantidad": "' . $cedula . '"}';
                    break;
                case 29:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '"}';
                    break;
                case 31:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '"}';
                    break;
                case 32:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","numerico": "' . $cedula . '"}';
                    break;
                case 33:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '"}';
                    break;
                case 34:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","organizacion": "' . $boleta . '", "dirigente": "' . $lider . '" , "cantidad": "' . $cedula . '"}';
                    break;
                case 35:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","organizacion": "' . $boleta . '", "dirigente": "' . $lider . '" , "cantidad": "' . $cedula . '"}';
                    break;
                case 36:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","organizacion": "' . $boleta . '", "dirigente": "' . $lider . '" , "cantidad": "' . $cedula . '"}';
                    break;
                case 37:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","organizacion": "' . $boleta . '", "dirigente": "' . $lider . '" , "cantidad": "' . $cedula . '"}';
                    break;
                case 41:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","funcion": "' . $cedula . '", "nombres": "' . $boleta . '"}';
                    break;
                case 42:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","instalacion": "' . $cedula . '", "descripcion": "' . $boleta . '"}';
                    break;
                case 43:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","direccion": "' . $cedula . '", "descripcion": "' . $boleta . '"}';
                    break;
                case 44:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","unidad": "' . $cedula . '"}';
                    break;
                case 45:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","nombre": "' . $cedula . '", "cargo": "' . $boleta . '" , "grado": "' . $lider . '"}';
                    break;
                case 46:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","nombre": "' . $cedula . '", "cargo": "' . $boleta . '" , "grado": "' . $lider . '"}';
                    break;
                case 47:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","nombre": "' . $cedula . '", "medioComunicacion": "' . $boleta . '"}';
                    break;
                case 48:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '"}';
                    break;
                case 49:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","numerico": "' . $cedula . '"}';
                    break;
                case 50:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","numerico": "' . $cedula . '"}';
                    break;
                case 51:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","numerico": "' . $cedula . '"}';
                    break;
                case 52:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","numerico": "' . $cedula . '"}';
                    break;
                case 53:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","numerico": "' . $cedula . '"}';
                    break;
                case 54:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","organizacion": "' . $cedula . '", "dirigente": "' . $boleta . '" , "cantidad": "' . $lider . '"}';
                    break;
                case 55:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '","hora":"' . $cedula . '"}';
                    break;

                default:
                    $observacion = '{"idDgoNovedadesElect": "' . $novedad . '"}';
            }
        }
        return $observacion;
    }
    public function getEditObservacion($novedad, $observacion)
    {
        $data1 = array();
        if (!empty($novedad)) {
            switch ($novedad) {
                case 6:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => '',
                        'lider'  => '',
                    );

                    break;
                case 7:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => '',
                        'lider'  => '',
                    );

                    break;
                case 8:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => '',
                        'lider'  => '',
                    );

                    break;
                case 9:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => '',
                        'lider'  => '',
                    );

                    break;
                case 10:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => $observacion['numCitacion'],
                        'lider'  => '',

                    );
                    break;
                case 11:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => $observacion['numCitacion'],
                        'lider'  => '',

                    );
                    break;
                case 12:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => $observacion['numCitacion'],
                        'lider'  => '',

                    );
                    break;
                case 13:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => $observacion['numCitacion'],
                        'lider'  => '',

                    );
                    break;
                case 14:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => $observacion['numBoleta'],
                        'lider'  => '',

                    );
                    break;
                case 15:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => $observacion['numBoleta'],
                        'lider'  => '',

                    );
                    break;
                case 16:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => $observacion['numBoleta'],
                        'lider'  => '',

                    );
                    break;
                case 17:
                    $observacion = '';
                    break;
                case 18:
                    $observacion = '';
                    break;
                case 19:
                    $data1 = array(
                        'cedula' => $observacion['hora'],
                        'boleta' => '',
                        'lider'  => '',

                    );
                    break;
                case 20:
                    $data1 = array(
                        'cedula' => $observacion['motivo'],
                        'boleta' => '',
                        'lider'  => '',

                    );
                    break;
                case 21:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => '',
                        'lider'  => '',

                    );
                    break;

                case 22:
                    $data1 = array(
                        'cedula' => $observacion['cantidad'],
                        'boleta' => $observacion['organizacion'],
                        'lider'  => $observacion['dirigente'],

                    );
                    break;
                case 23:
                    $data1 = array(
                        'cedula' => $observacion['cantidad'],
                        'boleta' => $observacion['organizacion'],
                        'lider'  => $observacion['dirigente'],

                    );
                    break;
                case 24:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => $observacion['numCitacion'],
                        'lider'  => '',

                    );
                    break;
                case 25:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => $observacion['numCitacion'],
                        'lider'  => '',

                    );
                    break;
                case 26:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => $observacion['numCitacion'],
                        'lider'  => '',

                    );
                    break;
                case 27:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => $observacion['numCitacion'],
                        'lider'  => '',

                    );
                    break;
                case 28:
                    $data1 = array(
                        'cedula' => $observacion['cantidad'],
                        'boleta' => $observacion['organizacion'],
                        'lider'  => $observacion['dirigente'],

                    );
                    break;
                case 29:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => '',
                        'lider'  => '',

                    );
                    break;
                case 31:
                    break;
                case 32:
                    $data1 = array(
                        'cedula' => $observacion['numerico'],
                        'boleta' => '',
                        'lider'  => '',

                    );
                    break;
                case 33:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => '',
                        'lider'  => '',

                    );
                    break;
                case 34:
                    $data1 = array(
                        'cedula' => $observacion['cantidad'],
                        'boleta' => $observacion['organizacion'],
                        'lider'  => $observacion['dirigente'],

                    );

                    break;
                case 35:
                    $data1 = array(
                        'cedula' => $observacion['cantidad'],
                        'boleta' => $observacion['organizacion'],
                        'lider'  => $observacion['dirigente'],

                    );
                    break;
                case 36:
                    $data1 = array(
                        'cedula' => $observacion['cantidad'],
                        'boleta' => $observacion['organizacion'],
                        'lider'  => $observacion['dirigente'],

                    );
                    break;
                case 37:
                    $data1 = array(
                        'cedula' => $observacion['cantidad'],
                        'boleta' => $observacion['organizacion'],
                        'lider'  => $observacion['dirigente'],

                    );
                    break;
                case 41:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => $observacion['funcion'],
                        'lider'  => $observacion['nombres'],

                    );
                    break;
                case 42:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => $observacion['instalacion'],
                        'lider'  => $observacion['descripcion'],

                    );
                    break;
                case 43:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => $observacion['direccion'],
                        'lider'  => $observacion['descripcion'],

                    );
                    break;
                case 44:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => $observacion['unidad'],
                        'lider'  => '',

                    );
                    break;
                case 45:
                    $data1 = array(
                        'cedula' => $observacion['grado'],
                        'boleta' => $observacion['nombre'],
                        'lider'  => $observacion['cargo'],

                    );
                    break;
                case 46:
                    $data1 = array(
                        'cedula' => $observacion['grado'],
                        'boleta' => $observacion['nombre'],
                        'lider'  => $observacion['cargo'],

                    );
                    break;
                case 47:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => $observacion['nombre'],
                        'lider'  => $observacion['medio'],

                    );
                    break;
                case 48:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => '',
                        'lider'  => '',

                    );
                    break;
                case 49:
                    $data1 = array(
                        'cedula' => $observacion['numerico'],
                        'boleta' => '',
                        'lider'  => '',

                    );
                    break;
                case 50:
                    $data1 = array(
                        'cedula' => $observacion['numerico'],
                        'boleta' => '',
                        'lider'  => '',

                    );
                    break;
                case 51:
                    $data1 = array(
                        'cedula' => $observacion['numerico'],
                        'boleta' => '',
                        'lider'  => '',

                    );
                    break;
                case 52:
                    $data1 = array(
                        'cedula' => $observacion['numerico'],
                        'boleta' => '',
                        'lider'  => '',

                    );
                    break;
                case 53:
                    $data1 = array(
                        'cedula' => $observacion['numerico'],
                        'boleta' => '',
                        'lider'  => '',

                    );
                    break;
                case 54:
                    $data1 = array(
                        'cedula' => $observacion['cantidad'],
                        'boleta' => $observacion['organizacion'],
                        'lider'  => $observacion['dirigente'],

                    );
                    break;
                case 55:
                    $data1 = array(
                        'cedula' => $observacion['hora'],
                        'boleta' => '',
                        'lider'  => '',

                    );
                    break;

                default:
                    $data1 = array(
                        'cedula' => '',
                        'boleta' => '',
                        'lider'  => '',
                    );
            }
        }

        return $data1;
    }

    public function getDetalleDatosJefe($idGenPersona)
    {
        $sql = "SELECT
                    pa.idDgoCreaOpReci,
                    rt.nomRecintoElec,
                    op.idDgoPerAsigOpe,
                    pa.estado,
                    op.cargo,
                    pa.latitud,
                    pa.longitud,
                    p.descProcElecc,
                    CONCAT( a.siglas, '. ', a.apenom ) as jefe_operativo,
                    t.idDgoTipoEje as idDgoTipoEje2,
                    t1.idDgoTipoEje as idDgoTipoEje1,
                    t2.idDgoTipoEje as idDgoTipoEje,
                    t.descripcion as nomt2,
                    t1.descripcion as nomt1,
                    t2.descripcion as nomt
                    FROM
                     dgoNovReciElec nv
                    INNER JOIN dgoPerAsigOpe op ON op.idDgoPerAsigOpe=nv.idDgoPerAsigOpe
                    INNER JOIN dgoCreaOpReci pa ON pa.idDgoCreaOpReci=op.idDgoCreaOpReci
                    LEFT JOIN v_personal_simple a ON a.idGenPersona = op.idGenPersona
                    INNER JOIN dgoComisios c ON c.idDgoComisios=pa.idDgoComisios
                    INNER JOIN dgoReciElect rt ON rt.idDgoReciElect=c.idDgoReciElect
                    INNER JOIN dgoProcElec p ON p.idDgoProcElec=c.idDgoProcElec
                    LEFT JOIN dgoTipoEje t ON t.idDgoTipoEje=rt.idDgoTipoEje
                    LEFT JOIN dgoTipoEje t1 ON t1.idDgoTipoEje=t.dgo_idDgoTipoEje
                    LEFT JOIN dgoTipoEje t2 ON t2.idDgoTipoEje=t1.dgo_idDgoTipoEje
                  WHERE
                   op.idGenPersona ='{$idGenPersona}'
                     AND pa.delLog='N'
                     AND pa.estado='A'
                     AND op.delLog='N'
                     AND op.idGenEstado=1";
        $id = $this->consultar($sql);
        $idRecinto = isset($id['idDgoCreaOpReci']) ? $id['idDgoCreaOpReci'] : 0;
        return $this->getDetalleIdOperativo($idRecinto);
    }

    public function getDetalleIdOperativo($idDgoCreaOpReci)
    {
        $sql = "SELECT
                    pa.idDgoCreaOpReci,
                    rt.nomRecintoElec,
                    op.idDgoPerAsigOpe,
                    pa.estado,
                    op.cargo,
                    pa.latitud,
                    pa.longitud,
                    p.descProcElecc,
                    CONCAT( a.siglas, '. ', a.apenom ) as jefe_operativo,
                    t.idDgoTipoEje as idDgoTipoEje2,
                    t1.idDgoTipoEje as idDgoTipoEje1,
                    t2.idDgoTipoEje as idDgoTipoEje,
                    t.descripcion as nomt2,
                    t1.descripcion as nomt1,
                    t2.descripcion as nomt
                    FROM
                     dgoNovReciElec nv
                    INNER JOIN dgoPerAsigOpe op ON op.idDgoPerAsigOpe=nv.idDgoPerAsigOpe
                    INNER JOIN dgoCreaOpReci pa ON pa.idDgoCreaOpReci=op.idDgoCreaOpReci
                    LEFT JOIN v_personal_simple a ON a.idGenPersona = op.idGenPersona
                    INNER JOIN dgoComisios c ON c.idDgoComisios=pa.idDgoComisios
                    INNER JOIN dgoReciElect rt ON rt.idDgoReciElect=c.idDgoReciElect
                    INNER JOIN dgoProcElec p ON p.idDgoProcElec=c.idDgoProcElec
                     LEFT JOIN dgoTipoEje t ON t.idDgoTipoEje=rt.idDgoTipoEje
                    LEFT JOIN dgoTipoEje t1 ON t1.idDgoTipoEje=t.dgo_idDgoTipoEje
                    LEFT JOIN dgoTipoEje t2 ON t2.idDgoTipoEje=t1.dgo_idDgoTipoEje
                  WHERE
                     pa.idDgoCreaOpReci={$idDgoCreaOpReci}
                     AND op.cargo='J'
                    --   AND nv.idDgoNovedadesElect!=1
                     AND pa.delLog='N'
                     AND pa.estado='A'";
        return $this->consultar($sql);
    }

    public function getDetalleDatosJefeEditar($idDgoNovReciElec)
    {
        $sql = "SELECT
                    pa.idDgoCreaOpReci,
                    rt.nomRecintoElec,
                    op.idDgoPerAsigOpe,
                    pa.estado,
                    op.cargo,
                    pa.latitud,
                    pa.longitud,
                    p.descProcElecc,
                    CONCAT( a.siglas, '. ', a.apenom ) as jefe_operativo,
                    t.idDgoTipoEje as idDgoTipoEje2,
                    t1.idDgoTipoEje as idDgoTipoEje1,
                    t2.idDgoTipoEje as idDgoTipoEje,
                    t.descripcion as nomt2,
                    t1.descripcion as nomt1,
                    t2.descripcion as nomt,
                    nv.idDgoNovReciElec
                    FROM
                     dgoNovReciElec nv
                    INNER JOIN dgoPerAsigOpe op ON op.idDgoPerAsigOpe=nv.idDgoPerAsigOpe
                    INNER JOIN dgoCreaOpReci pa ON pa.idDgoCreaOpReci=op.idDgoCreaOpReci
                    INNER JOIN v_personal_simple a ON a.idGenPersona = op.idGenPersona
                    INNER JOIN dgoComisios c ON c.idDgoComisios=pa.idDgoComisios
                    INNER JOIN dgoReciElect rt ON rt.idDgoReciElect=c.idDgoReciElect
                    INNER JOIN dgoProcElec p ON p.idDgoProcElec=c.idDgoProcElec
                     LEFT JOIN dgoTipoEje t ON t.idDgoTipoEje=rt.idDgoTipoEje
                    LEFT JOIN dgoTipoEje t1 ON t1.idDgoTipoEje=t.dgo_idDgoTipoEje
                    LEFT JOIN dgoTipoEje t2 ON t2.idDgoTipoEje=t1.dgo_idDgoTipoEje
                  WHERE
                     nv.idDgoNovReciElec ='{$idDgoNovReciElec}'";

        return $this->consultar($sql);
    }
}
