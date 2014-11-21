<?php
require_once $_SESSION['dir'] . '/app/controllers/AdminUserController.php';
$adminUser = new AdminUserController();

$sw;
$type = '';
$dpto = '';
$user = '';
$name = '';
$email = '';
$readonly = '';

$action = '';
$token = '';
$button = '';
$mess01 = '';
$mess02 = '';
$mess03 = '';
$mess04 = '';

if ($data == 0) {
	$sw = false;
	$action = 'app/views/proccess.php';
	$token = 'token-adduser';
	$button = 'Agregar Usuario';
	$mess01 = 'Usuario Agregado correctamente';
	$mess02 = 'No se pudo Agregar el Usuario';
	$mess03 = 'No se puede Agregar el Usuario';
	$mess04 = 'El Usuario no puede ser creado';
} else {
	$sw = true;
	$action = 'app/views/proccess.php';
	$token = 'token-upduser';
	$button = 'Actualizar Datos';
	$mess01 = 'Los datos se actualizaron correctamente';
	$mess02 = 'No se pudo actualizar los datos';
	$mess03 = 'No se puede actualizar los datos';
	$mess04 = 'Los datos no pueden ser actualizados';

	$rsUser = $adminUser->getUser($data);

	if($rsUser->num_rows == 1 ){
		$rowUser = $rsUser->fetch_array(MYSQLI_BOTH);
		$type = (int)$rowUser['permiso'];
		$dpto = (int)$rowUser['departamento'];
		$user = $rowUser['usuario'];
		$name = $rowUser['nombre'];
		$email = $rowUser['email'];
		$readonly = 'disabled';
	}
	$rsUser->free();
}
?>
<script type="text/javascript">
$(document).ready(function(e) {
	$('#fa-user').blur(function(){
		verifyUserName($(this).prop("id"));
	});

	$('#fa-pass-confirm').keyup(function(){
		var id_pass = $('#fa-pass').prop("id");
		var id_pass_confirm = $('#fa-pass-confirm').prop("id");
		validatePassword(id_pass,id_pass_confirm);
	});

	$("#form-add").submit(function(e){
		$("#form-add :submit").attr('disabled', true);
		e.preventDefault();
		var id_form = $(this).prop("id");

		var sw_val = true;

		$('#'+id_form+' input[type="text"], #'+id_form+' input[type="password"], #'+id_form+' select').each(function(){
			if(validateFormLogin($(this)) == false){
				sw_val = false;
				return false;
			}
		});

		if(sw_val == true){
			verifyUserName($(this).prop("id"));

			var email = $('#fa-email').prop("value");
			if(validateEmail(email) == false){
				$('#fa-email + .error-text').html('El email '+email+' es Invalido');
				$('#fa-key').prop("value",0);
				sw_val = false;
			}else{
				$('#fa-email + .error-text').html('');
				$('#fa-key').prop("value",'<?=md5('ok');?>');
			}
		}

		var id_pass = $('#fa-pass').prop("id");
		var id_pass_confirm = $('#fa-pass-confirm').prop("id");

		if(validatePassword(id_pass,id_pass_confirm) == false){
			$('#fa-key').prop("value",0);
			sw_val = false;
		}else{
			$('#fa-key').prop("value",'<?=md5('ok');?>');
		}

		var key = $('#fa-key').prop("value");

		if(sw_val == true && key == '<?=md5('ok');?>'){
			var data_user = $(this).serialize();
			//alert (data_add);
			$.ajax({
				url:"<?=$action;?>",
				async:true,
				cache:false,
				type:'POST',
				data:"<?=$token?>=&"+data_user,
				beforeSend: function(){
					$("#result-adduser").html('');
					$("#result-adduser").addClass('loading-02');
					$("#result-adduser").show();
				},
				complete: function(){
					$("#result-adduser").removeClass('loading-02');
				},
				success: function(result){
					switch(result){
						case '<?=md5('1');?>':
							$("#result-adduser").html('<?=$mess01;?>');
							setTimeout(function(){location.reload(true);},1000);
							$("#form-add :submit").attr('disabled', true);
							break;
						case '<?=md5('2');?>':
							$("#result-adduser").html('<?=$mess02;?>');
							$("#form-add :submit").attr('disabled', false);
							break;
						case '<?=md5('3');?>':
							$("#result-adduser").html('<?=$mess03;?>');
							$("#form-add :submit").attr('disabled', false);
							break;
						case '0':
							$("#result-adduser").html('<?=$mess04;?>');
							$("#form-add :submit").attr('disabled', false);
							break;
					}
					//setTimeout(function(){location.reload(true);},3000);
				}
			});
			return false;
		}else{
			$("#form-add :submit").attr('disabled', false);
		}
	});

	$("#fa-user").keyup(function(){
		var userName = $(this).prop("value");
		userName = userName.replace(/\s/g,'');
		$(this).prop("value",userName.toLowerCase());
	});

	$("#fa-type").change(function(){
		var val_type = $(this).prop('value');
		if (val_type === '1414006202' 
			|| val_type === '1414006203'
			|| val_type === '1414006204') {
			$("#container-client").slideDown();
		} else {
			$("#container-client").slideUp();
		}
	});
});

function verifyUserName(id_field){
	var userName = $.trim($('#'+id_field).prop('value'));
	if(userName != ''){
		$.get('app/views/proccess.php', {userName: userName}, function(result){
			if(result != '<?=md5('1');?>'){
				$('#fa-key').prop("value",0);
				$('#'+id_field).prop("value",'');
				$('#'+id_field+' + .error-text').html('El Usuario '+userName+' ya existe');
				$('#'+id_field).focus();
			}else{
				$('#'+id_field+' + .error-text').html('');
				$('#fa-key').prop("value",'<?=md5('ok');?>');
			}
		});
	}else{
		$('#'+id_field).focus();
		$('#'+id_field+' + .error-text').html('Campo Obligatorio');
	}

}
</script>

<form id="form-add" name="form-add" action="" method="post" class="f-admin-user">
	<label><span>*</span> Tipo de Usuario: </label>
	<select id="fa-type" name="fa-type">
		<option value="">-Seleccione-</option>
<?php
$rsType = $adminUser->getUserType();

if($rsType->num_rows > 0){
	while($rowType = $rsType->fetch_array(MYSQL_BOTH)){
		if ($type === (int)$rowType['id']) {
			echo '<option value="'.$rowType['id'].'" selected>'.$rowType['permiso'].'</option>';
		} else {
			echo '<option value="'.$rowType['id'].'">'.$rowType['permiso'].'</option>';
		}
	}
}
$rsType->free();
?>
	</select>
	<div class="error-text"></div>


	<label><span>*</span> Departamento: </label>
	<select id="fa-dpto" name="fa-dpto">
		<option value="">-Seleccione-</option>
<?php
$rsDpto = $adminUser->getDpto();

if($rsDpto->num_rows > 0){
	while($rowDpto = $rsDpto->fetch_array(MYSQL_BOTH)){
		if ($dpto === (int)$rowDpto['id']) {
			echo '<option value="'.$rowDpto['id'].'" selected>'.$rowDpto['departamento'].'</option>';
		} else {
			echo '<option value="'.$rowDpto['id'].'">'.$rowDpto['departamento'].'</option>';
		}
	}
}
$rsDpto->free();
?>
	</select>
	<div class="error-text"></div>
<?php
$display = 'display:none;';
if($type === 1414006202 || $type === 1414006203 || $type === 1414006204){
	$display = 'display:block;';
}
?>
	<div id="container-client" style="border:1px solid #AED7FF; <?=$display;?> ">
		<label style="width:auto; text-align:center;">Clientes:</label><label>&nbsp;</label><br>
<?php
$rsEF = $adminUser->getEF();

if($rsEF->num_rows > 0){
	if($type === 1414006202 || $type === 1414006203 || $type === 1414006204){

		$rsEFU = $adminUser->getEFUser($data);
	}
	$i = 0;
	while($rowEF = $rsEF->fetch_array(MYSQLI_BOTH)){
		$i += 1;
		if($type === 1414006202 || $type === 1414006203 || $type === 1414006204){
			$checkCl = '';
			if($rsEFU->num_rows > 0){
				$rsEFU->data_seek(0);
				while($rowEFU = $rsEFU->fetch_array(MYSQLI_BOTH)){

					$test = $rowEFU['ef_nombre'];
					if($rowEFU['ef_id'] == $rowEF['ef_id'])
						$checkCl = 'checked';
				}
			}
?>

		<label class="check" style="width:auto; text-align:center;">
			<input type="checkbox" id="fa-cl-<?=$i;?>" name="fa-cl-[]" value="<?=base64_encode($rowEF['ef_id']);?>" <?=$checkCl;?> /><?=$rowEF['ef_nombre'];?>


		</label>
<?php
		}else{
?>
		<label class="check" style="width:auto; text-align:center;">
			<input type="checkbox" id="fa-cl-<?=$i;?>" name="fa-cl-[]" value="<?=base64_encode($rowEF['ef_id']);?>" /><?=$rowEF['ef_nombre'];?>
		</label>
<?php
		}
	}
}
$rsEF->free();
?>
	</div>

	<label><span>*</span> Nombre de Usuario: </label>
		<input type="text" id="fa-user" name="fa-user" autocomplete="off" value="<?=$user;?>" <?=$readonly;?> />
	<div class="error-text"></div>

<?php
if($data == 0){
?>
	<label><span>*</span> Contraseña: </label>
	<input type="password" id="fa-pass" name="fa-pass" autocomplete="off"  />
	<div class="error-text"></div>

	<label><span>*</span> Repetir Contraseña: </label>
	<input type="password" id="fa-pass-confirm" name="fa-pass-confirm" autocomplete="off"  />
	<div class="error-text"></div>
<?php
}else{
?>
	<input type="hidden" id="fa-user" name="fa-user" value="<?=base64_encode($data);?>" />
<?php
}
?>
	<label><span>*</span> Nombre Completo: </label>
	<input type="text" id="fa-name" name="fa-name" autocomplete="off" value="<?=$name;?>" />
	<div class="error-text"></div>

	<label><span>*</span> Email: </label>
	<input type="text" id="fa-email" name="fa-email" autocomplete="off" value="<?=$email;?>" />
	<div class="error-text"></div>

	<input type="submit" id="fa-adduser" name="fa-adduser" value="<?=$button;?>" />
	<a href="<?=$_SERVER['HTTP_REFERER'];?>" class="cancel-action">Cancelar</a>
	<input type="hidden" id="fa-key" name="fa-key" value="<?=md5('ok');?>" />
	<br>

	<div id="result-adduser" class="loading loading-02" style="color:#414141;"></div>
</form>
