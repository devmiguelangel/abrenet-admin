<?php
require '/app/controllers/UserController.php';
require '/app/controllers/SessionController.php';
require '/app/controllers/ClientController.php';
require '/app/controllers/ClientDBController.php';

$result = array(
	'key'	=> false,
	'msg'	=> '',
	'lnk'	=> 'index.php'
);

if (isset($_POST['fl-user']) && isset($_POST['fl-pass'])) {
	$data_user = $_POST['fl-user'];
	$data_password = $_POST['fl-pass'];

	if (isset($_POST['Client-id'])) {
		$cl = new ClientController();

		$cl->id = $cl->real_escape_string(base64_decode(trim($_POST['Client-id'])));

		if ($cl->getClientDB() === true) {
			$cldb = new ClientDatabaseController($cl->db, $data_user, $data_password);

			if ($cldb->loginClient() === true) {
				$result['key'] = true;
				$result['msg'] = 'Bienvenido.';

				$session = new Session(true);
				$session->idUser = date('U');
				$session->user = 'mmamani';
				$session->name = 'Miguel';
				$session->permission = 'RRRR';

				$session->startSession($session->idUser);

			} else {
				$result['msg'] = 'El usuario o la contraseña no coinciden.';
			}
		} else {
			$result['key'] = true;
		}
	} else {
		$user = new UserController();
	
		if ($user->login($data_user, $data_password) === true) {
			$session = new Session();

			if ($session->err === true) {
				StartSession:

				$session->startSession($user->id);
				$result['key'] = true;
				$result['msg'] = $user->result['msg'];
			} else {
				$session->removeSession();
				goto StartSession;
			}
		} else {
			$result['msg'] = $user->result['msg'];
		}
	}
}

echo json_encode($result);

?>