<?php
include_once('../clases/autoload.php');
$conn = DB::getConexionDB();
?>
<style>
	.baret {
		width: auto;
		height: 30px;
		background-color: #CCC;
		color: #000;
		font-family: Verdana, Geneva, sans-serif;
		font-size: 10px;
		text-align: center;
		border: solid 2px #333;
		border-radius: 0 8px 8px 0;
		-moz-border-radius: 0 8px 8px 0;
		-webkit-border-radius: 0 8px 8px 0;
		-webkit-box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
		-moz-box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
		box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
		margin-bottom: 30px;
	}

	a.barra {
		text-decoration: none;
		border: none;
		color: #666;
		font-family: Verdana, Geneva, sans-serif;
		font-size: 11px;
	}

	.marcoUni {
		background: #fff;
		width: 225px;
		height: auto;
		border: solid 1px #3f3f3f;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;

	}

	.marcoUni:hover {
		background: #D5EAFF;

	}

	.marcoUni table {
		color: #555;
		font-size: 11px;
		padding-left: 0px;
	}

	.marcoUni a {
		text-decoration: none;
		border-bottom: none;

	}

	.marcoUni table a p {
		padding: 15px 10px 5px 10px;
		color: #666;
	}

	.marcoUni table a:hover {
		font-size: 11px;
		color: #111;
		text-decoration: underline;
		border: none;
	}


	.marco {
		/*background:url(../../../imagenes/sheet.jpg) no-repeat center;*/
		width: 180px;
		height: 260px;
		border: none;
		/*solid 1px #3f3f3f;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	-webkit-box-shadow: 3px 3px 5px 0px rgba(0,0,0,0.75);
	-moz-box-shadow: 3px 3px 5px 0px rgba(0,0,0,0.75);
	box-shadow: 3px 3px 5px 0px rgba(0,0,0,0.75);*/

	}

	.marco p {
		color: #3f3f3f;
		font-size: 11px;
		padding-left: 12px;
	}

	.marco a p {
		padding: 10px 10px 5px 10px;
		color: #3f3f3f;
	}

	.marco a:hover {
		font-size: 11px;
		color: #000;
		text-decoration: underline;
	}

	.return {
		background: url(modulos/gerenSupervisa/regresar.jpg) no-repeat;
		width: 40px;
		height: 40px;
		display: block;
	}

	.fotoR {
		border: solid 2px #aaa;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
		-webkit-box-shadow: 3px 3px 3px -2px #333;
		-moz-box-shadow: 3px 3px 3px -2px #333;
		box-shadow: 3px 3px 3px -2px #333;
	}

	/* FLIP */
	#f1_container {
		position: relative;
		margin: 10px auto;
		width: 180px;
		height: 260px;
		border: solid 1px #3f3f3f;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
		z-index: 1;
	}

	#f1_container {
		perspective: 1000;
	}

	#f1_container:hover {
		border: none;
	}

	#f1_card {
		width: 97%;
		height: 100%;
		transform-style: preserve-3d;
		transition: all 0.7s linear;
		margin: 0 auto;
	}

	#f1_container:hover #f1_card {
		transform: rotateY(180deg);
		box-shadow: -5px 5px 5px #aaa;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
	}

	.face {
		position: absolute;
		width: 100%;
		height: 100%;
		backface-visibility: hidden;
	}

	.face.back {
		display: block;
		transform: rotateY(180deg);
		box-sizing: border-box;
		padding: 10px;
		/*color: white;*/
		text-align: left;
		background-color: #D5EAFF;
	}

	.back a:hover {
		text-decoration: none;
	}
</style>
<script>
	$(document).ready(function() {
		inicio();
	});

	function inicio() {
		$('#forma').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
		$('#forma').load('modulos/gerenSupervisa/visitas.php');
	}

	function entrar(c) {
		//	alert(c);
		$('#forma').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
		$('#forma').load('modulos/gerenSupervisa/unidades.php?id=' + c);

	}

	function ejes(c, v) {
		//	alert(c);
		$('#forma').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
		$('#forma').load('modulos/gerenSupervisa/ejes.php?id=' + c + '&v=' + v);

	}

	function detalles(c, v, j) {
		var d = 0;
		//var v=0;
		$('#forma').html('<p><img src="../funciones/paginacion/images/ajax-loader.gif" /></p>');
		$('#forma').load('modulos/gerenSupervisa/detalle.php?id=' + c + '&v=' + v + '&j=' + j);
	}
</script>
<div id="forma" style="width:900px">
</div>