<?php
class HdrEventoResum extends Transaccion
{

    private $tabla      = 'hdrEventoResum';
    private $idCampo    = 'idHdrEventoResum';
    private $tStructure = array();

    public function getIdCampo()
    {
        return $this->idCampo;
    }

    public function getEventoResumPersona($idHdrEvento, $documento)
    { //b.idGenTipoTipificacion = '21296' AND
        $sql = "SELECT a.idHdrEventoResum, a.idHdrEvento, a.idGenPersona, b.fechaEvento, c.apenom, CONCAT(pol.siglas,'. ',pol.apenom) policia, a.idHdrTipoResum, tr.desHdrTipoResum, tt.descripcion descTipoTipificacion
            FROM hdrEventoResum a
            INNER JOIN hdrEvento b ON b.idHdrEvento = a.idHdrEvento
            INNER JOIN hdrTipoResum tr ON tr.idHdrTipoResum = a.idHdrTipoResum
            INNER JOIN genTipoTipificacion tt ON tt.idGenTipoTipificacion = b.idGenTipoTipificacion
            INNER JOIN v_persona c ON c.idGenPersona = a.idGenPersona
            INNER JOIN v_personal_simple pol ON pol.idGenPersona = b.idGenPersona
            WHERE  b.idHdrEvento = '{$idHdrEvento}' AND c.documento = '{$documento}'";
        return $this->consultar($sql);
    }

    public function updateTipoResumen($idHdrEventoResum)
    {
        $datos = array('idHdrTipoResum' => 56, 'idHdrEventoResum' => $idHdrEventoResum);
        $conDupli  = " AND {$this->idCampo} != '{$datos[$this->idCampo]}'";
        if (!empty($idHdrEventoResum)) {
            return $this->update($this->tabla, array('idHdrTipoResum' => 'idHdrTipoResum'), $datos, '', $conDupli);
        }
    }
}
