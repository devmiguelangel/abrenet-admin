<?php
$form_title = '';

switch ($action) {
case 1:
	$form_title = 'Registrar';
	break;
case 2:
	$form_title = 'Actualizar';

	if (($rsPr = $bank->getBankProduct($bank->id)) !== false) {
		
	}

	if (($rsIn = $bank->getBankInsurance($bank->id)) !== false) {
		# code...
	}

	break;
}
?>

<h3 style="text-align: center;">Entidad Financiera</h3>

<form action="" method="post" id="bank_form" class="bank_form f-admin-user">
	<label>Nombre: <span>*</span></label>
	<input type="text" id="fb_name" name="fb_name" value="<?=$bank->name;?>"
		autocomplete="off">
	<br>
	<label>Código: <span>*</span></label>
	<input type="text" id="fb_code" name="fb_code" value="<?=$bank->code;?>"
		autocomplete="off">
	<hr>
	<label>Host: <span>*</span></label>
	<input type="text" id="fb_host" name="fb_host" value="<?=$bank->db_host;?>"
		autocomplete="off">
	<br>
	<label>Base de Datos: <span>*</span></label>
	<input type="text" id="fb_db" name="fb_db" value="<?=$bank->db_database;?>"
		autocomplete="off">
	<br>
	<label>Usuario: <span>*</span></label>
	<input type="text" id="fb_user" name="fb_user" value="<?=$bank->db_user;?>"
		autocomplete="off">
	<br>
	<label>Contraseña: </label>
	<input type="password" id="fb_pass" name="fb_pass" value="<?=$bank->db_password;?>"
		autocomplete="off">
	<br>

	<hr>
	<label style="text-align: center;">Productos Asignados</label>
	<br>
<?php
if (($rs = $bank->getProduct()) !== false) {
	while ($row = $rs->fetch_array(MYSQLI_ASSOC)) {
		$checkPr = '';

		if ($action === 2) {
			if ($rsPr !== false) {
				if ($rsPr->data_seek(0) === true) {
					while ($rowPr = $rsPr->fetch_array(MYSQLI_ASSOC)) {
						if ($rowPr['pr_codigo'] === $row['pr_codigo']) {
							$checkPr = 'checked';
						}
					}
				}
			}
		}

		echo '<label class="check" style="width:auto; text-align:center;">
			<input type="checkbox" id="fb_pr_' . strtolower($row['pr_codigo']) .'" 
			name="fb_pr_' . strtolower($row['pr_codigo']) .'" 
			value="' . base64_encode($row['pr_id']) . '"' . $checkPr . '>
			' . $row['pr_nombre'] . '
		</label>';
	}

	$rs->free();
}
?>

	<hr>
	<label style="text-align: center;">Aseguradora</label>
	<br>
<?php
if (($rs = $bank->getInsurance()) !== false) {
	while ($row = $rs->fetch_array(MYSQLI_ASSOC)) {
		$checkIn = '';

		if ($action === 2) {
			if ($rsIn !== false) {
				if ($rsIn->data_seek(0) === true) {
					while ($rowIn = $rsIn->fetch_array(MYSQLI_ASSOC)) {
						if ($rowIn['as_codigo'] === $row['as_codigo']) {
							$checkIn = 'checked';
						}
					}
				}
			}
		}

		echo '<label class="check" style="width:auto; text-align:center;">
			<input type="checkbox" id="fb_in_' . strtolower($row['as_codigo']) .'" 
			name="fb_in_' . strtolower($row['as_codigo']) .'" 
			value="' . base64_encode($row['as_id']) . '"' . $checkIn . '>
			' . $row['as_nombre'] . '
		</label>';
	}

	$rs->free();
}
?>
	<br><br>

	<input type="hidden" id="fb_action" name="fb_action" value="<?=$action;?>">
<?php
if ($action === 2) {
	echo '<input type="hidden" id="fb_id" name="fb_id" value="' . base64_encode($bank->id) . '">';
}
?>
	<input type="submit" id="fb_add" name="fb_add" value="<?=$form_title;?>">
	<a href="<?=$_SERVER['HTTP_REFERER'];?>" class="cancel-action">Cancelar</a>
	<br>
	<div id="result_fbank" class="loading loading-02" style="color:#414141;"></div>
</form>
<script type="text/javascript">
$(document).ready(function(){
	$('#bank_form').submit(function(e){
		e.preventDefault();
		$(this).find(':submit').prop('disabled', true);

		$('#result_fbank').html('');
		$("#result_fbank").show();
		var token = true;

		$(this).find('input[type=text]').each(function(index, element) {
			var value = element.value;
			
			if (value === null || value.length === 0 || /^\s*$/.test(value)) {
				token = false;
           	}
		});

		if (token === true) {
			var _data = $(this).serialize();

			$.ajax({
				url: 'bank.php',
				type: 'POST',
				data: _data,
				async: true,
				cache: false,
				beforeSend: function(){
				},
				complete: function(){
					$("#result_fbank").removeClass('loading-02');
				},
				success: function(result){
					$('#result_fbank').html(result);

					setTimeout(function() {
						location.href = 'index.php?adm=1';
					}, 3000);
				}
			});
		} else {
			$("#result_fbank").removeClass('loading-02');
			$('#result_fbank').html('Los campos marcados con (*) son obligatorios');
			$(this).find(':submit').prop('disabled', false);
		}
	})
});
</script>