<?php

class GenModelo extends Transaccion
{

    private $table = "genModelo";
    private $id = "idGenModelo";



    private $tStructure = array(
        'idGenMarca' => 'idGenMarca',
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

    public function getSqlGenModelo()
    {
        return "SELECT a.idGenModelo,b.idGenMarca, b.descripcion marca,a.descripcion, a.idGenModelo AS cero, b.descripcion AS uno,a.descripcion AS dos FROM genModelo a,genMarca b WHERE a.idGenMarca=b.idGenMarca ORDER BY 2,3";
    }



    public function eliminar($id)
    {
        return $this->borrar($this->table, $id);
    }

    public function getCampos()
    {
        return array(
            'Código' => 'idGenModelo',
            'Marca' => 'marca',
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


    public function  getGenModeloPorId($id)
    {
        $sql = "SELECT a.idGenModelo,b.idGenMarca,b.descripcion marca,a.descripcion FROM genModelo a,genMarca b WHERE a.idGenMarca=b.idGenMarca AND `idGenModelo`=$id";
        return $this->consultar($sql);
    }

    public function  getGenModeloAll()
    {
        return $this->consultarAll($this->getSqlGenModelo());
    }
}