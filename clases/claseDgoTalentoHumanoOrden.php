<?php
class DgoTalentoHumanoOrden extends Transaccion
{
    private $tabla   = 'dgoTalentoHumano';
    private $idTabla = 'idDgoTalentoHumano';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaDgoTalentoHumanoOrden()
    {
        return $this->tabla;
    }
    public function getSqlDgoTalentoHumanoOrden($idDgoOrdenServico)
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
        b.funcion 	
    FROM
        dgoTalentoHumano a
        INNER JOIN v_personal_pn b ON b.idGenPersona = a.idGenPersona
        INNER JOIN dgpUnidad u ON u.idDgpUnidad = a.idDgpUnidad
        INNER JOIN dgpUnidad u1 ON u1.idDgpUnidad = u.dgp_idDgpUnidad
        INNER JOIN dgpUnidad u2 ON u2.idDgpUnidad = u1.dgp_idDgpUnidad
        WHERE a.delLog='N' AND a.idDgoOrdenServicio=" . $idDgoOrdenServico;
        return $sql;
    }
    public function getDgoTalentoHumanoOrden($idDgoOrdenServico)
    {
        return $this->consultarAll($this->getSqlDgoTalentoHumanoOrden($idDgoOrdenServico));
    }

    public function getEditDgoTalentoHumanoOrden($idDgoTalentoHumano)
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
        b.funcion 	
    FROM
        dgoTalentoHumano a
        INNER JOIN v_personal_pn b ON b.idGenPersona = a.idGenPersona
        INNER JOIN dgpUnidad u ON u.idDgpUnidad = a.idDgpUnidad
        INNER JOIN dgpUnidad u1 ON u1.idDgpUnidad = u.dgp_idDgpUnidad
        INNER JOIN dgpUnidad u2 ON u2.idDgpUnidad = u1.dgp_idDgpUnidad
        WHERE a.idDgoTalentoHumano=" . $idDgoTalentoHumano;
        return $this->consultar($sql);
    }

    public function registrarDgoTalentoHumanoOrden($datos)
    {
        $tabla      = 'dgoTalentoHumano';
        $tStructure = array(
            'idDgoOrdenServicio'      => 'idDgoOrdenServicio',
            'idDgpGrado'      => 'idDgpGrado',
            'idDgpUnidad'      => 'idDgpUnidad',
            'idGenPersona'      => 'idGenPersona',
            'delLog'      => 'delLog',
        );
        $datos['delLog'] = 'N';
        $descripcion     = 'idDgoOrdenServicio,idGenPersona,delLog';

        if (empty($datos['idDgoTalentoHumano'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoTalentoHumano != " . $datos['idDgoTalentoHumano'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarDgoTalentoHumanoOrden($idDgoTalentoHumano)
    {
        if (!empty($idDgoTalentoHumano)) {
            $respuesta = $this->delete($this->tabla, $idDgoTalentoHumano);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlDgoTalentoHumanoOrdenPdf()
    {
        $sql = "SELECT a.idDgoTalentoHumano cero,a.descripcion uno,a.idGenEstado,ge.descripcion dos
                FROM dgoTalentoHumano a
                INNER JOIN genEstado ge on ge.idGenEstado=a.idGenEstado
                WHERE a.delLog='N'";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlDgoTalentoHumanoOrdenPdf());
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
        a.funcion 
    FROM
        v_personal_pn a
        INNER JOIN genPersona gp ON gp.idGenPersona = a.idGenPersona
        LEFT JOIN genEstaCivil ge ON ge.idGenEstaCivil = gp.idGenEstaCivil
        LEFT JOIN genEtnia gt ON gt.idGenEtnia = gp.idGenEtnia
        LEFT JOIN genFichaIndi fi ON fi.idGenPersona = gp.idGenPersona
        INNER JOIN dgpUnidad u ON u.idDgpUnidad = a.idDgpUnidad
        INNER JOIN dgpUnidad u1 ON u1.idDgpUnidad = u.dgp_idDgpUnidad
        INNER JOIN dgpUnidad u2 ON u2.idDgpUnidad = u1.dgp_idDgpUnidad

    WHERE
        a.idGenPersona =" . $idGenPersona;
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
}
