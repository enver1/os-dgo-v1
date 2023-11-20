<?php

/**
 *
 */
class SenderoSeguro extends Transaccion
{

    //********************************* CONSULTAS ***********************************************
    public function getConsultarRutasPorFecha($fecha)
    {
        $fechaIni = $fecha . " 00:00:00";
        $fechaFin = $fecha . " 23:59:59";

        $sql = "SELECT  goeUsuReg.`idGoeUsuReg`,CONCAT(goeUsuReg.apeGoeUsuReg," . " ' '" . " ,goeUsuReg.nomGoeUsuReg) AS nombre,
        goeRutas.`idGoeRutas`,goeRutas.fechaCreacion , goeRutas.`idGoePunLleg`,goePunLleg.`descGoePunLleg` AS puntoLlegada,
        goeRutas.`polyLine`, goeRutas.`latInicial`, goeRutas.`lonInicial`,
        goeRutaDetalle.`idGoeRutaDetalle`, goeAlerta.`idGoeAlerta` ,`goeRutas`.`estado`
        FROM goeRutas
        INNER JOIN `goeUsuReg` ON goeUsuReg.`idGoeUsuReg` = goeRutas.`idGoeUsuReg`
        INNER JOIN `goePunLleg` ON goePunLleg.`idGoePunLleg` = goeRutas.`idGoePunLleg`
        LEFT JOIN `goeRutaDetalle` ON goeRutas.`idGoeRutas`=goeRutaDetalle.`idGoeRutas`
        LEFT JOIN `goeAlerta` ON goeRutas.`idGoeRutas`=goeAlerta.`idGoeRutas`
        WHERE goeRutas.fechaCreacion  BETWEEN '$fechaIni' AND '$fechaFin'
        GROUP BY goeRutas.idGoeRutas
        ORDER BY goeRutas.idGoeRutas DESC";

        return $this->consultarAll($sql);
    }

    public function getConsultarRutasPorFechaPuntoLlegada($fecha, $idPuntoLlegada)
    {
        $fechaIni = $fecha . " 00:00:00";
        $fechaFin = $fecha . " 23:59:59";

        $sql = "SELECT  goeUsuReg.`idGoeUsuReg`,CONCAT(goeUsuReg.apeGoeUsuReg," . " ' '" . " ,goeUsuReg.nomGoeUsuReg) AS nombre,
        goeRutas.`idGoeRutas`,goeRutas.fechaCreacion, goeRutas.`idGoePunLleg`,goePunLleg.`descGoePunLleg` AS puntoLlegada,
        goeRutas.`polyLine`, goeRutas.`latInicial`, goeRutas.`lonInicial`,
        goeRutaDetalle.`idGoeRutaDetalle`, goeAlerta.`idGoeAlerta` ,`goeRutas`.`estado`
        FROM goeRutas
        INNER JOIN `goeUsuReg` ON goeUsuReg.`idGoeUsuReg` = goeRutas.`idGoeUsuReg`
        INNER JOIN `goePunLleg` ON goePunLleg.`idGoePunLleg` = goeRutas.`idGoePunLleg`
        LEFT JOIN `goeRutaDetalle` ON goeRutas.`idGoeRutas`=goeRutaDetalle.`idGoeRutas`
        LEFT JOIN `goeAlerta` ON goeRutas.`idGoeRutas`=goeAlerta.`idGoeRutas`
        WHERE goeRutas.idGoePunLleg=$idPuntoLlegada AND
        goeRutas.fechaCreacion  BETWEEN '$fechaIni' AND '$fechaFin'
        GROUP BY goeRutas.idGoeRutas
        ORDER BY goeRutas.idGoeRutas DESC";

        return $this->consultarAll($sql);
    }

    public function getConsultarTodasRutasActivas()
    {

        $sql = "SELECT  goeUsuReg.`idGoeUsuReg`,CONCAT(goeUsuReg.apeGoeUsuReg," . " ' '" . " ,goeUsuReg.nomGoeUsuReg) AS nombre,
        goeRutas.`idGoeRutas`,goeRutas.fechaCreacion, goeRutas.`idGoePunLleg`,goePunLleg.`descGoePunLleg` AS puntoLlegada,
        goeRutas.`polyLine`, goeRutas.`latInicial`, goeRutas.`lonInicial`,
        goeRutaDetalle.`idGoeRutaDetalle`, goeAlerta.`idGoeAlerta` ,`goeRutas`.`estado`
        FROM goeRutas
        INNER JOIN `goeUsuReg` ON goeUsuReg.`idGoeUsuReg` = goeRutas.`idGoeUsuReg`
        INNER JOIN `goePunLleg` ON goePunLleg.`idGoePunLleg` = goeRutas.`idGoePunLleg`
        LEFT JOIN `goeRutaDetalle` ON goeRutas.`idGoeRutas`=goeRutaDetalle.`idGoeRutas`
        LEFT JOIN `goeAlerta` ON goeRutas.`idGoeRutas`=goeAlerta.`idGoeRutas`
        WHERE
        `goeRutas`.`estado`!='finalizada'
        GROUP BY goeRutas.idGoeRutas
        ORDER BY goeRutas.idGoeRutas DESC";

        return $this->consultarAll($sql);
    }

    public function getConsultarTodasAlertasActivas()
    {

        $sql = "SELECT goeUsuReg.`idGoeUsuReg`,CONCAT(goeUsuReg.apeGoeUsuReg, ' ' ,goeUsuReg.nomGoeUsuReg) AS nombre, goeRutas.`idGoeRutas`,goeRutas.fechaCreacion, goeRutas.`idGoePunLleg`,goePunLleg.`descGoePunLleg` AS puntoLlegada, goeRutas.`polyLine`, goeRutas.`latInicial`, goeRutas.`lonInicial`, goeRutaDetalle.`idGoeRutaDetalle`, goeAlerta.`idGoeAlerta` ,`goeRutas`.`estado`
        FROM goeRutas
        INNER JOIN `goeUsuReg` ON goeUsuReg.`idGoeUsuReg` = goeRutas.`idGoeUsuReg`
        INNER JOIN `goePunLleg` ON goePunLleg.`idGoePunLleg` = goeRutas.`idGoePunLleg`
        LEFT JOIN `goeRutaDetalle` ON goeRutas.`idGoeRutas`=goeRutaDetalle.`idGoeRutas`
        LEFT JOIN `goeAlerta` ON goeRutas.`idGoeRutas`=goeAlerta.`idGoeRutas`
        WHERE
        `goeRutas`.`estado`!='finalizada' AND
        `goeAlerta`.`descidGoeAlerta`='BotonSOS'
        GROUP BY goeRutas.idGoeRutas ORDER BY goeRutas.idGoeRutas DESC";

        return $this->consultarAll($sql);
    }

    public function getConsultarPuntoLlegada()
    {
        $sql = "SELECT  *
                FROM  goePunLleg
                WHERE `idGenEstado` = 1
                  AND `delLog` = 'N' ";

        return $this->consultarAll($sql);
    }

    public function getConsultarRutasPorId($id)
    {

        $sql = "SELECT *,`goeRutas`.`fechaCreacion` AS fechaRuta  FROM `goeRutas`" .
            " INNER JOIN `goePunLleg` ON  goeRutas.`idGoePunLleg`= goePunLleg.`idGoePunLleg`  " .
            " WHERE `goeRutas`.`idGoeRutas`=" . $id;

        return $this->consultarAll($sql);
    }

    public function getConsultarRutasDetallePorIdRuta($idRuta)
    {

        $sql = "SELECT *  FROM `goeRutaDetalle`" .
            " WHERE `goeRutaDetalle`.`idGoeRutas`=" . $idRuta;

        return $this->consultarAll($sql);
    }

    public function getConsultarUltimaRutaDetallePorIdRuta($idRuta)
    {

        $sql = "SELECT *  FROM `goeRutaDetalle`
        WHERE `goeRutaDetalle`.`idGoeRutas`=$idRuta AND
        `goeRutaDetalle`.`idGoeRutaDetalle` = (SELECT MAX(idGoeRutaDetalle) FROM goeRutaDetalle WHERE `goeRutaDetalle`.`idGoeRutas`=$idRuta)";
        return $this->consultarAll($sql);
    }

    public function getConsultaPrimerRutaAlertaPorIdRuta($idRuta)
    {

        $sql = "SELECT * FROM `goeAlerta`
        WHERE `goeAlerta`.`idGoeRutas`=$idRuta AND
        `goeAlerta`.`idGoeAlerta` = (SELECT MIN(idGoeAlerta) FROM goeAlerta WHERE `goeAlerta`.`idGoeRutas`=$idRuta)";

        return $this->consultarAll($sql);
    }

    public function getConsultaUltimaRutaAlertaPorIdRuta($idRuta)
    {

        $sql = "SELECT * FROM `goeAlerta`
        WHERE `goeAlerta`.`idGoeRutas`=$idRuta AND
        `goeAlerta`.`idGoeAlerta` = (SELECT MAX(idGoeAlerta) FROM goeAlerta WHERE `goeAlerta`.`idGoeRutas`=$idRuta)";

        return $this->consultarAll($sql);
    }

    public function getConsultarAlertasPorIdRuta($idRuta)
    {

        $sql = "SELECT *  FROM `goeAlerta`" .
            " WHERE `goeAlerta`.`idGoeRutas`=" . $idRuta;

        return $this->consultarAll($sql);
    }

    public function getConsultarUser($idUser)
    {

        $sql = "SELECT goeUsuReg.* ,genDivPolitica.`descripcion` AS pais FROM `goeUsuReg`
        INNER JOIN `genDivPolitica` ON `goeUsuReg`.`idGenDivPolitica`=`genDivPolitica`.`idGenDivPolitica`
        WHERE `goeUsuReg`.`idGoeUsuReg`=$idUser";

        return $this->consultarAll($sql);
    }

    //********************************* MODIFICAR ***********************************************

    public function modificarEstado($idGoeRutas, $estado, $accion)
    {

        /* $tStructure = array(
        'estado' => 'estado',

        );
        $nombreTabla='goeRutas';

        $datos['estado']=  $estado ;
        $datos['idGoeRutas']=  $idGoeRutas ;

        //$descripcion='campo1,campo2,campo3';  campo que valida para que se duplique un registro
        //$conDupli  = " and idGoeRutas != {$datos['idGoeRutas']}";
        //$conDupli  = " and idGoeRutas != {$idGoeRutas}";

        $sql="UPDATE goeRutas SET estado='$estado' WHERE idGoeRutas=$idGoeRutas";

        //$respuesta = $this->update( $nombreTabla, $tStructure, $datos, $descripcion, $conDupli);
        $respuesta = $this->update( $nombreTabla, $tStructure, $datos,'','');
        print_r($respuesta);*/

        $sql = "UPDATE goeRutas SET estado='$estado', accion='$accion' WHERE idGoeRutas=$idGoeRutas";



        $Upd =  $this->conn->prepare($sql);
        $Upd->execute();

        return $Upd->rowCount();
    } //function

} //fin clase