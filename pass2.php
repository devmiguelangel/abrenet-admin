<?php
$GLOBALS['DOCUMENT_ROOT'] = __dir__;

require_once 'app/controllers/UserController.php';

$user = new UserController();

echo $user->cryptPass('admin@123');
?>