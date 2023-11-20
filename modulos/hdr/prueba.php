<?php
// $archivo = "/var/www/html/siipne3/funciones/paginacion/libs/ps_pagination.php";
// $downloadfilename = 'clasePDF.php';

// if(file_exists($archivo)){

// 	$downloadfilename = $downloadfilename !== null ? $downloadfilename : basename($archivo);
// 	header('Content-Description: File Transfer');
// 	header('Content-Type: application/octet-stream');
// 	header('Content-Disposition: attachment; filename='.$downloadfilename);
// 	header('Content-Transfer-Encoding: binary');
// 	header('Expires: 0');
// 	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
// 	header('Pragma: public');
// 	header('Content-Length: '.filesize($archivo));
// 	ob_clean();
// 	flush();
// 	readfile($archivo);
// }else{
// 	echo $archivo.'- no existe';
// }



// $dir = "/var/www/html/siipne3/js/";
// $directorio=opendir($dir);
// echo "<b>Directorio actual:</b><br>$dir<br>";
// echo "<b>Archivos:</b><br>";
// 		while ($archivo = readdir($directorio)) {
// 		if($archivo == '.')
	// 	echo "<a href=\"?dir=.\">$archivo</a><br>";
// 	elseif($archivo == '..'){
// 	if($dir != '.'){
// 	$carpetas = split("/",$dir);
// 	array_pop($carpetas);
// 	$dir2 = join("/",$carpetas);
// 	echo "<a href=\"?dir=$dir2\">$archivo</a><br>";
// 	}
// 	}
// 	elseif(is_dir("$dir/$archivo"))
// 	echo "<a href=\"?dir=$dir/$archivo\">$archivo</a><br>";
// 	else echo "$archivo<br>";
// }
// closedir($directorio);



?>