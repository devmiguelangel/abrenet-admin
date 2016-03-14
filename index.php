<?php
// ini_set('display_errors', 'On');
require 'header.php';

if ($session->err === false) {
	require 'menu.php';
}
?>
<section id="main">
<?php
require 'app/views/home.php';
?>
</section>
<?php
require 'footer.php';
?>