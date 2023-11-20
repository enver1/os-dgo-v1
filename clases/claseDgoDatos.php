<?php

/**
 *
 */
class DgoDatos extends Transaccion
{

  public function validarDatos($anio, $mes, $tipo)
  {
    $sql = "SELECT texto1, COUNT(*) total FROM genTablaAuxiliar WHERE texto24='CURSANTE' AND cedula = '{$anio}' AND numerico = '{$mes}' AND numerico1 = '{$tipo}' AND delLog = 'N' GROUP BY texto1 HAVING total > 1 ORDER BY total";
    $row = $this->consultarAll($sql);
    if (!empty($row)) {
      $codigos = implode(',', array_column($row, 'texto1'));
      return array('success' => false, 'message' => 'EXISTEN DATOS DUPLICADOS: ' . $codigos);
    }
    $update     = "UPDATE genTablaAuxiliar SET texto = (SELECT idGenGeoSenplades FROM genGeoSenplades WHERE codigoSenplades=texto1 LIMIT 1) WHERE texto24='CURSANTE' AND cedula = '{$anio}' AND numerico = '{$mes}' AND numerico1 = '{$tipo}' AND delLog = 'N'";
    $sentenciaU = $this->conn->prepare($update);
    $sentenciaU->execute();

    $sqlS = "SELECT idGenTablaAuxiliar, texto1 FROM genTablaAuxiliar WHERE texto24='CURSANTE' AND cedula = '{$anio}' AND numerico = '{$mes}' AND numerico1 = '{$tipo}' AND delLog = 'N' AND (texto = '' OR ISNULL(texto))";
    $rowS = $this->consultarAll($sqlS);
    if (!empty($rowS)) {
      $codigos = implode(',', array_column($rowS, 'texto1'));
      return array('success' => false, 'message' => 'CODIGOS SENPLADES NO EXITEN EN LA BASE DE DATOS: ' . $codigos);
    }

    return array('success' => true, 'message' => 'DATOS CORRECTOS');
  }

  public function eliminarDatos($anio, $mes, $tipo)
  {
    try {
      $this->conn->beginTransaction();
      $update     = "UPDATE genTablaAuxiliar SET delLog='S' WHERE texto24='CURSANTE' AND cedula = '{$anio}' AND numerico = '{$mes}' AND numerico1 = '{$tipo}' AND delLog = 'N'";
      $sentenciaU = $this->conn->prepare($update);
      $sentenciaU->execute();

      $updateDatos    = "UPDATE dgoDatos SET delLog='S', fecha=now(), usuario={$_SESSION['usuarioAuditar']}, ip='{$this->getRealIP()}' WHERE anio = '{$anio}' AND idGenMes = '{$mes}' AND identificador = '{$tipo}' AND delLog = 'N'";
      $sentenciaDatos = $this->conn->prepare($updateDatos);
      $sentenciaDatos->execute();
      $this->conn->commit();
      return array('success' => true, 'message' => 'REGISTRO ELIMINADO CORRECTAMENTE');
    } catch (Exception $e) {
      $this->conn->rollBack();
      return array('success' => false, 'message' => 'ERROR AL ELIMINAR');
    }
  }

  public function cargarNotas($anio, $mes, $tipo)
  {
    try {
      $insert = "INSERT INTO dgoDatos (idGenGeoSenplades, anio, idGenMes, identificador, cantidad1, cantidad2, cantidad3, cantidad4, cantidad5, fecha, usuario, ip)
          SELECT ta.texto, ta.cedula, ta.numerico, ta.numerico1, REPLACE(ta.texto2, ',', '.') texto2, REPLACE(ta.texto3, ',', '.') texto3, REPLACE(ta.texto4, ',', '.') texto4, REPLACE(ta.texto5, ',', '.') texto5, REPLACE(ta.texto6, ',', '.') texto6, now(), ?, ?
          FROM genTablaAuxiliar ta
          WHERE texto24='CURSANTE' AND cedula = '{$anio}' AND numerico = '{$mes}' AND numerico1 = '{$tipo}' AND delLog = 'N'";
      $sentencia = $this->conn->prepare($insert);
      $sentencia->bindParam(1, $this->getRealIP());
      $sentencia->bindParam(2, $_SESSION['usuarioAuditar']);
      $sentencia->execute();
      $insertados = $sentencia->rowCount();
      return array('success' => true, 'message' => 'DATOS MIGRADOS CORRECTAMENTE, TOTAL: ' . $insertados);
    } catch (Exception $e) {
      //return array('success' => false, 'message' => 'ERROR AL MIGRAR DATOS');
      return array('success' => false, 'message' => 'ERROR:' . $e->getMessage());
    }
  }

  public function getDgoDatosMeses()
  {
    $sql = "SELECT a.anio, b.descMes, IF(a.identificador=1,'RESULTADOS','LINEA BASE') identificador, COUNT(*) total FROM dgoDatos a, genMes b WHERE a.idGenMes = b.idGenMes AND a.delLog = 'N' GROUP BY a.anio, a.idGenMes, a.identificador";
    return $this->consultarAll($sql);
  }

  public function getNotasSenpladesNivel($idGenTipoGeoSenplades, $anio)
  {
    $sql = "CALL getNotasSenplades({$idGenTipoGeoSenplades},{$anio})";
    return $this->consultarAll($sql);
  }

  public function getMesesNotasAnio($anio)
  {
    $sql = "SELECT idGenMes FROM dgoDatos WHERE delLog = 'N' AND identificador = 1 AND anio = {$anio} GROUP BY idGenMes";
    return array_column($this->consultarAll($sql), 'idGenMes');
  }
}
