<?php
require_once $GLOBALS['DOCUMENT_ROOT'] . '/app/controllers/BankController.php';

$bank = new BankController();

$id = '';
$action = '';

if (isset($_GET['action'])) {
	$action = $_GET['action'];

	switch ($action) {
	case sha1(1):	// Adicionar Entidad Financiera
		$action = 1;
		require_once 'form_bank.php';
		break;
	case sha1(2):	// Editar Entidad Financiera
		$action = 2;

		if (isset($_GET['bank'])) {
			$id = base64_decode($_GET['bank']);

			if ($bank->getBankData($id) === true) {
				require_once 'form_bank.php';
			} else {
				goto Adm;
			}
		} else {
			goto Adm;
		}
		break;
	case sha1(3):
		if (isset($_GET['id']) && isset($_GET['dir'])) {
			$bank->id = $bank->real_escape_string(base64_decode(trim($_GET['id'])));
			$bank->domain = $bank->real_escape_string(base64_decode(trim($_GET['dir'])));
			
			if ($bank->setBankDirectory()) {
				# code...
			}
		}

		goto Adm;
		break;
	case sha1(4):
		if (isset($_GET['id']) && isset($_GET['active'])) {
			$bank->id = $bank->real_escape_string(base64_decode(trim($_GET['id'])));
			$bank->active = !(boolean)$bank->real_escape_string(trim($_GET['active']));
			
			if ($bank->activateDeactivateBank() === true) {
				# code...
			}
		}

		goto Adm;
		break;
	default:
		Adm:
		header('Location: index.php?adm=1');
		break;
	}
}

if (empty($action) === true) {
?>
<div>
	<br>
	<a href="index.php?adm=1&action=<?=sha1(1);?>" id="bank_add" class="bank_add">Agregar</a>
</div>
<br>
<?php
if ($bank->getBankData() === true) {
	$active_title = '';
	$active_class = '';
	$dir = false;

	while ($bank->row = $bank->rs->fetch_array(MYSQLI_ASSOC)) {
		$bank->row['ef_activado'] = (boolean)$bank->row['ef_activado'];
		if ($bank->row['ef_activado'] === true) {
			$active_title = 'Desactivar';
			$active_class = '';
		} else {
			$active_title = 'Activar';
			$active_class = 'bank_active';
		}

?>
<article class="bank <?=$active_class;?>">
	<table style="width: 100%;">
		<tr>
			<td style="width: 60%;">
				<div class="bank_title"><?=$bank->row['ef_nombre'];?> 
					<span class="bank_code">(<?=$bank->row['ef_codigo'];?>)</span>
				</div>
			</td>
			<td style="width: 40%;">
				<div class="bank_title" style="text-align: right;">
<?php
		if ($bank->checkBankDirectory($bank->row['ef_dominio']) === false) {
			echo '<a href="index.php?adm=1&action=' . sha1(3) . '&id=' 
				. base64_encode($bank->row['ef_id']) . '&dir=' 
				. base64_encode($bank->row['ef_dominio']) . '" style="margin-right: 20px;">
				Crear Enlace
			</a>';
		}

		echo '<a href="index.php?adm=1&action=' . sha1(4) . '&id=' 
			. base64_encode($bank->row['ef_id']) . '&active=' 
			. (int)$bank->row['ef_activado'] . '">' 
			. $active_title . '
		</a>';
?>
				</div>
			</td>
		</tr>
	</table>

	<div class="bank_data_title">Parametros de la Conexión</div>
	<table class="bank_data">
		<tr style="color: #0f8e4f;">
			<td style="width: 20%;">Host</td>
			<td style="width: 20%;">Base de Datos</td>
			<td style="width: 20%;">Usuario</td>
			<td style="width: 20%;">Contraseña</td>
			<td style="width: 20%;" rowspan="2">
				<a href="index.php?adm=1&action=<?=sha1(2);?>&bank=<?=base64_encode($bank->row['ef_id']);?>" 
					class="bank_edit">Modificar datos</a>
			</td>
		</tr>
		<tr>
			<td><?=$bank->row['db_host'];?></td>
			<td><?=$bank->row['db_database'];?></td>
			<td><?=$bank->row['db_user'];?></td>
			<td><?=substr($bank->row['db_password'], 0, 3);?>...</td>
		</tr>
	</table>

	<table class="bank_data">
		<tr>
			<td style="width: 50%; text-align: left; padding: 5px 30px;">
				<div class="bank_data_title">Productos Asignados</div>
<?php
		if (($rs = $bank->getBankProduct($bank->row['ef_id'])) !== false) {
			echo '<ul style="list-style: circle; padding-left: 50px;">';
			while ($row = $rs->fetch_array(MYSQLI_ASSOC)) {
				echo '<li>' . $row['pr_nombre'] . '</li>';
			}
			echo '</ul>';

			$rs->free();
		}
?>
				</td>
			<td style="width: 50%; text-align: left; padding: 5px 30px;">
				<div class="bank_data_title">Aseguradora</div>
<?php
		if (($rs = $bank->getBankInsurance($bank->row['ef_id'])) !== false) {
			echo '<ul style="list-style: circle; padding-left: 50px;">';
			while ($row = $rs->fetch_array(MYSQLI_ASSOC)) {
				echo '<li>' . $row['as_nombre'] . '</li>';
			}
			echo '</ul>';

			$rs->free();
		}
?>
			</td>
		</tr>
	</table>
</article>
<?php
	}
} else {
	header('Location: index.php');
}

}

?>