<?php
/**
* Client Database Controller
*/
class ClientDatabaseController
{
	private $db, $cx, $user, $pass, $code;
	public $err;
	
	function __construct($db, $user, $pass)
	{
		$this->db = $db;
		$this->user = $user;
		$this->pass = $pass;

		$this->code = $this->db['code'];

		@$this->cx = new mysqli($this->db['db_host'], $this->db['db_user'], 
			$this->db['db_password'], $this->db['db_database']);
		
		if ($this->cx->connect_error) {
			die('Error de Conexión (' . $this->cx->connect_errno . ' ) ' . $this->cx->connect_error);
		}
	}

	public function loginClient()
	{
		switch ($this->code) {
		case 'EC':
			# code...
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
			# code...
			break;
		case 'CR':
			return $this->loginCrecer();
			break;
		default:
			return false;
			break;
		}
	}

	private function loginCrecer()
	{
		$sql = 'select 
			su.id_usuario,
			su.usuario,
			su.password,
			sut.id_tipo as tipo,
			sut.codigo as tipo_codigo
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
		order by sef.id_ef asc
		limit 0 , 1
		;';
	
		if (($rs = $this->cx->query($sql, MYSQLI_STORE_RESULT))) {
			if($rs->num_rows === 1){
				$row = $rs->fetch_array(MYSQLI_ASSOC);
				$rs->free();
				
				if(crypt($this->pass, $row['password']) == $row['password']){
					return true;
				}
			}
		}

		return false;
	}

}
?>