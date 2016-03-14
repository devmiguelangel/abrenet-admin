<?php
/**
* Administracion de Usuarios
*/
require_once $GLOBALS['DOCUMENT_ROOT'] . '/app/config/administrator.php';

class AdminUserController extends Administrator
{

	public function __construct()
	{
		// $this->cx = new Administrator();
		parent::__construct();
	}

	public function getUsers($id_user, $type)
	{
		$sql = 'select
			su.id,
			su.usuario,
			su.nombre,
			su.email,
			sd.departamento as dep_nombre,
			sd.codigo as dep_codigo,
			sup.permiso as up_permiso,
			sup.codigo as up_codigo,
			su.activado,
			su.actualizacion_password
		from
			sa_usuario as su
				inner join
			sa_departamento as sd ON (sd.id = su.departamento)
				inner join
			sa_usuario_permiso as sup ON (sup.id = su.permiso)
		';
		if ($type !== 1414006201) {
				$sql .= 'where su.id = '.$id_user;
		}
		$sql .= ' order by su.usuario asc';

		if (($rs = $this->query($sql, MYSQLI_STORE_RESULT)) !== false) {
			return $rs;
		} else {
			return false;
		}
	}

	public function getUserEF($id)
	{
		$sql = 'select su.id as u_id, su.usuario as u_usuario, sef.nombre as ef_nombre, sef.codigo as ef_codigo
			from sa_ef_usuario as sefu
				inner join
			sa_usuario as su on sefu.usuario = su.id
				inner join
			sa_entidad_financiera as sef on sefu.entidad_financiera = sef.id
				where
			su.id = '.base64_decode($id);

		if (($rs = $this->query($sql, MYSQLI_STORE_RESULT)) !== false) {
			return $rs;
		} else {
			return false;
		}
	}

	public function getUserType()
	{
		$sql = 'select
			sup.id,
			sup.permiso
		from
			sa_usuario_permiso as sup
		;';

		if (($rs = $this->query($sql, MYSQLI_STORE_RESULT)) !== false) {
			return $rs;
		} else {
			return false;
		}
	}

	public function getDpto()
	{
		$sql = 'select
			sd.id,
			sd.departamento
		from
			sa_departamento as sd
		;';

		if (($rs = $this->query($sql, MYSQLI_STORE_RESULT)) !== false) {
			return $rs;
		} else {
			return false;
		}
	}

	public function getEF()
	{
		$sql = 'select sef.id as ef_id, sef.nombre as ef_nombre
			from sa_entidad_financiera as sef
			where activado = 1
			';

		if (($rs = $this->query($sql, MYSQLI_STORE_RESULT)) !== false) {
			return $rs;
		} else {
			return false;
		}
	}

	public function addUser($data){

	$add_id = date('U');
	$add_type = (int)$this->escape_string(trim($data['add_type']));
	$add_dpto = (int)$this->escape_string(trim($data['add_dpto']));
	$add_user = $this->escape_string(trim($data['add_user']));
	$add_pass = $data['add_pass'];
	$add_pass_confirm = $data['add_pass_confirm'];
	$add_name = $this->escape_string(trim($data['add_name']));
	$add_email = $data['add_email'];
	$add_key = $data['add_key'];
	$add_ef = $data['add_ef'];

		if($add_key == md5('ok') && $add_pass == $add_pass_confirm){
			$add_pass = $this->crypt_blowfish_bycarluys($add_pass);

			$sqlAddU = "insert into sa_usuario VALUES
					(".$add_id.", '".$add_user."', '".$add_pass."', '".$add_name."', '".$add_email."',
					".$add_dpto.", ".$add_type.", curdate(), 1, 1) ;";

			if($this->query($sqlAddU,MYSQLI_USE_RESULT) === TRUE){
				$add_uc_id = date('U');
				$dataCl = "";

				if ($add_type === 1414006201) {
					$sqlCl = "select id from sa_entidad_financiera order by id asc;";

					$rsCl = $this->query($sqlCl,MYSQLI_STORE_RESULT);
					if($rsCl->num_rows > 0){
						while($rowCl = $rsCl->fetch_array(MYSQLI_BOTH)){
							$dataCl .= "(".$add_uc_id.", ".$add_id.", ".$rowCl['id']."),";
							$add_uc_id += 1;
						}
						$dataCl = trim($dataCl,',');
					}
				} elseif ($add_type === 1414006202 
					|| $add_type === 1414006203 
					|| $add_type === 1414006204  ) {

					if($add_ef != FALSE){
						$client = $add_ef;
						for($i = 0; $i < count($client);$i++){
							$dataCl .= "('".$add_uc_id."', '".$add_id."', '".base64_decode($client[$i])."'),";
							$add_uc_id += 1;
						}
						$dataCl = trim($dataCl,',');
					}
				}

				if ($dataCl != "") {
					$sqlAddUC = "insert into sa_ef_usuario values ".$dataCl." ;";
					if ($this->query($sqlAddUC,MYSQLI_USE_RESULT) === TRUE) {
						return md5('1');
					} else {
						return md5('2');
					}
				} else {
					return md5('1');
				}
			} else {
				return md5('2');
			}
		}else{
			return md5('3');
		}

	}

	public function crypt_blowfish_bycarluys($password, $digito = 7) {
		$set_salt = './1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$salt = sprintf('$2x$%02d$', $digito);
		for($i = 0; $i < 22; $i++){
			$salt .= $set_salt[mt_rand(0, 63)];
		}
		return crypt($password, $salt);
	}

	public function verifyUserName($userName)
	{
		$sql = "select COUNT(usuario) as flag
			from sa_usuario
			where usuario = '".$userName."'
			;";

		if(($rs = $this->query($sql,MYSQLI_USE_RESULT))){
			$row = $rs->fetch_array(MYSQLI_BOTH);
			$rs->free();
			if($row['flag'] == 0){
				return md5('1');
			}
		}else{
			return '0';
		}

	}

	public function getUser($id)
	{
		$sql = "select
			su.permiso,
			su.departamento,
			su.usuario,
			su.nombre,
			su.email,
			su.activado
		from
			sa_usuario as su
				inner join
			sa_usuario_permiso as sup ON (sup.id = su.permiso)
				inner join
			sa_departamento as sd ON (sd.id = su.departamento)
		where su.id = ".$id."
		order by su.usuario asc;
			";

		if (($rs = $this->query($sql, MYSQLI_STORE_RESULT)) !== false) {
			return $rs;
		} else {
			return false;
		}
	}

	public function getEFUser($id)
	{
		$sql = "select
			sef.id as ef_id, sef.nombre as ef_nombre
		from
			sa_ef_usuario as seu
		inner join
			sa_usuario as su on seu.usuario = su.id
		inner join
			sa_entidad_financiera as sef on seu.entidad_financiera = sef.id
		where
			su.id = ".$id."
			";

		if (($rs = $this->query($sql, MYSQLI_STORE_RESULT)) !== false) {
			return $rs;
		} else {
			return false;
		}
	}

	public function updUser($data){

	$upd_id = base64_decode($data['upd_id']);
	$upd_type = (int)$this->escape_string(trim($data['upd_type']));
	$upd_dpto = (int)$this->escape_string(trim($data['upd_dpto']));
	$upd_name = $this->escape_string(trim($data['upd_name']));
	$upd_email = $data['upd_email'];
	$upd_key = $data['upd_key'];
	$upd_ef = $data['upd_ef'];


		if($upd_key == md5('ok') && $upd_key != ''){
			$sqlUpdU = "update sa_usuario
					set nombre = '".$upd_name."', permiso = ".$upd_type.", email = '".$upd_email."', departamento = '".$upd_dpto."'
					where id = ".$upd_id." ;";
			if($this->query($sqlUpdU,MYSQLI_USE_RESULT) === TRUE){
				$add_uc_id = date('U');
				$dataCl = "";

////
				if ($upd_type === 1414006201) {
					$sqlCl = "select id from sa_entidad_financiera order by id asc;";

					$rsCl = $this->query($sqlCl,MYSQLI_STORE_RESULT);
					if($rsCl->num_rows > 0){
						while($rowCl = $rsCl->fetch_array(MYSQLI_BOTH)){
							$dataCl .= "(".$add_uc_id.", ".$upd_id.", ".$rowCl['id']."),";
							$add_uc_id += 1;
						}
						$dataCl = trim($dataCl,',');
					}
				}

				if ($upd_type === 1414006202 
					|| $upd_type === 1414006203 
					|| $upd_type = 1414006204 ) {
					//if(isset($_POST['fa-cl-'])){
					if($upd_ef != FALSE){
						$client = $upd_ef;
						for($i = 0; $i < count($client);$i++){
							$dataCl .= "(".$add_uc_id.", ".$upd_id.", ".base64_decode($client[$i])."),";
							$add_uc_id += 1;
						}
						$dataCl = trim($dataCl,',');
					}
				}

				$sw_del = false;
				if ($upd_type === 1414006201 
					|| $upd_type === 1414006202 
					|| $upd_type === 1414006203 
					|| $upd_type = 1414006204 ) {
					$sqlDelU = "delete from sa_ef_usuario where usuario = ".$upd_id." ;";
					if($this->query($sqlDelU,MYSQLI_USE_RESULT) === TRUE){
						$sw_del = true;
					}
				}

				if ($dataCl != '' && $sw_del == true) {
					$sqlAddUC = "insert into sa_ef_usuario  values ".$dataCl." ;";
					if ($this->query($sqlAddUC,MYSQLI_USE_RESULT) === TRUE) {
						return md5('1');
					} else {
						return md5('2');
					}
				} else {
					return md5('1');
				}
			} else {
				return md5('2');
			}
		} else {
			return md5('3');
		}

	}

	public function delUser($data){

	$del_id = base64_decode($data['del_id']);

		$sql = "update sa_usuario
				set activado = 0
				where id = ".$del_id." ;";
		if($this->query($sql,MYSQLI_USE_RESULT) === TRUE){
			return md5('1');
		} else {
			return md5('1');
		}

	}
	public function changePassUser($data){

	$cg_user = base64_decode($data['cg_user']);
	$cg_pass = "";

	$cg_pass = $this->escape_string(trim($data['cg_pass']));

	$cg_new_pass = $this->escape_string(trim($data['cg_new_pass']));
	$cg_repeat_pass = $this->escape_string(trim($data['cg_repeat_pass']));

	$cg_token_cpass = $data['cg_token_cpass'];
	$cg_token_rpass = $data['cg_token_rpass'];

	$cg_key = $data['cg_key'];

		if($cg_key == md5('ok')){

			$sqlUser = "select
					id, usuario, password
				from
					sa_usuario
				where id = '".$cg_user."';";

			$rsUser = $this->query($sqlUser,MYSQLI_STORE_RESULT);
			if($rsUser->num_rows == 1){
				$rowUser = $rsUser->fetch_array(MYSQLI_BOTH);
				$sw_token = FALSE;

				if( $cg_token_cpass == TRUE){
					if((crypt($cg_pass, $rowUser['password']) == $rowUser['password']) && ($cg_new_pass == $cg_repeat_pass)){
						$sw_token = TRUE;
					}else{
						return md5('2');
					}
				}elseif( $cg_token_rpass == TRUE ){
					if($cg_new_pass == $cg_repeat_pass){
						$sw_token = TRUE;
					}else{
						return md5('2');
					}
				}

				if($sw_token == TRUE){
					$cg_new_pass = $this->crypt_blowfish_bycarluys($cg_new_pass);

					$sqlPass = "update sa_usuario
							set password = '".$cg_new_pass."'
						where id = '".$rowUser['id']."' ;";
					if($this->query($sqlPass,MYSQLI_USE_RESULT) === TRUE){
						return md5('1');
					}else{
						return md5('2');
					}
				}
			}else{
				return '0';
			}
			$rsUser->free();
		}else{
			return '0';
		}

	}

	public function verifyPass($data)
	{
	$user = base64_decode($data['user']);
	$pass = $data['pass'];

		$sqlPass = "select  id, usuario, password
			from sa_usuario
			where id = ".$user."
			;";

		$rsPass = $this->query($sqlPass,MYSQLI_STORE_RESULT);
		if($rsPass->num_rows == 1){
			$rowPass = $rsPass->fetch_array(MYSQLI_BOTH);
			if(crypt($pass, $rowPass['password']) == $rowPass['password']){
				return '1';
			}else{
				return '0';
			}
		}else{
			return '0';
		}


	}
}