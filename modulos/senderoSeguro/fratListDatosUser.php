<?php

session_start();
header('Content-Type: text/html; charset=UTF-8');

include_once '../../../clases/autoload.php';


$senderoSeguro = new SenderoSeguro;



$idUser = strip_tags($_GET['idUser']);
$idRuta = strip_tags($_GET['idRuta']);

$datosUser = $senderoSeguro->getConsultarUser($idUser);
$datosRuta = $senderoSeguro->getConsultarRutasPorId($idRuta);
$datosDetalleRuta = $senderoSeguro->getConsultarUltimaRutaDetallePorIdRuta($idRuta);
$tamaDatosDetalleRuta = sizeof($datosDetalleRuta);

$datosPrimerDetalleAlerta = $senderoSeguro->getConsultaPrimerRutaAlertaPorIdRuta($idRuta);
$tamaDatosPrimerDetalleRuta = sizeof($datosPrimerDetalleAlerta);
$datosUltimoDetalleAlerta = $senderoSeguro->getConsultaUltimaRutaAlertaPorIdRuta($idRuta);
$tamaDatosUltimaDetalleRuta = sizeof($datosUltimoDetalleAlerta);

$datosUser = $datosUser[0];
$datosRuta = $datosRuta[0];

$activa = "Activa";



//DATOS DEL USUARIO
$documento = $datosUser['docuGoeUsuReg'];
$nombres = $datosUser['nomGoeUsuReg'] . " " . $datosUser['apeGoeUsuReg'];
$celular = $datosUser['celuGoeUsuReg'];
$contactoFamiliar = $datosUser['conFamiGoeUsuReg'];
$email = $datosUser['mailGoeUsuReg'];
$pais = $datosUser['pais'];


$camposDatos = array(
	'Documento:' => $documento,
	'Nombres y Apellidos:' => $nombres,
	'Celular:' => $celular,
	'Contacto Familiar:' => $contactoFamiliar,
	'Email/Correo:' => $email,
	'País:' => $pais
);

//DATOS DE LA RUTA

$fechaRuta = $datosRuta['fechaRuta'];
$destino = $datosRuta['descGoePunLleg'];
$coordenadasDestino = $datosRuta['latGoePunLleg'] . "," . $datosRuta['lonGoePunLleg'];
$fechaUltimaPosicion = "Sin Datos";
$coordenadasUltimaPosicion = "Sin Datos";
$fechaHoraAproximadaLLegada = $datosRuta['fechaLlegada'];
$distanciaRecorrer = $datosRuta['distancia'];
$tiempoRuta = $datosRuta['tiempoRuta'];
$tiempoEncontra = 0;
$estadoRuta = $datosRuta['estado'];
$accion = $datosRuta['accion'];



if ($estadoRuta == 'S') {
	$estadoRuta = $activa;

	$btnAdministrar = '<input type="button" value="Administrar" id="btnAdministrar" class="boton_process"">';

	if ($tamaDatosPrimerDetalleRuta > 0) { //se verifica si tiene alertas
		$msjObservacion = "<p ><strong>OBSERVACIÓN: </strong> EXISTEN ALERTAS ACTIVAS </strong></p>";
	} else {
		$msjObservacion = "<p ><strong>OBSERVACIÓN: </strong> LA RUTA SE ENCUENTRA ACTIVA. NO TIENE ALERTAS ACTIVAS </strong></p>";
	}
} else {
	$msjObservacion = "<p ><strong>DATOS E INFORMACIÓN DE LA RUTA</strong>  </strong></p>";
	$btnAdministrar = '<input type="button" value="Administrar" id="btnAdministrar" class="boton_process" style="display: none;" ">';
}

if ($tamaDatosDetalleRuta > 0) {
	$fechaUltimaPosicion = $datosDetalleRuta[0]['fecha'];
	$coordenadasUltimaPosicion = $datosDetalleRuta[0]['latGoeRutaDetalle'] . "," . $datosDetalleRuta[0]['lonGoeRutaDetalle'];
} else { //al no tener distancia recorrida la ultima posicion es donde inicio la ruta
	$fechaUltimaPosicion = $fechaRuta;
	$coordenadasUltimaPosicion = $datosRuta['latInicial'] . "," . $datosRuta['lonInicial'];
}


if (empty($fechaHoraAproximadaLLegada)) {
	$fechaHoraAproximadaLLegada = "Sin Datos";
	$distanciaRecorrer = "Sin Datos";
	$tiempoRuta = "Sin Datos";
}

if (empty($accion)) {
	$accion = "Sin Datos";
}


//calculo del tiempo encontra

//obtenemos la fecha local
date_default_timezone_set('America/Guayaquil');
$fechaLocal = date("Y/m/d H:i:s", time());

if ($estadoRuta == 'S' && $fechaHoraAproximadaLLegada != "SD" && !empty($fechaHoraAproximadaLLegada && strtotime($fechaHoraAproximadaLLegada) > 0)) { //se encuentra activa

	//compara si la fecha locla es mayor a la fecha aproximada de llegada
	$fecha_actual = strtotime($fechaLocal);
	$fecha_entrada = strtotime($fechaHoraAproximadaLLegada);


	if ($fecha_actual > $fecha_entrada) {
		//la fecha actual es mayor 
		$msjObservacion = "<p ><strong>Recomendación: </strong> La Fecha y Hora aproximada de llegada es mayor a la actual. </strong></p>";

		//saca el tiempo encontra de una fecha
		$fecha1 = new DateTime($fechaLocal);
		$fecha2 = new DateTime($fecha_entrada);
		$fecha = $fecha1->diff($fecha2);

		$tiempoEncontra = $fecha->y . ' años, ' . $fecha->m . ' meses, ' . $fecha->d . ' días, ' . $fecha->h . ' H, ' . $fecha->i . ' min, ' . $fecha->s . ' s';
	} else {
		$tiempoEncontra = "0";
	}
} else {

	$tiempoEncontra = "SD";
}



$camposRuta = array(
	'Fecha y Hora Inicio Ruta:' => $fechaRuta,
	'Destino:' => $destino,
	'Destino Coordenadas:' => $coordenadasDestino,
	'Fecha Ultima Posicion Rescorrida:' => $fechaUltimaPosicion,
	'Ultima Posicion Coordenadas:' => $coordenadasUltimaPosicion,
	'Fecha y Hora Aproximada de Llegada:' => $fechaHoraAproximadaLLegada,
	'Distancia a Recorrer:' => $distanciaRecorrer,
	'Tiempo Estimado de la Ruta:' => $tiempoRuta,
	'Tiempo Encontra' => $tiempoEncontra,
	'Estado Ruta' => $estadoRuta,
	'Accion Tomada' => $accion
);






?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SIIPNE 3w</title>
    <link href="../../../../css/siipne3.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="../../../js/sha1.js"></script>


    <script type="text/javascript" src="../../../js/jquery-3.5.1.min.js"></script>

</head>

<body>


    <div id="wraper">
        <div id="faux">

            <p></p>
            <div class="warningmess">

                <?php echo  $msjObservacion; ?>


            </div>


            <div id="content">
                <div id="content_top"></div>
                <div id="content_mid">
                    <div id="contenido">

                        <fieldset style="border-color:#336699">
                            <legend><strong>DATOS</strong></legend>


                            <table width="100%" border="0">


                                <?php foreach ($camposDatos as $campos => $valor) { ?>

                                <tr>
                                    <td>
                                        <b><?php echo $campos ?></b>
                                    </td>
                                    <td><?php echo  $valor ?></td>
                                </tr>

                                <?php } ?>


                                </tr>


                            </table>

                        </fieldset>


                        <p></p>

                        <fieldset style="border-color:#336699">
                            <legend><strong>INFORMACIÓN DE LA RUTA</strong></legend>


                            <table width="100%" border="0">


                                <?php foreach ($camposRuta as $campos => $valor) { ?>

                                <tr>
                                    <td>
                                        <b><?php echo $campos ?></b>
                                    </td>
                                    <td><?php echo  $valor ?></td>
                                </tr>

                                <?php } ?>



                            </table>

                        </fieldset>
                        <?php if ($tamaDatosPrimerDetalleRuta > 0) { ?>
                        <p></p>

                        <div id="informacionAlerta">
                            <fieldset style="border-color:#336699">
                                <legend><strong>INFORMACIÓN DE LA ALERTA</strong></legend>


                                <table width="100%" border="0">

                                    <tr>
                                        <td>
                                            <b>Fecha y Hora Primer Alerta:</b>
                                        </td>
                                        <td><?php echo  $datosPrimerDetalleAlerta[0]['fecha'] ?></td>

                                        <td>
                                            <b>Coordenadas:</b>
                                        </td>
                                        <td><?php echo  $datosPrimerDetalleAlerta[0]['latGoeAlerta'] . "," . $datosPrimerDetalleAlerta[0]['lonGoeAlerta'] ?>
                                        </td>
                                    </tr>

                                    <?php

										$fechaUltimaAlerta = $datosPrimerDetalleAlerta[0]['fecha'];
										$coordenadasUltimaAlerta = $datosPrimerDetalleAlerta[0]['latGoeAlerta'] . "," . $datosPrimerDetalleAlerta[0]['lonGoeAlerta'];

										if ($tamaDatosUltimaDetalleRuta > 0) {

											$fechaUltimaAlerta = $datosUltimoDetalleAlerta[0]['fecha'];
											$coordenadasUltimaAlerta = $datosUltimoDetalleAlerta[0]['latGoeAlerta'] . "," . $datosUltimoDetalleAlerta[0]['lonGoeAlerta'];
										}

										?>

                                    <tr>
                                        <td>
                                            <b>Fecha y Hora Ultima Alerta:</b>
                                        </td>
                                        <td><?php echo  $fechaUltimaAlerta ?></td>

                                        <td>
                                            <b>Coordenadas:</b>
                                        </td>
                                        <td><?php echo  $coordenadasUltimaAlerta ?></td>
                                    </tr>


                                </table>

                            </fieldset>
                        </div>
                        <?php } ?>
                        <p></p>

                        <div id="" align="center">


                            <?php
							echo $btnAdministrar;


							?>

                        </div>


                        <p></p>

                        <div id="accionTomada">


                            <fieldset style="border-color:#336699">
                                <legend><strong>RESUMEN ACCIÓN TOMADA</strong></legend>


                                <table width="100%" border="0">

                                    <tr>
                                        <td>
                                            <b>Descripcion:</b>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td>

                                            <textarea id="textAreaAccionTomada" class="inputSombra"> </textarea>
                                        </td>
                                    </tr>
                                </table>

                            </fieldset>
                            <p></p>
                            <div id="" align="center">
                                <input type="button" value="Guardar" id="btnModificarEstadoRuta" class="boton_save">

                            </div>
                        </div>




                    </div>
                </div>
            </div>

        </div>

</body>

<script>
let idRuta = <?= $idRuta  ?>;
console.log(idRuta);

$(document).ready(function() {
    $("#btnAdministrar").click(mostrarAccionTomada);
    document.getElementById("accionTomada").style.display = "none";
});

function mostrarAccionTomada() {
    var jsEstado = <?php echo "'" . $estadoRuta . "'"; ?>;
    var jsActiva = <?php echo "'" . $activa . "'"; ?>;



    document.getElementById("btnAdministrar").style.display = "none";
    if (jsEstado == jsActiva) {

        document.getElementById("accionTomada").style.display = "block";
        document.getElementById("textAreaAccionTomada").style.padding =
            "3px 0px"; //redusco el paddin para que no se salga
        $("#btnModificarEstadoRuta").click(modificarEstadoRuta);
    }

}


function modificarEstadoRuta() {
    var accionTomada = document.getElementById("textAreaAccionTomada").value;



    $.post('modicarEstado.php', {
            idRuta: idRuta,
            accionTomada: accionTomada
        },
        function(data, textStatus, xhr) {

            console.log(data);




            datos = JSON.parse(data);

            if (datos.estado == 1) {
                parent.parent.location.reload(true);
                parent.parent.GB_hide();


            }


        });







}
</script>

</html>