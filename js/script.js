// JavaScript Document
function validateFormLogin(field){
	var value = $(field).prop("value");
	var id_field = $(field).prop("id");
	
	if(value == ''){
		$('#'+id_field+' + .error-text').html('Campo Obligatorio');
		$(field).focus();
		return false;
	}else{
		$('#'+id_field+' + .error-text').html('');
		return true;
	}
}

function validateCaptcha(value,value_captcha){
	var hash = 5381;
	for (var i = 0; i < value.length; i++) {
		hash = ((hash << 5) + hash) + value.charCodeAt(i);
	}
	
	if(hash == value_captcha){
		return true;
	}else{
		return false;
	}
}

function validateEmail(email){
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) )
		return false;
	else
		return true;
}

function validatePassword(pass,pass_confirm){
	var vpass = $('#'+pass).prop("value");
	var vpass_confirm = $('#'+pass_confirm).prop("value");
	
	if(vpass != vpass_confirm){
		$('#'+pass_confirm).focus();
		$('#'+pass_confirm+' + .error-text').html('Las Contraseñas no son Iguales');
		return false;
	}else{
		$('#'+pass_confirm+' + .error-text').html('');
		return true;
	}
}