<?php
require '/app/controllers/UserController.php';

$user = new UserController();
if ($user->login('admin', 'pw4admin') === true) {
	echo "string";
}

/*function crypt_pass($password, $digito = 7) {
	$set_salt = './1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	$salt = sprintf('$2x$%02d$', $digito);
	
	for($i = 0; $i < 22; $i++){
		$salt .= $set_salt[mt_rand(0, 63)];
	}
	
	return crypt($password, $salt);
}

echo crypt_pass('pw4admin');

$pass_bd = '$2x$07$zcfSZ2.sE.jOSZdcCGK0geXOjt98pv2iUM22AIdJl.gcjgwYMd44S';

if(crypt('pw4admin', $pass_bd) == $pass_bd) {
	echo "<br>OK";
}
*/
?>