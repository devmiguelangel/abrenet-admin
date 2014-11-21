<?php
require_once $_SESSION['dir'] . '/app/controllers/AdminUserController.php';
$adminUser = new AdminUserController();

	$mess = '';
	$sw_del = FALSE;

	$rsUser = $adminUser->getUser($data, 1);

	if($rsUser->num_rows == 1){

		$rowUser = $rsUser->fetch_array(MYSQLI_BOTH);
		if($rowUser['activado'] == 1){
			$mess = '¿Esta seguro que desea dar de baja a el usuario '.$rowUser['usuario'].' ?';
			$sw_del = TRUE;
		}else{
			$mess = 'El usuario no existe o ya fue dado de baja';
		}
	}else{
		$mess = 'El usuario no existe o ya fue dado de baja';
	}

?>
<script type="text/javascript">
$(document).ready(function(e) {
	$("#form-del").submit(function(e){
		$("#form-del :submit").attr('disabled', true);
		e.preventDefault();

		var data_user = $(this).serialize();
		//alert (data_add);
		$.ajax({
			url:"app/views/proccess.php",
			async:true,
			cache:false,
			type:'POST',
			data:"token-deluser=&"+data_user,
			beforeSend: function(){
				$("#result-deluser").html('');
				$("#result-deluser").addClass('loading-02');
				$("#result-deluser").show();
			},
			complete: function(){
				$("#result-deluser").removeClass('loading-02');
			},
			success: function(result){
				switch(result){
					case '<?=md5('1');?>':
						$("#result-deluser").html('El usuario fue dado de baja exitosamente');
						setTimeout(function(){location.reload(true);},1000);
						$("#form-add :submit").attr('disabled', true);
						break;
					case '<?=md5('2');?>':
						$("#result-deluser").html('El usuario no puede ser dado de baja');
						$("#form-add :submit").attr('disabled', false);
						break;
					default:
						$("#result-deluser").html('No se puede dar de baja a este usuario');
						$("#form-add :submit").attr('disabled', false);
						break;
				}
				setTimeout(function(){location.reload(true);},3000);
			}
		});
		return false;
	});
});
</script>
<form id="form-del" name="form-del" action="" method="post" class="f-admin-user">
	<span style="display:block; margin:5px auto; font-size:110%; font-weight:bold; color:#FF4848;">
		<?=$mess;?>
	</span>
	<br>
<?php
	if($sw_del == TRUE){
?>
	<input type="hidden" id="fd-user" name="fd-user" value="<?=base64_encode($data);?>" />
	<input type="submit" id="fd-deluser" name="fd-deluser" value="SI" />
	<a href="<?=$_SERVER['HTTP_REFERER'];?>" class="cancel-action">NO</a>
<?php
	}else{
?>
	<a href="<?=$_SERVER['HTTP_REFERER'];?>" class="cancel-action">ACEPTAR</a>
<?php
	}
?>
	<div id="result-deluser" class="loading loading-02" style="color:#414141;"></div>
</form>
<?php
//}
?>