<?php
$GLOBALS['DOCUMENT_ROOT'] = __dir__;

require_once $GLOBALS['DOCUMENT_ROOT'] . '/app/controllers/ClientController.php';

$cl = new ClientController();

$url = $_SERVER['REQUEST_URI'];

if ($cl->getClientURL($url) === true) {
	header('Location: ../index.php?cl=' . strtolower($cl->code));
} else {
	header('Location: ../index.php');
}
?>