<?php
class RegistroAspectoAppCg extends Transaccion
{
    private $tabla   = 'cgRegistroAspecto';
    private $idTabla = 'idCgRegistroAspecto';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaRegistroAspectoAppCg()
    {
        return $this->tabla;
    }

    public function getSqlRegistroAspectoAppCg()
    {
        $sql = "SELECT
        ra.idCgAmbitoGestionAppCg,
        ra.nombreImagen,
        ra.idCgRegistroAspecto,
        ra.idDgpGrado,
        ra.idCgTipoAspectoSancion,
        ra.idDgpGradoSanciona,
        ra.observacion,
        ra.idGenPersona,
        cg.idGenUsuario,
        CONCAT( a.siglas, '. ', a.apenom ) AS nombrePersonaJefe,
        a.documento AS cedulaPersonaJefe,
        a.idGenPersona AS idGenPersonaJefe,
        CONCAT( pn.siglas, '. ', pn.apenom ) AS nombrePersona,
        pn.documento AS cedulaPersona,
        a.documento,
        ta2.idCgTipoAspecto  AS idCgTipoAspecto2,
        ta1.idCgTipoAspecto AS idCgTipoAspecto1,
        ta.idCgTipoAspecto,
        ta2.descripcion AS tipo,
        ta1.descripcion AS detalle,
        ta.descripcion AS aspecto,
        tra.descripcion AS motivo 
    FROM
        cgRegistroAspecto ra
        INNER JOIN cgAmbitoGestionAppCg cg ON cg.idCgAmbitoGestionAppCg = ra.idCgAmbitoGestionAppCg
        INNER JOIN genUsuario b ON b.idGenUsuario = cg.idGenUsuario
        INNER JOIN v_personal_pn a ON b.idGenPersona = a.idGenPersona
        INNER JOIN v_personal_pn pn ON pn.idGenPersona = ra.idGenPersona
        INNER JOIN cgTipoAspecto ta ON ta.idCgTipoAspecto = ra.idCgTipoAspecto
        INNER JOIN cgTipoAspecto ta1 ON ta1.idCgTipoAspecto = ta.cg_idCgTipoAspecto
        INNER JOIN cgTipoAspecto ta2 ON ta2.idCgTipoAspecto = ta1.cg_idCgTipoAspecto
        INNER JOIN cgTipoAspecto tra ON tra.idCgTipoAspecto = ra.idCgTipoAspectoSancion
        WHERE
        ra.delLog='N'
        ORDER BY idCgRegistroAspecto DESC";
        return $sql;
    }



    public function getVerificaUsuarioAppCg($idGenUsuario)
    {
        $sql = "SELECT
        cg.idGenUsuario,
        CONCAT( a.siglas, '. ', a.apenom ) AS nombrePersonaJefe,
        a.documento AS cedulaPersonaJefe,
        a.siglas,
        a.idGenPersona AS idGenPersonaJefe,
        a.documento,
        cg.idCgAmbitoGestionAppCg
    FROM
        cgAmbitoGestionAppCg cg
        INNER JOIN genUsuario b ON b.idGenUsuario = cg.idGenUsuario
        INNER JOIN v_personal_pn a ON b.idGenPersona = a.idGenPersona
        WHERE
        b.idGenUsuario={$idGenUsuario}
        AND 
        cg.idGenEstado=1";
        return $this->consultar($sql);
    }
    public function getRegistroAspectoAppCg()
    {
        return $this->consultarAll($this->getSqlRegistroAspectoAppCg());
    }

    public function getEditRegistroAspectoAppCg($idCgRegistroAspecto)
    {
        $sql = "SELECT
        ra.idCgAmbitoGestionAppCg,
        ra.nombreImagen,
        ra.idCgRegistroAspecto,
        ra.idDgpGrado,
        ra.idCgTipoAspectoSancion,
        ra.idDgpGradoSanciona,
        ra.observacion,
        ra.idGenPersona,
        cg.idGenUsuario,
        CONCAT( a.siglas, '. ', a.apenom ) AS nombrePersonaJefe,
        a.documento AS cedulaPersonaJefe,
        a.idGenPersona AS idGenPersonaJefe,
        CONCAT( pn.siglas, '. ', pn.apenom ) AS nombrePersona,
        pn.documento AS cedulaPersona,
        a.documento,
        ta2.idCgTipoAspecto  AS idCgTipoAspecto2,
        ta1.idCgTipoAspecto AS idCgTipoAspecto1,
        ta.idCgTipoAspecto,
        ta2.descripcion AS tipo,
        ta1.descripcion AS detalle,
        ta.descripcion AS aspecto,
        tra.descripcion AS motivo 
    FROM
        cgRegistroAspecto ra
        INNER JOIN cgAmbitoGestionAppCg cg ON cg.idCgAmbitoGestionAppCg = ra.idCgAmbitoGestionAppCg
        INNER JOIN genUsuario b ON b.idGenUsuario = cg.idGenUsuario
        INNER JOIN v_personal_pn a ON b.idGenPersona = a.idGenPersona
        INNER JOIN v_personal_pn pn ON pn.idGenPersona = ra.idGenPersona
        INNER JOIN cgTipoAspecto ta ON ta.idCgTipoAspecto = ra.idCgTipoAspecto
        INNER JOIN cgTipoAspecto ta1 ON ta1.idCgTipoAspecto = ta.cg_idCgTipoAspecto
        INNER JOIN cgTipoAspecto ta2 ON ta2.idCgTipoAspecto = ta1.cg_idCgTipoAspecto
        INNER JOIN cgTipoAspecto tra ON tra.idCgTipoAspecto = ra.idCgTipoAspectoSancion 
    WHERE
        ra.idCgRegistroAspecto ={$idCgRegistroAspecto}";
        return $this->consultar($sql);
    }

    public function registrarRegistroAspectoAppCg($datos, $file)
    {
        $FormRegistroAspectoAppCg = new FormRegistroAspectoAppCg;
        $tabla      = 'cgRegistroAspecto';
        $tStructure = array(
            'idCgAmbitoGestionAppCg' => 'idCgAmbitoGestionAppCg',
            'idCgTipoAspecto' => 'idCgTipoAspecto',
            'idCgTipoAspectoSancion'      => 'idCgTipoAspectoSancion',
            'idGenPersona' => 'idGenPersona',
            'idDgpGrado' => 'idDgpGrado',
            'idDgpGradoSanciona'      => 'idDgpGradoSanciona',
            'nombreImagen' => 'nombreImagen',
            'observacion' => 'observacion',
            'fechaRegistro' => 'fechaRegistro',
            'delLog'      => 'delLog',
        );
        $datos['delLog'] = 'N';
        $descripcion     = '';

        if (empty($datos['idCgRegistroAspecto'])) {
            $respuesta = $this->insertArchivo($tabla, $tStructure, $datos, $FormRegistroAspectoAppCg->getCamposRegistroAspectoAppCg(), $file, $descripcion);
        } else {
            $conDupli  = " and idCgRegistroAspecto != {$datos['idCgRegistroAspecto']}";
            $respuesta = $this->updateArchivo($tabla, $tStructure, $datos, $FormRegistroAspectoAppCg->getCamposRegistroAspectoAppCg(), $file, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarRegistroAspectoAppCg($idCgRegistroAspecto)
    {
        if (!empty($idCgRegistroAspecto)) {
            $respuesta = $this->delete($this->tabla, $idCgRegistroAspecto);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlRegistroAspectoAppCgPdf()
    {
        $sql = "SELECT a.idCgRegistroAspecto cero,a.descripcion uno,a.idGenEstado,ge.descripcion dos
                FROM cgRegistroAspecto a
                INNER JOIN genEstado ge on ge.idGenEstado=a.idGenEstado
                WHERE a.delLog='N'";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlRegistroAspectoAppCgPdf());
    }
    public function getDatosPersonaSIIPNE($cedula)
    {
        $sql = "SELECT gp.idGenPersona
        FROM genPersona gp
        INNER JOIN genDocumento gd ON gd.idGenPersona=gp.idGenPersona
        WHERE gd.documento='{$cedula}'";
        return $this->consultar($sql);
    }

    public function getDatosServidorPolicial($idGenPersona)
    {
        $sql = "SELECT
        a.idGenPersona,
        CONCAT( a.siglas, '. ', a.apenom ) as apenom,
        gp.fechaNacimiento,
        a.documento,
        a.siglas,
        a.grado,
        a.situacionPolicial,
    IF( gp.sexo = 'H', 'HOMBRE', 'MUJER' ) sexo,
        ge.descEstaCivil civil,
        TIMESTAMPDIFF(YEAR,	gp.fechaNacimiento,	NOW()) anios,
    IF( gt.descEtnia IS NULL, 'DESCONOCIDA', gt.descEtnia ) AS etnia,
    IF( fi.conyugue IS NULL, 'DESCONOCIDO', fi.conyugue ) AS conyugue,
        a.idDgpGrado,
        a.idDgpUnidad,
        u2.descripcion as unidad,
        a.funcion,
        cg.idCgAmbitoGestionAppCg
    FROM
        v_personal_pn a
        INNER JOIN genPersona gp ON gp.idGenPersona = a.idGenPersona
        LEFT JOIN genEstaCivil ge ON ge.idGenEstaCivil = gp.idGenEstaCivil
        LEFT JOIN genEtnia gt ON gt.idGenEtnia = gp.idGenEtnia
        LEFT JOIN genFichaIndi fi ON fi.idGenPersona = gp.idGenPersona
        INNER JOIN dgpUnidad u ON u.idDgpUnidad = a.idDgpUnidad
        INNER JOIN dgpUnidad u1 ON u1.idDgpUnidad = u.dgp_idDgpUnidad
        INNER JOIN dgpUnidad u2 ON u2.idDgpUnidad = u1.dgp_idDgpUnidad
        LEFT JOIN cgAmbitoGestionAppCg cg ON cg.idGenUsuario = a.idGenUsuario
    WHERE
    gp.idGenPersona =" . $idGenPersona;
        return $this->consultar($sql);
    }

    public function getDatosPersona($cedula)
    {
        $sql = "SELECT gp.idGenPersona,gp.apenom,ge.descEstaCivil,gd.documento,gp.fechaNacimiento,IF(gp.sexo='H','HOMBRE','MUJER') sexo,
        IF(gt.descEtnia IS NULL, 'DESCONOCIDA', gt.descEtnia ) etnia,
        IF (fi.conyugue IS NULL , 'DESCONOCIDO', fi.conyugue ) conyugue,
        TIMESTAMPDIFF(YEAR,gp.fechaNacimiento,NOW()) anios
        FROM genPersona gp
        INNER JOIN genDocumento gd ON gd.idGenPersona=gp.idGenPersona
        LEFT JOIN genEstaCivil ge ON ge.`idGenEstaCivil`=gp.`idGenEstaCivil`
        LEFT JOIN genEtnia gt on gt.idGenEtnia=gp.idGenEtnia
        LEFT JOIN genFichaIndi fi ON fi.idGenPersona = gp.idGenPersona 
        WHERE gd.documento='$cedula'";
        return $this->consultar($sql);
    }
    public function getDatos($idGenPersona, $cedula)
    {
        $codeResponse = 0;
        $mensaje = 'No Existe';
        $data = null;
        //if row consulta idGenPersona
        if ($idGenPersona > 0) {
            $data = $this->getDatosServidorPolicial($idGenPersona);
            //DATOS SI ES SERVIDOR POLICIAL
            if ($data != null) {
                $mensaje  = 'SERVIDOR POLICIAL';
                $codeResponse = 1;
            } else {
                // como no es servidor policial se consulta los datos de la persona civil
                $data = $this->getDatosPersona($cedula);
                if ($data != null) {
                    //se optiene datos de la persona civil
                    $mensaje  = 'PERSONA CIVIL';
                    $codeResponse = 1;
                }
                //if datos persona null
            }
            //if datos servidor policial null    

        }
        //if idGenPersona>0
        $respuesta = array('msj' => $mensaje, 'codeResponse' => $codeResponse, 'datos' => $data);

        return  $respuesta;
    }
    public function getTipoAspecto($idCgTipoAspecto)
    {
        $sql = "SELECT
        a.idCgTipoAspecto,
        a.descripcion 
    FROM
        cgTipoAspecto a 
    WHERE
        
         a.delLog = 'N' 
        AND a.idGenEstado = 1 
        AND a.cg_idCgTipoAspecto ='{$idCgTipoAspecto}'";
        return $this->consultarAll($sql);
    }
    public function getDatosReporte($fechaInicio, $fechaFin)
    {
        $sql = "SELECT
        ra.idCgRegistroAspecto,
        CONCAT( a.siglas, '. ', a.apenom ) AS nombrePersonaJefe,
        a.unidad,
        a.funcion,
        CONCAT( pn.siglas, '. ', pn.apenom ) AS nombrePersona,
        pn.documento AS cedulaPersona,
        pn.unidad as unidadPer,
        pn.funcion as funcionPer,
        ta2.descripcion AS tipo,
        ta1.descripcion AS detalle,
        ta.descripcion AS aspecto,
        tra.descripcion AS motivo 
    FROM
        cgRegistroAspecto ra
        INNER JOIN cgAmbitoGestionAppCg cg ON cg.idCgAmbitoGestionAppCg = ra.idCgAmbitoGestionAppCg
        INNER JOIN genUsuario b ON b.idGenUsuario = cg.idGenUsuario
        INNER JOIN v_personal_pn a ON b.idGenPersona = a.idGenPersona
        INNER JOIN v_personal_pn pn ON pn.idGenPersona = ra.idGenPersona
        INNER JOIN cgTipoAspecto ta ON ta.idCgTipoAspecto = ra.idCgTipoAspecto
        INNER JOIN cgTipoAspecto ta1 ON ta1.idCgTipoAspecto = ta.cg_idCgTipoAspecto
        INNER JOIN cgTipoAspecto ta2 ON ta2.idCgTipoAspecto = ta1.cg_idCgTipoAspecto
        INNER JOIN cgTipoAspecto tra ON tra.idCgTipoAspecto = ra.idCgTipoAspectoSancion
        WHERE
            DATE(ra.fechaRegistro)>='" . $fechaInicio . "' AND DATE(ra.fechaRegistro)<='" . $fechaFin . "' ";
        return $this->consultarAll($sql);
    }
}
