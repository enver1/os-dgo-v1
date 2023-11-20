<?php
$directorio = 'vehiculos';
$tgrid = $directorio . '/grid.php';
$tforma = $directorio . '/formulario.php';
$tborra = $directorio . '/borra.php';
$tgraba = $directorio . '/graba.php';
$tprint = $directorio . '/imprime.php';


// /* Aqui van los parametros a cambiar en cada formulario */
// /* path del directorio del modulo */
// $directorio='vehiculos'; // ** CAMBIAR **
// /* Nombre de la tabla  */
// $sNtabla='hdrVehiculo'; // ** CAMBIAR **
// /*---------------------------------------------*/
// /* Para el Id de la tabla convierte la primera letra en mayuscula*/
// $idcampo=ucfirst($sNtabla);
// $sqgrid=sha1('vehiculos');
// /* Select para mostrar los datos en el grid */
// /*-----------------** CAMBIAR **-----------------------------------------------------------------*/
$sqltable = urlencode("SELECT hdrVehiculo.idHdrVehiculo,genVehiculo.placa,genVehiculo.motor,genVehiculo.chasis,dgpUnidad.nomenclatura AS unidad,genModelo.descripcion AS modelo,genMarca.descripcion AS marca,genEstado.descripcion AS estado
FROM
  hdrVehiculo 
  INNER JOIN dgpUnidad 
    ON hdrVehiculo.idDgpUnidad = dgpUnidad.idDgpUnidad 
  INNER JOIN genVehiculo 
    ON genVehiculo.idGenVehiculo = hdrVehiculo.idGenVehiculo 
  INNER JOIN genEstado 
    ON hdrVehiculo.idGenEstado = genEstado.idGenEstado 
  INNER JOIN genModelo 
    ON genVehiculo.idGenModelo = genModelo.idGenModelo 
  INNER JOIN genMarca 
    ON genModelo.idGenMarca = genMarca.idGenMarca");
// /*-----------------------------------------------------------------------------------------------*/
// /*  Esta parte se mantiene para todos los modulos */
// $tgrid=$directorio.'/grid.php'; // php para mostrar la grid
// $tforma=$directorio.'/formulario.php'; // php para mostrar el formulario en la parte superior
// $tborra=$directorio.'/borra.php'; // php para borrar un registro
// $tgraba=$directorio.'/graba.php'; // php para grabar un registro
// $tprint=$directorio.'/imprime.php'; // nombre del php que imprime los registros
// /*  Fin de configuraciones    */
?>
<script type="text/javascript" src="modulos/<?php echo $directorio ?>/validacion.js"></script>
<div id='formulario'>
    <img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>
<div id='retrieved-data'>
    <img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>
<?php include_once('../js/ajaxuid.php'); // Este archivo contiene las funciones de ajax para update, insert, delete, y edit 
?>