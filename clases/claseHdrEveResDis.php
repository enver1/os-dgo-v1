<?php
class HdrEveResDis extends Transaccion
{
  private $tabla      = 'hdrEveResDis';
  private $idCampo    = 'idHdrEveResDis';
  public function getIdCampo()
  {
    return $this->idCampo;
  }
  private $tStructure = array(
    'idHdrEventoResum' => 'idHdrEventoResum',
    'idHdrTipoResum'   => 'idHdrTipoResum',
    'idGenUsuario'     => 'idGenUsuario',
    'idGenPersona'     => 'idGenPersona',
    'fechaRegistro'    => 'fechaRegistro',
    'causa'            => 'causa',
    'nroParteWeb'      => 'nroParteWeb',
    'justificacion'    => 'justificacion',
    'pathPdf'          => 'pathPdf',
  );



  public function getSqlDiscriminacionesRegistros()
  {
    return "SELECT a.idHdrEveResDis, a.idHdrEventoResum, a.idGenUsuario, a.fechaRegistro cinco, a.justificacion, a.pathPdf,
                CASE a.causa WHEN 1 THEN 'TOQUE DE QUEDA' WHEN 2 THEN 'RESTRICCIÓN VEHÍCULAR' WHEN 3 THEN 'MAL USO DEL SALVOCONDUCTO' END nueve,
                c.idHdrEvento cero, c.fechaEvento uno, d.documento seis, d.apenom siete, e.apenom diez, CONCAT(pol.siglas,'. ',pol.apenom) policia,
                a.idHdrTipoResum, tr.desHdrTipoResum ocho, a.nroParteWeb tres, tt.descripcion dos, a.idGenPersona, polp.documento cedula, polp.apenom cuatro
                FROM hdrEveResDis a
                INNER JOIN hdrEventoResum b ON b.idHdrEventoResum = a.idHdrEventoResum
                INNER JOIN hdrTipoResum tr ON tr.idHdrTipoResum = a.idHdrTipoResum
                INNER JOIN hdrEvento c ON c.idHdrEvento = b.idHdrEvento
                INNER JOIN genTipoTipificacion tt ON tt.idGenTipoTipificacion = c.idGenTipoTipificacion
                INNER JOIN v_persona d ON d.idGenPersona = b.idGenPersona
                INNER JOIN v_usuario e ON e.idGenUsuario = a.idGenUsuario
                INNER JOIN v_personal_simple pol ON pol.idGenPersona = c.idGenPersona
                INNER JOIN v_personal_simple polp ON polp.idGenPersona = a.idGenPersona
                WHERE a.delLog = 'N'";
  }

  public function getDiscriminacionesRegistros()
  {
    return $this->consultarAll($this->getSqlDiscriminacionesRegistros());
  }

  public function getDiscriminacionRegistro($idHdrEveResDis)
  {
    $sql = "SELECT a.idHdrEveResDis, a.idHdrEventoResum, a.idGenUsuario, a.fechaRegistro, a.justificacion, a.causa,
                a.pathPdf, c.idHdrEvento, c.fechaEvento, d.documento, d.apenom, e.apenom usuario, CONCAT(pol.siglas,'. ',pol.apenom) policia, a.idHdrTipoResum, tr.desHdrTipoResum, a.nroParteWeb, tt.descripcion descTipoTipificacion, a.idGenPersona, polp.documento cedula, polp.apenom nombrePersona
                FROM hdrEveResDis a
                INNER JOIN hdrEventoResum b ON b.idHdrEventoResum = a.idHdrEventoResum
                INNER JOIN hdrTipoResum tr ON tr.idHdrTipoResum = a.idHdrTipoResum
                INNER JOIN hdrEvento c ON c.idHdrEvento = b.idHdrEvento
                INNER JOIN genTipoTipificacion tt ON tt.idGenTipoTipificacion = c.idGenTipoTipificacion
                INNER JOIN v_persona d ON d.idGenPersona = b.idGenPersona
                INNER JOIN v_usuario e ON e.idGenUsuario = a.idGenUsuario
                INNER JOIN v_personal_simple pol ON pol.idGenPersona = c.idGenPersona
                INNER JOIN v_personal_simple polp ON polp.idGenPersona = a.idGenPersona
                WHERE a.delLog = 'N' AND a.idHdrEveResDis = '{$idHdrEveResDis}' ";
    return $this->consultar($sql);
  }

  public function registrar($datos, $files)
  {
    $formulario     = new FormDiscriminacion;
    $hdrEventoResum = new HdrEventoResum;

    $descripcion = 'idHdrEventoResum';
    $conDupli    = " AND delLog = 'N' ";

    if (empty($datos[$this->idCampo])) {
      $resp = $this->insertArchivo($this->tabla, $this->tStructure, $datos, $formulario->getEstructuraFormulario(), $files, $descripcion, $conDupli);
      if ($resp[0]) {
        $hdrEventoResum->updateTipoResumen($datos['idHdrEventoResum']);
      }
      return $resp;
    } else {
      $conDupli .= " AND $this->idCampo != {$datos[$this->idCampo]}";
      return $this->updateArchivo($this->tabla, $this->tStructure, $datos, $formulario->getEstructuraFormulario(), $files, $descripcion, $conDupli);
    }
  }
}
