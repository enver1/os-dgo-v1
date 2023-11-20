<?php
session_start();
include_once '../../../../../clases/autoload.php';
$conn = DB::getConexionDB();
$dgoEjemplarOrden  = new DgoEjemplarOrden;
$encriptar         = new Encriptar;
$transaccion = new Transaccion;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SIIPNE 3w</title>
    <link href="../../../../../../css/siipne3.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../../../../../../js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="../../../../../../js/datatables.min.js"></script>
    <link href="../../../../../../js/datatables.min.css" rel="stylesheet" type="text/css" />
    <style>
        a.boton-unase-seleccionar {
            color: #252525;
            display: block;
            font: bold 11px Verdana, arial, sans-serif;
            margin-right: 6px;
            text-align: center;
            text-decoration: none;
            background: #d2d2d2;
            border: solid 1px #36F;
            border-radius: 7px 7px 7px 7px;
            -moz-border-radius: 7px 7px 7px 7px;
            -webkit-border-radius: 7px 7px 7px 7px;
        }

        a.boton-unase-seleccionar:hover {
            background: #69C;
            -webkit-box-shadow: 2px 2px 3px 0px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 2px 2px 3px 0px rgba(0, 0, 0, 0.75);
            box-shadow: 2px 2px 3px 0px rgba(0, 0, 0, 0.75);
        }
    </style>
</head>

<body>
    <div id="wraper">
        <div>
            <div class="warningmess">
                <p><strong>AYUDA: </strong> Para seleccionar haga click en el <strong> Registro</strong> correspondiente</p>
            </div>
            <div id="content">
                <div id="content_top"></div>
                <div id="content_mid">
                    <div id="contenido" style="width:85%">
                        <table id='my-tbl' class="table1" style="width:100%;">
                            <thead>
                                <tr>
                                    <th class="data-th">Ord.</th>
                                    <th class="data-th">Descripción</th>
                                    <th class="data-th">Destino</th>
                                    <th class="data-th">Imprimir</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $id = $_GET['id'];
                                $sql    = $dgoEjemplarOrden->getSqlDgoEjemplarOrden($id);
                                $a      = "Imprimir";
                                $rowFL  = $transaccion->consultarAll($sql,);
                                $X      = 0;

                                foreach ($rowFL as $key => $row) {
                                    $X++;
                                    echo "<tr class='data-tr' align='center' style=>";
                                    echo "<td align=left>" . $X . "</td>";
                                    echo "<td align=left>" . $row['descripcion'] . "</td>";
                                    echo "<td align=left>" . $row['destino'] . "</td>";
                                    echo '<td align=left width="16%"><a href="#" ';
                                    echo 'onclick="seleccionar(\'' .  $id . '\',\'' . $X . '\')" ';
                                    echo 'class="boton24" >' . $a . "</a></td>";
                                    echo "</tr>";
                                } ?>
                            </tbody>
                        </table>
                        <br />
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    $(document).ready(function() {
        $('#my-tbl').DataTable();
    });


    function seleccionar(idDgoOrden, ejemplar) {
        var idDgoOrdenServicio = idDgoOrden;
        var url = "../../../../modulos/crearOrden/paso9/imprimeEjemplar.php?id=" + idDgoOrdenServicio + "&ejemplar=" + ejemplar;
        var l = screen.width;
        var t = screen.height;
        var opts = 'scrollbars=yes,toolbar=no,width=' + screen.width + ',height=' + screen.height + ',top=' + t + ' ,left=' + l;
        var name = 'pdf';
        window.open(url, name, opts);
    }
</script>