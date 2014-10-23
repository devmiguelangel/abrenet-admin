<?php 
header("Expires: Thu, 27 Mar 1980 23:59:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require '/app/controllers/SessionController.php';

$session = new Session();
if ($session->err === true) {
	$session->getDataCookie();
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Administrador</title>
	<meta charset="utf-8" >

	<link type="text/css" href="css/style.css" rel="stylesheet" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/modernizr.custom.17465.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
</head>
<body>

<header>
	<div id="logo"></div>
	<div class="title">
		Administrador
	</div>
</header>