<?php
class TipoResumen extends Transaccion
{
    private $tabla   = 'hdrTipoResum';
    private $idTabla = 'idHdrTipoResum';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaTipoResumen()
    {
        return $this->tabla;
    }
    public function getSqlTipoResumen()
    {

        $sql = "SELECT
                    a.idHdrTipoResum,
                    a.hdr_idHdrTipoResum,
                    a.desHdrTipoResum,
                    b.desHdrTipoResum descripcionPadre,
                    a.claseActor,
                    hd.desHdrGrupResum 

                FROM
                    hdrTipoResum a
                INNER JOIN hdrGrupResum hd ON hd.idHdrGrupResum=a.idHdrGrupResum
                LEFT OUTER JOIN hdrTipoResum b ON a.hdr_idHdrTipoResum = b.idHdrTipoResum
                WHERE a.delLog='N'
                ORDER BY hdr_idHdrTipoResum";

        return $sql;
    }
    public function getTipoResumen()
    {
        return $this->consultarAll($this->getSqlTipoResumen());
    }

    public function getEditTipoResumen($idHdrTipoResum)
    {
        $sql = "SELECT a.*, b.desHdrTipoResum descripcionPadre,hd.desHdrGrupResum,hd.idHdrGrupResum
                FROM hdrTipoResum a
                LEFT OUTER JOIN hdrTipoResum b ON a.hdr_idHdrTipoResum = b.idHdrTipoResum
                  INNER JOIN hdrGrupResum hd ON hd.idHdrGrupResum=a.idHdrGrupResum
                WHERE a.idHdrTipoResum ='{$idHdrTipoResum}'";
        return $this->consultar($sql);

    }

    public function registrarTipoResumen($datos)
    {
        $tabla      = 'hdrTipoResum';
        $tStructure = array(
            'idHdrTipoResum'     => 'idHdrTipoResum',
            'hdr_idHdrTipoResum' => 'hdr_idHdrTipoResum',
            'idHdrGrupResum'     => 'idHdrGrupResum',
            'desHdrTipoResum'    => 'desHdrTipoResum',
            'claseActor'         => 'claseActor',
            'delLog'             => 'delLog',

        );
        $datos['delLog'] = 'N';
        $descripcion     = 'hdr_idHdrTipoResum,desHdrTipoResum';

        if (empty($datos['idHdrTipoResum'])) {
            if (empty($datos['hdr_idHdrTipoResum'])) {
                $datos['hdr_idHdrTipoResum'] = 0;
            }

            return $this->insert($this->tabla, $tStructure, $datos, $descripcion);
        } else {
            if (empty($datos['hdr_idHdrTipoResum'])) {
                $datos['hdr_idHdrTipoResum'] = 0;
            }

            $conDupli = " and idHdrTipoResum != " . $datos['idHdrTipoResum'];
            return $this->update($this->tabla, $tStructure, $datos, $descripcion, $conDupli);
        }
    }

    public function eliminarTipoResumen($conn, $idHdrTipoResum)
    {
        if (!empty($idHdrTipoResum)) {
            $respuesta = $this->delete($this->tabla, $idHdrTipoResum);
            $this->borraDependientes($conn, $idHdrTipoResum);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;

    }

    public function getSqlTipoResumenPdf()
    {
        $sql = "SELECT
                    a.idHdrTipoResum cero,
                    a.hdr_idHdrTipoResum,
                    a.desHdrTipoResum dos,
                IF (a.hdr_idHdrTipoResum=0,'RAIZ',(SELECT n.desHdrTipoResum from hdrTipoResum n WHERE n.idHdrTipoResum =a.hdr_idHdrTipoResum  AND n.delLog='N')) uno
                FROM
                    hdrTipoResum a
                WHERE a.delLog='N'
                ORDER BY hdr_idHdrTipoResum";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlTipoResumenPdf());
    }

    public function borraDependientes($conn, $idHdrTipoResum)
    {
        $sql = "SELECT
                    count(a.idHdrTipoResum) cuantos
                FROM
                    hdrTipoResum a
                WHERE a.delLog='N'
                AND a.hdr_idHdrTipoResum='" . $idHdrTipoResum . "'";

        $rs   = $conn->query($sql);
        $rowB = $rs->fetch();
        if ($rowB['cuantos'] == 0) {

        } else {
            $sql1 = "UPDATE hdrTipoResum SET delLog='S' WHERE hdr_idHdrTipoResum='" . $idHdrTipoResum . "'";
            $conn->query($sql1);
        }
    }
    public function getSqlArbol($idHdrTipoResum)
    {
        if (!empty($idHdrTipoResum)) {
            return "SELECT idHdrTipoResum,hdr_idHdrTipoResum,desHdrTipoResum
                    FROM hdrTipoResum
                    WHERE hdr_idHdrTipoResum ='{$idHdrTipoResum}'  ORDER BY  hdr_idHdrTipoResum";
        } else {
            return "SELECT idHdrTipoResum,hdr_idHdrTipoResum,desHdrTipoResum
                    FROM hdrTipoResum
                    WHERE (hdr_idHdrTipoResum is null OR hdr_idHdrTipoResum=0) ORDER BY  idHdrTipoResum";
        }
    }

    public function getDatosArbol($idHdrTipoResum)
    {

        return $this->consultarAll($this->getSqlArbol($idHdrTipoResum));
    }

    public function getTotalArbol($idHdrTipoResum)
    {
        return "SELECT count(*) numreg FROM hdrTipoResum WHERE hdr_idHdrTipoResum='{$idHdrTipoResum}'";

    }
}
