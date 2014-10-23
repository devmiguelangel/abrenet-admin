<?php
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