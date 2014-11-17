<?php
require_once '/app/controllers/ClientController.php';

$cl = new ClientController();

$url = $_SERVER['REQUEST_URI'];

if ($cl->getClientURL($url) === true) {
	header('Location: ../index.php?cl=' . strtolower($cl->code));
} else {
	header('Location: ../index.php');
}


?>