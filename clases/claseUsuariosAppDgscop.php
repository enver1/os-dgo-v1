<?php
class UsuariosAppDgscop extends Transaccion
{
    private $tabla   = 'dnaUsuarioUnidadApp';
    private $idTabla = 'idDnaUsuarioUnidadApp';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaUsuariosAppDgscop()
    {
        return $this->tabla;
    }
    public function getSqlUsuariosAppDgscop($filtro)
    {
        $sql = "SELECT  a.idDnaUsuarioUnidadApp,
                        a.idDnaUnidadApp,
                        a.idGenEstado,
                        a.idGenUsuario,
                        a.idDnaPerfilVer,
                        b.descripcionUnidad as modulo,
                        c.descripcion as permiso,
                        CONCAT(e.siglas,'. ',e.apenom) as policia,
                        ge.descripcion as estado
                    FROM
                        dnaUsuarioUnidadApp a
                        INNER JOIN genEstado ge ON ge.idGenEstado = a.idGenEstado
                        INNER JOIN dnaUnidadApp b ON b.idDnaUnidadApp=a.idDnaUnidadApp
                        INNER JOIN dnaPerfilVer c ON c.idDnaPerfilVer=a.idDnaPerfilVer
                        INNER JOIN genUsuario d ON d.idGenUsuario=a.idGenUsuario
                        INNER JOIN v_personal_simple e ON e.idGenPersona=d.idGenPersona
                    WHERE
                        a.delLog = 'N'
                        AND a.filtro='{$filtro}' 
                    ORDER BY
                        a.idDnaUsuarioUnidadApp DESC";
        return $sql;
    }
    public function getUsuariosAppDgscop($filtro)
    {
        return $this->consultarAll($this->getSqlUsuariosAppDgscop($filtro));
    }

    public function getEditUsuariosAppDgscop($idDnaUsuarioUnidadApp)
    {
        $sql = "SELECT  a.idDnaUsuarioUnidadApp,
                        a.idDnaUnidadApp,
                        a.idGenEstado,
                        a.idGenUsuario,
                        a.idDnaPerfilVer,
                        e.documento as cedulaPersonaC,
                        b.descripcionUnidad as modulo,
                        c.descripcion as permiso,
                        CONCAT(e.siglas,'. ',e.apenom) as nombrePersonaC,
                        ge.descripcion as estado
                    FROM
                        dnaUsuarioUnidadApp a
                        INNER JOIN genEstado ge ON ge.idGenEstado = a.idGenEstado
                        INNER JOIN dnaUnidadApp b ON b.idDnaUnidadApp=a.idDnaUnidadApp
                        INNER JOIN dnaPerfilVer c ON c.idDnaPerfilVer=a.idDnaPerfilVer
                        INNER JOIN genUsuario d ON d.idGenUsuario=a.idGenUsuario
                        INNER JOIN v_personal_simple e ON e.idGenPersona=d.idGenPersona
                    WHERE a.idDnaUsuarioUnidadApp={$idDnaUsuarioUnidadApp}";
        return $this->consultar($sql);
    }

    public function registrarUsuariosAppDgscop($datos)
    {

        $tabla = 'dnaUsuarioUnidadApp';

        $tStructure = array(
            'idDnaUnidadApp'  => 'idDnaUnidadApp',
            'idGenUsuario'    => 'idGenUsuario',
            'idDnaPerfilVer'  => 'idDnaPerfilVer',
            'idGenEstado'     => 'idGenEstado',
            'delLog'          => 'delLog',
            'filtro'          => 'filtro',
        );
        $datos['delLog']       = 'N';
        $datos['filtro']       = 'APP_DGSCOP';
        $descripcion           = 'idGenUsuario,idDnaUnidadApp,delLog,filtro';
        if (empty($datos['idDnaUsuarioUnidadApp'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDnaUsuarioUnidadApp != " . $datos['idDnaUsuarioUnidadApp'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }

    public function eliminarUsuariosAppDgscop($idDnaUsuarioUnidadApp)
    {
        if (!empty($idDnaUsuarioUnidadApp)) {
            $respuesta = $this->delete($this->tabla, $idDnaUsuarioUnidadApp);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlUsuariosAppPdfDgscop($filtro)
    {
        $sql = "SELECT  a.idDnaUsuarioUnidadApp as cero,
                        a.idDnaUnidadApp,
                        a.idGenEstado,
                        a.idGenUsuario,
                        a.idDnaPerfilVer,
                        b.descripcionUnidad as dos,
                        c.descripcion as tres,
                        CONCAT(e.siglas,'. ',e.apenom) as uno,
                        ge.descripcion as cuatro
                    FROM
                        dnaUsuarioUnidadApp a
                        INNER JOIN genEstado ge ON ge.idGenEstado = a.idGenEstado
                        INNER JOIN dnaUnidadApp b ON b.idDnaUnidadApp=a.idDnaUnidadApp
                        INNER JOIN dnaPerfilVer c ON c.idDnaPerfilVer=a.idDnaPerfilVer
                        INNER JOIN genUsuario d ON d.idGenUsuario=a.idGenUsuario
                        INNER JOIN v_personal_simple e ON e.idGenPersona=d.idGenPersona
                    WHERE
                        a.delLog = 'N'
                        AND a.filtro='{$filtro}' 
                    ORDER BY
                        a.idDnaUsuarioUnidadApp DESC";
        return $sql;
    }
    public function getDatosImprimirUsuariosAppPdfDgscop($filtro)
    {
        return $this->consultarAll($this->getSqlUsuariosAppPdfDgscop($filtro));
    }
}
