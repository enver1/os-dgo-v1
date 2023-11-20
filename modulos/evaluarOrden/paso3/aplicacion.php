<?php
session_start();
if (isset($_SESSION['usuarioAuditar'])) {
    include_once '../../../../clases/autoload.php';
    $formPestanasI = new FormPestanas;
    $pestanaI      = array(
        1 => array(
            'pestaN' => '1',
            'pestaD' => '3.1. Talento Humano',
        ),
        2 => array(
            'pestaN' => '2',
            'pestaD' => '3.2.  Medios Logísticos',
        ),
        3 => array(
            'pestaN' => '3',
            'pestaD' => '3.3. Operaciones Realizadas',
        ),
    );
    $nPesI = count($pestanaI);
    echo '<link href="../../../../../css/stylePesta.css" rel="stylesheet" type="text/css" />';
    $nombre = '';
    $camposOcultos = array(
        'idOrden' => 0,
    );
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