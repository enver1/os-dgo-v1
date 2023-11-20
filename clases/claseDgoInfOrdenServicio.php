<?php
class DgoInfOrdenServicio extends Transaccion
{
    private $tabla   = 'dgoInfOrdenServicio';
    private $idTabla = 'idDgoInfOrdenServicio';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaDgoInfOrdenServicio()
    {
        return $this->tabla;
    }
    public function getSqlDgoInfOrdenServicio($idGenGeoSenplades)
    {
        $sql = "SELECT      os.idDgoInfOrdenServicio,
                                os.idDgoTipoCalificacion,
                                os.idGenPersonaResponsable,
                                os.idGenPersonaComandante,
                                os.idGenPersonaElabora,
                                os.idGenGeoSenplades,
                                os.idGenDivPolitica,
                                os.responsableInforme,
                                os.comandanteUnidad,
                                os.nombreElabora,                    
                                os.nombreInforme,
                                os.detalleInforme,
                                os.fechaInforme,
                                os.horaInforme,
                                os.estadoInforme,   
                                tc.descripcion as calificacion,
                                gd.siglasGeoSenplades,
                                gz.descripcion as Zona,
                                gs.descripcion as Subzona,
                                gd.descripcion as Distrito,
                                dp1.descripcion as provincia,
                                dp.descripcion as ciudad,
                               CONCAT(o.anio,'-',o.descripcion,'-',o.numerico) as numeroInforme,
                               CONCAT(dp1.descripcion,', ',dp.descripcion) as divPoliticaDescripcion 
                         FROM
                                dgoInfOrdenServicio os
                                INNER JOIN dgoTipoCalificacion tc ON tc.idDgoTipoCalificacion = os.idDgoTipoCalificacion
                                INNER JOIN genGeoSenplades gd ON gd.idGenGeoSenplades = os.idGenGeoSenplades
                                INNER JOIN genGeoSenplades gs ON gs.idGenGeoSenplades = gd.gen_idGenGeoSenplades
                                INNER JOIN genGeoSenplades gz ON gz.idGenGeoSenplades = gs.gen_idGenGeoSenplades
                                INNER JOIN genDivPolitica dp ON dp.idGenDivPolitica = os.idGenDivPolitica
                                INNER JOIN genDivPolitica dp1 ON dp1.idGenDivPolitica = dp.gen_idGenDivPolitica
                                LEFT JOIN dgoOrdinalesInforme o ON o.idDgoInfOrdenServicio=os.idDgoInfOrdenServicio
                            WHERE
                                 os.idGenGeoSenplades=" . $idGenGeoSenplades . " AND os.delLog = 'N' ORDER BY os.estadoInforme,os.idDgoInfOrdenServicio";
        return $sql;
    }
    public function getDgoInfOrdenServicio($idGenGeoSenplades)
    {
        return $this->consultarAll($this->getSqlDgoInfOrdenServicio($idGenGeoSenplades));
    }

    public function getEditDgoInfOrdenServicio($idDgoInfOrdenServicio)
    {
        $sql = "SELECT
        os.idDgoInfOrdenServicio,
        os.idDgoTipoCalificacion,
        os.idGenPersonaResponsable,
        os.idGenPersonaComandante,
        os.idGenPersonaElabora,
        os.idGenGeoSenplades,
        os.idGenDivPolitica,
        os.responsableInforme,
        os.comandanteUnidad,
        os.nombreElabora,
        os.nombreInforme,
        os.detalleInforme,
        os.fechaInforme,
        os.horaInforme,
        tc.descripcion AS calificacion,
        gd.siglasGeoSenplades,
        gz.descripcion AS Zona,
        gs.descripcion AS Subzona,
        gd.descripcion AS Distrito,
        dp1.descripcion AS provincia,
        dp.descripcion AS ciudad,
        CONCAT(o.anio,'-',o.descripcion,'-',o.numerico) as numeroInforme,
        CONCAT( dp1.descripcion, ', ', dp.descripcion ) AS divPoliticaDescripcion,
        CONCAT( vpj.siglas, '. ', vpj.apenom ) AS nombrePersonaR,
        vpj.documento AS cedulaPersonaR,
        vpj.idGenPersona AS idGenPersonaResponsable,
        CONCAT( vpc.siglas, '. ', vpc.apenom ) AS nombrePersonaComandante,
        vpc.documento AS cedulaPersonaComandante,
        vpc.apenom as coman,
        vpc.siglas as siglasComan,
        vpj.funcion,
        vpc.idGenPersona AS idGenPersonaComandante 
    FROM
        dgoInfOrdenServicio os
        INNER JOIN dgoTipoCalificacion tc ON tc.idDgoTipoCalificacion = os.idDgoTipoCalificacion
        INNER JOIN genGeoSenplades gd ON gd.idGenGeoSenplades = os.idGenGeoSenplades
        INNER JOIN genGeoSenplades gs ON gs.idGenGeoSenplades = gd.gen_idGenGeoSenplades
        INNER JOIN genGeoSenplades gz ON gz.idGenGeoSenplades = gs.gen_idGenGeoSenplades
        INNER JOIN genDivPolitica dp ON dp.idGenDivPolitica = os.idGenDivPolitica
        INNER JOIN genDivPolitica dp1 ON dp1.idGenDivPolitica = dp.gen_idGenDivPolitica
        LEFT JOIN dgoOrdinalesInforme o ON o.idDgoInfOrdenServicio = os.idDgoInfOrdenServicio
        INNER JOIN v_personal_pn vpj ON vpj.idGenPersona = os.idGenPersonaResponsable
        INNER JOIN v_personal_simple vpc ON vpc.idGenPersona = os.idGenPersonaComandante 
    WHERE
        os.idDgoInfOrdenServicio ={$idDgoInfOrdenServicio}";
        return $this->consultar($sql);
    }

    public function registrarDgoInfOrdenServicio($datos)
    {
        $tabla      = 'dgoInfOrdenServicio';
        $tStructure = array(
            'idDgoTipoCalificacion'         => 'idDgoTipoCalificacion',
            'idGenPersonaResponsable'     => 'idGenPersonaResponsable',
            'idGenPersonaComandante'        => 'idGenPersonaComandante',
            'idGenPersonaElabora'           => 'idGenPersonaElabora',
            'idGenGeoSenplades'             => 'idGenGeoSenplades',
            'idGenDivPolitica'              => 'idGenDivPolitica',
            'responsableInforme'                 => 'responsableInforme',
            'comandanteUnidad'              => 'comandanteUnidad',
            'nombreElabora'                 => 'nombreElabora',
            'estadoInforme'                   => 'estadoInforme',
            'nombreInforme'               => 'nombreInforme',
            'fechaInforme'                    => 'fechaInforme',
            'horaInforme'                     => 'horaInforme',
            'detalleInforme'              => 'detalleInforme',
            'delLog'                        => 'delLog',
        );
        $datos['delLog'] = 'N';
        $datos['estadoInforme'] = 'TEMPORAL';
        $descripcion     = 'idGenGeoSenplades,nombreInforme,estadoInforme,delLog';
        if (empty($datos['idDgoInfOrdenServicio'])) {
            $resp = $this->insert($tabla, $tStructure, $datos, $descripcion);
            $respuesta = $this->insertaControlOrden($resp[2]);
            // $respuesta = $this->insertaOrdinal($datos['idGenGeoSenplades'], $resp[2], $datos['anio'], $datos['siglasDistrito']);
        } else {
            $conDupli  = " and idDgoInfOrdenServicio != " . $datos['idDgoInfOrdenServicio'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarDgoInfOrdenServicio($idDgoInfOrdenServicio)
    {
        if (!empty($idDgoInfOrdenServicio)) {
            $respuesta = $this->delete($this->tabla, $idDgoInfOrdenServicio);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlDgoInfOrdenServicioPdf()
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
        dgoInfOrdenServicio os
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
    public function getDatosImprimirDgoInfOrdenServicioPdf()
    {
        return $this->consultarAll($this->getSqlDgoInfOrdenServicioPdf());
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
        FROM dgoOrdinalesInforme 
        where idGenGeoSenplades=" . $idGenGeoSenplades . " AND anio='" . $anio . "' AND delLog = 'N'";
        return $this->consultar($sql);
    }
    public function insertaOrdinal($idGenGeoSenplades, $idOrden, $anio, $siglas)
    {
        $datos = array();
        $numerico = $this->counOrdinal($idGenGeoSenplades, $anio);
        $total = $numerico['total'] + 1;
        $tabla      = 'dgoOrdinalesInforme';
        $tStructure = array(
            'idGenGeoSenplades'     => 'idGenGeoSenplades',
            'idDgoInfOrdenServicio'    => 'idDgoInfOrdenServicio',
            'descripcion'           => 'descripcion',
            'anio'                  => 'anio',
            'numerico'              => 'numerico',
            'delLog'                => 'delLog',
        );
        $datos['delLog'] = 'N';
        $datos['idGenGeoSenplades'] = $idGenGeoSenplades;
        $datos['idDgoInfOrdenServicio'] = $idOrden;
        $datos['descripcion'] = $siglas;
        $datos['numerico'] = $total;
        $datos['anio'] = $anio;
        $descripcion     = '';
        $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        return $respuesta;
    }
    public function insertaControlOrden($idDgoInfOrdenServicio)
    {
        $datos = array();
        $tabla      = 'dgoControlInforme';
        $tStructure = array(
            'idDgoInfOrdenServicio'    => 'idDgoInfOrdenServicio',
            'delLog'                => 'delLog',
        );
        $datos['delLog'] = 'N';
        $datos['idDgoInfOrdenServicio'] = $idDgoInfOrdenServicio;
        $descripcion     = '';
        $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        return $respuesta;
    }
    public function validaEstadoInforme($idDgoInfOrdenServicio)
    {
        $sql = "SELECT  a.*, dg.estadoInforme 
                        FROM
                            dgoControlInforme a
                            INNER JOIN dgoInfOrdenServicio dg ON dg.idDgoInfOrdenServicio=a.idDgoInfOrdenServicio
                        WHERE
                            a.idDgoInfOrdenServicio =" . $idDgoInfOrdenServicio;
        return $this->consultar($sql);
    }

    /*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
FUNCIONES SECUNDARIAS DEL INFORME//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/


    public function verificaAntecedente($idDgoInfOrdenServicio)
    {
        $sql = "SELECT * 
        FROM dgoAntecedentesInforme a
        where a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . "  AND delLog = 'N'";
        return $this->consultarAll($sql);
    }
    public function verificaOperaciones($idDgoInfOrdenServicio)
    {
        $sql = "SELECT * 
        FROM dgoOperacionesInf a
        where a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . "  AND delLog = 'N'";
        return $this->consultarAll($sql);
    }
    public function verificaEvaluacion($idDgoInfOrdenServicio)
    {
        $sql = "SELECT * 
        FROM dgoEvaluacionInf a
        where a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . "  AND delLog = 'N'";
        return $this->consultarAll($sql);
    }
    public function verificaOportunidades($idDgoInfOrdenServicio)
    {
        $sql = "SELECT * 
        FROM dgoOportunidadesInf a
        where a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . "  AND delLog = 'N'";
        return $this->consultarAll($sql);
    }
    public function getTipoEvaluacion()
    {
        $sql = "SELECT * 
        FROM dgoTipoEvaluacionInf a
        where a.delLog = 'N' AND a.idGenEstado=1";
        return $this->consultarAll($sql);
    }

    public function verificaEvaluacionDetalle($idDgoInfOrdenServicio, $idDgoTipoEvaluacionInf)
    {
        $sql = "SELECT * 
        FROM dgoEvaluacionInf a
        where a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . "  AND idDgoTipoEvaluacionInf = '" . $idDgoTipoEvaluacionInf . "' AND delLog = 'N'";
        return $this->consultarAll($sql);
    }
    public function verificaEjemplares($idDgoInfOrdenServicio)
    {
        $sql = "SELECT * 
        FROM dgoEjemplarInforme a
        where a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . "  AND delLog = 'N'";
        return $this->consultarAll($sql);
    }
    public function verificaEjemplaresTipo($idDgoInfOrdenServicio, $tipo)
    {
        $sql = "SELECT * 
        FROM dgoEjemplarInforme a
        where a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . "  AND a.delLog = 'N' AND a.destino='" . $tipo . "'";
        return $this->consultarAll($sql);
    }
    public function verificaAnexos($idDgoInfOrdenServicio)
    {
        $sql = "SELECT * 
        FROM dgoAnexosInforme a
        where a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . "  AND delLog = 'N'";
        return $this->consultarAll($sql);
    }
    public function verificaFuerzasPropias($idDgoInfOrdenServicio)
    {
        $sql = "SELECT     a.superiores as uno,
                           a.subalternos as dos,
                           a.clases as tres,
                           du.descripcion as cero,
                           du1.descripcion,
                           a.idDgpUnidad,
                           du.nomenclatura 
                    FROM
                        dgoFuerzasPropias a
                        INNER JOIN dgpUnidad du ON du.idDgpUnidad= a.idDgpUnidad 
                        INNER JOIN dgpUnidad du1 ON du1.idDgpUnidad= du.dgp_idDgpUnidad 
                    WHERE
                        a.delLog = 'N' AND a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . "
                    ORDER BY
                        a.idDgoFuerzasPropias DESC";
        return $this->consultarAll($sql);
    }
    public function getTotalFuerzasP($idDgoInfOrdenServicio)
    {
        $sql = "SELECT  CONCAT('TOTAL') as cero,
                        SUM( a.superiores ) as uno,
                        SUM( a.subalternos ) as dos,
                        SUM( a.clases ) as tres
                    FROM
                        dgoFuerzasPropias a
                    WHERE
                        a.delLog = 'N' 
                        AND a.idDgoInfOrdenServicio =" . $idDgoInfOrdenServicio;
        return $this->consultarAll($sql);
    }
    public function getTotalFuerzasA($idDgoInfOrdenServicio)
    {
        $sql = "SELECT  CONCAT('TOTAL') as cero,
                        SUM( a.numericoJefes ) as uno,
                        SUM( a.numericoSubalternos ) as dos
                    FROM
                    dgoFuerzasAlternativas a
                    WHERE
                        a.delLog = 'N' 
                        AND a.idDgoInfOrdenServicio =" . $idDgoInfOrdenServicio;
        return $this->consultarAll($sql);
    }
    public function verificaFuerzasAgregadas($idDgoInfOrdenServicio)
    {
        $sql = "SELECT  a.numericoJefes as uno,
                        a.numericoSubalternos as dos,
                        a.idDgoTipoFuerzasAlternativas,
                        du.descripcion as cero                           
                        FROM
                            dgoFuerzasAlternativas a
                            INNER JOIN dgoTipoFuerzasAlternativas du ON du.idDgoTipoFuerzasAlternativas= a.idDgoTipoFuerzasAlternativas 
                        WHERE
                            a.delLog = 'N' AND a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . "
                        ORDER BY
                            a.idDgoFuerzasAlternativas DESC";
        return $this->consultarAll($sql);
    }
    public function verificaMediosLogísticos($idDgoInfOrdenServicio)
    {
        $sql = "SELECT      a.idDgoMediosLogisticos,
                            a.idDgoInfOrdenServicio,
                            a.cantidad as uno,
                            a.idDgoMediosLogisticosInf,
                            du.descripcion   as cero                        
                        FROM
                        dgoMediosLogisticosInf a
                            INNER JOIN dgoMediosLogisticos du ON du.idDgoMediosLogisticos= a.idDgoMediosLogisticos 
                        WHERE
                            a.delLog = 'N' AND a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio;
        return $this->consultarAll($sql);
    }
    public function consultaOrdinalInforme($idDgoInfOrdenServicio)
    {
        $sql = "SELECT * 
        FROM dgoOrdinalesInforme a
        where a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . "  AND delLog = 'N'";
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

    public function getDatosUnidades($idDgoInfOrdenServicio)
    {
        $sql = "SELECT
        a.idDgpUnidad,
        b.nombreComun as unidad
    FROM
        dgoTalentoHumano a
        INNER JOIN v_personal_pn b ON b.idGenPersona = a.idGenPersona
        WHERE a.delLog='N' AND a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . " GROUP BY	a.idDgpUnidad";
        return $this->consultarAll($sql);
    }
    public function getDatosTalentoHumanoOrden($idDgoInfOrdenServicio)
    {
        $sql = "SELECT
        a.idDgoTalentoHumano,
        a.idDgoInfOrdenServicio,
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
        WHERE a.delLog='N' AND a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . " Order by a.idDgpUnidad,a.idDgpGrado";
        return $this->consultarAll($sql);
    }
    public function getDatosTalentoHumanoNumerico($idDgoInfOrdenServicio, $idDgpUnidad)
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
        WHERE a.delLog='N' AND a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . " AND a.idDgpUnidad=" . $idDgpUnidad;
        return $this->consultarAll($sql);
    }




    public function getDatosTalentoHumanoPorUnidad($idDgoInfOrdenServicio)
    {

        $ord = array();
        $thr = $this->getDatosUnidades($idDgoInfOrdenServicio);

        foreach ($thr as $fila) {
            $v = $this->getDatosTalentoHumanoNumerico($idDgoInfOrdenServicio, $fila['idDgpUnidad']);
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


    public function getTotalTalentoHumano($idDgoInfOrdenServicio)
    {

        $ord = array();
        $thr = $this->getDatosTalentoHumanoOrden($idDgoInfOrdenServicio);
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
    public function getDatosListaTalentoHumanoOrden($idDgoInfOrdenServicio)
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
        WHERE a.delLog='N' AND a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . " Order by a.idDgpUnidad,a.idDgpGrado";
        return $this->consultarAll($sql);
    }

    public function consultaLetra($letra)
    {
        switch ($letra) {
            case '1':
                $indice = "a. ";
                break;
            case '2':
                $indice = "b. ";
                break;
            case '3':
                $indice = "c. ";
                break;
            case '4':
                $indice = "d. ";
                break;
            case '5':
                $indice = "e. ";
                break;
            case '6':
                $indice = "f. ";
                break;
            case '7':
                $indice = "g. ";
                break;
            case '8':
                $indice = "h. ";
                break;
            case '9':
                $indice = "i. ";
                break;
            case '10':
                $indice = "j. ";
                break;
        }
        return ($indice);
    }
}
