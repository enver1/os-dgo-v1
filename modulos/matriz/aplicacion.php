<?php
include_once('../funciones/db_connect.inc.php');
include_once('../funciones/funcion_select.php');
include_once('../funciones/funciones_generales.php');

$formulario = array(
	1 => array(
		'tipo' => 'comboSQL',
		'etiqueta' => 'Proceso Unidad:',
		'tabla' => 'dgoActUnidad',
		'campoTabla' => 'idDgoActUnidadX',
		'sql' => "select a.idDgoActUnidad idDgoActUnidadX, 
	CONCAT_WS(' / ',b.descripcion,c.nomenclatura) descripcion  
	FROM dgoActUnidad a, dgoProcSuper b, dgpUnidad c WHERE a.idDgoProcSuper=b.idDgoProcSuper 
	AND a.idDgpUnidad=c.idDgpUnidad AND b.idGenEstado=1",
		'onclick' => ' onchange="muestraGrid()" ',
		'soloLectura' => 'false',
		'ancho' => '400'
	),
);
?>
<script>
function muestraGrid() {
    var c = $('#idDgoActUnidadX').val();
    $('#ejes').load('modulos/matriz/muestraEjes.php?id=' + c);
    $('#detalles').html('');
    $('#matriz').html('');

}

function genMatriz(d, a) {
    var c = $('#idDgoActUnidadX').val();
    $('#matriz').load('modulos/matriz/generaMatriz.php?id=' + c + '&eje=' + d);
    $("td").each(function() {
        //Or: $.each( $("p"), function() {
        $(this).css("border", "none");
        $(this).css("background-color", "transparent");
    });
    $('#td' + a).css('border-style', 'solid');
    $('#td' + a).css('border-width', '3px');
    $('#td' + a).css('border-color', '#696969');
    $('#td' + a).css('background-color', '#FFEAEA');
    $('#detalles').html('');

}

function muestraDetalles(c) {
    var a = $('#idDgoActUnidadX').val();
    $('#detalles').load('modulos/matriz/detalles.php?id=' + c + '&activ=' + a);
    $("dic").each(function() {
        $(this).html("");
    });
    $('#d' + c).html('<img src="imagenes/circle_red_16_ns.png" border="0" alt="->">');
}
</script>
<div id="filtro" style="border-bottom:solid 3px #777;height:40px">
    <table width="100%">
        <tr>
            <td class="etiqueta">Proceso Unidad:</td>
            <td>
                <?php
				foreach ($formulario as $campos)
					generaComboSimpleSQL(
						$conn,
						$campos['tabla'],
						$campos['campoTabla'],
						'descripcion',
						isset($rowt[$campos['campoTabla']]) ? $rowt[$campos['campoTabla']] : '',
						$campos['sql'],
						$campos['onclick'],
						(empty($campos['ancho']) ? 'width:250px' : 'width:' . $campos['ancho'] . 'px')
					);

				?></td>
        </tr>
    </table>
</div>
<div id='ejes'>
</div>
<div id='matriz'>
</div>
<div id='detalles'>
</div>