<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include_once('../../../funciones/funciones_generales.php');
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
    $(document).ready(function() {
      $('#tpais').tree({
        onClick: function(node) {
          var node = $('#tpais').tree('getSelected');
          //alert(node.id);
          $('#paisDesc').attr('value', node.attributes[0]);
          $('#paisCdg').attr('value', node.id);
          $("html, body").animate({
            scrollTop: 0
          }, "slow");
        }
      });
    });

    function selecciona() {
      parent.parent.document.getElementById("Unidad").innerHTML = $('#paisDesc').val();
      parent.parent.document.getElementById("idDgpUnidad").value = $('#paisCdg').val();
      parent.parent.GB_hide();
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
              <table width="100" border="0">
                <tr>
                  <td><input type="text" name="paisCdg" id="paisCdg" size="8" readonly="readonly" />&nbsp;
                    <input type="text" name="paisDesc" id="paisDesc" size="70px" readonly="readonly" />
                    <a href="javascript:void(0)" onclick="selecciona()" class="button"><span>Seleccionar</span></a>
                  </td>
                </tr>
                <tr>
                  <td width="100%">
                    <div style=" overflow: scroll; height:auto;width:890px">
                      <ul id="tpais" class="easyui-tree" animate="true" style="font-size:10px" url="tree_unidad_todo.php?id=<?php echo (isset($_GET['id']) ? $_GET['id'] : 0) ?>">
                      </ul>
                    </div>
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