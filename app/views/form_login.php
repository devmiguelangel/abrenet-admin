<?php
require_once $_SESSION['dir'] . '/app/controllers/ClientController.php';

$client_token = false;
if (isset($_GET['cl'])) {
	$cl = new ClientController();

	$cl->code = strtoupper($cl->real_escape_string(trim($_GET['cl'])));

	if ($cl->getClientByCode() === true) {
		$client_token = true;
	}
}
?>

<link type="text/css" href="css/jquery.realperson.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery.realperson.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
	$("#fl-sin").realperson({
		length: 6,
		includeNumbers: true,
		regenerate: 'Click para Cambiar'
	});
	
	$("#form-login").submit(function(e){
		$("#form-login :submit").attr('disabled', true);
		e.preventDefault();
		var id_form = $(this).prop("id");
		
		var value_field = $("#fl-captcha").prop('value');
		var value_captcha = $('input[name="fl-sinHash"]').prop('value');
		
		var sw_val = true;
		$('#' + id_form + ' input[type="text"], #' + id_form + ' input[type="password"]').each(function() {
			if (validateFormLogin($(this)) == false) {
				sw_val = false;
				return false;
			}
		});
		
		if (sw_val == true) {
			if (validateCaptcha(value_field,value_captcha) == true) {
				var data_login = $(this).serialize();
				
				$.ajax({
					url: 'login.php',
					async: true,
					cache: false,
					type: 'POST',
					dataType: 'json',
					data: data_login,
					beforeSend: function(){
						$("#result-login").html('');
						$("#result-login").addClass('loading-01');
						$("#result-login").show();
					},
					complete: function(){
						$("#result-login").removeClass('loading-01');
					},
					success: function(result){
						// $("#result-login").html(result);
						
						$("#result-login").html(result['msg']);
						if (result['key'] === true) {
							location.href = result['lnk'];
						} else {
							$("#form-login :submit").attr('disabled', false);
						}
					}
				});

				return false;
			} else {
				$("#form-login :submit").attr('disabled', false);
				$("#fl-captcha + .error-text").html('Error');
				$("#fl-captcha").prop('value','');
			}
		} else {
			$("#form-login :submit").attr('disabled', false);
		}
		
	});
});
</script>

<form id="form-login" name="form-login" method="post" action="">
	<div id="fl-header">Accede a tu cuenta</div>
<?php
if ($client_token === true) {
	echo '<input type="hidden" id="Client-id" name="Client-id" value="' . base64_encode($cl->id) . '">';
}
?>	
	<label>Usuario</label>
	<span class="fl-icon"></span><input type="text" id="fl-user" name="fl-user" 
		value="" autocomplete="off" placeholder="Tu Usuario" class="fl-text" />
	<div class="error-text"></div>

	<label>Contraseña</label>
	<span class="fl-icon fl-icon2"></span><input type="password" id="fl-pass" name="fl-pass" 
		value="" autocomplete="off" placeholder="Tu Contraseña" class="fl-text" />
	<div class="error-text"></div>
	
	<div align="center">
		<label style="width:300px; font-size: 80%;">Por favor, introduzca las letras que aparecen:</label>
		<input type="text" id="fl-captcha" name="fl-captcha" class="fl-text" 
			style="width:100px; margin:5px auto; font-size:100%; color:#000;" maxlength="10" autocomplete="off" >
		<div class="error-text"></div>
	</div>
	<input type="submit" id="fl-sin" name="fl-sin" value="Ingresar" />
	<div id="result-login" class="loading"></div>
</form>