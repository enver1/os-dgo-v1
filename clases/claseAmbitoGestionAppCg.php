<?php
class AmbitoGestionAppCg extends Transaccion
{
    private $tabla   = 'cgAmbitoGestionAppCg';
    private $idTabla = 'idCgAmbitoGestionAppCg';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaAmbitoGestionAppCg()
    {
        return $this->tabla;
    }
    public function getSqlAmbitoGestionAppCg()
    {
        $sql = "SELECT
                        cg.idCgAmbitoGestionAppCg,
                        cg.idGenUsuario,
                        a.apenom,
                        CONCAT( a.siglas, '. ', a.apenom ) AS apenom,
                        a.descGrado,
                        a.documento,
                        u2.descripcion AS direccion,
                        a.unidad,
                        es.descripcion as estado
                    FROM
                        cgAmbitoGestionAppCg cg
                        INNER JOIN genUsuario b ON b.idGenUsuario = cg.idGenUsuario
                        INNER JOIN v_personal_simple a ON b.idGenPersona = a.idGenPersona
                        INNER JOIN dgpUnidad u ON u.idDgpUnidad = a.idDgpUnidad
                        INNER JOIN dgpUnidad u1 ON u1.idDgpUnidad = u.dgp_idDgpUnidad
                        INNER JOIN dgpUnidad u2 ON u2.idDgpUnidad = u1.dgp_idDgpUnidad
                        INNER JOIN genEstado es ON es.idGenEstado=cg.idGenEstado 
                    WHERE
                        cg.idGenEstado = 1 
                        AND cg.delLog = 'N'";
        return $sql;
    }
    public function getAmbitoGestionAppCg()
    {
        return $this->consultarAll($this->getSqlAmbitoGestionAppCg());
    }

    public function getEditAmbitoGestionAppCg($idcgAmbitoGestionAppCg)
    {
        $sql = "SELECT
        cg.idCgAmbitoGestionAppCg,
        cg.idGenUsuario,
        a.apenom,
        CONCAT( a.siglas, '. ', a.apenom ) AS apenom,
        a.descGrado,
        a.documento,
        u2.descripcion AS direccion,
        a.unidad,
        es.descripcion as estado,
        es.idGenEstado
    FROM
        cgAmbitoGestionAppCg cg
        INNER JOIN genUsuario b ON b.idGenUsuario = cg.idGenUsuario
        INNER JOIN v_personal_simple a ON b.idGenPersona = a.idGenPersona
        INNER JOIN dgpUnidad u ON u.idDgpUnidad = a.idDgpUnidad
        INNER JOIN dgpUnidad u1 ON u1.idDgpUnidad = u.dgp_idDgpUnidad
        INNER JOIN dgpUnidad u2 ON u2.idDgpUnidad = u1.dgp_idDgpUnidad 
        INNER JOIN genEstado es ON es.idGenEstado=cg.idGenEstado 
    WHERE
        cg.idGenEstado = 1 
        AND cg.delLog = 'N'
        AND a.idcgAmbitoGestionAppCg={$idcgAmbitoGestionAppCg}";
        return $this->consultar($sql);
    }

    public function registrarAmbitoGestionAppCg($datos)
    {
        $tabla      = 'cgAmbitoGestionAppCg';
        $tStructure = array(
            'idGenEstado'       => 'idGenEstado',
            'idGenUsuario'      => 'idGenUsuario',
            'tipoPermiso'       => 'tipoPermiso',
            'delLog'            => 'delLog',
        );
        $datos['delLog'] = 'N';
        $datos['idGenUsuario'] =  $datos['usuario'];
        $descripcion     = 'idGenUsuario,delLog';

        if (empty($datos['idCgAmbitoGestionAppCg'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idCgAmbitoGestionAppCg != " . $datos['idCgAmbitoGestionAppCg'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarAmbitoGestionAppCg($idcgAmbitoGestionAppCg)
    {
        if (!empty($idcgAmbitoGestionAppCg)) {
            $respuesta = $this->delete($this->tabla, $idcgAmbitoGestionAppCg);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlAmbitoGestionAppCgPdf()
    {
        $sql = "SELECT
        cg.idCgAmbitoGestionAppCg,
        cg.idGenUsuario,
        a.apenom,
        CONCAT( a.siglas, '. ', a.apenom ) AS apenom,
        a.descGrado,
        a.documento,
        u2.descripcion AS direccion,
        a.unidad,
        es.descripcion,
        cg.idGenEstado
    FROM
        cgAmbitoGestionAppCg cg
        INNER JOIN genUsuario b ON b.idGenUsuario = cg.idGenUsuario
        INNER JOIN v_personal_simple a ON b.idGenPersona = a.idGenPersona
        INNER JOIN dgpUnidad u ON u.idDgpUnidad = a.idDgpUnidad
        INNER JOIN dgpUnidad u1 ON u1.idDgpUnidad = u.dgp_idDgpUnidad
        INNER JOIN dgpUnidad u2 ON u2.idDgpUnidad = u1.dgp_idDgpUnidad 
        INNER JOIN genEstado es ON es.idGenEstado=cg.idGenEstado 
    WHERE
        cg.idGenEstado = 1 
        AND cg.delLog = 'N'";
        return $sql;
    }
    public function getDatosImprimirAmbitoGestionAppCgPdf()
    {
        return $this->consultarAll($this->getSqlAmbitoGestionAppCgPdf());
    }
}
