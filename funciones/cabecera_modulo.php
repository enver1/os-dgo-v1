<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include_once('../../../funciones/db_connect.inc.php');
include_once('../../../funciones/funcion_select.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>SIIPNE 3w OPERACIONES</title>
  <link href="../../../css/easyui.css" rel="stylesheet" type="text/css" />
  <link href="../../../css/siipne3.css" rel="stylesheet" type="text/css" />
  <link href="../../../css/menu.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="../../../js/jquery-3.5.1.min.js"></script>
</head>
<div id="wraper">
  <div id="top">
    <div id="faux">
      <div id="header"></div>
      <div id="navigation">
        <div id="navigationL"></div>
      </div>
      <div id="content">
        <div id="content_top"></div>
        <div id="content_mid">
          <div id="contenido">