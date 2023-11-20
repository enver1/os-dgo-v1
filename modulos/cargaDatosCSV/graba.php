<?php
header('Content-Type: application/json');
session_start();
if (isset($_SESSION['usuarioAuditar'])) {
    include '../../../funciones/db_connect.inc.php';
    include '../../../clases/autoload.php';
    include_once '../../../funciones/funcion_upload.php';

    $uploadDataCSV = new UploadDataCSV();
    $dgoDatos      = new DgoDatos();

    $anio = $_POST['cedula'];
    $mes  = $_POST['numerico'];
    $tipo = $_POST['numerico1'];

    if (!isset($_FILES['myfile'])) {
        echo json_encode(array('success' => false, 'message' => 'No existe archivo.'));
        exit();
    }

    $_POST['usuarioAuditar'] = $_SESSION['usuarioAuditar'];
    $fileSize                = $_POST['fileSize'];
    /*--Se sube el archivo al Servidor de Aplicaciones--*/
    //$uploaddir  = '/var/www/html/siipne3/descargas/operaciones/cargaDatosCSV/';
    //$uploaddir = '../../../descargas/operaciones/cargaDatosCSV/';
    $uploaddir = FuncionesGenerales::getPathAlmacenamiento('../../../descargas/operaciones/cargaDatosCSV/');
    $nomArchivo = subirArchivo1('myfile', $uploaddir, $fileSize, 'csv', 'Archivo de Datos', 'igual_name');

    if ($nomArchivo[0] != 1) {
        echo json_encode(array('success' => false, 'message' => $nomArchivo[1]));
        exit();
    }

    $respuesta = $dgoDatos->eliminarDatos($anio, $mes, $tipo);

    if (!$respuesta['success']) {
        echo json_encode($respuesta);
        exit();
    }

    $_POST['texto24'] = 'CURSANTE';
    $camposaux        = 'texto1,texto2,texto3,texto4,texto5,texto6';
    $tStructure       = array(
        'cedula'    => 'cedula',
        'numerico'  => 'numerico',
        'numerico1' => 'numerico1',
        'texto24'   => 'texto24',
    );

    $respuesta = $uploadDataCSV->subirDatos($conn, $ambsiipne, $serverarch, $username, $claveuser, $uploaddir, $nomArchivo[1], $camposaux, $_POST, $tStructure);

    //echo json_encode($respuesta);

    if (!$respuesta['success']) {
        echo json_encode($respuesta);
        exit();
    }

    $respuesta = $dgoDatos->validarDatos($anio, $mes, $tipo);

    if (!$respuesta['success']) {
        echo json_encode($respuesta);
        exit();
    }

    $respuesta = $dgoDatos->cargarNotas($anio, $mes, $tipo);

    echo json_encode($respuesta);
    exit();
}
