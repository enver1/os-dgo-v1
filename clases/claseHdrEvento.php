<?php

/**
 *
 */
class HdrEvento extends Transaccion
{
    private $table = "hdrEvento";
    private $id = "idHdrEvento";

    public function getIdCampo()
    {
        return $this->id;
    }

    public function getNombreTabla()
    {
        return $this->table;
    }

    private $tStructure = array(
        'estadoPolicia'      => 'estadoPolicia',
    );

    public function getSubSqlTotalHdrEventoOSU($siglas, $anio, $mes = 0, $idGenTipoTipificacion = 0, $estadoPolicia = 0)
    {
        $sql = "SELECT
                    count( * ) cuantos 
                FROM
                    v_hdrevento_anio a,
                    genGeoSenplades b
                WHERE
                    a.idGenGeoSenplades = b.idGenGeoSenplades 
                    AND b.siglasGeosenplades LIKE CONCAT(gs.siglasGeoSenplades,'%') 
                    AND a.anio = '{$anio}'  
                    AND a.siglas LIKE '{$siglas}%' ";

        $sql .= (!empty($mes)) ? " AND a.mes='{$mes}' " : "";

        $sql .= (!empty($idGenTipoTipificacion)) ? " AND a.idGenTipoTipificacion={$idGenTipoTipificacion} " : "";

        $sql .= (!empty($estadoPolicia)) ? " AND a.estadoPolicia='{$estadoPolicia}' " : "";

        return $sql;
    }

    public function getTotalHdrEventoOSU($gen_idGenGeoSenplades, $siglas, $anio, $mes = 0, $idGenTipoTipificacion = 0, $estadoPolicia = 0)
    {
        $subSql = $this->getSubSqlTotalHdrEventoOSU($siglas, $anio, $mes, $idGenTipoTipificacion, $estadoPolicia);

        $condicion = (empty($gen_idGenGeoSenplades)) ? " IS NULL " : " = {$gen_idGenGeoSenplades}";

        $sql = "SELECT 
                    gs.idGenGeoSenplades, gs.descripcion, gs.siglasGeoSenplades, 
                    ({$subSql}) cuantos
                FROM
                    genGeoSenplades gs
                WHERE
                    gs.gen_idGenGeoSenplades {$condicion}";

        return $this->consultarAll($sql);
    }

    public function getSqlOperativosAbiertos()
    {
        return "	SELECT
        a.idHdrEvento,
        a.idHdrEvento as CodigoOperativo,
        b.siglasGeoSenplades as LugarOperativo,
        c.descripcion as TipoOperativo 
    FROM
        hdrEvento a
        INNER JOIN genGeoSenplades b on  a.idGenGeoSenplades = b.idGenGeoSenplades 
        INNER JOIN 	genTipoTipificacion c ON  a.idGenTipoTipificacion = c.idGenTipoTipificacion 
        WHERE TIMESTAMPDIFF(HOUR,a.fechaEvento, NOW())> 24 
		and a.estadoPolicia=3
		and a.idHdrTipoServicio=4";
    }


    public function getCampos()
    {
        return array(
            'Código' => 'idHdrEvento',
            'Lugar Operativo' => 'LugarOperativo',
            'Tipo Operativo' => 'TipoOperativo',


        );
    }
    public function editCerrarOperativos($idhdrEvento)
    {
        $sql = "SELECT
        a.idHdrEvento,
        b.siglasGeoSenplades,
        c.descripcion 
    FROM
        hdrEvento a
        INNER JOIN genGeoSenplades b on  a.idGenGeoSenplades = b.idGenGeoSenplades 
        INNER JOIN 	genTipoTipificacion c ON  a.idGenTipoTipificacion = c.idGenTipoTipificacion 
		WHERE a.idhdrEvento={$idhdrEvento}";
        return $this->consultar($sql);
    }
    public function cerrarOperativos($id)
    {
        try {
            $updateCerrar = "UPDATE hdrEvento SET estadoPolicia=5 WHERE idhdrEvento={$id}";
            $rs = $this->conn->prepare($updateCerrar);
            $rs->execute();
            return array(true, 'OPERATIVO CERRADO CORRECTAMENTE', 0);
        } catch (Exception $e) {
            return array(true, $e->getMessage(), 0);
        }
    }
    public function cerrarOperativosold()
    {
        try {
            $updateCerrar = "UPDATE hdrEvento SET estadoPolicia=5, usuario={$_SESSION['usuarioAuditar']}, fecha=NOW(), ip='{$this->getRealIP()}' WHERE estadoPolicia=3 AND idHdrTipoServicio=4 AND TIMESTAMPDIFF(HOUR,fechaEvento,NOW())>24";
            $rs = $this->conn->prepare($updateCerrar);
            $rs->execute();
            return array(true, 'OPERATIVOS CERRADOS CORRECTAMENTE', 0);
        } catch (Exception $e) {
            return array(true, $e->getMessage(), 0);
        }
    }
    public function cuentaregistrosOsu($gen_idGenGeoSenplades, $anio, $mes = 0, $estadoPolicia = 0, $siglas)
    {
        $condicion = (empty($gen_idGenGeoSenplades)) ? " IS NULL " : " = {$gen_idGenGeoSenplades}";

        $sqlreg = "SELECT
                    count(idHdrEventoResum) cuantosr
                FROM
                    v_hdrevento_anio a
                    LEFT JOIN hdrEventoResum ON a.idHdrEvento = hdrEventoResum.idHdrEvento,
                    genGeoSenplades c
                WHERE
                    a.estadoPolicia = '{$estadoPolicia}'
                    AND a.idGenGeoSenplades = c.idGenGeoSenplades 
		            AND c.siglasGeosenplades LIKE CONCAT( gs.siglasGeoSenplades, '%' ) 
                    AND a.anio = '{$anio}' 
                    AND a.siglas LIKE '{$siglas}'";
        $sqlreg .= (!empty($mes)) ? " AND a.mes='{$mes}' " : "";
        $sql = "SELECT  
            ({$sqlreg}) cuantosr
        FROM
            genGeoSenplades gs
        WHERE
            gs.gen_idGenGeoSenplades {$condicion}";

        return $this->consultarAll($sql);
    }
    public function cuentaResultadosOsu($gen_idGenGeoSenplades, $anio, $mes = 0, $estadoPolicia = 0, $siglas)
    {
        $condicion = (empty($gen_idGenGeoSenplades)) ? " IS NULL " : " = {$gen_idGenGeoSenplades}";
        $sqlres = "SELECT
                    count(*) cuantosrs
                FROM
                    v_hdrevento_anio a
                    LEFT JOIN hdrEventoResum ON a.idHdrEvento = hdrEventoResum.idHdrEvento,
                    genGeoSenplades c
                WHERE
                    a.estadoPolicia = '{$estadoPolicia}'
                    AND a.idGenGeoSenplades = c.idGenGeoSenplades 
		            AND c.siglasGeosenplades LIKE CONCAT( gs.siglasGeoSenplades, '%' ) 
                    AND a.anio = '{$anio}' 
                    AND a.siglas LIKE '{$siglas}%'
                    AND detBusqueda NOT IN ( 'No existen restricciones', 'NO EXISTE RESTRICCIÓN', 'NO EXISTEN BOLETAS', 'No existen boletas', '' )";
        $sqlres .= (!empty($mes)) ? " AND a.mes='{$mes}' " : "";
        $sql = "SELECT  
                ({$sqlres}) cuantosrs
            FROM
                genGeoSenplades gs
            WHERE
                gs.gen_idGenGeoSenplades {$condicion}";

        return $this->consultarAll($sql);
    }
    public function cuentaxTipoOsu($gen_idGenGeoSenplades, $anio, $mes = 0, $estadoPolicia = 0, $siglas)
    {
        $condicion = (empty($gen_idGenGeoSenplades)) ? " IS NULL " : " = {$gen_idGenGeoSenplades}";
        $sqlxt = "SELECT 
                        b.idGenGeoSenplades,
                        b.siglasGeoSenplades,
                        a.descripcion,
                        count( * ) cuantos 
                    FROM
                        v_hdrevento_anio a,
                        genGeoSenplades b
                    WHERE
                        a.idGenGeoSenplades = b.idGenGeoSenplades 
                        AND a.anio = '{$anio}'
                        AND a.siglas LIKE '{$siglas}%' 
                        AND a.estadoPolicia = '{$estadoPolicia}' ";
        $sqlxt .= (!empty($mes)) ? " AND a.mes={$mes} " : "";
        $sqlxt .= "GROUP BY b.idGenGeoSenplades";
        $sql = "SELECT 
                        d.descripcion desctipo,
	                    SUM(d.cuantos) ctatipo
                        FROM
                        genGeoSenplades gs
                        JOIN ({$sqlxt}) d ON d.siglasGeosenplades LIKE CONCAT( gs.siglasGeoSenplades, '%' ) 
                    WHERE
                    gs.gen_idGenGeoSenplades {$condicion}
                    GROUP BY d.descripcion ";

        return $this->consultarAll($sql);
    }
}
