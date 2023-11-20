<?php
session_start();
include_once '../../../../clases/autoload.php';
$encriptar   = new Encriptar;
$unaCatalogo = new TipoResumen();

$result = array();
$id     = isset($_POST['id']) ? intval($_POST['id']) : 0;

$datos = $unaCatalogo->getDatosArbol($id);
foreach ($datos as $registro) {
    $node               = array();
    $node['id']         = $registro['idHdrTipoResum'];
    $p                  = array('/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/');
    $r                  = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'n', 'N');
    $x                  = preg_replace($p, $r, $registro['desHdrTipoResum']);
    $node['text']       = $x;
    $node['attributes'] = array($registro['desHdrTipoResum'], $encriptar->getEncriptar($registro['idHdrTipoResum'], $_SESSION['usuarioAuditar']));
    $sql                = $unaCatalogo->getTotalArbol($registro['idHdrTipoResum']);
    $node['state']      = FuncionesGenerales::has_child($sql) ? 'closed' : 'open';
    array_push($result, $node);
}
echo json_encode($result);
