<?php

class GenMarca extends Transaccion
{

    private $table = "genMarca";
    private $id = "idGenMarca";



    private $tStructure = array(
        'descripcion' => 'descripcion',
    );


    public function getIdCampo()
    {
        return $this->id;
    }

    public function getNombreTabla()
    {
        return $this->table;
    }

    public function getSqlGenMarca()
    {
        return "SELECT a.idGenMarca,a.descripcion,a.idGenMarca as cero,a.descripcion as uno FROM genMarca a ORDER BY 2";
    }



    public function eliminar($id)
    {
        return $this->borrar($this->table, $id);
    }

    public function getCampos()
    {
        return array(
            'Código' => 'idGenMarca',
            'Descripcion' => 'descripcion',


        );
    }

    public function grabaRegistros($datos)
    {
        $descripcion = "";
        $idTbl = 'id' . ucfirst($this->table);
        if (empty($datos[$idTbl])) {
            $respuesta = $this->insert($this->table, $this->tStructure, $datos, $descripcion); // insert y update son métodos declarados en la clase padre TRNSACTION.
        } else {

            $conDupli  = " and {$idTbl} != {$datos[$idTbl]}";
            //$conDupli  = " and idDneEscuela != {$datos['idDneEscuela']}";
            $respuesta = $this->update($this->table, $this->tStructure, $datos, $descripcion, $conDupli);
        }
        return $respuesta;
    }


    public function  getGenMarcaPorId($id)
    {
        $sql = "SELECT a.idGenMarca,a.descripcion FROM genMarca a 
        WHERE a.idGenMarca=$id";
        return $this->consultar($sql);
    }

    public function  getGenMarcaAll()
    {
        return $this->consultarAll($this->getSqlGenMarca());
    }
}