<?php
session_start();
if (isset($_SESSION['usuarioAuditar'])) {
    include_once '../../../../clases/autoload.php';
    $formPestanasI = new FormPestanas;
    $pestanaI      = array(
        1 => array(
            'pestaN' => '1',
            'pestaD' => '5.1. Talento Humano',
        ),
        2 => array(
            'pestaN' => '2',
            'pestaD' => '5.2. Agregaciones',
        ),
        3 => array(
            'pestaN' => '3',
            'pestaD' => '5.3. Medios Logísticos',
        ),
    );
    $nPesI = count($pestanaI);
    echo '<link href="../../../../../css/stylePesta.css" rel="stylesheet" type="text/css" />';
    $nombre = '';
    $camposOcultos = array(
        'idOrden' => 0,
    );
    // $formPestanasI->mostrarFormPestanas($pestanaI, $camposOcultos, $nombre);
    $formPestanasI->mostrarFormPestanasInternas($pestanaI, $camposOcultos, "pestaI");
    include_once 'js/ajaxuidPestaInterno.php';
} else {
    header('Location: indexSiipne.php');
}
?>
<script>
    $(document).ready(function() {
        pestaI(1);
    });
</script>