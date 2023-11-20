<?php
session_start();
include_once '../../../../clases/autoload.php';
$encriptar = new Encriptar;
$unaCatalogo = new TipoTipificacion();

$result = array();
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

$datos = $unaCatalogo->getDatosArbol($id);
foreach ($datos as $registro) {
    $node = array();
    $node['id'] = $registro['idGenTipoTipificacion'];
    $p = array('/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/');
    $r = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'n', 'N');
    $x = preg_replace($p, $r, $registro['descripcion']);
    $node['text'] = $x;
    $node['attributes'] = array($registro['descripcion'], $encriptar->getEncriptar($registro['idGenTipoTipificacion'], $_SESSION['usuarioAuditar']));
    $sql = $unaCatalogo->getTotalArbol($registro['idGenTipoTipificacion']);
    $node['state'] = FuncionesGenerales::has_child($sql) ? 'closed' : 'open';
    if ($registro['idGenEstado'] == 2)
        $node['iconCls'] = "tree-dnd-no";
    array_push($result, $node);
}
echo json_encode($result);
