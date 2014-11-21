<?php
if (!isset($_SESSION['dir'])) {
	session_start();
}

require $_SESSION['dir'] . '/app/controllers/BankController.php';

if (isset($_POST['fb_action'])) {
	$action = (int)$_POST['fb_action'];

	if (is_int($action)) {
		$bank = new BankController();

		$bank->id = date('U');
		$bank->name = $bank->real_escape_string((trim($_POST['fb_name'])));
		$bank->code = $bank->real_escape_string((trim($_POST['fb_code'])));
		$bank->db_host = $bank->real_escape_string((trim($_POST['fb_host'])));
		$bank->db_database = $bank->real_escape_string((trim($_POST['fb_db'])));
		$bank->db_user = $bank->real_escape_string((trim($_POST['fb_user'])));
		$bank->db_password = $bank->real_escape_string((trim($_POST['fb_pass'])));
		$bank->active = false;

		$bank->product = array();
		if (($rsPr = $bank->getProduct()) !== false) {
			while ($rowPr = $rsPr->fetch_array(MYSQLI_ASSOC)) {
				if (isset($_POST['fb_pr_' . strtolower($rowPr['pr_codigo'])])) {
					$bank->product[] = $bank->real_escape_string(base64_decode(
						trim($_POST['fb_pr_' . strtolower($rowPr['pr_codigo'])])));
				}
			}
		}

		$bank->insurance = array();
		if (($rsIn = $bank->getInsurance()) !== false) {
			while ($rowIn = $rsIn->fetch_array(MYSQLI_ASSOC)) {
				if (isset($_POST['fb_in_' . strtolower($rowIn['as_codigo'])])) {
					$bank->insurance[] = $bank->real_escape_string(base64_decode(
						trim($_POST['fb_in_' . strtolower($rowIn['as_codigo'])])));
				}
			}
		}

		switch ($action) {
		case 1:
			if ($bank->addBank() === true) {
				echo 'La Entidad Financiera fue registrada';
			} else {
				echo 'No se pudo registrar.';
			}
			break;
		case 2:
			if (isset($_POST['fb_id'])) {
				$bank->id = $bank->real_escape_string(base64_decode(trim($_POST['fb_id'])));

				if ($bank->updateBank() === true) {
					echo 'Los datos se actualizaron correctamente';
				} else {
					echo 'No se pudo actualizar';
				}
			} else {
				echo 'No se pudo actualizar.';
			}
			break;
		default:
			# code...
			break;
		}
	}
}
?>