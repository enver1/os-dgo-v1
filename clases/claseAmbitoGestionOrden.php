<?php
class AmbitoGestionOrden extends Transaccion
{
    private $tabla   = 'dgoAmbitoGestionOrden';
    private $idTabla = 'idDgoAmbitoGestionOrden';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaAmbitoGestionOrden()
    {
        return $this->tabla;
    }
    public function getSqlAmbitoGestionOrden()
    {
        $sql = "SELECT      a.idDgoAmbitoGestionOrden,
                            a.idGenUsuario,
                            a.idGenEstado,
                            ge.descripcion AS estado,
                            a.idGenGeoSenplades,
                            gs2.descripcion as Zona,
                            gs1.descripcion as Subzona,
                            gs.descripcion as Distrito,
                            CONCAT(vs.siglas,'. ',vs.apenom) as apenom                            
                        FROM
                            dgoAmbitoGestionOrden a
                            INNER JOIN genEstado ge ON ge.idGenEstado = a.idGenEstado 
                            INNER JOIN genUsuario gns ON gns.idGenUsuario=a.idGenUsuario
                            INNER JOIN v_personal_simple vs ON vs.idGenPersona=gns.idGenPersona
                            INNER JOIN genGeoSenplades gs ON gs.idGenGeoSenplades=a.idGenGeoSenplades
                            INNER JOIN genGeoSenplades gs1 ON gs1.idGenGeoSenplades=gs.gen_idGenGeoSenplades
                            INNER JOIN genGeoSenplades gs2 ON gs2.idGenGeoSenplades=gs1.gen_idGenGeoSenplades
                        WHERE
                       a.delLog = 'N'";
        return $sql;
    }
    public function getAmbitoGestionOrden()
    {
        return $this->consultarAll($this->getSqlAmbitoGestionOrden());
    }

    public function getEditAmbitoGestionOrden($idDgoAmbitoGestionOrden)
    {
        $sql = "SELECT      a.idDgoAmbitoGestionOrden,
                            a.idGenUsuario,
                            a.idGenUsuario as usuario,
                            a.idGenEstado,
                            ge.descripcion AS estado,
                            a.idGenGeoSenplades,
                            gs2.descripcion as Zona,
                            gs1.descripcion as Subzona,
                            gs.descripcion as Distrito,
                            gs.descripcion as senpladesDescripcion,
                            CONCAT(vs.siglas,'. ',vs.apenom) as nombrePersona,
                            vs.idGenPersona,
                            vs.documento as cedulaPersona                            
                        FROM
                            dgoAmbitoGestionOrden a
                            INNER JOIN genEstado ge ON ge.idGenEstado = a.idGenEstado 
                            INNER JOIN genUsuario gns ON gns.idGenUsuario=a.idGenUsuario
                            INNER JOIN v_personal_simple vs ON vs.idGenPersona=gns.idGenPersona
                            INNER JOIN genGeoSenplades gs ON gs.idGenGeoSenplades=a.idGenGeoSenplades
                            INNER JOIN genGeoSenplades gs1 ON gs1.idGenGeoSenplades=gs.gen_idGenGeoSenplades
                            INNER JOIN genGeoSenplades gs2 ON gs2.idGenGeoSenplades=gs1.gen_idGenGeoSenplades
                        WHERE
                             a.idDgoAmbitoGestionOrden={$idDgoAmbitoGestionOrden}";
        return $this->consultar($sql);
    }

    public function registrarAmbitoGestionOrden($datos)
    {
        $tabla      = 'dgoAmbitoGestionOrden';
        $tStructure = array(
            'idGenEstado'       => 'idGenEstado',
            'idGenUsuario'      => 'idGenUsuario',
            'idGenGeoSenplades' => 'idGenGeoSenplades',
            'delLog'            => 'delLog',
        );
        $datos['delLog'] = 'N';
        $datos['idGenUsuario'] =  $datos['usuario'];
        $descripcion     = 'idGenUsuario,delLog';

        if (empty($datos['idDgoAmbitoGestionOrden'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoAmbitoGestionOrden != " . $datos['idDgoAmbitoGestionOrden'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarAmbitoGestionOrden($idDgoAmbitoGestionOrden)
    {
        if (!empty($idDgoAmbitoGestionOrden)) {
            $respuesta = $this->delete($this->tabla, $idDgoAmbitoGestionOrden);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlAmbitoGestionOrdenPdf()
    {
        $sql = "SELECT      a.idDgoAmbitoGestionOrden as cero,
                            a.idGenUsuario,
                            a.idGenEstado,
                            ge.descripcion AS cinco,
                            a.idGenGeoSenplades,
                            gs2.descripcion as uno,
                            gs1.descripcion as dos,
                            gs.descripcion as tres,
                            CONCAT(vs.siglas,'. ',vs.apenom) as cuatro                            
                        FROM
                            dgoAmbitoGestionOrden a
                            INNER JOIN genEstado ge ON ge.idGenEstado = a.idGenEstado 
                            INNER JOIN genUsuario gns ON gns.idGenUsuario=a.idGenUsuario
                            INNER JOIN v_personal_simple vs ON vs.idGenPersona=gns.idGenPersona
                            INNER JOIN genGeoSenplades gs ON gs.idGenGeoSenplades=a.idGenGeoSenplades
                            INNER JOIN genGeoSenplades gs1 ON gs1.idGenGeoSenplades=gs.gen_idGenGeoSenplades
                            INNER JOIN genGeoSenplades gs2 ON gs2.idGenGeoSenplades=gs1.gen_idGenGeoSenplades
                        WHERE
                            a.delLog = 'N'";
        return $sql;
    }
    public function getDatosImprimirAmbitoGestionOrdenPdf()
    {
        return $this->consultarAll($this->getSqlAmbitoGestionOrdenPdf());
    }

    public function getDatosUsuariosSenplades($idGenUsuario)
    {
        $sql = "SELECT      a.idDgoAmbitoGestionOrden,
                            a.idGenUsuario,
                            a.idGenEstado,
                            gns.idGenPersona,
                            ge.descripcion AS estado,
                            a.idGenGeoSenplades,
                            gs2.descripcion as Zona,
                            gs1.descripcion as Subzona,
                            gs.descripcion as Distrito,
                            gs.siglasGeoSenplades as siglasD,
                            CONCAT(vs.siglas,'. ',vs.apenom) as spElabora,
                            vs.funcion                           
                        FROM
                            dgoAmbitoGestionOrden a
                            INNER JOIN genEstado ge ON ge.idGenEstado = a.idGenEstado 
                            INNER JOIN genUsuario gns ON gns.idGenUsuario=a.idGenUsuario
                            INNER JOIN v_personal_pn vs ON vs.idGenPersona=gns.idGenPersona
                            INNER JOIN genGeoSenplades gs ON gs.idGenGeoSenplades=a.idGenGeoSenplades
                            INNER JOIN genGeoSenplades gs1 ON gs1.idGenGeoSenplades=gs.gen_idGenGeoSenplades
                            INNER JOIN genGeoSenplades gs2 ON gs2.idGenGeoSenplades=gs1.gen_idGenGeoSenplades
                        WHERE
                         a.idGenEstado=1
                            AND a.idGenUsuario=" . $idGenUsuario;
        return $this->consultar($sql);
    }
}
