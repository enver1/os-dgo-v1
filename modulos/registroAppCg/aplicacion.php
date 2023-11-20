<?php
if (isset($_SESSION['usuarioAuditar'])) {
    include_once 'config.php';
    include_once '../clases/autoload.php';
    $RegistroAspectoAppCg      = new RegistroAspectoAppCg;
    $encriptar       = new Encriptar;
    $sqltable        = $encriptar->getEncriptar($RegistroAspectoAppCg->getSqlRegistroAspectoAppCg(), $_SESSION['usuarioAuditar']);
    $tgrid           = $directorio . '/grid.php'; // php para mostrar la grid
    $tforma          = $directorio . '/formulario.php'; // php para mostrar el formulario en la parte superior
    $tborra          = $directorio . '/borra.php'; // php para borrar un registro
    $tgraba          = $directorio . '/graba.php'; // php para grabar un registro
    $tprint          = $directorio . '/imprime.php'; // nombre del php que imprime los registros
    $verificaUsuario        = $RegistroAspectoAppCg->getVerificaUsuarioAppCg($_SESSION['usuarioAuditar']);
    $idGenUsuario = isset($verificaUsuario['idGenUsuario']) ? $verificaUsuario['idGenUsuario'] : 0;
    if ($verificaUsuario > 0) {
?>
        <script type="text/javascript" src="js/sweetalert2/sweetalert2.all.min.js"></script>
        <link href='js/sweetalert2/sweetalert2.min.css' rel="stylesheet" type="text/css">
        <link href='css/estilosbs.css' rel="stylesheet" type="text/css">
        <div class="contenedor" style="width:99%">
            <div class="dheader2">
                <!-- <center>AMBITO DE GESTIÓN</center> -->
            </div>
            <div class="dbody">
                <table width="98%" border="0">
                    <tr>
                        <td style="vertical-align:top;">
                            <div id='formulario'>
                                <img src="../funciones/paginacion/images/ajax-loader.gif" />
                            </div>
                            <div id="retrieved-data">
                                <img src="../funciones/paginacion/images/ajax-loader.gif" />
                            </div>
                        </td>
                    </tr>

                </table>
            </div>
            <div class="dfoot">
            </div>
        </div>
<?php
        include_once '../js/ajaxuidGenerico.php'; // Este archivo contiene las funciones de ajax para update, insert, delete, y edit
    } else {
        die('<p class="col3" style="width:90%;margin:5px auto;"><span class="texto_azul" style="font-size:12px">El Usuario NO  se encuentra registrado en la APPCG. Favor Tome Contacto con el Subadministrador</span></p>');
    }
} else {
    header('Location: indexSiipne.php');
}
?>
<script type="text/javascript" src="<?php echo '../' . $directorio ?>/validacion.js"></script>