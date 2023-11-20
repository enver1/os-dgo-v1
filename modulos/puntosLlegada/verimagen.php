<?php
session_start();

include_once '../../../clases/autoload.php';
include_once "config.php";


$id = $_GET['idDaiDelito'];

$sql = "SELECT imgDelito from daiDelito  where idDaiDelito=" . $id;

$conn = DB::getConexionDB();
$rs = $conn->query($sql);
$row = $rs->fetch();
$imagen = $row['imgDelito'];

echo "<img src=../../../descargas/operaciones/delitosipat/" . $imagen . " width=35%>";