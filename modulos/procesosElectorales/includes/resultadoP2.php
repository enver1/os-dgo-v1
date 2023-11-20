<?php
include_once '../../clases/autoload.php';
$encriptar = new Encriptar;
$simple    = isset($simple) ? $simple : 0;
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

$columna = $encriptar->getEncriptar($colBusca, $_SESSION['usuarioAuditar']);
$btn     = isset($_GET['btn']) ? $_GET['btn'] : 0;
if (!empty($rs)) {
    echo '<table id="my-tbl">';
    echo '<tr>';
    echo '        <td class="data-th" align="right" style="font-size:11px;" colspan="' . ($columnas - 3) . '"><strong>B&uacute;squeda:&nbsp;</strong></td>';
    echo '        <td class="data-th" align="right" style="font-size:11px;" colspan="3">';
    echo '            <input type="hidden" name="columna" id="columna" value="' . $columna . '"></input>';
    echo '            <input type="text" name="criterio" id="criterio" value="' . (isset($_GET['busqueda']) ? $_GET['busqueda'] : '') . '" style="width:150px;color: #000000;"/>';
    echo '                <a href="javascript:void(0)" onclick="buscaCriterioGrid()"><img src="../imagenes/ver.png" alt="0" border="0" /></a>';
    echo '        </td>';
    echo '    </tr>';
    echo '<tr>';

    foreach ($gridS as $campos => $valor) {
        echo '<th class="data-th" style="font-size:11px;">' . $campos . '</th>';
    }
    if ($simple != 1) {

        echo '<th class="data-th" style="font-size:11px; width: 90px;">Editar</th>';

    }
    echo '</tr>';

    while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr class='data-tr' align='center' style='font-size:11px;'>";
        foreach ($gridS as $campos => $valor) {
            if (isset($_GET['busqueda']) && !empty($_GET['busqueda']) && strpos(trim(strtoupper($row[$valor])), strtoupper($_GET['busqueda'])) !== false) {
                echo '<td><span style="color:#ff0000;background-color:#ffff22">' . $row[$valor] . '</span></td>';
            } else {
                if (isset($row['idGenAcceso']) && $row['idGenAcceso'] == 1) {
                    echo '<td style="color:#900;font-weight:bold">' . $row[$valor] . '</td>';
                } else {
                    echo '<td>' . $row[$valor] . '</td>';
                }
            }
        }

        if (isset($_SESSION['privilegios']) && substr($_SESSION['privilegios'], 2, 1) == 1 && $btn == 0) {
            if ($simple != 1) {
                echo '<td><a href="javascript:void(0);" onclick="getregistro(\'' . $encriptar->getEncriptar($row[$idcampo], $_SESSION['usuarioAuditar']) . '\')">Editar</a></td>';
            }
        } else {
            echo '<td>&nbsp;</td>';
        }

    

    }
    echo '</table>';
}
