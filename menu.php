<?php
require_once $GLOBALS['DOCUMENT_ROOT'] . '/app/controllers/UserController.php';
require_once $GLOBALS['DOCUMENT_ROOT'] . '/app/controllers/BankController.php';
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

	$user->token = false;
} elseif (isset($_SESSION['user']) && isset($_SESSION['permission'])) {
	$user->token = true;
	$user->user = base64_decode($_SESSION['user']);
	$user->name = base64_decode($_SESSION['name']);
	$user->permission['codigo'] = base64_decode($_SESSION['permission']);
	$user->ef = base64_decode($_SESSION['ef']);
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
<?php
	if ($user->token === false) {
		echo '<li>
			<a href="?rp=3" class="item-uniq">Usuario(s)</a>
		</li>';
	}
?>
				<li><a href="logout.php" class="item-uniq">Salir</a></li>
			</ul>
		</li>
		<li><a href="#" style="width: auto;">Reportes</a>
			<ul>
<?php
	if ($user->token === false) {
		foreach ($user->menu as $key => $value) {
			if ($value['active'] === true) {
				echo '<li>
					<a href="?rp=' . $value['key'] . '" class="item-uniq">' . $value['title'] . '</a>
				</li>';
			}
		}
	} else {
		$bank = new BankController();
		$bank->code = $user->ef;

		if ($bank->getBankByCode() === true) {
			echo '<li>
				<a href="?rp=4&ef=' . base64_encode($bank->code) . '" class="item-uniq">' . $bank->name . '</a>
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