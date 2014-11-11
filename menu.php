<?php
require_once '/app/controllers/UserController.php';
$user = new UserController();

if ($user->getDataUser($_SESSION['id_user']) === true) {
	switch ($user->permission['codigo']) {
	case 'ROOT':
		Report:
		$user->menu[1]['active'] = true;
		$user->menu[2]['active'] = true;
		break;
	case 'RGR':
		$user->menu[1]['active'] = true;
		break;
	case 'RCL':
		$user->menu[2]['active'] = true;
		break;
	case 'RGC':
		goto Report;
		break;
	}


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
					<a href="?rp=3" class="item-uniq">Usuario(s)</a>
				</li>
				<li><a href="logout.php" class="item-uniq">Salir</a></li>
			</ul>
		</li>
		<li><a href="#" style="width: auto;">Reportes</a>
			<ul>
<?php
	foreach ($user->menu as $key => $value) {
		if ($value['active'] === true) {
			echo '<li>
				<a href="?rp=' . $value['key'] . '" class="item-uniq">' . $value['title'] . '</a>
			</li>';
		}
	}
?>
			</ul>
		</li>
<?php
	if ($user->permission['codigo'] === 'ROOT') {
?>
		<li><a href="" style="width: auto;">Administración</a>
			<ul>
				<li><a href="?adm=1" class="item-uniq">Entidad Financiera</a></li>
				<li><a href="?adm=2" class="item-uniq">Aseguradora</a></li>
			</ul>
		</li>
<?php
	}
?>
	</ul>
</nav>
<?php
}

?>