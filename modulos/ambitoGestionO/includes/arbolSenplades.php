<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include '../../../../clases/autoload.php';
include '../../../../funciones/funcion_select.php';
$conn = DB::getConexionDB();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>SIIPNE 3w</title>
  <script type="text/javascript" src="../../../js/sweetalert2/sweetalert2.all.min.js"></script>
  <link href='../../../js/sweetalert2/sweetalert2.min.css' rel="stylesheet" type="text/css">

  <link href="../../../../css/easyui.css" rel="stylesheet" type="text/css" />
  <link href="../../../../css/siipne3.css" rel="stylesheet" type="text/css" />
  <link href="../../../css/menu.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="../../../../js/jquery-3.5.1.min.js"></script>
  <script type="text/javascript" src="../../../../js/jquery.easyui.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#tpais').tree({
        onClick: function(node) {
          var node = $('#tpais').tree('getSelected');
          if (node.tipo == 3) {
            $('#paisDesc').attr('value', node.text);
            $('#siglasGS').attr('value', node.attributes + " (" + node.text + ")");
            $('#paisCdg').attr('value', node.id);
            $("html, body").animate({
              scrollTop: 0
            }, "slow");
          } else {
            //  alert('EL NIVEL REQUERIDO ES UN DISTRITO');
            Swal.fire(
              'El Nivel Reuqerido es un Distrito',
              'Ambito de Gestión Orden',
              'info'
            )
            return false;
            $('#siglasGS').val('');
            $('#paisCdg').val('');
            $('#paisDesc').val('');
          }

        }
      });
    });

    function selecciona() {
      parent.parent.document.getElementById("senpladesDescripcion").value = $('#siglasGS').val();
      parent.parent.document.getElementById("idGenGeoSenplades").value = $('#paisCdg').val();
      parent.parent.GB_hide();
    }
  </script>
</head>

<body style="background-color:#fff">
  <div id="wraper" style="background-image:none">
    <div id="top" style="background-image:none">
      <div id="faux" style="background-image:none">
        <div style="border-bottom:solid 2px #bbb;width:100%;text-align:center">
          <img src="../../../../imagenes/helpArbol.jpg" alt="0" border="0" />
        </div>
        <div id="content" style="background-image:none">
          <div id="content_top"></div>
          <div id="content_mid">
            <div id="contenido">
              <table width="100" border="0">
                <tr>
                  <td>
                    <input type="text" name="paisCdg" id="paisCdg" size="8" readonly="readonly" />&nbsp;
                    <input type="text" name="siglasGS" id="siglasGS" size="8" readonly="readonly" />
                    <input type="text" name="paisDesc" id="paisDesc" size="70px" readonly="readonly" />
                    <a href="javascript:void(0)" onclick="selecciona()" class="button"><span>Seleccionar</span></a>
                  </td>
                </tr>
                <tr>
                  <td width="100%">
                    <div style=" overflow: scroll; height:auto;width:890px">
                      <ul id="tpais" class="easyui-tree" animate="true" style="font-size:10px" url="treeViewSenplades.php?id=" +usuario<?php echo isset($_GET['pais']) ? '&pais=' . $_GET['pais'] : '' ?><?php echo isset($_GET['parroquia']) ? '&parroquia=' . $_GET['parroquia'] : '' ?>">
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