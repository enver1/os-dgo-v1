<?php
class RecintoElectoral extends Transaccion
{
    private $tabla   = 'dgoReciElect';
    private $idTabla = 'idDgoReciElect';
    public function getIdCampoRecintoElectoral()
    {
        return $this->idTabla;
    }
    public function getTablaRecintoElectoral()
    {
        return $this->tabla;
    }
    public function getSqlRecintoElectoral()
    {
        $sql = "SELECT
                    a.idDgoReciElect,
                    a.idGenEstado,
                    b.descripcion as estado,
                    a.idGenGeoSenplades,
                    a.idGenDivPolitica,
                    a.codRecintoElec,
                    a.idDgoTipoEje,
                    a.nomRecintoElec,
                    a.direcRecintoElec,
                    a.tipoRecinto,
                    a.latitud,
                    a.longitud,
                    geo.descripcion AS subcircuito,
                    geoS.descripcion AS circuito,
                    geoD.descripcion AS Distrito,
                    geoSb.descripcion AS Subzona,
                    geoZ.descripcion AS Zona,
                    divp.descripcion AS division,
                     geo.descripcion AS senpladesDescripcion,
                    divp.descripcion AS divPoliticaDescripcion
                FROM
                    dgoReciElect a
                    LEFT JOIN genDivPolitica divp ON divp.idGenDivPolitica = a.idGenDivPolitica
                    LEFT JOIN genGeoSenplades geo ON geo.idGenGeoSenplades = a.idGenGeoSenplades
                    LEFT JOIN genGeoSenplades geoS ON geoS.idGenGeoSenplades = geo.gen_idGenGeoSenplades
                    LEFT JOIN genGeoSenplades geoD ON geoD.idGenGeoSenplades = geoS.gen_idGenGeoSenplades
                    LEFT JOIN genGeoSenplades geoSb ON geoSb.idGenGeoSenplades = geoD.gen_idGenGeoSenplades
                    LEFT JOIN genGeoSenplades geoZ ON geoZ.idGenGeoSenplades = geoSb.gen_idGenGeoSenplades
                    LEFT JOIN genEstado b ON b.idGenEstado = a.idGenEstado
                WHERE
                    a.delLog = 'N'
                ORDER BY
                    a.idDgoReciElect DESC";
        return $sql;
    }
    public function getRecintoElectoral()
    {
        return $this->consultarAll($this->getSqlRecintoElectoral());
    }

    public function getEditRecintoElectoral($idDgoReciElect)
    {
        $sql = "SELECT
                    a.idDgoReciElect,
                    a.idGenEstado,
                    b.descripcion as estado,
                    a.idGenGeoSenplades,
                    a.idGenDivPolitica,
                    a.codRecintoElec,
                    a.idDgoTipoEje,
                    IF((t1.idDgoTipoEje is null),a.idDgoTipoEje,t1.idDgoTipoEje) as idDgoTipoEje2,
                    IF((t2.idDgoTipoEje is null),a.idDgoTipoEje,t2.idDgoTipoEje) as auxiliar,
                    IF((t2.idDgoTipoEje is null), IF((t1.idDgoTipoEje is null),a.idDgoTipoEje,t1.idDgoTipoEje),t2.idDgoTipoEje) as idDgoTipoEje1,
                    a.nomRecintoElec,
                    a.idDgoTipoEje as idDgoT1,
                    a.direcRecintoElec,
                    a.tipoRecinto,
                    a.latitud,
                    a.longitud,
                    geo.descripcion AS senpladesDescripcion,
                    divp.descripcion AS divPoliticaDescripcion
                FROM
                    dgoReciElect a
                    LEFT JOIN genDivPolitica divp ON divp.idGenDivPolitica = a.idGenDivPolitica
                    LEFT JOIN genGeoSenplades geo ON geo.idGenGeoSenplades = a.idGenGeoSenplades
                    LEFT JOIN genEstado b ON b.idGenEstado = a.idGenEstado
                    LEFT JOIN dgoTipoEje t ON t.idDgoTipoEje=a.idDgoTipoEje
                    LEFT JOIN dgoTipoEje t1 ON t1.idDgoTipoEje=t.dgo_idDgoTipoEje
                    LEFT JOIN dgoTipoEje t2 ON t2.idDgoTipoEje=t1.dgo_idDgoTipoEje
                WHERE a.idDgoReciElect={$idDgoReciElect}";
        return $this->consultar($sql);
    }

    public function registrarRecintoElectoral($datos)
    {

        $tabla = 'dgoReciElect';

        $tStructure = array(
            'idGenDivPolitica'  => 'idGenDivPolitica',
            'idGenGeoSenplades' => 'idGenGeoSenplades',
            'idGenEstado'       => 'idGenEstado',
            'codRecintoElec'    => 'codRecintoElec',
            'nomRecintoElec'    => 'nomRecintoElec',
            'idDgoTipoEje'      => 'idDgoTipoEje',
            'siglaPro'          => 'siglaPro',
            'direcRecintoElec'  => 'direcRecintoElec',
            'tipoRecinto'       => 'tipoRecinto',
            'latitud'           => 'latitud',
            'longitud'          => 'longitud',
            'delLog'            => 'delLog',

        );
        $datos['delLog'] = 'N';

        //  $datos['idDgoTipoEje']      = (!empty($datos['idDgoTipoEje'])) ? $datos['idDgoTipoEje'] :(!empty($datos['auxiliar'])) ? $datos['auxiliar'] :;
        $datos['siglaPro'] = $this->getDatosSiglasPro($datos['idGenDivPolitica']);

        if (empty($datos['idDgoTipoEje'])) {
            if ((!empty($datos['auxiliar']))) {
                $datos['idDgoTipoEje'] = $datos['auxiliar'];
            } else {
                $datos['idDgoTipoEje'] = $datos['idDgoT1'];
            }
        }

        $descripcion                = 'codRecintoElec,delLog,idGenEstado';
        $datos['idGenGeoSenplades'] = (!empty($datos['idGenGeoSenplades'])) ? $datos['idGenGeoSenplades'] : null;

        if (empty($datos['idDgoReciElect'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoReciElect != " . $datos['idDgoReciElect'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }

    public function eliminarRecintoElectoral($idDgoReciElect)
    {
        if (!empty($idDgoReciElect)) {
            $respuesta = $this->delete($this->tabla, $idDgoReciElect);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlRecintoElectoralPdf()
    {
        $sql = "SELECT
                    a.idDgoReciElect,
                    a.idGenEstado,
                    b.descripcion cinco,
                    a.idGenGeoSenplades,
                    a.idGenDivPolitica,
                    a.codRecintoElec cero,
                    a.nomRecintoElec uno,
                    a.direcRecintoElec dos,
                    a.latitud,
                    a.longitud,
                    geo.descripcion AS tres,
                    divp.descripcion AS cuatro
                FROM
                    dgoReciElect a
                    LEFT JOIN genDivPolitica divp ON divp.idGenDivPolitica = a.idGenDivPolitica
                    LEFT JOIN genGeoSenplades geo ON geo.idGenGeoSenplades = a.idGenGeoSenplades
                    LEFT JOIN genEstado b ON b.idGenEstado = a.idGenEstado
                WHERE
                    a.delLog = 'N'
                ORDER BY
                    a.idDgoReciElect DESC";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlRecintoElectoralPdf());
    }

    public function getEjes1($idDgoTipoEje)
    {
        $sql = "SELECT a.idDgoTipoEje, a.descripcion
        FROM dgoTipoEje a
        WHERE a.dgo_idDgoTipoEje={$idDgoTipoEje} AND a.idGenEstado=1 AND a.delLog='N'";
        return $this->consultarAll($sql);
    }
    public function getVerificaEje($idDgoTipoEje)
    {
        $sql = "SELECT a.idDgoTipoEje, a.descripcion
        FROM dgoTipoEje a
        WHERE a.dgo_idDgoTipoEje={$idDgoTipoEje} AND a.idGenEstado=1 AND a.delLog='N'";
        return $this->consultar($sql);
    }
    public function getDatosSiglasPro($idGenDivPolitica)
    {
        $sql = "SELECT a.idGenDivPolitica, a.descripcion
        FROM genDivPolitica a
        WHERE a.idGenDivPolitica={$idGenDivPolitica}";

        $descripcion    = $this->consultar($sql);

        $data1 = '';
        if (!empty($descripcion['descripcion'])) {
            switch ($descripcion['descripcion']) {
                case 'AZUAY':
                    $data1 = 'EC-A';
                    break;
                case 'BOLIVAR':
                    $data1 = 'EC-B';
                    break;
                case 'CAÑAR':
                    $data1 = 'EC-F';
                    break;
                case 'CARCHI':
                    $data1 = 'EC-C';
                    break;
                case 'CHIMBORAZO':
                    $data1 = 'EC-H';
                    break;
                case 'COTOPAXI':
                    $data1 = 'EC-X';
                    break;
                case 'EL ORO':
                    $data1 = 'EC-O';
                    break;
                case 'ESMERALDAS':
                    $data1 = 'EC-E';
                    break;
                case 'GALAPAGOS':
                    $data1 = 'EC-W';
                    break;
                case 'GUAYAS':
                    $data1 = 'EC-G';
                    break;
                case 'IMBABURA':
                    $data1 = 'EC-I';
                    break;
                case 'LOJA':
                    $data1 = 'EC-L';
                    break;
                case 'LOS RIOS':
                    $data1 = 'EC-R';
                    break;
                case 'MAMABI':
                    $data1 = 'EC-M';
                    break;
                case 'MORONA SANTIAGO':
                    $data1 = 'EC-S';
                    break;
                case 'NAPO':
                    $data1 = 'EC-N';
                    break;

                case 'ORELLANA':
                    $data1 = 'EC-D';
                    break;
                case 'PASTAZA':
                    $data1 = 'EC-Y';
                    break;
                case 'PICHINCHA':
                    $data1 = 'EC-P';
                    break;
                case 'SANTA ELENA':
                    $data1 = 'EC-SE';
                    break;
                case 'SUCUMBIOS':
                    $data1 = 'EC-U';
                    break;
                case 'TUNGURAHUA':
                    $data1 = 'EC-T';
                    break;
                case 'ZAMORA CHIMCHIPE':
                    $data1 = 'EC-Z';
                    break;
                case 'SANTO DOMINGO':
                    $data1 = 'EC-SD';
                    break;

                default:
                    $data1 = "EC-P";
            }
        }

        return $data1;
    }
}
