<?php
session_start();
include_once '../../../funciones/db_connect.inc.php';
include_once '../../../clases/autoload.php';
include_once "config.php";

$id = $_GET['idGenUpc'];
$sql = "SELECT g.fotoUpc from genUpc g where g.idGenUpc=" . $id;
$rs = $conn->query($sql);
$row = $rs->fetch();
$imagen = $row['fotoUpc'];

echo "<img src=../../../descargas/polco/upc/" . $imagen . " width=35%>";
