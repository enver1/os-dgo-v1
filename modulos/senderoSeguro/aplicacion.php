<script src="modulos/senderoSeguro/js/procesos.js"></script>
<!--LIBRERIAS DE FIREBASE -->
<!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
<script src="modulos/senderoSeguro/js/firebase/firebase-app.js"></script>

<!-- Add Firebase products that you want to use -->
<script src="modulos/senderoSeguro/js/firebase/firebase-auth.js"></script>
<script src="modulos/senderoSeguro/js/firebase/firebase-database.js"></script>
<script src="modulos/senderoSeguro/js/javaSeñalEtica.js"></script>
<!--FIN LIBRERIAS DE FIREBASE -->
<?php
if (isset($_SESSION['usuarioAuditar'])) {
	$directorio  = 'senderoSeguro'; // ** CAMBIAR **

	$tforma = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
	$treporte = $directorio . '/reporte.php';
?>

<div id='formulario'>
    <img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>
<script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
<script type="text/javascript">
$(function() {
    getregistro(0);
});

function getregistro(c) {
    var urlt = 'modulos/<?= $tforma ?>?opc=<?= $_GET['opc'] ?>&c=' + c;

    $('#formulario').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
    $('#formulario').load(urlt);
    $("html, body").animate({
        scrollTop: 0
    }, "slow");

}

function generarReporte(id) {
    var titulo = 'REPORTE';
    var url = "../../operaciones/<?= $treporte ?>?id=" + id;
    return GB_showPage(titulo, url);
}
</script>
<?php } ?>