<?php
include_once 'config.php';
include_once '../clases/autoload.php';
include_once '../funciones/db_connect.inc.php';
$encriptar            = new Encriptar;
$formDgoInfOrdenServicio = new FormDgoInfOrdenServicio;
$DgoInfOrdenServicio     = new DgoInfOrdenServicio;
$ambitoGestionOrden      = new AmbitoGestionOrden;
$gridS = $formDgoInfOrdenServicio->getGrillaDgoInfOrdenServicio();
$datosUsuario =    $ambitoGestionOrden->getDatosUsuariosSenplades($_SESSION['usuarioAuditar']);
//$data      = $encriptar->getEncriptar($DgoInfOrdenServicio->getSqlDgoInfOrdenServicio($datosUsuario['idGenGeoSenplades']), $_SESSION['usuarioAuditar']);
$data = $DgoInfOrdenServicio->getDgoInfOrdenServicio($datosUsuario['idGenGeoSenplades']);
$idcampo = $DgoInfOrdenServicio->getIdCampo();
$simple = isset($simple) ? $simple : 0;
?>
<hr><br>
<div>
    <span style="background-color:#fcc0c8;border:solid 1px #444;padding:2px 5px;font-size:9px">&nbsp;
    </span>Informes en Estado Temporal
    &nbsp;&nbsp;
    <span style="background-color:#ffffff;border:solid 1px #444;padding:2px 5px;font-size:9px">&nbsp;
    </span> Informes Generadas
    &nbsp;&nbsp;
</div>
<br>
<?php
echo '<table id="my-tbl" class="display cell-border compact" style="width:100%;font-size:11px">';
echo '<thead>';
echo '<tr>';
foreach ($gridS as $campos => $valor) {
    echo '<th class="data-th">' . $campos . '</th>';
}
if ($simple != 1) {
    echo '<th class="data-th">Seleccionar</th>';
}
echo '</tr>';
echo '</thead>';
echo '<tbody>';
foreach ($data as $row) {
    echo "<tr>";
    foreach ($gridS as $campos => $valor) {
        if (($row['estadoInforme'] == 'TEMPORAL')) {
            $estilo = 'style="background-color:#fcc0c8; color:black"';
        } else {
            $estilo = 'style="background-color: #ffffff; color:black"';
        }
        echo '<td ' . $estilo . '">' . $row[$valor] . '</td>';
    }
    if (isset($_SESSION['privilegios']) && substr($_SESSION['privilegios'], 1, 1) == 1) {
        if ($simple != 1) {
            if ($row['estadoInforme'] == 'TEMPORAL') {
                echo '<td><a href="javascript:void(0)" onclick="getregistro(\'' . $encriptar->getEncriptar($row[$idcampo], $_SESSION['usuarioAuditar']) . '\')"><center><img src="../imagenes/btnEditar.png" width="20" height="20"></center></a>
                <a href="javascript:void(0)" onclick="delregistro(\'' . $encriptar->getEncriptar($row[$idcampo], $_SESSION['usuarioAuditar']) . '\')"><center><img src="../imagenes/btnEliminar.png" width="20" height="20"></center></a>
                ';
            } else {
                echo '<td><a href="javascript:void(0)" onclick="imprimir(' . $row[$idcampo] . ')"><center><img src="../imagenes/btnBuscar.png" width="20" height="20"></center></a>  <a href="javascript:void(0)" onclick="delregistro(\'' . $encriptar->getEncriptar($row[$idcampo], $_SESSION['usuarioAuditar']) . '\')"><center><img src="../imagenes/btnEliminar.png" width="20" height="20"></center></a>
                ';
            }
        }
    } else {
        echo '<td style="width:25px"></td>';
    }

    echo '</tr>';
}
echo '</tbody></table>';
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
            scrollX: true,
            scrollY: 1000,
            scrollCollapse: true,
            order: [],
            columnDefs: [{
                targets: -1,
                orderable: false
            }]
        });
    });
</script>