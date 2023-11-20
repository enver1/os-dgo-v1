<?php
class DgoFuerzasPropias extends Transaccion
{
    private $tabla   = 'dgoFuerzasPropias';
    private $idTabla = 'idDgoFuerzasPropias';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaDgoFuerzasPropias()
    {
        return $this->tabla;
    }
    public function getSqlDgoFuerzasPropias($idDgoInfOrdenServicio)
    {
        $sql = "SELECT      a.idDgoFuerzasPropias,
                            a.idDgoInfOrdenServicio,
                            a.superiores,
                            a.subalternos,
                            a.clases,
                            du.descripcion,
                            du1.descripcion as Unidad,
                            a.idDgpUnidad,
                            du.nomenclatura as unidadDescripcion
                        FROM
                            dgoFuerzasPropias a
                            INNER JOIN dgpUnidad du ON du.idDgpUnidad= a.idDgpUnidad 
                            INNER JOIN dgpUnidad du1 ON du1.idDgpUnidad= du.dgp_idDgpUnidad 
                        WHERE
                            a.delLog = 'N' AND a.idDgoInfOrdenServicio=" . $idDgoInfOrdenServicio . "
                        ORDER BY
                            a.idDgoFuerzasPropias DESC";
        return $sql;
    }
    public function getDgoFuerzasPropias($idDgoInfOrdenServicio)
    {
        return $this->consultarAll($this->getSqlDgoFuerzasPropias($idDgoInfOrdenServicio));
    }

    public function getEditDgoFuerzasPropias($idDgoFuerzasPropias)
    {
        $sql = "SELECT      a.idDgoFuerzasPropias,
                            a.idDgoInfOrdenServicio,
                            a.idDgpUnidad,
                            a.superiores,
                            a.subalternos,
                            a.clases,
                            du.descripcion,
                            du1.descripcion as Unidad,
                            a.idDgpUnidad,
                            du.nomenclatura as unidadDescripcion
                        FROM
                            dgoFuerzasPropias a
                            INNER JOIN dgpUnidad du ON du.idDgpUnidad= a.idDgpUnidad 
                            INNER JOIN dgpUnidad du1 ON du1.idDgpUnidad= du.dgp_idDgpUnidad 
                        WHERE a.idDgoFuerzasPropias={$idDgoFuerzasPropias}";
        return $this->consultar($sql);
    }

    public function registrarDgoFuerzasPropias($datos)
    {
        $tabla      = 'dgoFuerzasPropias';
        $tStructure = array(
            'idDgoInfOrdenServicio' => 'idDgoInfOrdenServicio',
            'idDgpUnidad' => 'idDgpUnidad',
            'superiores'  => 'superiores',
            'subalternos' => 'subalternos',
            'clases'      => 'clases',
            'delLog'      => 'delLog',
        );
        $datos['delLog'] = 'N';
        $descripcion     = 'idDgoInfOrdenServicio,idDgpUnidad,delLog';

        if (empty($datos['idDgoFuerzasPropias'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idDgoFuerzasPropias != " . $datos['idDgoFuerzasPropias'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }
    public function eliminarDgoFuerzasPropias($idDgoFuerzasPropias)
    {
        if (!empty($idDgoFuerzasPropias)) {
            $respuesta = $this->delete($this->tabla, $idDgoFuerzasPropias);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlDgoFuerzasPropiasPdf()
    {
        $sql = "SELECT      a.idDgoFuerzasPropias,
                            a.idDgoInfOrdenServicio,
                            a.idDgpUnidad,
                            a.superiores,
                            a.subalternos,
                            a.clases,
                            du.descripcion,
                            du1.descripcion as Unidad
                        FROM
                            dgoFuerzasPropias a
                            INNER JOIN dgpUnidad du ON du.idDgpUnidad= a.idDgpUnidad 
                            INNER JOIN dgpUnidad du1 ON du1.idDgpUnidad= du.dgp_idDgpUnidad 
                       ";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlDgoFuerzasPropiasPdf());
    }
}
