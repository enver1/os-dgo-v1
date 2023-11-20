<?php
session_start();
include_once '../../../../clases/autoload.php';
$encriptar        = new Encriptar;
$TipoAspectoCg      = new TipoAspectoCg;
$result           = array();
$idCgTipoAspecto = isset($_POST['id']) ? intval($_POST['id']) : 0;
$datosTipoAspectoCg = $TipoAspectoCg->getDatosArbolTipoAspectoCg($idCgTipoAspecto);
foreach ($datosTipoAspectoCg as $registro) {
    $node               = array();
    $node['id']         = $registro['idCgTipoAspecto'];
    $p                  = array('/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/');
    $r                  = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'n', 'N');
    $x                  = preg_replace($p, $r, $registro['descripcion']);
    $node['text']       = $x;
    $node['attributes'] = array($registro['descripcion'], $encriptar->getEncriptar($registro['idCgTipoAspecto'], $_SESSION['usuarioAuditar']));
    $sql                = $TipoAspectoCg->getSqlTotalArbolTipoAspectoCg($registro['idCgTipoAspecto']);
    $node['state']      = FuncionesGenerales::has_child($sql) ? 'closed' : 'open';
    if ($registro['idGenEstado'] == 2)
        $node['iconCls'] = "tree-dnd-no";
    array_push($result, $node);
}
echo json_encode($result);
