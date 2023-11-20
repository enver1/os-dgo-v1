<?php
header("Content-type: image/png");
include_once('../../../clases/autoload.php');
$conn = DB::getConexionDB();
$cont = new control;
$fini = $_GET['fini'];
$ffin = $_GET['ffin'];
$geo = $_GET['lugar'];
$col = new configColor;
$rowJT = $cont->zona($conn, $fini, $ffin, $geo);

print_r($geo);
die();
$y = 300;
$contador = 120;
$imagen = imagecreatetruecolor(600, $y);
$blanco = imagecolorallocate($imagen, 0, 0, 0);
imagefilltoborder($imagen, 0, 0, $blanco, $blanco);
imagecopy($imagen, imagecreatefrompng('fondo1.png'), 0, 0, 0, 0, 600, 600);
imagefilter($imagen, IMG_FILTER_BRIGHTNESS, -100);
$nom = array('OPERATIVOS', 'REGISTROS', 'PERSONAS', 'VEHICULOS', 'ROBADOS', 'BOLETAS');
$color = array(
  imagecolorallocate($imagen, 255, 255, 0),
  imagecolorallocate($imagen, 255, 0, 0),
  imagecolorallocate($imagen, 255, 255, 100),
  imagecolorallocate($imagen, 255, 255, 200),
  imagecolorallocate($imagen, 100, 255, 0),
  imagecolorallocate($imagen, 200, 255, 255)
);
$negro = imagecolorallocate($imagen, 0, 0, 0);
$fuente = "./cuyabra.otf";
$fuentes = "./cuyabra.otf";
$cc = $col->ocho();
for ($i = 0; $i < count($rowJT); $i++) {

  imagefilledrectangle($imagen, $contador, $y - 70, $contador + 40, ($y - 70 - ($rowJT[$i]) / 300), $color[$i]);
  imagettftext($imagen, 10, -45, $contador + 10, 240, $y - 70, $fuentes, $nom[$i]);
  imagettftext($imagen, 10, -90, $contador + 10, 180, $y - 70, $fuentes, $rowJT[$i]);
  $contador += 60;
}



imagepng($imagen);
imagedestroy($imagen);
