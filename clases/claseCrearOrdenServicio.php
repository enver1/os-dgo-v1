<?php
class CrearOrdenServicio extends Transaccion
{
    private $tabla   = 'dgoOrdenServicio';
    private $idTabla = 'idDgoOrdenServicio';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaCrearOrdenServicio()
    {
        return $this->tabla;
    }
    public function getSqlCrearOrdenServicio($idGenGeoSenplades)
    {
        $sql = "SELECT      os.idDgoOrdenServicio,
                                os.idDgoTipoCalificacion,
                                os.idGenPersonaJefeOperativo,
                                os.idGenPersonaComandante,
                                os.idGenPersonaElabora,
                                os.idGenGeoSenplades,
                                os.idGenDivPolitica,
                                os.jefeOperativo,
                                os.comandanteUnidad,
                                os.nombreElabora,                    
                                os.nombreOperativo,
                                os.detalleOperativo,
                                os.fechaOrden,
                                os.horaOrden,
                                os.horaFormacion,
                                os.estadoOrden,   
                                tc.descripcion as calificacion,
                                gt.descripcion as tipoOperativo,
                                gt1.descripcion as operativo,
                                gt1.idGenTipoOperativo as idGenTipoOperativo,	
	                            gt.idGenTipoOperativo as idGenTipoOperativo1,
                                gd.siglasGeoSenplades,
                                gz.descripcion as Zona,
                                gs.descripcion as Subzona,
                                gd.descripcion as Distrito,
                                dp1.descripcion as provincia,
                                dp.descripcion as ciudad,
                               CONCAT(o.anio,'-',o.descripcion,'-',o.numerico) as numeroOrden,
                               CONCAT(dp1.descripcion,', ',dp.descripcion) as divPoliticaDescripcion,
                               os.estadoOrden 
                         FROM
                                dgoOrdenServicio os
                                INNER JOIN dgoTipoCalificacion tc ON tc.idDgoTipoCalificacion = os.idDgoTipoCalificacion
                                INNER JOIN genTipoOperativo gt ON gt.idGenTipoOperativo = os.idGenTipoOperativo
                                INNER JOIN genTipoOperativo gt1 ON gt1.idGenTipoOperativo = gt.genTipoOperativo_idGenTipoOperativo
                                INNER JOIN genGeoSenplades gd ON gd.idGenGeoSenplades = os.idGenGeoSenplades
                                INNER JOIN genGeoSenplades gs ON gs.idGenGeoSenplades = gd.gen_idGenGeoSenplades
                                INNER JOIN genGeoSenplades gz ON gz.idGenGeoSenplades = gs.gen_idGenGeoSenplades
                                INNER JOIN genDivPolitica dp ON dp.idGenDivPolitica = os.idGenDivPolitica
                                INNER JOIN genDivPolitica dp1 ON dp1.idGenDivPolitica = dp.gen_idGenDivPolitica
                                LEFT JOIN dgoOrdinalesOrden o ON o.idDgoOrdenServicio=os.idDgoOrdenServicio
                            WHERE
                                 os.idGenGeoSenplades=" . $idGenGeoSenplades . " AND os.delLog = 'N' ORDER BY os.estadoOrden,os.idDgoOrdenServicio";
        return $sql;
    }
    public function getCrearOrdenServicio($idGenGeoSenplades)
    {
        return $this->consultarAll($this->getSqlCrearOrdenServicio($idGenGeoSenplades));
    }

    public function getEditCrearOrdenServicio($idDgoOrdenServicio)
    {
        $sql = "SELECT
        os.idDgoOrdenServicio,
        os.idDgoTipoCalificacion,
        os.idGenPersonaJefeOperativo,
        os.idGenPersonaComandante,
        os.idGenPersonaElabora,
        os.idGenGeoSenplades,
        os.idGenDivPolitica,
        os.jefeOperativo,
        os.comandanteUnidad,
        os.nombreElabora,
        os.nombreOperativo,
        os.detalleOperativo,
        os.fechaOrden,
        os.horaOrden,
        os.fechaFinOrden,
        os.horaFormacion,
        tc.descripcion AS calificacion,
        os.idGenTipoOperativo AS idGenTipoOperativoHijo,
        gt.genTipoOperativo_idGenTipoOperativo AS idGenTipoOperativo,
        gd.siglasGeoSenplades,
        gz.descripcion AS Zona,
        gs.descripcion AS Subzona,
        gd.descripcion AS Distrito,
        dp1.descripcion AS provincia,
        dp.descripcion AS ciudad,
        CONCAT(o.anio,'-',o.descripcion,'-',o.numerico) as numeroOrden,
        CONCAT( dp1.descripcion, ', ', dp.descripcion ) AS divPoliticaDescripcion,
        CONCAT( vpj.siglas, '. ', vpj.apenom ) AS nombrePersonaJefe,
        vpj.documento AS cedulaPersonaJefe,
        vpj.idGenPersona AS idGenPersonaJefeOperativo,
        CONCAT( vpc.siglas, '. ', vpc.apenom ) AS nombrePersonaComandante,
        vpc.documento AS cedulaPersonaComandante,
        vpc.apenom as coman,
        vpc.siglas as siglasComan,
        vpj.funcion,
        vpc.idGenPersona AS idGenPersonaComandante 
    FROM
        dgoOrdenServicio os
        INNER JOIN dgoTipoCalificacion tc ON tc.idDgoTipoCalificacion = os.idDgoTipoCalificacion
        INNER JOIN genTipoOperativo gt ON gt.idGenTipoOperativo = os.idGenTipoOperativo
        INNER JOIN genTipoOperativo gt1 ON gt1.idGenTipoOperativo = gt.idGenTipoOperativo
        INNER JOIN genGeoSenplades gd ON gd.idGenGeoSenplades = os.idGenGeoSenplades
        INNER JOIN genGeoSenplades gs ON gs.idGenGeoSenplades = gd.gen_idGenGeoSenplades
        INNER JOIN genGeoSenplades gz ON gz.idGenGeoSenplades = gs.gen_idGenGeoSenplades
        INNER JOIN genDivPolitica dp ON dp.idGenDivPolitica = os.idGenDivPolitica
        INNER JOIN genDivPolitica dp1 ON dp1.idGenDivPolitica = dp.gen_idGenDivPolitica
        LEFT JOIN dgoOrdinalesOrden o ON o.idDgoOrdenServicio = os.idDgoOrdenServicio
        INNER JOIN v_personal_pn vpj ON vpj.idGenPersona = os.idGenPersonaJefeOperativo
        INNER JOIN v_personal_simple vpc ON vpc.idGenPersona = os.idGenPersonaComandante 
    WHERE
        os.idDgoOrdenServicio ={$idDgoOrdenServicio}";
        return $this->consultar($sql);
    }

    public function registrarCrearOrdenServicio($datos)
    {
        $tabla      = 'dgoOrdenServicio';
        $tStructure = array(
            'idDgoTipoCalificacion'         => 'idDgoTipoCalificacion',
            'idGenTipoOperativo'            => 'idGenTipoOperativo',
            'idGenPersonaJefeOperativo'     => 'idGenPersonaJefeOperativo',
            'idGenPersonaComandante'        => 'idGenPersonaComandante',
            'idGenPersonaElabora'           => 'idGenPersonaElabora',
            'idGenGeoSenplades'             => 'idGenGeoSenplades',
            'idGenDivPolitica'              => 'idGenDivPolitica',
            'jefeOperativo'                 => 'jefeOperativo',
            'comandanteUnidad'              => 'comandanteUnidad',
            'nombreElabora'                 => 'nombreElabora',
            'fechaFinOrden'                        => 'fechaFinOrden',
            'estadoOrden'                   => 'estadoOrden',
            'nombreOperativo'               => 'nombreOperativo',
            'fechaOrden'                    => 'fechaOrden',
            'horaOrden'                     => 'horaOrden',
            'horaFormacion'                 => 'horaFormacion',
            'detalleOperativo'              => 'detalleOperativo',
            'delLog'                        => 'delLog',
        );
        $datos['delLog'] = 'N';
        $datos['estadoOrden'] = 'TEMPORAL';
        $datos['idGenTipoOperativo'] = $datos['idGenTipoOperativoHijo'];
        $descripcion     = 'idGenGeoSenplades,nombreOperativo,estadoOrden,delLog';
        if (empty($datos['idDgoOrdenServicio'])) {
            $resp = $this->insert($tabla, $tStructure, $datos, $descripcion);
            $respuesta = $this->insertaControlOrden($resp[2]);
            // $respuesta = $this->insertaOrdinal($datos['idGenGeoSenplades'], $resp[2], $datos['anio'], $datos['siglasDistrito']);
        } else {
            $conDupli  = " and idDgoOrdenServicio != " . $datos['idDgoOrdenServicio'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarCrearOrdenServicio($idDgoOrdenServicio)
    {
        if (!empty($idDgoOrdenServicio)) {
            $respuesta = $this->delete($this->tabla, $idDgoOrdenServicio);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlCrearOrdenServicioPdf()
    {
        $sql = "SELECT
        os.*,
        tc.descripcion AS calificacion,
        gt.descripcion AS tipoOperativo,
        gt1.descripcion AS operativo,
        gd.siglasGeoSenplades,
        gz.descripcion AS Zona,
        gs.descripcion AS Subzona,
        gd.descripcion AS Distrito,
        dp1.descripcion AS provincia,
        dp.descripcion AS ciudad 
    FROM
        dgoOrdenServicio os
        INNER JOIN dgoTipoCalificacion tc ON tc.idDgoTipoCalificacion = os.idDgoTipoCalificacion
        INNER JOIN genTipoOperativo gt ON gt.idGenTipoOperativo = os.idGenTipoOperativo
        INNER JOIN genTipoOperativo gt1 ON gt1.idGenTipoOperativo = gt.genTipoOperativo_idGenTipoOperativo
        INNER JOIN genGeoSenplades gd ON gd.idGenGeoSenplades = os.idGenGeoSenplades
        INNER JOIN genGeoSenplades gs ON gs.idGenGeoSenplades = gd.gen_idGenGeoSenplades
        INNER JOIN genGeoSenplades gz ON gz.idGenGeoSenplades = gs.gen_idGenGeoSenplades
        INNER JOIN genDivPolitica dp ON dp.idGenDivPolitica = os.idGenDivPolitica
        INNER JOIN genDivPolitica dp1 ON dp1.idGenDivPolitica = dp.gen_idGenDivPolitica 
    WHERE
        os.delLog = 'N'";
        return $sql;
    }
    public function getDatosImprimirCrearOrdenServicioPdf()
    {
        return $this->consultarAll($this->getSqlCrearOrdenServicioPdf());
    }
    public function getTipoOperativo($idGenTipoOperativo)
    {
        $sql = "SELECT      a.idGenTipoOperativo,
                            a.descripcion,
                            a.genTipoOperativo_idGenTipoOperativo
                        FROM
                            genTipoOperativo a
                            
                        WHERE
                            a.genTipoOperativo_idGenTipoOperativo =" . $idGenTipoOperativo . " AND a.delLog = 'N'";
        return $this->consultarAll($sql);
    }
    public function counOrdinal($idGenGeoSenplades, $anio)
    {
        $sql = "SELECT count(*) as total 
        FROM dgoOrdinalesOrden 
        where idGenGeoSenplades=" . $idGenGeoSenplades . " AND anio='" . $anio . "' AND delLog = 'N'";
        return $this->consultar($sql);
    }
    public function insertaOrdinal($idGenGeoSenplades, $idOrden, $anio, $siglas)
    {
        $datos = array();
        $numerico = $this->counOrdinal($idGenGeoSenplades, $anio);
        $total = $numerico['total'] + 1;
        $tabla      = 'dgoOrdinalesOrden';
        $tStructure = array(
            'idGenGeoSenplades'     => 'idGenGeoSenplades',
            'idDgoOrdenServicio'    => 'idDgoOrdenServicio',
            'descripcion'           => 'descripcion',
            'anio'                  => 'anio',
            'numerico'              => 'numerico',
            'delLog'                => 'delLog',
        );
        $datos['delLog'] = 'N';
        $datos['idGenGeoSenplades'] = $idGenGeoSenplades;
        $datos['idDgoOrdenServicio'] = $idOrden;
        $datos['descripcion'] = $siglas;
        $datos['numerico'] = $total;
        $datos['anio'] = $anio;
        $descripcion     = '';
        $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        return $respuesta;
    }
    public function insertaControlOrden($idDgoOrdenServicio)
    {
        $datos = array();
        $tabla      = 'dgoControlOrden';
        $tStructure = array(
            'idDgoOrdenServicio'    => 'idDgoOrdenServicio',
            'delLog'                => 'delLog',
        );
        $datos['delLog'] = 'N';
        $datos['idDgoOrdenServicio'] = $idDgoOrdenServicio;
        $descripcion     = '';
        $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        return $respuesta;
    }
    public function validaEstadoOrden($idDgoOrdenServicio)
    {
        $sql = "SELECT  a.*, dg.estadoOrden 
                        FROM
                            dgoControlOrden a
                            INNER JOIN dgoOrdenServicio dg ON dg.idDgoOrdenServicio=a.idDgoOrdenServicio
                        WHERE
                            a.idDgoOrdenServicio =" . $idDgoOrdenServicio;
        return $this->consultar($sql);
    }
    public function verificaAntecedente($idDgoOrdenServicio)
    {
        $sql = "SELECT * 
        FROM dgoAntecedentes a
        where a.idDgoOrdenServicio=" . $idDgoOrdenServicio . "  AND delLog = 'N'";
        return $this->consultarAll($sql);
    }
    public function verificaMision($idDgoOrdenServicio)
    {
        $sql = "SELECT * 
        FROM dgoDetalleMision a
        where a.idDgoOrdenServicio=" . $idDgoOrdenServicio . "  AND delLog = 'N'";
        return $this->consultarAll($sql);
    }
    public function verificaInstrucciones($idDgoOrdenServicio, $tipo)
    {
        $sql = "SELECT * 
        FROM dgoDetalleInstrucciones a
        where a.idDgoOrdenServicio=" . $idDgoOrdenServicio . "  AND delLog = 'N' AND a.tipo='" . $tipo . "'";
        return $this->consultarAll($sql);
    }
    public function verificaInstruccionesDetalle($idDgoOrdenServicio, $tipo, $temp)
    {
        $sql = "SELECT * 
        FROM dgoDetalleInstrucciones a
        where a.idDgoOrdenServicio=" . $idDgoOrdenServicio . "  AND temporalidad = '" . $temp . "' AND delLog = 'N' AND a.tipo='" . $tipo . "'";
        return $this->consultarAll($sql);
    }
    public function verificaEjemplares($idDgoOrdenServicio)
    {
        $sql = "SELECT * 
        FROM dgoEjemplarOrden a
        where a.idDgoOrdenServicio=" . $idDgoOrdenServicio . "  AND delLog = 'N'";
        return $this->consultarAll($sql);
    }
    public function verificaEjemplaresTipo($idDgoOrdenServicio, $tipo)
    {
        $sql = "SELECT * 
        FROM dgoEjemplarOrden a
        where a.idDgoOrdenServicio=" . $idDgoOrdenServicio . "  AND a.delLog = 'N' AND a.destino='" . $tipo . "'";
        return $this->consultarAll($sql);
    }
    public function verificaAnexos($idDgoOrdenServicio)
    {
        $sql = "SELECT * 
        FROM dgoAnexosOrden a
        where a.idDgoOrdenServicio=" . $idDgoOrdenServicio . "  AND delLog = 'N'";
        return $this->consultarAll($sql);
    }
    public function verificaFuerzasPropias($idDgoOrdenServicio)
    {
        $sql = "SELECT     a.superiores as uno,
                           a.subalternos as dos,
                           a.clases as tres,
                           du.descripcion,
                           du1.descripcion,
                           a.idDgpUnidad,
                           du.nomenclatura as cero
                    FROM
                        dgoFuerzasPropias a
                        INNER JOIN dgpUnidad du ON du.idDgpUnidad= a.idDgpUnidad 
                        INNER JOIN dgpUnidad du1 ON du1.idDgpUnidad= du.dgp_idDgpUnidad 
                    WHERE
                        a.delLog = 'N' AND a.idDgoOrdenServicio=" . $idDgoOrdenServicio . "
                    ORDER BY
                        a.idDgoFuerzasPropias DESC";
        return $this->consultarAll($sql);
    }
    public function getTotalFuerzasP($idDgoOrdenServicio)
    {
        $sql = "SELECT  CONCAT('TOTAL') as cero,
                        SUM( a.superiores ) as uno,
                        SUM( a.subalternos ) as dos,
                        SUM( a.clases ) as tres
                    FROM
                        dgoFuerzasPropias a
                    WHERE
                        a.delLog = 'N' 
                        AND a.idDgoOrdenServicio =" . $idDgoOrdenServicio;
        return $this->consultarAll($sql);
    }
    public function getTotalFuerzasA($idDgoOrdenServicio)
    {
        $sql = "SELECT  CONCAT('TOTAL') as cero,
                        SUM( a.numericoJefes ) as uno,
                        SUM( a.numericoSubalternos ) as dos
                    FROM
                    dgoFuerzasAlternativas a
                    WHERE
                        a.delLog = 'N' 
                        AND a.idDgoOrdenServicio =" . $idDgoOrdenServicio;
        return $this->consultarAll($sql);
    }
    public function verificaFuerzasAgregadas($idDgoOrdenServicio)
    {
        $sql = "SELECT  a.numericoJefes as uno,
                        a.numericoSubalternos as dos,
                        a.idDgoTipoFuerzasAlternativas,
                        du.descripcion as cero                           
                        FROM
                            dgoFuerzasAlternativas a
                            INNER JOIN dgoTipoFuerzasAlternativas du ON du.idDgoTipoFuerzasAlternativas= a.idDgoTipoFuerzasAlternativas 
                        WHERE
                            a.delLog = 'N' AND a.idDgoOrdenServicio=" . $idDgoOrdenServicio . "
                        ORDER BY
                            a.idDgoFuerzasAlternativas DESC";
        return $this->consultarAll($sql);
    }
    public function verificaMediosLogísticos($idDgoOrdenServicio)
    {
        $sql = "SELECT      a.idDgoMediosLogisticos,
                            a.idDgoOrdenServicio,
                            a.cantidad as uno,
                            a.idDgoDetalleMediosLogisticos,
                            du.descripcion   as cero                        
                        FROM
                        dgoDetalleMediosLogisticos a
                            INNER JOIN dgoMediosLogisticos du ON du.idDgoMediosLogisticos= a.idDgoMediosLogisticos 
                        WHERE
                            a.delLog = 'N' AND a.idDgoOrdenServicio=" . $idDgoOrdenServicio;
        return $this->consultarAll($sql);
    }
    public function consultaOrdinalOrden($idDgoOrdenServicio)
    {
        $sql = "SELECT * 
        FROM dgoOrdinalesOrden a
        where a.idDgoOrdenServicio=" . $idDgoOrdenServicio . "  AND delLog = 'N'";
        return $this->consultar($sql);
    }
    public function formatoFecha($fecha, $op)
    {
        $dia = $this->conocerDiaSemanaFecha($fecha);
        $afecha = explode('-', $fecha);
        switch ($afecha[1]) {
            case '01':
                $mes = 'ENERO';
                break;
            case '02':
                $mes = 'FEBRERO';
                break;
            case '03':
                $mes = 'MARZO';
                break;
            case '04':
                $mes = 'ABRIL';
                break;
            case '05':
                $mes = 'MAYO';
                break;
            case '06':
                $mes = 'JUNIO';
                break;
            case '07':
                $mes = 'JULIO';
                break;
            case '08':
                $mes = 'AGOSTO';
                break;
            case '09':
                $mes = 'SEPTIEMBRE';
                break;
            case '10':
                $mes = 'OCTUBRE';
                break;
            case '11':
                $mes = 'NOVIEMBRE';
                break;
            case '12':
                $mes = 'DICIEMBRE';
                break;
        }
        if ($op == 1) {
            return ($dia . ' ' . $afecha[2] . ' DE ' . $mes . ' DEL ' . $afecha[0]);
        }
        if ($op == 2) {
            return ($dia . '-' . $afecha[2] . '-' . $mes . '-' . $afecha[0]);
        }
    }
    function conocerDiaSemanaFecha($fecha)
    {
        $dias = array('DOMINGO', 'LUNES', 'MARTES', 'MIÉRCOLES', 'JUEVES', 'VIERNES', 'SÁBADO');
        $dia = $dias[date('w', strtotime($fecha))];
        return $dia;
    }
    public function formatoGrado($siglas)
    {
        switch ($siglas) {
            case 'GRAS':
                $grado = 'GENERAL SUPERIOR';
                break;
            case 'GRAI':
                $grado = 'GENERAL INSPECTOR';
                break;
            case 'GRAD':
                $grado = 'GENERAL DE DISTRITO';
                break;
            case 'CRNL':
                $grado = 'CORONEL DE POLICÍA DE E.M.';
                break;
            case 'TCNL':
                $grado = 'TENIENTE CORONEL DE POLICÍA DE E.M.';
                break;
            case 'MAYR':
                $grado = 'MAYOR DE POLICÍA';
                break;
            case 'CPTN':
                $grado = 'CAPITÁN DE POLICÍA';
                break;
            case 'TNTE':
                $grado = 'TENIENTE DE POLICÍA';
                break;
            case 'SBTE':
                $grado = 'SUBTENIENTE DE POLICÍA';
                break;
            case 'SBOM':
                $grado = 'SUBOFICIAL MAYOR DE POLICÍA';
                break;
            case 'SBOP':
                $grado = 'SUBOFICIAL PRIMERO DE POLICÍA';
                break;
            case 'SBOS':
                $grado = 'SUBOFICIAL SEGUNDO DE POLICÍA';
                break;
            case 'SGOP':
                $grado = 'SARGENTO PRIMERO DE POLICÍA';
                break;
            case 'SGOS':
                $grado = 'SARGENTO SEGUNDO DE POLICÍA';
                break;
            case 'CBOP':
                $grado = 'CABO PRIMERO DE POLICÍA';
                break;
            case 'CBOS':
                $grado = 'CABO SEGUNDO DE POLICÍA';
                break;
            case 'POLI':
                $grado = 'POLICÍA NACIONAL';
                break;
        }
        return ($grado);
    }

    public function getDatosUnidades($idDgoOrdenServicio)
    {
        $sql = "SELECT
        a.idDgpUnidad,
        b.nombreComun as unidad
       	
    FROM
        dgoTalentoHumano a
        INNER JOIN v_personal_pn b ON b.idGenPersona = a.idGenPersona
        WHERE a.delLog='N' AND a.idDgoOrdenServicio=" . $idDgoOrdenServicio . " GROUP BY	a.idDgpUnidad";
        return $this->consultarAll($sql);
    }
    public function getDatosTalentoHumanoOrden($idDgoOrdenServicio)
    {
        $sql = "SELECT
        a.idDgoTalentoHumano,
        a.idDgoOrdenServicio,
        a.idDgpGrado,
        a.idDgpUnidad,
        a.idGenPersona,
        CONCAT(b.siglas,'. ',b.apenom) as nombrePersona,
        b.documento as cedulaPersona,
        u2.descripcion as unidad,
        b.funcion,
        b.siglas	
    FROM
        dgoTalentoHumano a
        INNER JOIN v_personal_pn b ON b.idGenPersona = a.idGenPersona
        INNER JOIN dgpUnidad u ON u.idDgpUnidad = a.idDgpUnidad
        INNER JOIN dgpUnidad u1 ON u1.idDgpUnidad = u.dgp_idDgpUnidad
        INNER JOIN dgpUnidad u2 ON u2.idDgpUnidad = u1.dgp_idDgpUnidad
        WHERE a.delLog='N' AND a.idDgoOrdenServicio=" . $idDgoOrdenServicio . " Order by a.idDgpUnidad,a.idDgpGrado";
        return $this->consultarAll($sql);
    }
    public function getDatosTalentoHumanoNumerico($idDgoOrdenServicio, $idDgpUnidad)
    {
        $sql = "SELECT
        a.idDgpUnidad,
        u2.descripcion as unidad,
        b.siglas	
    FROM
        dgoTalentoHumano a
        INNER JOIN v_personal_pn b ON b.idGenPersona = a.idGenPersona
        INNER JOIN dgpUnidad u ON u.idDgpUnidad = a.idDgpUnidad
        INNER JOIN dgpUnidad u1 ON u1.idDgpUnidad = u.dgp_idDgpUnidad
        INNER JOIN dgpUnidad u2 ON u2.idDgpUnidad = u1.dgp_idDgpUnidad
        WHERE a.delLog='N' AND a.idDgoOrdenServicio=" . $idDgoOrdenServicio . " AND a.idDgpUnidad=" . $idDgpUnidad;
        return $this->consultarAll($sql);
    }




    public function getDatosTalentoHumanoPorUnidad($idDgoOrdenServicio)
    {

        $ord = array();
        $thr = $this->getDatosUnidades($idDgoOrdenServicio);

        foreach ($thr as $fila) {
            $v = $this->getDatosTalentoHumanoNumerico($idDgoOrdenServicio, $fila['idDgpUnidad']);
            $subAlternos = 0;
            $superiores = 0;
            $clases = 0;
            foreach ($v as $f) {
                $subAlternos = $subAlternos + $this->verificaGradoSuperiores($f['siglas']);
                $superiores = $superiores + $this->verificaGradoSubalternos($f['siglas']);
                $clases = $clases + $this->verificagradoClases($f['siglas']);
            }

            array_push($ord, array('cero' => $f['unidad'], 'uno' =>  $superiores, 'dos' =>  $subAlternos, 'tres' => $clases));
        }
        return $ord;
    }


    public function getTotalTalentoHumano($idDgoOrdenServicio)
    {

        $ord = array();
        $thr = $this->getDatosTalentoHumanoOrden($idDgoOrdenServicio);
        $subAlternos = 0;
        $superiores = 0;
        $clases = 0;
        foreach ($thr as $fila) {

            $subAlternos = $subAlternos + $this->verificaGradoSuperiores($fila['siglas']);
            $superiores = $superiores + $this->verificaGradoSubalternos($fila['siglas']);
            $clases = $clases + $this->verificagradoClases($fila['siglas']);
        }

        array_push($ord, array('cero' => 'TOTAL PERSONAL', 'uno' =>  $superiores, 'dos' =>  $subAlternos, 'tres' => $clases));
        return $ord;
    }



    public function verificaGradoSuperiores($siglas)
    {
        switch ($siglas) {
            case 'GRAS':
                $grado = 1;
                break;
            case 'GRAI':
                $grado = 1;
                break;
            case 'GRAD':
                $grado = 1;
                break;
            case 'CRNL':
                $grado = 1;
                break;
            case 'TCNL':
                $grado = 1;
                break;
            case 'MAYR':
                $grado = 1;
                break;
        }
        return ($grado);
    }
    public function verificaGradoSubalternos($siglas)
    {
        switch ($siglas) {
            case 'CPTN':
                $grado = 1;
                break;
            case 'TNTE':
                $grado = 1;
                break;
            case 'SBTE':
                $grado = 1;
                break;
        }
        return ($grado);
    }
    public function verificaGradoClases($siglas)
    {
        switch ($siglas) {
            case 'SBOM':
                $grado = 1;
                break;
            case 'SBOP':
                $grado = 1;
                break;
            case 'SBOS':
                $grado = 1;
                break;
            case 'SGOP':
                $grado = 1;
                break;
            case 'SGOS':
                $grado = 1;
                break;
            case 'CBOP':
                $grado = 1;
                break;
            case 'CBOS':
                $grado = 1;
                break;
            case 'POLI':
                $grado = 1;
                break;
        }
        return ($grado);
    }
    public function getDatosListaTalentoHumanoOrden($idDgoOrdenServicio)
    {
        $sql = "SELECT
  
        CONCAT(b.siglas,'. ',b.apenom) as cero,
        b.documento as cedulaPersona,
        u2.descripcion as uno,
        b.funcion as dos	
    FROM
        dgoTalentoHumano a
        INNER JOIN v_personal_pn b ON b.idGenPersona = a.idGenPersona
        INNER JOIN dgpUnidad u ON u.idDgpUnidad = a.idDgpUnidad
        INNER JOIN dgpUnidad u1 ON u1.idDgpUnidad = u.dgp_idDgpUnidad
        INNER JOIN dgpUnidad u2 ON u2.idDgpUnidad = u1.dgp_idDgpUnidad
        WHERE a.delLog='N' AND a.idDgoOrdenServicio=" . $idDgoOrdenServicio . " Order by a.idDgpUnidad,a.idDgpGrado";
        return $this->consultarAll($sql);
    }
}
