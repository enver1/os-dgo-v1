<?php
session_start();
header("content-type: application/json; charset=utf-8");
include_once '../../../clases/autoload.php';
$hdrEveResDis = new HdrEveResDis;
echo json_encode($hdrEveResDis->registrar($_POST, $_FILES));
