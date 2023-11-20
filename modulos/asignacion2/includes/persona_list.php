<?php
include '../../../../funciones/funciones_generales.php';
include '../../../../clases/autoload.php';
$conn = DB::getConexionDB();
$boton = false;
if (isset($_GET['boton']) and $_GET['boton'] == "2")
  $boton = true;
$filtro = '';
$paraPolicias = true;
if (isset($_GET['policia']))
  switch ($_GET['policia']) {
    case sha1(2):
      $filtro = "  ";
      $paraPolicias = false;
      break;
    case sha1(0):
      $filtro = " and idDgpTipoSituacion in ('A','B','T','D')  ";
      break;
    case sha1(1):
      $filtro = " and idDgpTipoSituacion in ('A','T','D')  ";
      break;
    case sha1(3):
      $filtro = " and idDgpTipoSituacion in ('A')  ";
      break;
    case sha1(4):
      $filtro = " and idDgpTipoSituacion in ('B')  ";
      break;
    default:
      $filtro = "  ";
      $paraPolicias = false;
      break;
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>SIIPNE 3w</title>
  <link href="../../../../css/siipne3.css" rel="stylesheet" type="text/css" />
  <script>
    function seleccionarBoton2(c) {
      /* Una vez seleccionada la persona pone el valor del documento en el campo cedula hace click en buscar de la pantalla padre y cierra la ventana Greybox */
      parent.parent.document.getElementById('cedulaSancionador').value = c;
      parent.parent.document.getElementById('Buscar2').onclick();
      parent.parent.GB_hide();
    }

    function seleccionar(c) {
      /* Una vez seleccionada la persona pone el valor del documento en el campo cedula hace click en buscar de la pantalla padre y cierra la ventana Greybox */
      //  alert('Selecionar  '+c);
      parent.parent.document.getElementById('cedula').value = c;
      parent.parent.document.getElementById('Buscar').onclick();
      parent.parent.GB_hide();
    }

    function validar(thisform) {
      /* Valida que se ingresen 4 o mas caracteres en la busqueda*/
      var field = thisform.apellido1;
      var alerttxt = 'El campo de busqueda ';
      with(field) {
        if (value == null || value == "") {
          alert(alerttxt + ' no puede estar en blanco');
          return false;
        } else {
          if (value.length < 3) {
            alert(alerttxt + ' debe tener al menos 3 caracteres');
            return false;
          } else {
            return true;
          }
        }
      }
    }
  </script>
</head>

<body>
  <div id="wraper">
    <div id="faux">
      <div class="warningmess">
        <p><strong>AYUDA: </strong> Para buscar una persona puede ingresar los apellidos y nombres completos <strong>(Zambrano Ortega Juan Carlos)</strong> o puede digitar un apellido y un nombre <strong>(Zambrano%Juan)</strong>; luego de click en Buscar. Para seleccionar una persona de click en la <strong>c&eacute;dula</strong> correspondiente</p>
      </div>
      <div id="content">
        <div id="content_top"></div>
        <div id="content_mid">
          <div id="contenido">
            <div id='formpersona'>
              <form name="persona" id="persona" method="get" onSubmit="return validar(this);">
                <table class="tabla1" style="width:950px">
                  <tr>
                    <td>* Apellidos y Nombres:</td>
                    <td colspan="2">
                      <input type="text" style="text-transform:uppercase;" name="apellido1" id="apellido1" value="<?php echo isset($_GET['apellido1']) ? $_GET['apellido1'] : '' ?>" size="60" />
                      <input type="hidden" name="policia" id="policia" value="<?php echo isset($_GET['policia']) ? $_GET['policia'] : 0 ?>" />
                      <input type="hidden" name="activo" id="activo" value="<?php echo isset($_GET['activo']) ? $_GET['activo'] : 0 ?>" />
                      <input type="hidden" name="boton" id="boton" value="<?php echo isset($_GET['boton']) ? $_GET['boton'] : 0 ?>" />
                    </td>
                    <td><input type="submit" value="Buscar" class="boton_general" /></td>
                  </tr>
                  <tr>
                    <td colspan="4">
                      <hr />
                    </td>
                  </tr>
                </table>
              </form>
            </div>

            <?php
            $sNtabla = 'v_personal_simple';       /* nombre de la tabla de la que va a leer los datos*/
            $maxRows_Recordset1 = 20;   /* Numero de registros en cada pgina de la grilla*/
            $pageNum_Recordset1 = 0;    /* Numero de la primera pagina*/
            $activo = "";
            $policia = "";            /* Aqui se almacenara la variable GET policia con valore de 1= Busca solo policias, 0=Busca todas las pers*/
            $currentPage = $_SERVER["PHP_SELF"]; /* Pagina actual */

            //if(isset($_GET['policia']) and $_GET['policia']==1)   /* Consulta si el GET de policia es 1 y coloca una instr. and al final del query*/
            //  {
            //    $policia=" and idDgpGrado>0 ";
            //  }
            if (isset($_GET['activo']) and $_GET['activo'] == 1)   /* Consulta si el GET de policia es 1 y coloca una instr. and al final del query*/ {
              $activo = " and  idDgpTipoSituacion='A'";
            }

            if (isset($_GET['apellido1'])) {
              if (isset($_GET['pageNum_Recordset1'])) {
                $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
              }

              $startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;   /* inicio del limite en el select */

              if (isset($_GET['totalRows_Recordset1'])) {
                $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
              } else {
                //$sql1 ="select count(*) from ".$sNtabla." where concat(apellido1,' ',apellido2,' ',nombre1,' ',nombre2) like '";
                $sql1 = "select count(*) from " . $sNtabla . " where apenom like '";
                $sql1 .= $_GET['apellido1'] . "%'  " . $filtro . $activo . " order by apenom limit 1";
                $all_Recordset1 = $conn->query($sql1);
                $totalRows_Recordset1 = $all_Recordset1->fetchColumn();
              }

              $totalPages_Recordset1 = ceil($totalRows_Recordset1 / $maxRows_Recordset1) - 1;
              $queryString_Recordset1 = "";

              if (!empty($_SERVER['QUERY_STRING'])) {
                $params = explode("&", $_SERVER['QUERY_STRING']);
                // print_r($params);
                $newParams = array();
                foreach ($params as $param) {
                  if (
                    stristr($param, "pageNum_Recordset1") == false &&
                    stristr($param, "totalRows_Recordset1") == false
                  ) {
                    array_push($newParams, $param);
                  }
                }
                if (count($newParams) != 0) {
                  $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
                }
              }

              $queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
            ?>
              <table class="tabla1" style="width:250px">
                <tr>
                  <td>&nbsp;<?php if ($pageNum_Recordset1 > 0) { // Show if not first page 
                            ?>
                    <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="../../../../imagenes/anterior.png" alt="&lt;&lt;" border="0"></a>
                  <?php } else {
                              echo '<img src="../../../../../imagenes/anterior_b.png" alt="&lt;&lt;" border="0">';
                            } // Show if not first page 
                  ?>
                  </td>
                  <td>&nbsp;<?php if ($pageNum_Recordset1 > 0) { // Show if not first page 
                            ?>
                    <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="../../../../../imagenes/inicio.png" alt="&lt;" border="0"></a>
                  <?php } else {
                              echo '<img src="../../../../../imagenes/inicio_b.png" alt="&lt;" border="0">';
                            } // Show if not first page 
                  ?>
                  </td>
                  <td>&nbsp;<?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page 
                            ?>
                    <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="../../../../imagenes/siguiente.png" alt="&gt;" border="0"></a>
                  <?php } else {
                              echo '<img src="../../../../../imagenes/siguiente_b.png" alt="&gt;" border="0">';
                            } // Show if not last page 
                  ?>
                  </td>
                  <td>&nbsp;<?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page 
                            ?>
                    <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="../../../../../imagenes/fin.png" alt="&gt;&gt;" border="0"></a>
                  <?php } else {
                              echo '<img src="../../../../../imagenes/fin_b.png" alt="&gt;&gt;" border="0">';
                            } // Show if not last page 
                  ?>
                  </td>
                  <td align="right" style="font-weight:bold">Pag: <?php echo isset($_GET['pageNum_Recordset1']) ? $_GET['pageNum_Recordset1'] + 1 : 1 ?></td>
                </tr>
              </table>
              <table id='my-tbl' class="tabla1" width="100%">
                <tr>
                  <!--<th class="data1-th">Sel</th> -->
                  <th class="data-th">Cedula</th>
                  <th class="data-th">Grado</th>
                  <?php if ($paraPolicias) { ?>
                    <th class="data-th">1er Apellido</th>
                    <th class="data-th">2do Apellido</th>
                    <th class="data-th">1er Nombre</th>
                    <th class="data-th">2do Nombre</th>
                    <th class="data-th">Sexo</th>
                    <th class="data-th">Unidad</th>
                    <th class="data-th">Sit.Policial</th>
                  <?php } else { ?>
                    <!--         <th class="data-th">Dactilar</th>       -->
                    <th class="data-th">Apellidos y Nombres</th>
                  <?php } ?>
                </tr>
              <?php

              //loop por cada registro
              if (!($_GET['apellido1'] == '')) {
                //$sql  ="select * from ".$sNtabla." where concat(apellido1,' ',apellido2,' ',nombre1,' ',nombre2) like  '";
                $sql = "select * from " . $sNtabla . " where apenom like  '";
                $sql .= $_GET['apellido1'] . "%' " . $filtro . $activo;
                $query_limit_Recordset1 = sprintf("%s order by apenom LIMIT %d, %d", $sql, $startRow_Recordset1, $maxRows_Recordset1);
                $rs = $conn->query($query_limit_Recordset1);

                while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
                  echo "<tr class='data-tr' align='center' style=>";
                  if ($boton)
                    echo "<td align=left><a href='#' onclick=\"seleccionarBoton2('" . $row[upc('documento')] . "');\" >" . $row['documento'] . "</a></td>";
                  else
                    echo "<td align=left> <a href='#' onclick=\"seleccionar('" . trim($row[upc('documento')]) . "');\" >" . $row['documento'] . "</a></td>";
                  echo "<td align=left>" . $row[upc('siglas')] . "</td>";
                  if ($paraPolicias) {
                    echo "<td align=left>" . $row[upc('apellido1')] . "</td>";
                    echo "<td align=left>" . $row[upc('apellido2')] . "</td>";
                    echo "<td align=left>" . $row[upc('nombre1')] . "</td>";
                    echo "<td align=left>" . $row[upc('nombre2')] . "</td>";
                    echo "<td>" . $row[upc('sexo')] . "</td>";
                    echo "<td align=left>" . $row[upc('unidad')] . "</td>";
                    echo "<td align=left>" . $row[upc('situacionPolicial')] . "</td>";
                  } else {
                    echo "<td align=left>" . $row[upc('apenom')] . "</td>";
                  }
                  //echo "<td>{$row['codigoDactilar']}</td>";                
                  echo "</tr>";
                }
              } else echo '<script language="javascript"> alert("De ingresar Apellido1 y Nombre1");</script>';
            };
              ?>
              </table>
          </div>
        </div>
      </div>
      <div id="content_bot"></div>
    </div>
  </div>
</body>

</html>