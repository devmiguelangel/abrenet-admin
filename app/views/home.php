<?php
if ($session->err === true) {
	require 'login.html';
} else {
	if (isset($_GET['rp'])) {
		$rp = (int)$_GET['rp'];

		switch ($rp) {
		case 1:		// Generales
			if ($user->menu[1]['active'] === true) {
				require '/app/views/rep_general.php';
			} else {
				goto Index;
			}
			break;
		case 2:		// Clientes
			if ($user->menu[2]['active'] === true) {
				require '/app/views/rep_general.php';
			} else {
				goto Index;
			}
			break;
		case 3:		// Usuarios
			require '/app/views/admin_user.php';
			break;
		default:
			Index:
			header('Location: index.php');
			break;
			
		}
	}
	
}
?>