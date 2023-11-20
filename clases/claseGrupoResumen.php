<?php
class GrupoResumen extends Transaccion
{
    private $tabla   = 'hdrGrupResum';
    private $idTabla = 'idHdrGrupResum';
    public function getIdCampoGrupoResumen()
    {
        return $this->idTabla;
    }
    public function getTablaGrupoResumen()
    {
        return $this->tabla;
    }
    public function getSqlGrupoResumen()
    {
        $sql = "SELECT a.idHdrGrupResum,a.desHdrGrupResum,a.categorizacion  from hdrGrupResum a WHERE a.delLog='N' ORDER BY a.idHdrGrupResum DESC";
        return $sql;
    }
    public function getGrupoResumen()
    {
        return $this->consultarAll($this->getSqlGrupoResumen());
    }

    public function getEditGrupoResumen($idHdrGrupResum)
    {
        $sql = "SELECT a.idHdrGrupResum,a.desHdrGrupResum,a.categorizacion   from hdrGrupResum a
        WHERE a.idHdrGrupResum={$idHdrGrupResum}";
        return $this->consultar($sql);
    }

    public function registrarGrupoResumen($datos)
    {

        $tabla = 'hdrGrupResum';

        $tStructure = array(

            'desHdrGrupResum' => 'desHdrGrupResum',
            'categorizacion'  => 'categorizacion',
            'delLog'          => 'delLog',

        );
        $datos['delLog'] = 'N';
        $descripcion     = 'desHdrGrupResum';

        if (empty($datos['idHdrGrupResum'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idHdrGrupResum != " . $datos['idHdrGrupResum'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }

        return $respuesta;
    }

    public function eliminarGrupoResumen($idHdrGrupResum)
    {
        if (!empty($idHdrGrupResum)) {
            $respuesta = $this->delete($this->tabla, $idHdrGrupResum);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;

    }

    public function getSqlGrupoResumenPdf()
    {
        $sql = "SELECT a.idHdrGrupResum cero,a.desHdrGrupResum uno,a.categorizacion dos FROM hdrGrupResum a";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlGrupoResumenPdf());
    }

}
