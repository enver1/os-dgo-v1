<?php
class RepPersonalComisios extends Transaccion
{

  public function getSqlRepPersonalComisios($fechaInicio, $fechaFin, $id, $tipo)
  {
    $sql = "SELECT        gsz.descripcion AS ZONA,
                          gsb.descripcion AS SUBZONA,
                          gsd.descripcion AS DISTRITO,
                          gsc.descripcion AS CIRCUITO,
                          gs.descripcion AS SUBCIRCUITO,
                          p.descProcElecc AS OPERATIVO,
                          vs.documento AS CEDULA,
                          vs.siglas AS GRADO,
                        IF( ISNULL( vs.siglas ), vs.apenom, vs.apenom ) AS NOMBRES,
                        IF( pa.cargo = 'J', 'JEFE DE RECINTO', 'INTEGRANTE' ) AS CARGO,
                        IF(( t2.descripcion IS NULL ), IF (( t1.descripcion IS NULL ), rt.nomRecintoElec, t1.descripcion ), t2.descripcion ) AS EJE,
                        IF(( t1.descripcion IS NULL ), rt.nomRecintoElec, t1.descripcion ) AS TIPO_EJE,
                          rt.nomRecintoElec AS UNIDAD,
                          rt.codRecintoElec AS CODIGO,
                          rt.tipoRecinto AS TIPO_RECINTO,
                          pa.idDgoCreaOpReci AS NUMERO, vs.unidad as UNIDAD 
                        FROM
                          dgoPerAsigOpe pa 
                          INNER JOIN genPersona a ON a.idGenPersona = pa.idGenPersona
                          LEFT JOIN v_personal_simple vs ON vs.idGenPersona = pa.idGenPersona
                          INNER JOIN genDocumento d ON d.idGenPersona = pa.idGenPersona 
                          AND d.idGenTipoDocu = 1
                          JOIN dgoCreaOpReci co ON pa.idDgoCreaOpReci = co.idDgoCreaOpReci
                          INNER JOIN dgoComisios c ON c.idDgoComisios = co.idDgoComisios
                          INNER JOIN dgoReciElect rt ON rt.idDgoReciElect = c.idDgoReciElect
                          INNER JOIN dgoProcElec p ON p.idDgoProcElec = c.idDgoProcElec
                          LEFT JOIN genGeoSenplades gs ON gs.idGenGeoSenplades = pa.idGenGeoSenplades
                          LEFT JOIN genGeoSenplades gsc ON gsc.idGenGeoSenplades = gs.gen_idGenGeoSenplades
                          LEFT JOIN genGeoSenplades gsd ON gsd.idGenGeoSenplades = gsc.gen_idGenGeoSenplades
                          LEFT JOIN genGeoSenplades gsb ON gsb.idGenGeoSenplades = gsd.gen_idGenGeoSenplades
                          LEFT JOIN genGeoSenplades gsz ON gsz.idGenGeoSenplades = gsb.gen_idGenGeoSenplades
                          LEFT JOIN dgoTipoEje t ON t.idDgoTipoEje = rt.idDgoTipoEje
                          LEFT JOIN dgoTipoEje t1 ON t1.idDgoTipoEje = t.dgo_idDgoTipoEje
                          LEFT JOIN dgoTipoEje t2 ON t2.idDgoTipoEje = t1.dgo_idDgoTipoEje 
                        WHERE
                         pa.delLog = 'N' AND p.idDgoProcElec=" . $id;
    if ($tipo == 'A') {
      $sql = $sql . "  AND pa.idGenEstado=1";
    }
    if ($tipo == 'I') {
      $sql = $sql . "  AND pa.idGenEstado=2";
    }
    $sql = $sql .   "  AND  DATE(pa.fecha)>=" . "DATE('" . "{$fechaInicio}" . "')" . " AND DATE(pa.fecha)<=" . "DATE('" . "{$fechaFin}" . "')";

    return $sql;
  }
  public function getRepPersonalComisios($fechaInicio, $fechaFin, $id, $tipo)
  {
    return $this->consultarAll($this->getSqlRepPersonalComisios($fechaInicio, $fechaFin, $id, $tipo));
  }
}
