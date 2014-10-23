<?php
if ($session->err === true) {
	require 'login.html';
} else {
	if (isset($_GET['rp'])) {
		$rp = (int)$_GET['rp'];

		switch ($rp) {
			case 1:		// Generales
				require '/app/views/rep_general.php';
				break;
			case 2:		// Clientes
				
				break;
			default:
				header('Location: index.php');
				break;
			
		}
	}
}
?>