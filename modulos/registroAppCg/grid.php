<?php
include_once 'config.php';
include_once '../clases/autoload.php';
include_once '../funciones/funciones_generales.php';
$encriptar           = new Encriptar;
$FormRegistroAspectoAppCg = new FormRegistroAspectoAppCg;
$RegistroAspectoAppCg     = new RegistroAspectoAppCg;
$idcampo             = $RegistroAspectoAppCg->getIdCampo(); //Primary Key Table
$gridS               = $FormRegistroAspectoAppCg->getGrillaRegistroAspectoAppCg(); //Campos de la Grilla
$columnas            = count($gridS) + 2;

$data = $RegistroAspectoAppCg->getRegistroAspectoAppCg();

$simple = isset($simple) ? $simple : 0;
if ($simple == 1) {
    $columnas = count($gridS);
} else {
    $columnas = count($gridS) + 2;
}
if (isset($colBusca)) {
    $colBusca = $colBusca;
} else {
    $colBusca = 2;
}
if (!empty($data)) {
    echo '<table id="my-tbl" class="display cell-border compact" style="width:99%">';
    echo '<thead>';
    echo '<tr>';
    foreach ($gridS as $campos => $valor) {
        echo '<th class="data-th" style="font-size:11px;">' . $campos . '</th>';
    }
    if ($simple != 1) {
        echo '<th class="data-th">Acciones</th>';
        echo '<th class="data-th">Ver Imagen</th>';
    }
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    foreach ($data as $row) {
        echo "<tr>";
        foreach ($gridS as $campos => $valor) {
            $idGenPersona = isset($row['idGenPersona']) ? $row['idGenPersona'] : '';
            if (isset($row['idGenAcceso']) && $row['idGenAcceso'] == 1) {
                echo '<td style="color:#900;font-weight:bold">' . $row[$valor] . '</td>';
            } else {
                echo '<td style="font-size:11px">' . $row[$valor] . '</td>';
            }
        }
        if (isset($_SESSION['privilegios']) && substr($_SESSION['privilegios'], 1, 1) == 1) {
            if ($simple != 1) {
                echo '<td>
                          <a href="javascript:void(0)" onclick="getregistro(\'' . $encriptar->getEncriptar($row[$idcampo], $_SESSION['usuarioAuditar']) . '\')"><center><img src="../imagenes/btnEditar.png" width="20" height="20"></center></a>
                          <a href="javascript:void(0)" onclick="delregistro(\'' . $encriptar->getEncriptar($row[$idcampo], $_SESSION['usuarioAuditar']) . '\')"><center><img src="../imagenes/btnEliminar.png" width="20" height="20"></center></a>
                          </td>';

                if (!empty($row['nombreImagen']) && isset($row['nombreImagen'])) {
                    $foto = explode('.', $row['nombreImagen']);
                    if (!empty($foto[1])) {
                        $path = FuncionesGenerales::getPathAlmacenamiento('descargas/comandoGeneral/appCg/') . $row['nombreImagen'];
                        $tipo = $encriptar->getEncriptar($foto[1], $_SESSION['usuarioAuditar']);
                        $param = $encriptar->getEncriptar($path, $_SESSION['usuarioAuditar']);
                        $imagen = "/includes/visualiza.php?tipo=' . $tipo . '&param=' . $param.'";
                        echo '<td style="text-align:center"><a href="' . $imagen . '" onclick="return GB_showPage(\'Imagen\', this.href)" target="_blank"class="btn btn-danger pull-right"><span class="glyphicon glyphicon-file"</span><img src="../imagenes/btnVer.png" width="20" height="20"></a></td>';
                    } else {
                        echo '<td style="width:25px"></td>';
                    }
                } else {
                    echo '<td style="width:25px"></td>';
                }
            }
        } else {
            echo '<td style="width:25px"></td>';
        }
    }
    echo '</tr></tbody></table>';
}
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#my-tbl').DataTable({
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "_START_ al _END_ de _TOTAL_ registros",
                "sInfoEmpty": "0 al 0 de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad"
                }
            },
            pagingType: "full_numbers",
            scrollY: true,
            paging: true,
            scrollCollapse: true,
            processing: true,
            order: [],
            columnDefs: [{
                targets: -1,
                orderable: false
            }]
        });
    });
</script>