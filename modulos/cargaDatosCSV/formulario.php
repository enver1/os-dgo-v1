<?php
include 'config.php';
$meses = array(array('id' => 1, 'nombre' => 'ENERO'), array('id' => 2, 'nombre' => 'FEBRERO'), array('id' => 3, 'nombre' => 'MARZO'),
  array('id' => 4, 'nombre' => 'ABRIL'), array('id' => 5, 'nombre' => 'MAYO'), array('id' => 6, 'nombre' => 'JUNIO'), array('id' => 7,
    'nombre'                                                                                                                       => 'JULIO'), array('id' => 8, 'nombre' => 'AGOSTO'), array('id' => 9, 'nombre' => 'SEPTIEMBRE'), array('id' => 10, 'nombre' => 'OCTUBRE'),
  array('id' => 11, 'nombre' => 'NOVIEMBRE'), array('id' => 12, 'nombre' => 'DICIEMBRE'));
?>
<form name="edita" id="edita" method="POST"  enctype="multipart/form-data">
<table width="100%">
  <tr>
    <td><strong>Año:</strong></td>
    <td><strong>Mes:</strong></td>
    <td><strong>Tipo:</strong></td>
    <td><strong>Separador de campos:</strong></td>
    <td><strong>Nro. de filas de cabecera:</strong></td>
    <td><strong>Archivo de Datos (csv/2MB):</strong></td>
  </tr>
  <tr>
    <td>
      <select name="cedula" id="cedula" class="inputSombra">
      <option value="">Seleccione opción</option>
      <?php for ($i = date('Y'); $i >= 2021; $i--): ?>
      <option value="<?=$i?>"><?=$i?></option>
      <?php endfor;?>
      </select>
    </td>
    <td>
      <select name="numerico" id="numerico" class="inputSombra">
      <option value="">Seleccione opción</option>
      <?php foreach ($meses as $key => $value): ?>
      <option value="<?=$value['id']?>"><?=$value['nombre']?></option>
      <?php endforeach;?>
      </select>
    </td>
    <td>
      <select name="numerico1" id="numerico1" class="inputSombra">
      <option value="">Seleccione opción</option>
      <option value="1">RESULTADOS</option>
      <option value="2">LINEA BASE</option>
      </select>
    </td>
    <td><input type="text" name="separador" style="width:15px" maxlength="1" value=";" class="inputSombra"></td>
    <td><input type="text" name="filasCabecera" style="width:15px" maxlength="1" value="1" class="inputSombra"></td>
    <td>
      <input type="file" name="myfile" id="myfile" size="40" accept=".csv">
      <input type="hidden" name="archivo" id="archivo" value="">
      <input type="hidden" name="fileSize" value="5242880">
    </td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td align="center">
      <input type="button" name="enviar" onclick="cargaDatos()" value="Grabar" class="boton_save" id="enviar">
    </td>
  </tr>
</table>
</form>
<script type="text/javascript" src="<?= $directorio ?>/validacion.js"></script>