<?php
class AsignaPersonalElec extends Transaccion
{
    private $tabla   = 'dgoPerAsigOpe';
    private $idTabla = 'idDgoPerAsigOpe';
    public function getIdCampoAsignaPersonalElec()
    {
        return $this->idTabla;
    }
    public function getTablaAsignaPersonalElec()
    {
        return $this->tabla;
    }
    public function getSqlAsignaPersonalElec($idDgoCreaOpRec)
    {

        $sql = "SELECT
                    pa.idDgoPerAsigOpe,
                    rt.nomRecintoElec,
                    pa.idGenEstado,
                    pa.idGenGeoSenplades,
                    rtt.nomRecintoElec as unidad,
                    gs.descripcion AS estado,
                IF  ( ISNULL( vs.siglas ), a.apenom, CONCAT( vs.siglas, '. ', vs.apenom ) ) as personal,
                     pa.idGenGeoSenplades,
                     gss.descripcion as senpladesDescripcion
                FROM
                    dgoPerAsigOpe pa
                    LEFT JOIN genPersona a ON a.idGenPersona = pa.idGenPersona
                    LEFT JOIN v_personal_simple vs ON vs.idGenPersona=pa.idGenPersona
                    LEFT JOIN dgoCreaOpReci co ON co.idDgoCreaOpReci = pa.idDgoCreaOpReci
                    INNER JOIN dgoComisios c ON c.idDgoComisios=co.idDgoComisios
                    INNER JOIN dgoReciElect rt ON rt.idDgoReciElect=c.idDgoReciElect
                    INNER JOIN dgoProcElec p ON p.idDgoProcElec=c.idDgoProcElec
                    LEFT JOIN dgoReciElect rtt ON rtt.idDgoReciElect = pa.idDgoReciElect
                    LEFT JOIN genEstado gs ON gs.idGenEstado = pa.idGenEstado
                    LEFT JOIN genGeoSenplades gss ON gss.idGenGeoSenplades = pa.idGenGeoSenplades 
                WHERE
                pa.cargo='I'
                AND
                pa.delLog='N'
                AND
                pa.idDgoCreaOpReci ={$idDgoCreaOpRec}";
        return $sql;
    }
    public function getAsignaPersonalElec($idDgoCreaOpRec)
    {
        return $this->consultarAll($this->getSqlAsignaPersonalElec($idDgoCreaOpRec));
    }

    public function getEditAsignaPersonalElec($idDgoPerAsigOpe)
    {
        $sql = "SELECT
                    pa.idDgoPerAsigOpe,
                    rt.nomRecintoElec,
                    pa.idGenEstado,
                    pa.idGenPersona,
                    pa.idDgoReciElect,
                    pa.idGenGeoSenplades,
                    pa.latitud,
                    pa.longitud,
                    pa.idGenGeoSenplades,
                    gs.descripcion AS estado,
                    IF  ( ISNULL( vs.siglas ), a.apenom, CONCAT( vs.siglas, '. ', vs.apenom ) ) nombrePersonaC,
                    dt.documento as cedulaPersonaC,
                     pa.idGenGeoSenplades,
                     gss.descripcion as senpladesDescripcion

                FROM
                    dgoPerAsigOpe pa
                    LEFT JOIN genPersona a ON a.idGenPersona = pa.idGenPersona
                    LEFT JOIN v_personal_simple vs ON vs.idGenPersona=pa.idGenPersona
                    LEFT JOIN dgoCreaOpReci co ON co.idDgoCreaOpReci = pa.idDgoCreaOpReci
                    INNER JOIN dgoComisios c ON c.idDgoComisios=co.idDgoComisios
                    INNER JOIN dgoReciElect rt ON rt.idDgoReciElect=c.idDgoReciElect
                    INNER JOIN dgoProcElec p ON p.idDgoProcElec=c.idDgoProcElec
                    LEFT JOIN dgoReciElect rtt ON rtt.idDgoReciElect = pa.idDgoReciElect
                    LEFT JOIN genEstado gs ON gs.idGenEstado = pa.idGenEstado
                    LEFT JOIN genDocumento dt on dt.idGenPersona=a.idGenPersona
                    LEFT JOIN genGeoSenplades gss ON gss.idGenGeoSenplades = pa.idGenGeoSenplades 
                WHERE
                     pa.idDgoPerAsigOpe ='{$idDgoPerAsigOpe}'";
        return $this->consultar($sql);
    }

    public function registrarAsignaPersonalElec($datos)
    {
        $conn               = DB::getConexionDB();
        $CrearOperativoReci = new CrearOperativoReci;
        $tabla              = 'dgoPerAsigOpe';
        $tStructure         = array(
            'idDgoReciElect'  => 'idDgoReciElect',
            'idDgoCreaOpReci' => 'idDgoCreaOpReci',
            'idGenPersona'    => 'idGenPersona',
            'idGenEstado'     => 'idGenEstado',
            'latitud'         => 'latitud',
            'idDgoTipoEje'    => 'idDgoTipoEje',
            'longitud'        => 'longitud',
            'idGenGeoSenplades'        => 'idGenGeoSenplades',
            'cargo'           => 'cargo',
            'delLog'          => 'delLog',
        );

        $datos['delLog'] = 'N';
        $datos['cargo']  = 'I';
        $descripcion     = 'idDgoCreaOpReci,idGenPersona,delLog';
        $dt              = new DateTime('now', new DateTimeZone('America/Guayaquil'));
        $hoy             = $dt->format('Y-m-d H:i:s');

        // $CrearOperativoReci = new CrearOperativoReci;
        // $rowD =        $CrearOperativoReci->getCircuitoGeoespacial($datos['latitud'], $datos['longitud']);
        // $datos['idGenGeoSenplades'] =  $rowD;
        if (empty($datos['idDgoPerAsigOpe'])) {
            $respuesta    = $this->insert($tabla, $tStructure, $datos, $descripcion);
            $respuestaNov = $CrearOperativoReci->registraPrimeraNovedad($respuesta[2], 'REGISTRO DE PERSONAL (INTEGRANTES)', '1', $datos['latitud'], $datos['longitud']);
        } else {
            $res       = $this->updateNovedad($datos['idDgoPerAsigOpe'], $conn, $datos['idGenEstado'], $hoy);
            $conDupli  = " and idDgoPerAsigOpe != " . $datos['idDgoPerAsigOpe'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }
        return $respuesta;
    }

    public function eliminarAsignaPersonalElec($idDgoPerAsigOpe)
    {
        if (!empty($idDgoPerAsigOpe)) {
            $respuesta = $this->delete($this->tabla, $idDgoPerAsigOpe);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }
    public function updateNovedad($idDgoPerAsigOpe, $conn, $id, $fecha)
    {
        if ($id == 1) {
            $sql1 = "UPDATE dgoNovReciElec SET idDgoNovedadesElect=1,fecha='{$fecha}'   WHERE idDgoPerAsigOpe={$idDgoPerAsigOpe} AND delLog='N'";
            $conn->query($sql1);
        } else {
            $sql1 = "UPDATE dgoNovReciElec SET idDgoNovedadesElect=40,fecha='{$fecha}'  WHERE idDgoPerAsigOpe={$idDgoPerAsigOpe} AND delLog='N'";
            $conn->query($sql1);
        }
    }
    public function getverificaServidor($documento, $idDgoProcElec)
    {
        $sql = "SELECT
                    pa.idDgoPerAsigOpe,
                    rt.nomRecintoElec,
                    pa.idGenEstado,
                    pa.idGenPersona,
                    pa.idGenGeoSenplades,
                    gs.descripcion AS estado,
                    IF (ISNULL( vs.siglas ), a.apenom, CONCAT( vs.siglas, '. ', vs.apenom ) ) nombrePersonaC,
                    dt.documento as cedulaPersonaC,
                    p.descProcElecc
                FROM
                    dgoPerAsigOpe pa
                    LEFT JOIN genPersona a ON a.idGenPersona = pa.idGenPersona
                    LEFT JOIN v_personal_simple vs ON vs.idGenPersona=pa.idGenPersona
                    LEFT JOIN dgoCreaOpReci co ON co.idDgoCreaOpReci = pa.idDgoCreaOpReci
                    INNER JOIN dgoComisios c ON c.idDgoComisios=co.idDgoComisios
                    INNER JOIN dgoReciElect rt ON rt.idDgoReciElect=c.idDgoReciElect
                    INNER JOIN dgoProcElec p ON p.idDgoProcElec=c.idDgoProcElec
                    LEFT JOIN genEstado gs ON gs.idGenEstado = pa.idGenEstado
                    LEFT JOIN genDocumento dt on dt.idGenPersona=a.idGenPersona
                WHERE
                     dt.documento ='{$documento}'
                     AND pa.delLog='N'
                     AND co.estado='A'
                     AND co.delLog='N'
                     AND c.delLog='N'
                     AND pa.idGenEstado=1";
        return $this->consultar($sql);
    }
}
