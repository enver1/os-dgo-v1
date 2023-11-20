<?php
if (isset($_SESSION['usuarioAuditar'])) {
	include_once('config.php');
	$tgrid = $directorio . '/grid.php'; // php para mostrar la grid
	$tforma = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
	$tborra = $directorio . '/borra.php'; // php para borrar un registro
	$tgraba = $directorio . '/graba.php'; // php para grabar un registro
	$tprint = $directorio . '/imprime.php'; // nombre del php que imprime los registros
?>
<script>
function getregistroL(c) {
    //alert('dd');
    var urlt = 'modulos/<?php echo $tforma ?>?opc=<?php echo $_GET['opc'] ?>&c=' + c;
    $('#formulario').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
    $('#formulario').load(urlt);
    $('#actividades').html('');
    $("html, body").animate({
        scrollTop: 0
    }, "slow");

}

function getregistroDet(c) {
    var urlt = 'modulos/<?php echo $tforma ?>?opc=<?php echo $_GET['opc'] ?>&c=' + c;
    $('#formulario').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
    $('#formulario').load(urlt);
    $('#actividades').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
    $('#actividades').load('modulos/actunidad/gridInstrucciones.php?opc=' + c);
    $("html, body").animate({
        scrollTop: 0
    }, "slow");

}

function getdataDet(c) {
    var a = $('#idDgoProcSuper').val();
    var urlt = 'modulos/actunidad/gridInstrucciones.php?opc=' + a + '&c=' + c;
    $('#actividades').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
    $('#actividades').load(urlt);
    $("html, body").animate({
        scrollTop: 0
    }, "slow");

}

function detaInstru() {
    var $inputs = $('#detalleI :input');
    var values = {};
    $inputs.each(function() {
        if (this.type == 'checkbox') {
            values[this.name] = (this.checked ? $(this).val() : "0");
        } else {
            values[this.name] = $(this).val();
        }
    });
    /*    */
    var result = '';
    var $forma = $('html,body');
    $.ajax({
        type: "POST",
        url: "modulos/actunidad/grabaInstru.php",
        data: values,
        async: false,
        success: function(response) {
            result = response;
            if (result.trim() != '')
                alert(result);
            else {
                //var urlt = 'modulos/actunidad/gridInstrucciones.php?opc='+$('#idDgoProcSuper').val()+'&c='+$('#idDgoActividad').val()+'&preg='+$('#idDgoInstrucci').val();  
                //$('#formulario',parent.parent.window.document).html('<p>HEY</p>');
                //$('#formulario',parent.parent.window.document).load( urlt );
                $("html, body").animate({
                    scrollTop: 0
                }, "slow");
            }
        }
    });

}
</script>
<script type="text/javascript" src="<?php echo $directorioC ?>/validacion.js"></script>
<div id='formulario'>
    <img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>
<div id='actividades'>
</div>
<div id='retrieved-data'>
    <img src="../funciones/paginacion/images/ajax-loader.gif" />
</div>
<?php include_once('../js/ajaxuid.php'); // Este archivo contiene las funciones de ajax para update, insert, delete, y edit 
} else
	header('Location: imprime.php');
?>