<?php

class PuntosLlegada extends Transaccion
{

    public function getSqlPuntosLlegada()
    {
        $sql = "SELECT a.idGoePunLleg,a.descGoePunLleg,a.latGoePunLleg,a.lonGoePunLleg,ge.descripcion  from goePunLleg a
                INNER JOIN genEstado ge on ge.idGenEstado=a.idGenEstado
                WHERE  a.delLog='N'";
        return $sql;
    }
    public function getPuntosLlegada()
    {
        return $this->consultarAll($this->getSqlPuntosLlegada());
    }

    public function getEditPuntosLlegada($idGoePunLleg)
    {
        $sql = "SELECT a.idGoePunLleg,a.descGoePunLleg,a.latGoePunLleg latitud,a.lonGoePunLleg longitud,a.idGenEstado,ge.descripcion  from goePunLleg a
        INNER JOIN genEstado ge on ge.idGenEstado=a.idGenEstado
        where  a.idGoePunLleg= {$idGoePunLleg}
        AND a.delLog='N'
        ";
        return $this->consultar($sql);
    }

    public function registrarPuntosLlegada($datos)
    {

        $tabla      = 'goePunLleg';
        $tStructure = array(
            'descGoePunLleg' => 'descGoePunLleg',
            'latGoePunLleg'  => 'latGoePunLleg',
            'lonGoePunLleg'  => 'lonGoePunLleg',
            'idGenEstado'    => 'idGenEstado',
        );
        $datos['latGoePunLleg'] = $datos['latitud'];
        $datos['lonGoePunLleg'] = $datos['longitud'];
        $descripcion            = 'descGoePunLleg';

        if (empty($datos['idGoePunLleg'])) {
            $respuesta = $this->insert($tabla, $tStructure, $datos, $descripcion);
        } else {
            $conDupli  = " and idGoePunLleg != " . $datos['idGoePunLleg'];
            $respuesta = $this->update($tabla, $tStructure, $datos, $descripcion, $conDupli);
        }
        return $respuesta;
    }
}
