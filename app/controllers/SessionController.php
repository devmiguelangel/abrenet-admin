<?php
/**
* Session
*/
class Session
{
	public $idUser, $userAgent, $err = false;
	
	public function __construct()
	{
		session_start();

		if (isset($_SESSION['id_user']) && isset($_SESSION['user_agent'])) {
			$this->err = false;
		} else {
			$this->err = true;
		}
	}

	public function startSession($id_user)
	{
		$_SESSION['id_user'] = base64_encode($id_user);
		$_SESSION['key'] = md5(uniqid(mt_rand(), true));
		$_SESSION['ip_address'] = $this->getIPAddress();
		$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
		$_SESSION['last_activity'] = $_SERVER['REQUEST_TIME'];
		$_SESSION['session_time'] = 30000;

		$this->setDataCookie();
	}

	private function setDataCookie() 
	{
		if (empty($_SESSION['id_user']) === false
			&& empty($_SESSION['user_agent']) === false) {
			//setcookie('sud_admin[user]', $_SESSION['id_user'], time() + 1 * 24 * 60 * 60);
			setcookie('sud_admin[user]', $_SESSION['id_user'], 0, '/', '', false, true);
			setcookie('sud_admin[agent]', $_SESSION['user_agent'], 0, '/', '', false, true);
		}
	}

	public function getDataCookie()
	{
		if (isset($_COOKIE['sud_admin']) 
			&& empty($_SESSION['id_user']) === true) {
			$data = $_COOKIE['sud_admin'];
			/*$data['user'] = htmlspecialchars($_COOKIE['sud_admin[user]']);
			$data['ef'] = htmlspecialchars($_COOKIE['sud_admin[ef]']);*/
			$data_user = htmlspecialchars($data['user']);
			$this->startSession(base64_decode($data_user));

			$this->err = false;
		}
	}

	public function removeSession()
	{
		session_unset();
		session_destroy();
		session_regenerate_id(true);

		if (isset($_COOKIE['sud_admin'])) {
			setcookie('sud_admin', '', time() - 3600, '/', '', false, true);
			setcookie('sud_admin[user]', '', time() - 3600, '/', '', false, true);
			setcookie('sud_admin[agent]', '', time() - 3600, '/', '', false, true);
		}
	}

	private function getIPAddress()
	{
		$ip = '';

		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		
		return $ip;
	}
}
?>