<?php
//PROCESOS DE ADMINISTRACION DE USUARIOS
$GLOBALS['DOCUMENT_ROOT'] = __dir__;

require_once $GLOBALS['DOCUMENT_ROOT'] . '/app/controllers/AdminUserController.php';
$adminUser = new AdminUserController();

if(isset($_GET['rel']) && isset($_GET['data'])){
	$rel = $_GET['rel'];
	$data = base64_decode($_GET['data']);

	switch($rel){
	case md5('1'):
		require_once $GLOBALS['DOCUMENT_ROOT'] . '/app/views/form-add-user.php';
		break;
	case md5('2'):
		if($data != 0){
			require_once $GLOBALS['DOCUMENT_ROOT'] . '/app/views/form-add-user.php';
		}
		break;
	case md5('3'):
		require_once $GLOBALS['DOCUMENT_ROOT'] . '/app/views/delete-user.php';
		break;
	case md5('4'):
		require_once $GLOBALS['DOCUMENT_ROOT'] . '/app/views/form-change-pass.php';
		break;
	case md5('5'):
		require_once $GLOBALS['DOCUMENT_ROOT'] . '/app/views/form-change-pass.php';
		break;
	}
}

//Add User
if(isset($_POST['token-adduser']) && isset($_POST['fa-user'])){

	$data['add_type'] = $_POST['fa-type'];
	$data['add_dpto'] = $_POST['fa-dpto'];
	$data['add_user'] = $_POST['fa-user'];
	$data['add_pass'] = $_POST['fa-pass'];
	$data['add_pass_confirm'] = $_POST['fa-pass-confirm'];
	$data['add_name'] = $_POST['fa-name'];
	$data['add_email'] = $_POST['fa-email'];
	$data['add_key'] = $_POST['fa-key'];

	if(isset($_POST['fa-cl-']))
		$data['add_ef'] = $_POST['fa-cl-'];
	else
		$data['add_ef'] = FALSE;

	echo $adminUser->addUser($data);
}

//Verify User
if(isset($_GET['userName'])){

	echo $adminUser->verifyUserName(trim($_GET['userName']));

}

//Edit User
if(isset($_POST['token-upduser']) && isset($_POST['fa-user'])){

	$data['upd_id'] = $_POST['fa-user'];
	$data['upd_type'] = $_POST['fa-type'];
	$data['upd_dpto'] = $_POST['fa-dpto'];
	$data['upd_name'] = $_POST['fa-name'];
	$data['upd_email'] = $_POST['fa-email'];
	$data['upd_key'] = $_POST['fa-key'];

	if(isset($_POST['fa-cl-']))
		$data['upd_ef'] = $_POST['fa-cl-'];
	else
		$data['upd_ef'] = FALSE;

	echo $adminUser->updUser($data);
}

//Delete User
if(isset($_POST['token-deluser']) && $_POST['fd-user']){

	$data['del_id'] = $_POST['fd-user'];

	echo $adminUser->delUser($data);
}

//Change Password User
if((isset($_POST['token-cpass']) || isset($_POST['token-rpass'])) && isset($_POST['user']) && isset($_POST['fc-key'])){

	$data['cg_user'] = $_POST['user'];

	if(isset($_POST['fc-pass']))
		$data['cg_pass'] = $_POST['fc-pass'];
	else
		$data['cg_pass'] = FALSE;

	$data['cg_new_pass'] = $_POST['fc-new-pass'];
	$data['cg_repeat_pass'] = $_POST['fc-repeat-pass'];

	if(isset($_POST['token-cpass']))
		$data['cg_token_cpass'] = TRUE;
	else
		$data['cg_token_cpass'] = FALSE;

	if(isset($_POST['token-rpass']))
		$data['cg_token_rpass'] = TRUE;
	else
		$data['cg_token_rpass'] = FALSE;

	$data['cg_key'] = $_POST['fc-key'];

	echo $adminUser->changePassUser($data);
}

//Verify Pass
if(isset($_GET['user']) && isset($_GET['pass'])){

	$data['user'] = $_GET['user'];
	$data['pass'] = $_GET['pass'];

	echo $adminUser->verifyPass($data);

}


?>