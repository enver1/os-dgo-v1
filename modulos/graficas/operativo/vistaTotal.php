<?php
header("Content-type: image/png");
include_once('../../../clases/autoload.php');
$conn = DB::getConexionDB();
$cont = new control;
$fini = $_GET['fini'];
$ffin = $_GET['ffin'];
$geo = $_GET['lugar'];
$rowJT = $cont->zona($conn, $fini, $ffin, $geo);

$y = 300;
$contador = 60;
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
for ($i = 0; $i < count($rowJT); $i++) {
    imagefilledellipse($imagen, 160, $contador, 20, 20, $color[$i]);
    imagettftext($imagen, 12, 0, 180, $contador + 10, $y - 70, $fuentes, $nom[$i]);
    imagettftext($imagen, 12, 0, 310, $contador + 10, $y - 70, $fuentes, $rowJT[$i]);
    $contador += 30;
}



imagepng($imagen);
imagedestroy($imagen);
