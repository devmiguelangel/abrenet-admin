<?php
require_once $GLOBALS['DOCUMENT_ROOT'] . '/app/controllers/AdminUserController.php';
$adminUser = new AdminUserController();

$id_user = base64_decode($_SESSION['id_user']);

$rsUs = $adminUser->getUser($id_user);

	if($rsUs->num_rows == 1 ){
		$rowUs = $rsUs->fetch_array(MYSQLI_BOTH);
		$userType = (int)$rowUs['permiso'];
	}
	$rsUs->free();

$rsUser = $adminUser->getUsers($id_user, $userType);
if($rsUser->num_rows > 0){
?>

<script type="text/javascript">
$(document).ready(function(e) {
	$(".action-user").click(function(e){
	e.preventDefault();
	var rel = $(this).prop('rel');
	var data = $(this).attr('data-rel');
	var dir = $('#dir').prop('value');

	$.ajax({
		type:"GET",
		url:"user.php",
		async:true,
		cache:false,
		data:'rel=' + rel + '&data=' + data + '&dir=' + dir,
		beforeSend: function(){
			$("#container-user").hide();
		},
		complete: function(){
			$("#container-user").fadeIn();
		},
		success: function(result){
			$("#container-user").html(result);
			}
		});
	});
});
</script>

<div class="subtitle">Administración de Usuarios</div>
<div id="container-user">
<?php
		if ($userType === 1414006201) {
?>
	<a href="#" class="action-user" rel="<?=md5('1');?>" data-rel="0">
	<img src="img/add-user-icon.png" width="48" height="48" alt="Agregar Usuario" title="Agregar Usuario" /><br>
	<span>Agregar Usuario</span>
	<input type="hidden" id="dir" name="dir" value="<?=base64_encode($GLOBALS['DOCUMENT_ROOT']);?>">
	</a>
<?php
		}
?>
<div class="result-search">
	<table class="user-result">
		<thead>
			<tr>
				<td style="width:10%;">Usuario</td>
				<td style="width:20%;">Nombre Completo</td>
				<td style="width:10%;">Departamento</td>
				<td style="width:10%;">Tipo de Usuario</td>
				<td style="width:25%;">Permisos</td>
				<td style="width:25%;">&nbsp;</td>
			</tr>
		</thead>

		<tbody>
		<?php
		while($rowUser = $rsUser->fetch_array(MYSQLI_BOTH)){
		$idUser = base64_encode($rowUser['id']);

		$rsUserEF = $adminUser->getUserEF($idUser);

		$permission = '';
			if($rsUserEF->num_rows > 0){
				while($rowUserEF = $rsUserEF->fetch_array(MYSQLI_BOTH)){
					$permission .= '<div class="permission">'.$rowUserEF['ef_nombre'].'</div>';
				}
				$rsUserEF->free();
			}else{
				$rsUserEF->free();
			}

		$backgroud_active = '';
		if($rowUser['activado'] == 0){
			$backgroud_active = 'background:#FFB9B9;';
		}
		?>
			<tr style=" <?=$backgroud_active;?> ">
			<td><?=$rowUser['usuario'];?></td>
			<td><?=$rowUser['nombre'];?></td>
			<td><?=$rowUser['dep_nombre'];?></td>
			<td><?=$rowUser['up_permiso'];?></td>
			<td><?=$permission;?></td>
			<td style="background:#FFFFFF; border-bottom:1px solid #D2D2D2;">
	<?php
				if ($userType === 1414006201) {
	?>
				<a href="#" class="action-user action-user-02" rel="<?=md5('2');?>" data-rel="<?=$idUser;?>">
					<img src="img/edit-user-icon.png" width="36" height="36" alt="Editar" title="Editar" /><br>
					<span>Editar Usuario</span>
				</a>
				<a href="#" class="action-user action-user-02" rel="<?=md5('3');?>" data-rel="<?=$idUser;?>">
					<img src="img/remove-user-icon.png" width="36" height="36" alt="Dar de Baja" title="Dar de Baja" /><br>
					<span>Dar de Baja</span>
				</a>
	<?php
				}
	?>
				<a href="#" class="action-user action-user-02" rel="<?=md5('4');?>" data-rel="<?=$idUser;?>">
					<img src="img/change-pass-icon.png" width="36" height="36" alt="Cambiar Contraseña" title="Cambiar Contraseña" /><br>
					<span>Cambiar Contraseña</span>
				</a>
				<a href="#" class="action-user action-user-02" rel="<?=md5('5');?>" data-rel="<?=$idUser;?>">
					<img src="img/reset-pass-icon.png" width="36" height="36" alt="Resetear Contraseña" title="Resetear Contraseña" /><br>
					<span>Resetear Contraseña</span>
				</a>
			</td>
		</tr>

		<?php
		}
		$rsUser->free();
		?>

		</tbody>

	</table>
	</div>
</div>

<?php
	}
?>