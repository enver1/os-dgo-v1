<?php
if (!isset($_SESSION)) {
	session_start();
}
header('Content-Type: text/html; charset=UTF-8');
include_once('../../funciones/db_connect.inc.php');
include_once('../../funciones/paginacion/libs/ps_pagination.php');
include_once('../../funciones/funciones_generales.php');
if (substr($_GET['sql'], 0, 6) == 'select')
	$sql = $_GET['sql'];
else
	$sql = decrypt($_GET['sql'], $_SESSION['nomUsuarioLogueado']);
//die($sql);
//$conn is a variable from our config_open_db.php
//$sql is our sql statement above
//3 is the number of records retrieved per page
//4 is the number of page numbers rendered below
//null - i used null since in dont have any other
//parameters to pass (i.e. param1=valu1&param2=value2)
//you can use this if you're gonna use this class for search
//results since you will have to pass search keywords
$npag = substr_count($_GET['page'], 'p');
echo '<hr />';
$html = '<table id="my-tbl" border="0" style="border:none" cellpadding="0" cellspacing="0">
<tr style="border:none;padding:0 auto;margin:0 auto;">
	<th  colspan="6" align="right">
<select name="lapagina"  onchange="getdata( this.value )"><option value="p1">Otra Pagina</option>';
if ($npag >= 2) {
	$fpos = 1;
	$ipos = 1;
	for ($i = 2; $i < $npag; $i++) {
		$ipos = strpos($_GET['page'], 'p', $fpos) + 1;
		$epos = strpos($_GET['page'], 'p', $ipos) - $ipos;
		$fpos = $ipos;
		$pag = substr($_GET['page'], $ipos, $epos);
		$pagval = $pag . substr($_GET['page'], 0, $ipos - 1) . substr($_GET['page'], strpos($_GET['page'], 'p', $ipos), 500);
		$html .= '<option value="p' . $pagval . '">Pag: ' . $pag . '</option>';
	}
	$ipos = strpos($_GET['page'], 'p', $ipos) + 1;
	$pag = substr($_GET['page'], $ipos, 20);
	$pagval = $pag . substr($_GET['page'], 0, $ipos - 1);
	$html .= '<option value="p' . $pagval . '">Pag: ' . $pag . '</option></select></th><tr></table>';
	echo $html;
}
//OnClick='getdata( $pageno )'
$pager = new PS_Pagination($conn, $sql, 25, 10, null);

//our pagination class will render new
//recordset (search results now are limited
//for pagination)

if ($rs = $pager->paginate()) {
	$num = $rs->rowCount();
} else {
	$num = 0;
}
echo "<div class='page-nav' style='margin-bottom:5px'>";
//display our page number navigation
echo $pager->renderFullNav();
echo "</div>";

if ($num >= 1) {
	//creating our table header
	include_once($_GET['grilla']);
	//die($_GET['grilla']);
} else {
	//if no records found
	echo "No hay registros!";
}
//page-nav class to control
//the appearance of our page 
//number navigation
echo "<div class='page-nav'>";
//display our page number navigation
echo $pager->renderFullNav();
echo "</div>";
