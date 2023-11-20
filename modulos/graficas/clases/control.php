<?php
class control
{

  function zona($conn, $fini, $ffin, $geo)
  {
    $sql = "select  count(e.idHdrEvento)numeroregistro,count(er.idGenPersona)personas,count(er.idGenVehiculo)vehiculos
from hdrEvento e inner join hdrEventoResum er on e.idHdrEvento=er.idHdrEvento
inner join genGeoSenplades g on g.idGenGeoSenplades=e.idGenGeoSenplades
INNER JOIN genGeoSenplades AS c ON g.gen_idGenGeoSenplades=c.idGenGeoSenplades
INNER JOIN genGeoSenplades AS d ON c.gen_idGenGeoSenplades=d.idGenGeoSenplades
INNER JOIN genGeoSenplades AS sz ON d.gen_idGenGeoSenplades=sz.idGenGeoSenplades
INNER JOIN genGeoSenplades AS z ON sz.gen_idGenGeoSenplades=z.idGenGeoSenplades
where e.fechaEvento between '" . $fini . "' and '" . $ffin . "' and e.idHdrTipoServicio=4 and e.ip='movil'
and (g.idGenGeoSenplades='" . $geo . "' or c.idGenGeoSenplades='" . $geo . "' or d.idGenGeoSenplades='" . $geo . "' or sz.idGenGeoSenplades='" . $geo . "' or z.idGenGeoSenplades='" . $geo . "')
group by z.idGenGeoSenplades desc";

    print_r($sql);
    die();
    $rs = $conn->query($sql);
    if ($rowT = $rs->fetch(PDO::FETCH_ASSOC)) {
      $reg = $rowT['numeroregistro'];
      $per = $rowT['personas'];
      $veh = $rowT['vehiculos'];
      $roba = $this->robados($conn, $fini, $ffin, $geo);
      $ro = $roba['robados'];
      $bol = $this->boletas($conn, $fini, $ffin, $geo);
      $bo = $bol['boletas'];
      $opera = $this->operativo($conn, $fini, $ffin, $geo);
      $ope = $opera['operativos'];
      $resu =  array($ope, $reg, $per, $veh, $ro, $bo);

      return $resu;
    }
  }
  function robados($conn, $fini, $ffin, $geo)
  {
    $sql = "select  count(er.detBusqueda)robados
from hdrEvento e inner join hdrEventoResum er on e.idHdrEvento=er.idHdrEvento
inner join genGeoSenplades g on g.idGenGeoSenplades=e.idGenGeoSenplades
INNER JOIN genGeoSenplades AS c ON g.gen_idGenGeoSenplades=c.idGenGeoSenplades
INNER JOIN genGeoSenplades AS d ON c.gen_idGenGeoSenplades=d.idGenGeoSenplades
INNER JOIN genGeoSenplades AS sz ON d.gen_idGenGeoSenplades=sz.idGenGeoSenplades
INNER JOIN genGeoSenplades AS z ON sz.gen_idGenGeoSenplades=z.idGenGeoSenplades
where e.fechaEvento between '" . $fini . "' and '" . $ffin . "' and e.idHdrTipoServicio=4 and e.ip='movil' and er.detBusqueda='ROBADO'
and (g.idGenGeoSenplades='" . $geo . "' or c.idGenGeoSenplades='" . $geo . "' or d.idGenGeoSenplades='" . $geo . "' or sz.idGenGeoSenplades='" . $geo . "' or z.idGenGeoSenplades='" . $geo . "')
group by z.idGenGeoSenplades desc";
    $rs = $conn->query($sql);
    $rowT = $rs->fetch(PDO::FETCH_ASSOC);
    return $rowT;
  }
  function boletas($conn, $fini, $ffin, $geo)
  {
    $sql = "select  count(er.detBusqueda)boletas
from hdrEvento e inner join hdrEventoResum er on e.idHdrEvento=er.idHdrEvento
inner join genGeoSenplades g on g.idGenGeoSenplades=e.idGenGeoSenplades
INNER JOIN genGeoSenplades AS c ON g.gen_idGenGeoSenplades=c.idGenGeoSenplades
INNER JOIN genGeoSenplades AS d ON c.gen_idGenGeoSenplades=d.idGenGeoSenplades
INNER JOIN genGeoSenplades AS sz ON d.gen_idGenGeoSenplades=sz.idGenGeoSenplades
INNER JOIN genGeoSenplades AS z ON sz.gen_idGenGeoSenplades=z.idGenGeoSenplades
where e.fechaEvento between '" . $fini . "' and '" . $ffin . "' and e.idHdrTipoServicio=4 and e.ip='movil' and er.detBusqueda='TIENE ORDEN DE CAPTURA'
and (g.idGenGeoSenplades='" . $geo . "' or c.idGenGeoSenplades='" . $geo . "' or d.idGenGeoSenplades='" . $geo . "' or sz.idGenGeoSenplades='" . $geo . "' or z.idGenGeoSenplades='" . $geo . "')
group by z.idGenGeoSenplades desc";
    $rs = $conn->query($sql);
    $rowT = $rs->fetch(PDO::FETCH_ASSOC);
    return $rowT;
  }
  function operativo($conn, $fini, $ffin, $geo)
  {
    $sql = "select  count(e.idHdrEvento)operativos
from hdrEvento e inner join genGeoSenplades g on g.idGenGeoSenplades=e.idGenGeoSenplades
INNER JOIN genGeoSenplades AS c ON g.gen_idGenGeoSenplades=c.idGenGeoSenplades
INNER JOIN genGeoSenplades AS d ON c.gen_idGenGeoSenplades=d.idGenGeoSenplades
INNER JOIN genGeoSenplades AS sz ON d.gen_idGenGeoSenplades=sz.idGenGeoSenplades
INNER JOIN genGeoSenplades AS z ON sz.gen_idGenGeoSenplades=z.idGenGeoSenplades
where e.fechaEvento between '" . $fini . "' and '" . $ffin . "' and e.idHdrTipoServicio=4 and e.ip='movil'
and (g.idGenGeoSenplades='" . $geo . "' or c.idGenGeoSenplades='" . $geo . "' or d.idGenGeoSenplades='" . $geo . "' or sz.idGenGeoSenplades='" . $geo . "' or z.idGenGeoSenplades='" . $geo . "')
group by z.idGenGeoSenplades desc";
    $rs = $conn->query($sql);
    $rowT = $rs->fetch(PDO::FETCH_ASSOC);
    return $rowT;
  }
}
