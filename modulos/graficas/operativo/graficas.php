<?php
header("Content-type: image/png");

$y = 300;
$contador = 120;
//CREO array PARA SIMULAR UNA BASE DE DATOS
$fila = array(10, 14, 19, 30, 70, 60, 50, 100);
$mes = array("ENERO", "FEBRERO", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE");
$valor = array("10", "14", "19", "30", "70", "60", "50", "100");

//CREO EL LIENZO DONDE SE BA A DIBUJAR PASANDO LOS PARAMETROS (X,Y)
$imagen = imagecreatetruecolor(600, $y);
//DOY COLOR AL LIENZO
$blanco = imagecolorallocate($imagen, 0, 0, 0);
//PONGO LA IMAGEN (DIMENCION CREADA,INICIO DE X, INICIO DE Y,EL COOR,EL COLOR)
imagefilltoborder($imagen, 0, 0, $blanco, $blanco);
//COPIO LA IMAGEN ()
imagecopy($imagen, imagecreatefrompng('fondo1.png'), 0, 0, 0, 0, 600, 600);
//DOY UN FILTO A LA IMAGEN CON UN FILTRO QUE TENGA UN BRILLO
imagefilter($imagen, IMG_FILTER_BRIGHTNESS, -10);
//GENERO UN COLOR PARA  EL RECTANGULO
$color = array(
    imagecolorallocate($imagen, 255, 255, 0),
    imagecolorallocate($imagen, 255, 0, 0),
    imagecolorallocate($imagen, 255, 255, 100),
    imagecolorallocate($imagen, 255, 255, 200),
    imagecolorallocate($imagen, 100, 255, 0),
    imagecolorallocate($imagen, 200, 255, 0),
    imagecolorallocate($imagen, 255, 0, 255),
    imagecolorallocate($imagen, 255, 50, 90)

);

//GENERO UN COLOR PARA LA LETRA
$negro = imagecolorallocate($imagen, 0, 0, 0);

//CREO VARIABLES PARA TIPO DE LETRA
//$texto="bienvenido a pruebas";
$fuente = "./cuyabra.otf";
$fuentes = "./cuyabra.otf";
//CREO UN CICLO PARA QUE SEA DINAMICO
for ($i = 0; $i < count($fila); $i++) {
    //CREO LOS RECTANGULOS PARA LAS GRAFICAS

    imagefilledrectangle($imagen, $contador, $y - 70, $contador + 10, ($y - 70 - $fila[$i]), $color[$i]);
    imagettftext($imagen, 10, -45, $contador, 250, $y - 70, $fuentes, $mes[$i]);
    //CREO EL TEXTO PARA LA GRAFICA

    //CREO EL TEXTO DEL NUMERO
    imagettftext($imagen, 8, -90, $contador, 210, $y - 70, $fuentes, $valor[$i]);
    $contador += 20;
}


imagepng($imagen);
//con esto cierro memoria
imagedestroy($imagen);
