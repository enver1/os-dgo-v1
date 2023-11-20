<?php
include '../../../clases/autoload.php';
$conn = DB::getConexionDB();
include_once('../../../funciones/funciones_generales.php');

$maxRows_Recordset1 = 12;    /* Numero de registros en cada pgina de la grilla*/
$pageNum_Recordset1 = 0;    /* Numero de la primera pagina*/
$currentPage = $_SERVER["PHP_SELF"]; /* Pagina actual */
$pageNum_Recordset1 = isset($_GET['pageNum_Recordset1']) ? $_GET['pageNum_Recordset1'] : 0;
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;   /* inicio del limite en el select */
if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {

  $sql1 = "SELECT  count( DISTINCT a.idGenPersona)
            from dgpPersonal a
            join dgpResumenPersonal rp on a.idGenPersona=rp.idGenPersona
            join dgpAscenso ao on rp.idDgpAscenso=ao.idDgpAscenso
            join dgpGrado gr on ao.idDgpGrado=gr.idDgpGrado
            join dgpPdtPase ps on rp.idDgpPdtPase=ps.idDgpPdtPase
            join dgpPdtAsignacion pa on a.idGenPersona=pa.idGenPersona
            join dgpUnidad un on pa.idDgpUnidad=un.idDgpUnidad
            join dgpFuncion fu on pa.idDgpFuncion=fu.idDgpFuncion
            join genDocumento doc on a.idGenPersona=doc.idGenPersona and doc.idGenTipoDocu=1
            where ps.idDgpFuncion=348 and idDgpTipoSituacion='A' and ao.idDgpGrado in (7,8,9) 
            and year(pa.fechaAsignacion)='" . $_GET['an'] . "' order by ao.idDgpGrado,apellido1,apellido2,nombres,pa.fechaAsignacion";

  //$sql1="SELECT count(*) FROM v_persona WHERE documento='1104730799';";
  $all_Recordset1 = $conn->query($sql1);
  $totalRows_Recordset1 = $all_Recordset1->fetchColumn();
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1 / $maxRows_Recordset1) - 1;
$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>SIIPNE 3w</title>
  <link href="../../../../css/siipne3.css" rel="stylesheet" type="text/css" />
  <script>
    function seleccionar(c, d, f) {
      parent.parent.document.getElementById('cedula').value = f;
      parent.parent.document.getElementById('Buscar').onclick();
      parent.parent.getregistro(0);
      parent.parent.getdata(1);
      parent.parent.GB_hide();
    }
  </script>
</head>

<body>
  <div id="wraper">
    <div id="faux">
      <div class="warningmess">
        <p><strong>AYUDA: </strong> Para seleccionar un Cursante haga click en el <strong>Nro. de C&eacute;dula</strong> correspondiente</p>
      </div>
      <div id="content">
        <div id="content_top"></div>
        <div id="content_mid">
          <div id="contenido">
            <table class="tabla1" style="width:250px">
              <tr>
                <td>&nbsp;<?php if ($pageNum_Recordset1 > 0) { // Show if not first page 
                          ?>
                  <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="../../../../imagenes/anterior.png" alt="&lt;&lt;" border="0"></a>
                <?php } else {
                            echo '<img src="../../../../imagenes/anterior_b.png" alt="&lt;&lt;" border="0">';
                          } // Show if not first page 
                ?>
                </td>
                <td>&nbsp;<?php if ($pageNum_Recordset1 > 0) { // Show if not first page 
                          ?>
                  <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="../../../../imagenes/inicio.png" alt="&lt;" border="0"></a>
                <?php } else {
                            echo '<img src="../../../../imagenes/inicio_b.png" alt="&lt;" border="0">';
                          } // Show if not first page 
                ?>
                </td>
                <td>&nbsp;<?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page 
                          ?>
                  <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="../../../../imagenes/siguiente.png" alt="&gt;" border="0"></a>
                <?php } else {
                            echo '<img src="../../../../imagenes/siguiente_b.png" alt="&gt;" border="0">';
                          } // Show if not last page 
                ?>
                </td>
                <td>&nbsp;<?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page 
                          ?>
                  <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="../../../../imagenes/fin.png" alt="&gt;&gt;" border="0"></a>
                <?php } else {
                            echo '<img src="../../../../imagenes/fin_b.png" alt="&gt;&gt;" border="0">';
                          } // Show if not last page 
                ?>
                </td>
                <td align="right" style="font-weight:bold">Pag: <?php echo isset($_GET['pageNum_Recordset1']) ? $_GET['pageNum_Recordset1'] + 1 : 1 ?></td>
              </tr>
            </table>
            <table id='my-tbl' class="tabla1" style="width:900px">
              <tr>
                <th class="data-th">CEDULA</th>
                <th class="data-th">CURSANTE</th>
              </tr>
              <?php

              $sql = "SELECT DISTINCT a.idGenPersona, trim(doc.documento) documento, CONCAT_WS(' ',gr.siglas,apellido1,apellido2,nombres) as cursante
                      from dgpPersonal a
                      join dgpResumenPersonal rp on a.idGenPersona=rp.idGenPersona
                      join dgpAscenso ao on rp.idDgpAscenso=ao.idDgpAscenso
                      join dgpGrado gr on ao.idDgpGrado=gr.idDgpGrado
                      join dgpPdtPase ps on rp.idDgpPdtPase=ps.idDgpPdtPase
                      join dgpPdtAsignacion pa on a.idGenPersona=pa.idGenPersona
                      join dgpUnidad un on pa.idDgpUnidad=un.idDgpUnidad
                      join dgpFuncion fu on pa.idDgpFuncion=fu.idDgpFuncion
                      join genDocumento doc on a.idGenPersona=doc.idGenPersona and doc.idGenTipoDocu=1
                      where ps.idDgpFuncion=348 and idDgpTipoSituacion='A' and ao.idDgpGrado in (7,8,9) 
                      and year(pa.fechaAsignacion)='" . $_GET['an'] . "' order by ao.idDgpGrado,apellido1,apellido2,nombres,pa.fechaAsignacion";

              $query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $sql, $startRow_Recordset1, $maxRows_Recordset1);
              $rs = $conn->query($query_limit_Recordset1);
              while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {

                echo "<tr class='data-tr' align='center' style=>";
                echo '<td align=left width="25%" ' . $estilo . '><a href="#" ';
                echo 'onclick="seleccionar(\'' . $row['idGenPersona'] . '\',\'' . $row['cursante'] . '\',\'' . $row['documento'] . '\')"';
                echo 'class="boton24">' . $row['documento'] . "</a></td>";
                echo "<td align=left " . $estilo . ">" . $row['cursante'] . "</td>";
                echo "</tr>";
              } ?>
            </table>
          </div>
        </div>
      </div>
      <div id="content_bot"></div>
    </div>
  </div>
</body>

</html>