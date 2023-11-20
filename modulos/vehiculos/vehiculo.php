<?php

session_start();
header('Content-Type: text/html; charset=UTF-8');
include_once('../../../clases/autoload.php');
include_once('../../../funciones/funcion_select.php');
$conn = DB::getConexionDB();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SIIPNE 3w OPERACIONES</title>
    <link href="../../../css/easyui.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/siipne3.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/menu.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../../../js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="../../../js/jquery.easyui.min.js"></script>
    <script>
        function selecciona() {
            parent.parent.document.getElementById("GenVehiculo").innerHTML = $('#descripcionVehiculo').val();
            parent.parent.document.getElementById("idGenVehiculo").value = $('#codigoVehiculo').val();
            parent.parent.GB_hide();
        }

        function elegir(codigo, nombre) {
            $('#codigoVehiculo').val(codigo);
            $('#descripcionVehiculo').val(nombre);
        }
    </script>
</head>

<body style="background-color:#fff">
    <div id="wraper">
        <div id="top">
            <div id="faux">
                <div id="content">
                    <div id="content_top"></div>
                    <div id="content_mid">
                        <div id="contenido">
                            <table width="100%" border="0">
                                <tr>
                                    <td><input type="text" name="codigoVehiculo" id="codigoVehiculo" size="8" readonly="readonly" />&nbsp;
                                        <input type="text" name="descripcionVehiculo" id="descripcionVehiculo" size="70px" readonly="readonly" />
                                        <a href="javascript:void(0)" onclick="selecciona()" class="button"><span>Seleccionar</span></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%">
                                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="frmVehiculoBuscar">
                                            <fieldset>
                                                <legend>Buscar Vehiculos</legend>
                                                <?php
                                                $ch = '';
                                                if (isset($_POST['mostrar'])) {
                                                    $ch = $_POST['mostrar'];
                                                }
                                                ?>
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <input type="radio" name="mostrar" checked="checked" value="placa" <?php if ($ch == 'placa') { ?>checked="checked" <?php } ?> />&nbsp;Placa
                                                        </td>
                                                        <td>
                                                            <input type="radio" name="mostrar" value="chasis" <?php if ($ch == 'chasis') { ?>checked="checked" <?php } ?> />&nbsp;Chasis
                                                        </td>
                                                        <td>
                                                            <input type="radio" name="mostrar" value="motor" <?php if ($ch == 'motor') { ?>checked="checked" <?php } ?> />&nbsp;Motor
                                                        </td>
                                                    </tr>
                                                </table>
                                                <table width="100%">
                                                    <tr>
                                                        <td width="40%">
                                                            <input type="text" value="<?php echo isset($_POST['txt_buscar']) ? $_POST['txt_buscar'] : ''; ?>" size="40" name="txt_buscar" />
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0)" onclick="$('#frmVehiculoBuscar').submit();" class="button"><span>Buscar</span></a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </fieldset>
                                        </form>
                                        <?php
                                        if (isset($_POST['mostrar'])) {

                                            $sql = "SELECT 
						genVehiculo.idGenVehiculo,
						genVehiculo.{$_POST['mostrar']},
						genEstVehi.descripcion as estado,
						genModelo.descripcion as modelo,
						genMarca.descripcion as marca
						FROM genVehiculo
						INNER JOIN genEstVehi ON genVehiculo.idGenEstVehi = genEstVehi.idGenEstVehi
						INNER JOIN genModelo ON genVehiculo.idGenModelo = genModelo.idGenModelo
						INNER JOIN genMarca ON genModelo.idGenMarca = genMarca.idGenMarca
						WHERE LENGTH(genVehiculo.{$_POST['mostrar']}) > 0 AND genVehiculo.{$_POST['mostrar']} LIKE '%{$_POST['txt_buscar']}%'";
                                        ?>
                                            <fieldset>
                                                <legend>Resultado de la Busqueda</legend>
                                                <table width="100%">
                                                    <tr>
                                                        <th class="data-th">C&oacute;digo</th>
                                                        <th class="data-th"><?php echo ucfirst($_POST['mostrar']) ?></th>
                                                        <th class="data-th">Modelo</th>
                                                        <th class="data-th">Marca</th>
                                                        <th class="data-th">Estado</th>
                                                        <th class="data-th">&nbsp;</th>
                                                    </tr>
                                                    <?php
                                                    $rs = $conn->query($sql);
                                                    while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
                                                    ?>
                                                        <tr class='data-tr' align='center'>
                                                            <td><?php echo $row['idGenVehiculo']; ?></td>
                                                            <td><?php echo $row[$_POST['mostrar']]; ?></td>
                                                            <td><?php echo $row['modelo']; ?></td>
                                                            <td><?php echo $row['marca']; ?></td>
                                                            <td><?php echo $row['estado']; ?></td>
                                                            <td><a href="javascript:void(0)" onclick="elegir(<?php echo $row['idGenVehiculo']; ?>,'<?php echo $row[$_POST['mostrar']]; ?>');">Elegir</a>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </table>
                                            </fieldset>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="content_bot"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>