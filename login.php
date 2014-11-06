<?php
require '/app/controllers/UserController.php';
require '/app/controllers/SessionController.php';

$result = array(
	'key'	=> false,
	'msg'	=> '',
	'lnk'	=> ''
);

if(isset($_POST['fl-user']) && isset($_POST['fl-pass'])){
	$data_user = $_POST['fl-user'];
	$data_password = $_POST['fl-pass'];

	$user = new UserController();
	
	if ($user->login($data_user, $data_password) === true) {
		$session = new Session();

		if ($session->err === true) {
			StartSession:

			$session->startSession($user->id);
			$result = array(
				'key' => true,
				'msg' => $user->result['msg'],
				'lnk' => 'index.php'
				);
		} else {
			$session->removeSession();
			goto StartSession;
		}
	} else {
		$result = array(
			'key' => false,
			'msg' => $user->result['msg'],
			'lnk' => 'index.php'
			);
	}
}

echo json_encode($result);

?>