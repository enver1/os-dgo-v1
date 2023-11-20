<?php
session_start();
include_once '../../../../clases/autoload.php';
$conn = DB::getConexionDB();
$id           = isset($_POST['id']) ? intval($_POST['id']) : 0;
$result       = array();
$abrirRecinto = false;
if (($id != 0)) {

    $sql = "SELECT distinct a.idDgoTipoEje, a.dgo_idDgoTipoEje, a.descripcion
            FROM dgoTipoEje a
            WHERE a.dgo_idDgoTipoEje = '{$id}' AND a.delLog='N'
            UNION
            SELECT distinct b.idDgoReciElect as idDgoTipoEje, b.idDgoTipoEje as dgo_idDgoTipoEje , b.nomRecintoElec as descripcion
            FROM dgoReciElect b
            WHERE b.idDgoTipoEje = '{$id}' AND b.delLog='N'";

    if ($id == 1) {
        $sql = "SELECT  b.idDgoReciElect, b.idDgoTipoEje,b.idDgoTipoEje as dgo_idDgoTipoEje, b.nomRecintoElec as descripcion
                        FROM dgoReciElect b
                        WHERE b.idDgoTipoEje =1  
                        AND
                       b.delLog='N'  ";
    }
} else {

    $sql = "SELECT idDgoTipoEje,dgo_idDgoTipoEje,descripcion
                    FROM dgoTipoEje
                    WHERE dgo_idDgoTipoEje is null  AND delLog='N' ORDER BY  idDgoTipoEje ";
}

$rs = $conn->query($sql);

while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
    $node       = array();
    $node['id'] = $row['idDgoTipoEje'];

    if ($id == 1) {
        $node['isRecinto'] = true;
        $node['id']        = $row['idDgoReciElect'];
    }

    $p            = array('/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/');
    $r            = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'n', 'N');
    $idDgoTipoEje = $row['idDgoTipoEje'];
    if ($id == 0) {
        $x = preg_replace($p, $r, $row['descripcion']);
    } else {

        if ($idDgoTipoEje == 1 && $abrirRecinto == true) {
            $idDgoTipoEje = 0;
        }

        if ($idDgoTipoEje == 1 && $abrirRecinto == false) {
            $abrirRecinto = true;
        }

        $x = preg_replace($p, $r, $row['descripcion']);
    }
    $node['text'] = $x;

    $node['state']     = has_child($idDgoTipoEje, $conn) ? 'closed' : 'open';
    $node['isRecinto'] = false;
    if ($abrirRecinto) {
        $node['isRecinto'] = true;
        $node['state']     = 'open';
    }
    if ($node['id'] == 1) {

        $node['state'] = 'open';
    }
    array_push($result, $node);
}
echo json_encode($result);

//cuenta los hijos de la tabla tipo de eje
function has_child($id, $conn)
{

    $sql = "SELECT count(*) total
    FROM dgoTipoEje a
    WHERE a.dgo_idDgoTipoEje = '{$id}' AND a.delLog='N'
    UNION
    SELECT count(*) total
    FROM dgoReciElect b
    WHERE b.idDgoTipoEje = '{$id}' AND b.delLog='N' order by total desc limit 1";

    if ($id == 1) {

        $sql = "SELECT count(*) total
    FROM dgoReciElect a
    WHERE a.idDgoTipoEje  = '1' AND a.delLog='N'
   ";
        return true;
    }

    $rs  = $conn->query($sql);
    $row = $rs->fetch(PDO::FETCH_ASSOC);
    if ($row['total'] == 0) {
        return false;
    } else {
        return true;
    }
}
