<?php
/**
* User
*/
require $GLOBALS['DOCUMENT_ROOT'] . '/app/config/administrator.php';

class UserController extends Administrator
{
	public $id,
		$user,
		$password,
		$name,
		$email,
		$depto,
		$permission,
		$activated,
		$passwordUpdate,
		$ef,
		$token = false,

		$data = array(),
		$dataDepto = array(),
		$menu = array(
			1 => array(
				'key'	=> 1,
				'title'	=> 'Reportes Generales',
				'active'	=> false
				),
			2 => array(
				'key'	=> 2,
				'title'	=> 'Reportes Clientes',
				'active'	=> false
				),
			)
		;

	public $result = array(
		'msg' => ''
	);
	
	public function __construct()
	{
		parent::__construct();
	}

	public function login($user, $password)
	{
		$user = $this->real_escape_string(trim($user));
		$password = $this->real_escape_string(trim($password));

		$sql = 'select id, usuario, password
			from 
				sa_usuario as su
			where 
				su.usuario = "' . $user . '" 
					and su.activado = true 
		;';

		if (($rs = $this->query($sql, MYSQLI_STORE_RESULT)) !== false) {
			if ($rs->num_rows === 1) {
				$row = $rs->fetch_array(MYSQLI_ASSOC);
				$rs->free();

				if ($this->verifyPassword($password, $row['password']) === true) {
					$this->id = $row['id'];
					$this->result['msg'] = 'Bienvenido';
					return true;
				} else {
					$this->result['msg'] = 'La contraseña es incorrecta';
				}
			} else {
				$this->result['msg'] = 'El usuario no existe.';
			}
		} else {
			$this->result['msg'] = 'El usuario no existe';
		}

		return false;
	}

	public function getDataUser($id)
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
		where 
			su.id = ' . base64_decode($id) . '
		;';

		if (($rs = $this->query($sql, MYSQLI_STORE_RESULT)) !== false) {
			if ($rs->num_rows === 1) {
				$row = $rs->fetch_array(MYSQLI_ASSOC);
				$rs->free();

				$this->id = $row['id'];
				$this->user = $row['usuario'];
				$this->name = $row['nombre'];
				$this->email = $row['email'];
				$this->depto = array(
					'depto' 	=> $row['dep_nombre'], 
					'codigo' 	=> $row['dep_codigo']
				);
				$this->permission = array(
					'permiso'	=> $row['up_permiso'],
					'codigo'	=> $row['up_codigo']
				);
				$this->activated = $row['activado'];
				$this->passwordUpdate = $row['actualizacion_password'];

				return true;
			}
		}

		return false;
	}

	public function verifyUser($id)
	{
		
	}

	private function verifyPassword($input_password, $user_password)
	{
		if (crypt($input_password, $user_password) == $user_password) {
			return true;
		} else {
			return false;
		}
	}

	public function getDepto($codex = '')
	{
		$sql = 'select 
			sdep.id,
			sdep.departamento,
			sdep.codigo 
		from 
			sa_departamento as sdep
		where
			sdep.codigo like "%' . $codex . '%"
		;';

		if (($rs = $this->query($sql, MYSQLI_STORE_RESULT)) !== false) {
			if ($rs->num_rows > 0) {
				$this->dataDepto = array();
				while ($row = $rs->fetch_array(MYSQLI_ASSOC)) {
					$this->dataDepto[] = $row;
				}

				return true;
			}
		}

		return false;
	}

	private function cryptPass($password, $digit = 7) {
		$set_salt = './1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$salt = sprintf('$2x$%02d$', $digit);
		
		for ($i = 0; $i < 22; $i++) {
			$salt .= $set_salt[mt_rand(0, 63)];
		}
		
		return crypt($password, $salt);
	}

}
?>