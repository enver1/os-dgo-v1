<?php
session_start();
include_once '../../../clases/autoload.php';
$encriptar = new Encriptar;
$unaCatalogo = new NovedadesEje;

$result = array();
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

$datos = $unaCatalogo->getDatosArbolNovedadesEje($id);
foreach ($datos as $registro) {
    $node = array();
    $node['id'] = $registro['idDgoNovedadesElect'];
    $p = array('/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/');
    $r = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'n', 'N');
    $x = preg_replace($p, $r, $registro['descripcion']);
    $node['text'] = $x;
    $node['attributes'] = array($registro['descripcion'], $encriptar->getEncriptar($registro['idDgoNovedadesElect'], $_SESSION['usuarioAuditar']));
    $sql = $unaCatalogo->getTotalArbolNovedadesEje($registro['idDgoNovedadesElect']);
    $node['state'] = FuncionesGenerales::has_child($sql) ? 'closed' : 'open';
    array_push($result, $node);
}
echo json_encode($result);
