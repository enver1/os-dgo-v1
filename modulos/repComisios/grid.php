<?php
/* MUESTRA LA GRILLA EN LA PARTE INFERIOR DEL FORMULARIO */
include_once '../../clases/autoload.php';
$conn = DB::getConexionDB();
$idcampo = isset($_GET['idGenGeoSenplades']) ? $_GET['idGenGeoSenplades'] : 0;
$upc     = new Upc;

$gridS = array(
    'codigo'        => 'codigo',
    'Nombre Upc'    => 'descripcionUpc',
    'Direccion'     => 'dirUpc',
    'Correo'        => 'mailUpc',
    'Telefono'      => 'fonoUpc',
    'Subcircuito'   => 'subcircuito',
    'Actualizacion' => 'fechaRegistro',
    'Foto'          => 'Actualizada',

);
$row = $upc->getSqlActualizacionUpc($conn, $idcampo);
if (!empty($row)) {
?>
    <table id='my-tbl' style="font-size:9px;">
        <tr>
            <th class="data-th">Ord.</th>
            <?php foreach ($gridS as $campos => $valor) { ?>
                <th class="data-th"><?php echo $campos ?></th>

            <?php } ?>
            <th class="data-th">Foto UPC</th>

        </tr>
        <?php
        //loop por cada registro tomando los campos delarreglo $gridS
        $x = 1;
        for ($i = 0; $i < count($row); $i++) {
            echo "<tr class='data-tr' align='center'>";
            echo '<td>' . $x . '</td>';
            $x = $x + 1;
            foreach ($gridS as $campos => $valor) {
                if ($row[$i]['Actualizada'] == 'ACTUALIZADA') {
                    $color = '#dbe9ef';
                } else {
                    $color = '#f7bdca';
                }
                echo '<td font="color:black"style="background-color:' . $color . '">' . $row[$i][$valor] . '</td>';
            }
            if (isset($_SESSION['privilegios']) and substr($_SESSION['privilegios'], 1, 1) == 1) {
                echo '<td><a href="modulos/reportActualizacionupc/verimagen.php?idGenUpc=' . $row[$i]['codigo'] . '"
                onclick="return GB_showPage(\'Imagen UPC\', this.href)" target="_blank"
                class="btn btn-danger pull-right"
                ><span class="glyphicon glyphicon-file"</span>
                                Ver_Foto</a></td>';
            } else {
                echo '<td>&nbsp;</td>';
            }

            echo "</tr>";
        }
        ?>
    </table>
    <br />
<?php } ?>