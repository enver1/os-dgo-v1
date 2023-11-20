
<?php

if (file_exists(dirname(dirname(dirname(dirname(__DIR__))))."/clases/controlador/claseDB.php")) {
    include_once dirname(dirname(dirname(dirname(__DIR__)))).'/clases/autoload.php';
    $obj=true;	
}
else {
    include_once dirname(dirname(dirname(dirname(__DIR__)))).'/funciones/db_connect.inc.php';
    include_once dirname(dirname(dirname(dirname(__DIR__)))).'/clases/autoload.php';
    $obj=false;
}

if($obj) $forma = new Form();
if($obj==false) $forma = new Forma();

$campos = array(
	array(
                'tipo'        => 'textArea',
                'etiqueta'    => 'Documento Autorización:',
                'campoTabla'  => 'docuAutorizado1',
                'maxChar'     => '300',
                'ancho'       => '300',
                'alto'        => '50',
                'soloLectura' => 'false'),
    array(
                'tipo'        => 'checkArreglo',
                'etiqueta'    => ' ',
                'campoTabla'  => 'cdocuAutorizado1',
                'columnas'    => 1,
                'valores'     => array('Incluir'),
                'maxChar'     => '300',
                'ancho'       => '300',
                'alto'        => '50',
                'soloLectura' => 'false'),    

array(
                'tipo'        => 'checkArreglo',
                'etiqueta'    => ' ',
                'campoTabla'  => 'cgenEstado1',
                'columnas'    => 1,
                'valores'     => array('Incluir'),
                'maxChar'     => '300',
                'ancho'       => '300',
                'alto'        => '50',
                'soloLectura' => 'false'),    
);

$datos= null;
?>

<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
<table>
<?php
	if($obj) $forma->campoFormulario($campos, $datos);
	if($obj==false) $forma->campoFormulario($conn,$campos, $datos);
?>
<tr><td></td><td><button id="guarda">Aceptar</button><button id="cancela">Cancelar</button>
<input type="hidden" id="prv" name="prv" value="<?php print_r($_SESSION['privilegios']); ?>">
</td></tr>
</table>
  </div>

</div>
