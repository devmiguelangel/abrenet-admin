<?php
/**
* Client Database Controller
*/
class ClientDatabaseController
{
	private $db, $cx, $sql, $rs, $row;
	public $err,
		$id, $user, $pass, $name, $permission, $ef;
	
	function __construct($db)
	{
		$this->db = $db;
		$this->ef = $this->db['code'];

		@$this->cx = new mysqli($this->db['db_host'], $this->db['db_user'], 
			$this->db['db_password'], $this->db['db_database']);
		
		if ($this->cx->connect_error) {
			die('Error de Conexión (' . $this->cx->connect_errno . ' ) ' . $this->cx->connect_error);
		}
	}

	public function loginClient()
	{
		switch ($this->ef) {
		case 'EC':
			return $this->loginEcofuturo();
			break;
		case 'SS':
			# code...
			break;
		case 'EM':
			# code...
			break;
		case 'PV':
			# code...
			break;
		case 'ID':
			return $this->loginIdepro();
			break;
		case 'CR':
			return $this->loginCrecer();
			break;
		default:
			return false;
			break;
		}
	}

	private function loginEcofuturo()
	{
		$this->sql = 'select 
		    su.idusuario AS user_id,
		    su.idusuario AS user_username,
		    su.password AS user_pass,
		    su.nombre AS user_name,
		    su.tipo AS user_code
		from
		    tblusuarios AS su
		where
		    su.idusuario = "' . $this->user . '"
		        and su.activado = true
		LIMIT 0 , 1
		;';

		if (($this->rs = $this->cx->query($this->sql, MYSQLI_STORE_RESULT))) {
			if($this->rs->num_rows === 1){
				$this->row = $this->rs->fetch_array(MYSQLI_ASSOC);
				$this->rs->free();
				
				if(md5($this->pass) == $this->row['user_pass']){
					$this->setData();
					return true;
				}
			}
		}

		return false;
	}

	private function loginIdepro()
	{
		$this->sql = 'select 
			su.id_usuario as user_id,
			su.usuario as user_username,
			su.password as user_pass,
			su.nombre as user_name,
			sut.codigo as user_code
		from
			s_usuario as su
				inner join
			s_usuario_tipo as sut ON (sut.id_tipo = su.id_tipo)
				inner join
			s_ef_usuario as seu ON (seu.id_usuario = su.id_usuario)
				inner join
			s_entidad_financiera as sef ON (sef.id_ef = seu.id_ef)
		where
			su.usuario = "'.$this->user.'"
				and su.activado = true
				and sef.activado = true
		limit 0 , 1
		;';

		if (($this->rs = $this->cx->query($this->sql, MYSQLI_STORE_RESULT))) {
			if($this->rs->num_rows === 1){
				$this->row = $this->rs->fetch_array(MYSQLI_ASSOC);
				$this->rs->free();
				
				if(crypt($this->pass, $this->row['user_pass']) == $this->row['user_pass']){
					$this->setData();
					return true;
				}
			}
		}

		return false;
	}

	private function loginCrecer()
	{
		$this->sql = 'select 
			su.id_usuario as user_id,
			su.usuario as user_username,
			su.password as user_pass,
			su.nombre as user_name,
			sut.codigo as user_code
		from
			s_usuario as su
				inner join
			s_usuario_tipo as sut ON (sut.id_tipo = su.id_tipo)
				inner join
			s_ef_usuario as seu ON (seu.id_usuario = su.id_usuario)
				inner join
			s_entidad_financiera as sef ON (sef.id_ef = seu.id_ef)
		where
			su.usuario = "'.$this->user.'"
				and su.activado = true
				and sef.activado = true
		limit 0 , 1
		;';
	
		if (($this->rs = $this->cx->query($this->sql, MYSQLI_STORE_RESULT))) {
			if($this->rs->num_rows === 1){
				$this->row = $this->rs->fetch_array(MYSQLI_ASSOC);
				$this->rs->free();
				
				if(crypt($this->pass, $this->row['user_pass']) == $this->row['user_pass']){
					$this->setData();
					return true;
				}
			}
		}

		return false;
	}

	private function setData()
	{
		$this->id = $this->row['user_id'];
		$this->user = $this->row['user_username'];
		$this->name = $this->row['user_name'];
		$this->permission = $this->row['user_code'];

		unset($this->row);
	}

}
?>