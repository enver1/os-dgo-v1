<?php

/**
 *
 */
class DgoAsignacion extends Transaccion
{
  public function getCursantesAnio($anio)
  {
    $sql = "SELECT CONCAT(IF(ISNULL(b.siglas), '', b.siglas), ' ', b.apenom) nombre, b.documento cedula, a.idGenPersona  
            FROM dgoAsignacion a 
            INNER JOIN v_personal_simple b ON b.idGenPersona = a.idGenPersona
            WHERE a.anio = {$anio} GROUP BY a.idGenPersona ORDER BY b.idDgpGrado, nombre";
    return $this->consultarAll($sql);
  }

  public function getCursantesAsignacionAnio($anio)
  {
    $sql = "SELECT a.idGenPersona, a.idGenGeoSenplades, a.meses, a.senplades, b.codigoSenplades, b.descripcion, b.siglasGeoSenplades  
            FROM dgoAsignacion a 
            INNER JOIN genGeoSenplades b ON b.idGenGeoSenplades = a.idGenGeoSenplades
            WHERE a.anio = {$anio} ORDER BY a.idGenPersona, a.meses";
    return $this->consultarAll($sql);
  }

  public function getNotasCursantesAnio($anio)
  {
    $dgoDatos = new DgoDatos();
    $data = array();
    $subzonas = $dgoDatos->getNotasSenpladesNivel(2, $anio);
    $distritos = $dgoDatos->getNotasSenpladesNivel(3, $anio);
    $circuitos = $dgoDatos->getNotasSenpladesNivel(4, $anio);
    $subcircuitos = $dgoDatos->getNotasSenpladesNivel(5, $anio);
    $cursantes = $this->getCursantesAnio($anio);
    $asignaciones = $this->getCursantesAsignacionAnio($anio);
    $tempArr = $dgoDatos->getMesesNotasAnio($anio);
    $meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);

    foreach ($cursantes as $key => $cursante) {
      $notas = array();
      foreach ($asignaciones as $keya => $asignacion) {
        if ($cursante['idGenPersona'] == $asignacion['idGenPersona']) {
          $mesesAsig = explode(',', $asignacion['meses']);
          foreach ($meses as $mes) {
            if (in_array($mes, $mesesAsig)) {
              if (isset($notas[$mes - 1])) {
                $notas[$mes - 1] = array('idGenGeoSenplades' => $asignacion['idGenGeoSenplades'], 'descripcion' => $asignacion['descripcion'], 'codigo' => $asignacion['codigoSenplades'], 'senplades' => $asignacion['senplades'], 'mes' => $mes, 'cmi_delito' => null, 'det_cmi' => null, 'det_cont' => null, 'arma_fuego' => null, 'veh_recu' => null, 'nota' => null);
              } else {
                array_push($notas, array('idGenGeoSenplades' => $asignacion['idGenGeoSenplades'], 'descripcion' => $asignacion['descripcion'], 'codigo' => $asignacion['codigoSenplades'], 'senplades' => $asignacion['senplades'], 'mes' => $mes, 'cmi_delito' => null, 'det_cmi' => null, 'det_cont' => null, 'arma_fuego' => null, 'veh_recu' => null, 'nota' => null));
              }
            } else {
              if (!isset($notas[$mes - 1])) {
                array_push($notas, array('idGenGeoSenplades' => null, 'descripcion' => null, 'codigo' => null, 'senplades' => null, 'mes' => $mes, 'cmi_delito' => null, 'det_cmi' => null, 'det_cont' => null, 'arma_fuego' => null, 'veh_recu' => null, 'nota' => null));
              }
            }
          }
          /* foreach ($meses as $value) {
            array_push($notas, array('idGenGeoSenplades' => $asignacion['idGenGeoSenplades'], 'descripcion' => $asignacion['descripcion'], 'codigo' => $asignacion['codigoSenplades'], 'senplades' => $asignacion['senplades'], 'mes' => $value, 'cmi_delito' => null, 'det_cmi' => null, 'det_cont' => null, 'arma_fuego' => null, 'veh_recu' => null, 'nota' => null));
          } */
          unset($asignaciones[$keya]);
        }
      }
      $cursantes[$key]['notas'] = $notas;
    }

    foreach ($cursantes as $key => $cursante) {
      foreach ($cursante['notas'] as $keyn => $nota) {
        if (in_array($nota['mes'], $tempArr)) {
          switch ($nota['senplades']) {
            case '2':
              $data = $subzonas;
              break;
            case '3':
              $data = $distritos;
              break;
            case '4':
              $data = $circuitos;
              break;
            case '5':
              $data = $subcircuitos;
              break;
          }
          foreach ($data as $value) {
            if ($nota['idGenGeoSenplades'] == $value['idGenGeoSenplades'] && $nota['mes'] == $value['idGenMes']) {
              $cursantes[$key]['notas'][$keyn]['cmi_delito'] = $value['cmi_delito'];
              $cursantes[$key]['notas'][$keyn]['det_cmi'] = $value['det_cmi'];
              $cursantes[$key]['notas'][$keyn]['det_cont'] = $value['det_cont'];
              $cursantes[$key]['notas'][$keyn]['arma_fuego'] = $value['arma_fuego'];
              $cursantes[$key]['notas'][$keyn]['veh_recu'] = $value['veh_recu'];
              $cursantes[$key]['notas'][$keyn]['nota'] = $value['total'];
            }
          }
        }
      }
    }

    return $cursantes;
  }
}
