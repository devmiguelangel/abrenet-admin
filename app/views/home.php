<?php
if ($session->err === true) {
	require 'form_login.php';
} else {
	if (isset($_GET['rp'])) {
		$rp = (int)$_GET['rp'];

		switch ($rp) {
		case 1:		// Generales
			if ($user->menu[1]['active'] === true) {
				require $GLOBALS['DOCUMENT_ROOT'] . '/app/views/rep_general.php';
			} else {
				goto Index;
			}
			break;
		case 2:		// Clientes
			if ($user->menu[2]['active'] === true) {
				require $GLOBALS['DOCUMENT_ROOT'] . '/app/views/rep_general.php';
			} else {
				goto Index;
			}
			break;
		case 3:		// Usuarios
			require $GLOBALS['DOCUMENT_ROOT'] . '/app/views/admin_user.php';
			break;
		case 4:
			if (isset($_GET['ef'])) {
				require $GLOBALS['DOCUMENT_ROOT'] . '/app/views/rep_general.php';
			}
			break;
		default:
			Index:
			header('Location: index.php');
			break;
			
		}
	}

	if (isset($_GET['adm'])) {
		if ($user->permission['codigo'] === 'ROOT') {
			$adm = (int)$_GET['adm'];

			switch ($adm) {
			case 1:
				require $GLOBALS['DOCUMENT_ROOT'] . '/app/views/admin_bank.php';
				break;
			case 2:
				# code...
				break;
			default:
				header('Location: index.php');
				break;
			}
		} else {
			header('Location: index.php');
		}
	}
}
?>