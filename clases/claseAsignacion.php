<?php
class Asignacion extends Transaccion
{
    private $tabla   = 'dgoAsignacion';
    private $idTabla = 'idDgoAsignacion';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaAsignacion()
    {
        return $this->tabla;
    }
    public function getSqlAsignacion($idGenPersona)
    {
        $sql = "SELECT
        a.idDgoAsignacion,
        a.anio,
        a.documento,
        a.idGenGeoSenplades,
        a.meses,
        a.senplades,
        gp.siglas,
        gp.apenom,
        gs.descripcion 
    FROM
        dgoAsignacion a
        INNER JOIN v_personal_simple gp ON gp.idGenPersona = a.idGenPersona
        INNER JOIN genGeoSenplades gs ON gs.idGenGeoSenplades = a.idGenGeoSenplades
        WHERE a.idGenPersona=$idGenPersona";
        return $sql;
    }
    public function getAsignacion($idGenPersona)
    {
        return $this->consultarAll($this->getSqlAsignacion($idGenPersona));
    }

    public function getEditAsignacion($idDgoAsignacion)
    {
        $sql = " SELECT
        a.idDgoAsignacion,
        a.anio,
        a.documento,
        a.idGenGeoSenplades,
        a.meses,
        a.senplades,
        CONCAT( gp.siglas, '. ', gp.apenom ) AS apenom,
	gs.descripcion,
	CONCAT(IF(a.meses LIKE '%1%', 'Enero, ', '' ),
	IF( a.meses LIKE '%2,%', 'Febrero, ', '' ),
	IF( a.meses LIKE '%3%', 'Marzo, ', '' ),
	IF( a.meses LIKE '%4%', 'Abril, ', '' ),
	IF( a.meses LIKE '%5%', 'Mayo, ', '' ),
	IF( a.meses LIKE '%6%', 'Junio, ', '' ),
	IF( a.meses LIKE '%7%', 'Julio, ', '' ),
	IF( a.meses LIKE '%8%', 'Agosto, ', '' ),
	IF( a.meses LIKE '%9%', 'Septiembre, ', '' ),
	IF( a.meses LIKE '%10%', 'Octubre, ', '' ),
	IF( a.meses LIKE '%11%', 'Noviembre, ', '' ),
	IF( a.meses LIKE '%12%', 'Diciembre', '' )) as mes 
    FROM
        dgoAsignacion a
        INNER JOIN v_personal_simple gp ON gp.idGenPersona = a.idGenPersona
        INNER JOIN genGeoSenplades gs ON gs.idGenGeoSenplades = a.idGenGeoSenplades
        WHERE a.idDgoAsignacion={$idDgoAsignacion}";
        return $this->consultar($sql);
    }

    public function registrarAsignacion($datos, $file, $formulario)
    {
        $tabla      = 'dgoAsignacion';
        $tStructure = array(
            'idGenPersona' => 'idGenPersona',
            'idGenGeoSenplades' => 'idGenGeoSenplades',
            'meses' => 'meses',
            'anio' => 'anio',
            'senplades' => 'senplades',
            'documento' => 'documento'
        );
        //$datos['idGenPersona'] = $datos['persona'];
        $descripcion     = 'idGenPersona,meses,anio';

        if (empty($datos['idDgoAsignacion'])) {
            $respuesta = $this->insertArchivo($tabla, $tStructure, $datos, $formulario, $file, $descripcion);
        } else {
            $conDupli  = " and idDgoAsignacion != {$datos['idDgoAsignacion']}";
            $respuesta = $this->updateArchivo($tabla, $tStructure, $datos, $formulario, $file, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarAsignacion($idDgoAsignacion)
    {
        if (!empty($idDgoAsignacion)) {
            $respuesta = $this->delete($this->tabla, $idDgoAsignacion);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlAsignacionPdf()
    {
        $sql = "SELECT
        a.idDgoAsignacion,
        a.anio,
        a.documento,
        a.idGenGeoSenplades,
        a.meses,
        a.senplades,
        gp.siglas,
        gp.apenom,
        gs.descripcion 
    FROM
        dgoAsignacion a
        INNER JOIN v_personal_simple gp ON gp.idGenPersona = a.idGenPersona
        INNER JOIN genGeoSenplades gs ON gs.idGenGeoSenplades = a.idGenGeoSenplades";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlAsignacionPdf());
    }
}
