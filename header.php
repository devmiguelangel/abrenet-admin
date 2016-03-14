<?php 
header("Expires: Thu, 27 Mar 1980 23:59:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$GLOBALS['DOCUMENT_ROOT'] = __dir__;

require $GLOBALS['DOCUMENT_ROOT'] . '/app/controllers/SessionController.php';

$session = new Session();
if ($session->err === true) {
	$session->getDataCookie();
	// $GLOBALS['DOCUMENT_ROOT'] = __dir__;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Administrador</title>
	<meta charset="utf-8" >

	<link type="text/css" href="css/style.css" rel="stylesheet" />

	<link type="text/css" href="jQueryAssets/smoothness/jquery.ui.all.css" rel="stylesheet" >
	<link type="text/css" href="assets/vendors/fancybox/jquery.fancybox.css" rel="stylesheet" media="screen" />
	
	<link type="text/css" href="css/tooltip-ui.css" rel="stylesheet" />
	<link type="text/css" href="css/flat/_all.css" rel="stylesheet" />

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="jQueryAssets/ui/jquery.ui.core.js"></script>
	<script type="text/javascript" src="jQueryAssets/ui/jquery.ui.widget.js"></script>

	<script type="text/javascript" src="jQueryAssets/ui/jquery.ui.datepicker.js"></script>
	<script type="text/javascript" src="jQueryAssets/ui/i18n/jquery.ui.datepicker-es.js"></script>
	<script type="text/javascript" src="jQueryAssets/ui/jquery.ui.accordion.js"></script>
	<script type="text/javascript" src="jQueryAssets/ui/jquery.ui.tabs.js"></script>
	<script type="text/javascript" src="jQueryAssets/ui/jquery.ui.position.js"></script>
	<script type="text/javascript" src="jQueryAssets/ui/jquery.ui.tooltip.js"></script>

	<script type="text/javascript" src="assets/vendors/fancybox/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="assets/vendors/fancybox/jquery.fancybox.pack.js"></script>

	<!--[if lte IE 8]>
	<script type="text/javascript" src="js/modernizr.custom.17465.js"></script>
	<![endif]-->

	<script type="text/javascript" src="js/icheck.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript">

	$(document).ready(function(e) {
	    $(".fancybox").fancybox({
			
		});
	});
	</script>
</head>
<body>

<header>
	<div id="logo"></div>
	<div class="title">
		Administrador
	</div>
</header>