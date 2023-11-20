<?php
class configColor{

  function ocho(){
    $colorOcho=array (
                      imagecolorallocate($imagen,255,255,0),
                      imagecolorallocate($imagen,255,0,0),
                      imagecolorallocate($imagen,255,255,100),
                      imagecolorallocate($imagen,255,255,200),
                      imagecolorallocate($imagen,100,255,0),
                      imagecolorallocate($imagen,200,255,255)
              );
    return $colorOcho;
  }
}
?>
