<?php

session_start();
header('Content-Type: text/html; charset=UTF-8');

include_once '../../../clases/autoload.php';
$senderoSeguro = new SenderoSeguro;

$puntosLlegada = $senderoSeguro->getConsultarPuntoLlegada();

?>
<script type="text/javascript" src="../../../js/sha1.js"></script>
<script type="text/javascript" src="../../../js/jquery-3.5.1.min.js"></script>



<link rel="stylesheet" type="text/css" href="modulos/senderoSeguro/js/notificaciones/toastr.min.css">
<script type="text/javascript" src="modulos/senderoSeguro/js/notificaciones/toastr.min.js"></script>

<link rel="stylesheet" href="modulos/senderoSeguro/css/popup.css">


<link rel="stylesheet" href="modulos/senderoSeguro/js/leaflet/leaflet.css"
    integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
    crossorigin="" />


<script src="modulos/senderoSeguro/js/leaflet/leaflet.js"
    integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
    crossorigin=""></script>
<script src="modulos/senderoSeguro/js/leaflet/leaflet-heat.js"></script>


<script src="modulos/senderoSeguro/js/polyLine.js"></script>
<script src="modulos/senderoSeguro/js/procesos.js"></script>


<!--LIBRERIAS DE FIREBASE -->
<!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
<script src="modulos/senderoSeguro/js/firebase/firebase-app.js"></script>

<!-- Add Firebase products that you want to use -->
<script src="modulos/senderoSeguro/js/firebase/firebase-auth.js"></script>
<script src="modulos/senderoSeguro/js/firebase/firebase-database.js"></script>
<script src="modulos/senderoSeguro/js/javaSeñalEtica.js"></script>
<!--FIN LIBRERIAS DE FIREBASE -->



<form name="edita" id="edita" method="post">


    <div style="float: right">
        <a href="javascript:void(0);" onclick="generarTodasAlertasActivas()" class="col2"
            style="background-color:#DCA8A8;padding:4px 20px">
            <span id="numAlertas" class="texto_azul" style="font-size:15px"> 0 </span> Alertas

        </a>

    </div>

    <div style="float: right">
        <a href="javascript:void(0);" onclick="generarTodasRutasActivas()" class="col2"
            style="background-color:#A8DCC1;padding:4px 20px">
            <span id="numRutasActivas" class="texto_azul" style="font-size:15px"> 0 </span> Rutas Activas

        </a>

    </div>

    <table class="egt">

        <tr>



            <td>
                <div id="divFecha">
                    Fecha:
                    <input type="text" name="fechaini" id="fechaini" size="12" style="width:100px" class="inputSombra"
                        readonly="readonly" />
                    <input type="button" value="" onclick="displayCalendar(document.edita.fechaini,'yyyy-mm-dd',this)"
                        class="calendario" />
                </div>
            </td>

            <td> Punto Llegada: </td>
            <td>
                <div id="divPuntoLlegada">
                    <select id='comboPuntoLlegada' class="inputSombra">
                        <option value='0'>Todos</option>
                        <?php foreach ($puntosLlegada as $key => $row) : ?>
                        <option value="<?= $row['idGoePunLleg'] ?>"><?= $row['descGoePunLleg'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </td>

            <td><input type="button" value="Generar" id="btnGenerar" class="boton_preview" /> </td>



        </tr>


    </table>







    <table width="100%" border="0">

        <tr>
            <th colspan="2"><span class="texto_gris" style="font-size:18px" id="title"></span>
                <hr>
            </th>
        </tr>


        <tr>
            <td width="100%">
                <table width="100%">
                    <tr>
                        <td class="map" style="" align="top" id="tdMapa">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>


        <tr>
            <td width="100%" colspan="2">
                <table width="100%">
                    <tr>
                        <td align="center" id="tdRutas">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>
</form>


<table width="100%" border="0">
    <tr>

        <td>

        </td>
    </tr>

</table>



<div id="toast-container" class="toast-bottom-right">




</div>