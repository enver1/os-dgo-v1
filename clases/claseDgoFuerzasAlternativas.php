<?php
class DgoFuerzasAlternativas extends Transaccion
{
    private $tabla   = 'dgoFuerzasAlternativas';
    private $idTabla = 'idDgoFuerzasAlternativas';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaDgoFuerzasAlternativas()
    {
        return $this->tabla;
    }
    public function getSqlDgoFuerzasAlternativas($idDgoOrdenServicio)
    {
        $sql = "SELECT      a.idDgoFuerzasAlternativas,
                            a.idDgoOrdenServicio,
                            a.numericoJefes,
                            a.numericoSubalternos,
                            a.idDgoTipoFuerzasAlternativas,
                            du.descripcion                            
                        FROM
                            dgoFuerzasAlternativas a
                            INNER JOIN dgoTipoFuerzasAlternativas du ON du.idDgoTipoFuerzasAlternativas= a.idDgoTipoFuerzasAlternativas 
                        WHERE
                            a.delLog = 'N' AND a.idDgoOrdenServicio=" . $idDgoOrdenServicio . "
                        ORDER BY
                            a.idDgoFuerzasAlternativas DESC";
        return $sql;
    }
    public function getDgoFuerzasAlternativas($idDgoOrdenServicio)
    {
        return $this->consultarAll($this->getSqlDgoFuerzasAlternativas($idDgoOrdenServicio));
    }

    public function getEditDgoFuerzasAlternativas($idDgoFuerzasAlternativas)
    {
        $sql = "SELECT      a.idDgoFuerzasAlternativas,
                            a.idDgoOrdenServicio,
                            a.numericoJefes,
                            a.numericoSubalternos,
                            a.idDgoTipoFuerzasAlternativas,
                            du.descripcion                            
                        FROM
                            dgoFuerzasAlternativas a
                            INNER JOIN dgoTipoFuerzasAlternativas du ON du.idDgoTipoFuerzasAlternativas= a.idDgoTipoFuerzasAlternativas 
                        WHERE
                        a.idDgoFuerzasAlternativas={$idDgoFuerzasAlternativas}";
        return $this->consultar($sql);
    }

    public function registrarDgoFuerzasAlternativas($datos)
    {
        $tabla      = 'dgoFuerzasAlternativas';
        $tStructure = array(
            'idDgoOrdenServicio' => 'idDgoOrdenServicio',
            'numericoJefes'  => 'numericoJefes',
            'numericoSubalternos' => 'numericoSubalternos',
            'idDgoTipoFuerzasAlternativas'      => 'idDgoTipoFuerzasAlternativas',
            'delLog'      => 'delLog',
        );
        $datos['delLog'] = 'N';
        $descripcion     = 'idDgoOrdenServicio,delLog';

        if (empty($datos['idDgoFuerzasAlternativas'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoFuerzasAlternativas != " . $datos['idDgoFuerzasAlternativas'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarDgoFuerzasAlternativas($idDgoFuerzasAlternativas)
    {
        if (!empty($idDgoFuerzasAlternativas)) {
            $respuesta = $this->delete($this->tabla, $idDgoFuerzasAlternativas);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlDgoFuerzasAlternativasPdf()
    {
        $sql = "SELECT      a.idDgoFuerzasAlternativas,
                            a.idDgoOrdenServicio,
                            a.idDgpUnidad,
                            a.numericoJefes,
                            a.numericoSubalternos,
                            a.idDgoTipoFuerzasAlternativas,
                            du.descripcion,
                            du1.descripcion as Unidad
                        FROM
                            dgoFuerzasAlternativas a
                            INNER JOIN dgpUnidad du ON du.idDgpUnidad= a.idDgpUnidad";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlDgoFuerzasAlternativasPdf());
    }
}
