<?php
class TipoTipificacion extends Transaccion
{
    private $tabla   = 'genTipoTipificacion';
    private $idTabla = 'idGenTipoTipificacion';
    public function getIdCampo()
    {
        return $this->idTabla;
    }
    public function getTablaTipoTipificacion()
    {
        return $this->tabla;
    }
    public function getSqlTipoTipificacion()
    {

        $sql = "SELECT
                    a.idGenTipoTipificacion,
                    a.gen_idGenTipoTipificacion,
                    a.descripcion,
                    b.descripcion as descripcionPadre
                    a.detalle,
                    a.siglas,
                    hd.descripcion as servicio,
                    a.idGenEstado,
                    ge.descripcion as estado

                FROM
                    genTipoTipificacion a
                INNER JOIN hdrTipoServicio hd ON hd.idHdrTipoServicio=a.idHdrTipoServicio
                LEFT OUTER JOIN genTipoTipificacion b ON a.gen_idGenTipoTipificacion = b.idGenTipoTipificacion
                INNER JOIN genEstado ge ON ge.idGenEstado=a.idGenEstado
                ORDER BY gen_idGenTipoTipificacion";

        return $sql;
    }
    public function getTipoTipificacion()
    {
        return $this->consultarAll($this->getSqlTipoTipificacion());
    }

    public function getEditTipoTipificacion($idGenTipoTipificacion)
    {
        $sql = "SELECT a.*, b.descripcion descripcionPadre,hd.descripcion servicio,hd.idHdrTipoServicio, a.idGenEstado, ge.descripcion as estado
                FROM genTipoTipificacion a
                LEFT OUTER JOIN genTipoTipificacion b ON a.gen_idGenTipoTipificacion = b.idGenTipoTipificacion
                  INNER JOIN hdrTipoServicio hd ON hd.idHdrTipoServicio=a.idHdrTipoServicio
                  INNER JOIN genEstado ge ON ge.idGenEstado=a.idGenEstado
                WHERE a.idGenTipoTipificacion ='{$idGenTipoTipificacion}'";
        return $this->consultar($sql);
    }

    public function registrarTipoTipificacion($datos)
    {
        $tabla      = 'genTipoTipificacion';
        $tStructure = array(
            'idGenTipoTipificacion'     => 'idGenTipoTipificacion',
            'gen_idGenTipoTipificacion' => 'gen_idGenTipoTipificacion',
            'idHdrTipoServicio'         => 'idHdrTipoServicio',
            'descripcion'               => 'descripcion',
            'detalle'                   => 'detalle',
            'idGenEstado'                   => 'idGenEstado',
            'siglas'                    => 'siglas',

        );

        $descripcion = 'gen_idGenTipoTipificacion,descripcion';

        if (empty($datos['idGenTipoTipificacion'])) {
            if (empty($datos['gen_idGenTipoTipificacion'])) {
                $datos['gen_idGenTipoTipificacion'] = null;
            }

            return $this->insert($this->tabla, $tStructure, $datos, $descripcion);
        } else {
            if (empty($datos['gen_idGenTipoTipificacion'])) {
                $datos['gen_idGenTipoTipificacion'] = null;
            }

            $conDupli = " and idGenTipoTipificacion != " . $datos['idGenTipoTipificacion'];
            return $this->update($this->tabla, $tStructure, $datos, $descripcion, $conDupli);
        }
    }

    public function eliminarTipoTipificacion($conn, $idGenTipoTipificacion)
    {
        if (!empty($idGenTipoTipificacion)) {
            $respuesta = $this->delete($this->tabla, $idGenTipoTipificacion);
            $this->borraDependientes($conn, $idGenTipoTipificacion);
        } else {
            $respuesta = array(false, 'NO EXISTE DATOS A ELIMINAR');
        }
        return $respuesta;
    }

    public function getSqlTipoTipificacionPdf()
    {
        $sql = "SELECT
                    a.idGenTipoTipificacion as cero,
                    a.gen_idGenTipoTipificacion,
                    a.idGenEstado,
                    a.descripcion as dos,
                IF (a.gen_idGenTipoTipificacion=0,'RAIZ',(SELECT n.descripcion from genTipoTipificacion n WHERE n.idGenTipoTipificacion =a.gen_idGenTipoTipificacion  AND n.delLog='N')) uno
                FROM
                    genTipoTipificacion a
                WHERE a.delLog='N'
                ORDER BY gen_idGenTipoTipificacion";
        return $sql;
    }
    public function getDatosImprimirPdf()
    {
        return $this->consultarAll($this->getSqlTipoTipificacionPdf());
    }

    public function borraDependientes($conn, $idGenTipoTipificacion)
    {
        $sql = "SELECT
                    count(a.idGenTipoTipificacion) cuantos
                FROM
                    genTipoTipificacion a
                WHERE a.delLog='N'
                AND a.gen_idGenTipoTipificacion='" . $idGenTipoTipificacion . "'";

        $rs   = $conn->query($sql);
        $rowB = $rs->fetch();
        if ($rowB['cuantos'] == 0) {
        } else {
            $sql1 = "UPDATE genTipoTipificacion SET delLog='S' WHERE gen_idGenTipoTipificacion='" . $idGenTipoTipificacion . "'";
            $conn->query($sql1);
        }
    }
    public function getSqlArbol($idGenTipoTipificacion)
    {
        if (!empty($idGenTipoTipificacion)) {
            return "SELECT idGenTipoTipificacion,gen_idGenTipoTipificacion,descripcion,idGenEstado
                    FROM genTipoTipificacion 
                    WHERE gen_idGenTipoTipificacion ='{$idGenTipoTipificacion}'  ORDER BY descripcion, gen_idGenTipoTipificacion";
        } else {
            return "SELECT idGenTipoTipificacion,gen_idGenTipoTipificacion,descripcion,idGenEstado
                    FROM genTipoTipificacion
                    WHERE gen_idGenTipoTipificacion is null  ORDER BY descripcion, idGenTipoTipificacion";
        }
    }

    public function getDatosArbol($idGenTipoTipificacion)
    {

        return $this->consultarAll($this->getSqlArbol($idGenTipoTipificacion));
    }

    public function getTotalArbol($idGenTipoTipificacion)
    {
        return "SELECT count(*) numreg FROM genTipoTipificacion WHERE gen_idGenTipoTipificacion='{$idGenTipoTipificacion}'";
    }
}
