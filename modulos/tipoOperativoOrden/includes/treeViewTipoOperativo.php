<?php
session_start();
include_once '../../../../clases/autoload.php';
$encriptar        = new Encriptar;
$TipoOperativoOrden      = new TipoOperativoOrden;
$result           = array();
$idGenTipoOperativo = isset($_POST['id']) ? intval($_POST['id']) : 0;
$datosTipoOperativoOrden = $TipoOperativoOrden->getDatosArbolTipoOperativoOrden($idGenTipoOperativo);
foreach ($datosTipoOperativoOrden as $registro) {
    $node               = array();
    $node['id']         = $registro['idGenTipoOperativo'];
    $p                  = array('/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/');
    $r                  = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'n', 'N');
    $x                  = preg_replace($p, $r, $registro['descripcion']);
    $node['text']       = $x;
    $node['attributes'] = array($registro['descripcion'], $encriptar->getEncriptar($registro['idGenTipoOperativo'], $_SESSION['usuarioAuditar']));
    $sql                = $TipoOperativoOrden->getSqlTotalArbolTipoOperativoOrden($registro['idGenTipoOperativo']);
    $node['state']      = FuncionesGenerales::has_child($sql) ? 'closed' : 'open';
    if ($registro['idGenEstado'] == 2)
        $node['iconCls'] = "tree-dnd-no";
    array_push($result, $node);
}
echo json_encode($result);
