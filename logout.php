<?php
require 'app/controllers/SessionController.php';

$session = new Session();

$session->removeSession();

header('Location: index.php');

?>