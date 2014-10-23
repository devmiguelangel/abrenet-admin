<?php
require_once '/app/controllers/UserController.php';
$user = new UserController();

if ($user->getDataUser($_SESSION['id_user']) === true) {
?>
<nav>
	<ul id="main-menu">
		<li>
			<a href="#" class="name-user">
				<?=$user->user?>
				<br>
				<span>(<?=$user->name?>)</span>
			</a>
			<ul>
				<li>
					<a href="index.php" class="item-uniq">Inicio</a>
				</li>
				<li>
					<a href="" class="item-uniq">Usuario</a>
				</li>
				<li><a href="logout.php" class="item-uniq">Salir</a></li>
			</ul>
		</li>
		<li><a href="#" style="width: auto;">Reportes</a>
			<ul>
				<li>
					<a href="?rp=1" class="item-uniq">Generales</a>
				</li>
				<li>
					<a href="?rp=2" class="item-uniq">Clientes</a>
				</li>
			</ul>
		</li>
	</ul>
</nav>
<?php
}

?>