<?php
require_once('/../controllers/AdminUserController.php');
$adminUser = new AdminUserController();

$sw = FALSE;
$token = '';

if($rel == md5('4')){
	$sw = TRUE;
	$token = 'token-cpass';
}else{
	$sw = FALSE;
	$token = 'token-rpass';
}

$rsUser = $adminUser->getUser($data);

if($rsUser->num_rows == 1){
	$rowUser = $rsUser->fetch_array(MYSQLI_BOTH);
?>
<script type="text/javascript">
$(document).ready(function(e) {
	$("#form-cpass").submit(function(e){
		$("#form-cpass :submit").attr('disabled', true);
		e.preventDefault();

		var id_form = $(this).prop("id");

		var sw_val = true;

		$('#'+id_form+' input[type="password"]').each(function(){
			if(validateFormLogin($(this)) == false){
				sw_val = false;
				return false;
			}
		});

		var id_pass = $('#fc-new-pass').prop("id");
		var id_pass_confirm = $('#fc-repeat-pass').prop("id");

		if(validatePassword(id_pass,id_pass_confirm) == false){
			$('#fc-key').prop("value",0);
			sw_val = false;
		}else{
			$('#fc-key').prop("value",'<?=md5('ok');?>');
		}

		var key = $('#fa-key').prop("value");

		if(sw_val == true){
			var data_cpass = $(this).serialize();

			$.ajax({
				url:"app/views/proccess.php",
				async:true,
				cache:false,
				type:'POST',
				data:"<?=$token;?>=&user=<?=base64_encode($data);?>&"+data_cpass,
				beforeSend: function(){
					$("#result-cpass").html('');
					$("#result-cpass").addClass('loading-02');
					$("#result-cpass").show();
				},
				complete: function(){
					$("#result-cpass").removeClass('loading-02');
				},
				success: function(result){
					switch(result){
						case '<?=md5('1');?>':
							$("#result-cpass").html('La Contraseña se actualizó correctamente');
							$("#form-add :submit").attr('disabled', true);
							setTimeout(function(){location.reload(true);},1000);
							break;
						case '<?=md5('2');?>':
							$("#result-cpass").html('La Contraseña no puede ser actualizada');
							$("#form-add :submit").attr('disabled', false);
							break;
						case '0':
							$("#result-cpass").html('No se puede actualizar la contraseña');
							$("#form-add :submit").attr('disabled', false);
							break;
					}
				//	setTimeout(function(){location.reload(true);},3000);
				}
			});
			return false;
		}else{
			$("#form-cpass :submit").attr('disabled', false);
		}
	});

	$("#fc-pass").on({
		keyup: function(){
			var pass = $(this).prop('value');
			verifyPass(this,pass);
		},
		blur: function(){
			var pass = $(this).prop('value');
			verifyPass(this,pass);
		}
	});

	$("#fc-repeat-pass").on({
		keyup: function(){
			var id_pass = $('#fc-new-pass').prop("id");
			var id_pass_confirm = $('#fc-repeat-pass').prop("id");

			if(validatePassword(id_pass,id_pass_confirm) == false)
				$('#fc-key').prop("value",0);
			else
				$('#fc-key').prop("value",'<?=md5('ok');?>');
		},
		blur: function(){
			var id_pass = $('#fc-new-pass').prop("id");
			var id_pass_confirm = $('#fc-repeat-pass').prop("id");

			if(validatePassword(id_pass,id_pass_confirm) == false)
				$('#fc-key').prop("value",0);
			else
				$('#fc-key').prop("value",'<?=md5('ok');?>');
		}
	});

});

function verifyPass(form,pass){
	var id = $(form).prop('id');
	$.get("app/views/proccess.php", {user: '<?=base64_encode($data);?>', pass: pass},function(result){
		if(parseInt(result) == 1){
			$("#"+id+" + .error-text").html('La Contraseña es Correcta');
		}else if(parseInt(result) == 0){
			$("#"+id+" + .error-text").html('La Contraseña no es igual a la actual');
			$(form).focus();
		}
	});
}
</script>
<form id="form-cpass" name="form-cpass" action="" method="post" class="f-admin-user">
	<label style="text-align:center;"><?=$rowUser['usuario'];?></label><br>
	<label style="text-align:center;"><?=$rowUser['nombre'];?></label><br>

<?php
	if($sw == TRUE){
?>
	<label>Contraseña Actual:</label>
	<input type="password" id="fc-pass" name="fc-pass" value="" />
	<div class="error-text"></div>
<?php
	}
?>

	<label>Nueva Contraseña:</label>
	<input type="password" id="fc-new-pass" name="fc-new-pass" value="" />
	<div class="error-text"></div>

	<label>Repetir Contraseña:</label>
	<input type="password" id="fc-repeat-pass" name="fc-repeat-pass" value="" />
	<div class="error-text"></div>

	<input type="submit" id="fa-adduser" name="fa-adduser" value="Cambiar Contraseña" />
	<a href="<?=$_SERVER['HTTP_REFERER'];?>" class="cancel-action">Cancelar</a>
	<input type="hidden" id="fc-key" name="fc-key" value="<?=md5('ok');?>" />
	<br>

	<div id="result-cpass" class="loading loading-02" style="color:#414141;"></div>
</form>
<?php
}else{
	echo 'La Contraseña no puede ser modificada';
}
?>