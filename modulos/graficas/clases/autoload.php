<?php

    function carga($class){

      include  $class.'.php';

    }

    spl_autoload_register('carga');
?>
