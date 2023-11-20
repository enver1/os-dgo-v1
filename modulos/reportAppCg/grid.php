<?php
session_start();
include_once 'config.php';
include_once '../../../clases/autoload.php';
$encriptar            = new Encriptar;
$Upc     = new Upc;
$FormUnidadPolicial   = new FormUnidadPolicial;
$gridS                = $FormUnidadPolicial->grillaReporteUPC(); //Campos de la Grilla
$columnas             = count($gridS) + 2;
$idcampo              = $Upc->getIdCampoUpc();
$campo = isset($_GET['idGenGeoSenplades']) ? $_GET['idGenGeoSenplades'] : 0;
$fd = strip_tags(trim($_GET['fd']));
$fh = strip_tags(trim($_GET['fh']));
$data                 = $Upc->getDatosActualizacionUpcReporte($campo, $fd, $fh);;
$auxBE  = 0;
?>
<hr><br>
<div>
    <span style="background-color:#f5a6b3;border:solid 1px #444;padding:2px 5px;font-size:9px">&nbsp;
    </span> No Actualizado
    &nbsp;&nbsp;
    <span style="background-color:#f9f5f6 ;border:solid 1px #444;padding:2px 5px;font-size:9px">&nbsp;
    </span> Actualizado
</div>
<br>
<?php
echo '<table id="my-tbl" class="display cell-border compact" style="width:100%;font-size:9px">';
echo '<thead>';
echo '<tr>';
foreach ($gridS as $campos => $valor) {
    echo '<th class="data-th">' . $campos . '</th>';
}
echo '<th class="data-th">Ver Foto</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
foreach ($data as $row) {
    echo "<tr>";
    foreach ($gridS as $campos => $valor) {

        if (($row['Actualizada'] == 'ACTUALIZADA')) {
            $estilo = 'style="background-color:#f9f5f6; color:black"';
        } else {
            $estilo = 'style="background-color:#e87680; color:black"';
        }

        echo '<td ' . $estilo . '">' . $row[$valor] . '</td>';
    }
    $path = FuncionesGenerales::getPathAlmacenamiento('descargas/polco/upc/') . $row['foto'];
    $foto = explode('.', $row['foto']);
    $tipo = $encriptar->getEncriptar($foto[1], $_SESSION['usuarioAuditar']);
    $param = $encriptar->getEncriptar($path, $_SESSION['usuarioAuditar']);

    echo '<td style="text-align:center"><a href="/includes/visualiza.php?tipo=' . $tipo . '&param=' . $param . ' "onclick="return GB_showPage(\'Imagen Novedades\', this.href)" target="_blank"class="btn btn-danger pull-right"><span class="glyphicon glyphicon-file"</span><img src="../imagenes/btnVer.png" width="20" height="20"></a></td>';
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
            scrollCollapse: true,
            order: [],
            columnDefs: [{
                targets: -1,
                orderable: false
            }]
        });
    });
</script>