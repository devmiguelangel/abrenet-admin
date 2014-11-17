<?php
/**
* Client Controller
*/

require_once '/../config/administrator.php';

class ClientController extends Administrator
{
	public
		$id,
		$name,
		$code,
		$domain,
		$db = array(),
		
		$sql, $rs, $row;
	
	function __construct()
	{
		parent::__construct();
	}

	public function getClientURL($url)
	{
		$data = explode('/', trim($url, '/'));
		$no_data = count($data);

		if ($no_data === 1) {
			$this->domain = $data[0];
			
			Domain:
			if ($this->getClientByDomain() === true) {
				$this->id = $this->row['id'];
				$this->name = $this->row['nombre'];
				$this->code = $this->row['codigo'];
				$this->domain = $this->row['dominio'];

				unset($this->row);
				return true;
			}
		} elseif ($no_data === 2) {
			$this->domain = $data[1];
			goto Domain;
		}

		return false;
	}

	private function getClientByDomain()
	{
		$this->sql = 'select 
			id,
			nombre,
			codigo,
			dominio
		from 
			sa_entidad_financiera
		where 
			dominio = "' . $this->domain . '"
				and activado = true
		;';

		if (($this->rs = $this->query($this->sql, MYSQLI_STORE_RESULT)) !== false) {
			if ($this->rs->num_rows === 1) {
				$this->row = $this->rs->fetch_array(MYSQLI_ASSOC);
				$this->rs->free();

				return true;
			}
		}

		return false;
	}

	public function getClientByCode()
	{
		$this->sql = 'select 
			id,
			nombre,
			codigo,
			dominio
		from 
			sa_entidad_financiera
		where 
			codigo = "' . $this->code . '"
				and activado = true
		;';

		if (($this->rs = $this->query($this->sql, MYSQLI_STORE_RESULT)) !== false) {
			if ($this->rs->num_rows === 1) {
				$this->row = $this->rs->fetch_array(MYSQLI_ASSOC);
				$this->rs->free();

				$this->id = $this->row['id'];
				$this->name = $this->row['nombre'];
				$this->code = $this->row['codigo'];
				$this->domain = $this->row['dominio'];

				unset($this->row);

				return true;
			}
		}

		return false;
	}

	public function getClientDB()
	{
		$this->sql = 'select 
			id,
			nombre,
			codigo,
			dominio,
			db_host,
			db_database,
			db_user,
			db_password
		from 
			sa_entidad_financiera
		where 
			id = "' . $this->id . '"
				and activado = true
		;';

		if (($this->rs = $this->query($this->sql, MYSQLI_STORE_RESULT)) !== false) {
			if ($this->rs->num_rows === 1) {
				$this->row = $this->rs->fetch_array(MYSQLI_ASSOC);
				$this->rs->free();

				$this->id = $this->row['id'];
				$this->name = $this->row['nombre'];
				$this->code = $this->row['codigo'];
				$this->domain = $this->row['dominio'];

				$this->db = array(
					'db_host' 		=> $this->row['db_host'],
					'db_database' 	=> $this->row['db_database'],
					'db_user' 		=> $this->row['db_user'],
					'db_password' 	=> $this->row['db_password'],
					'code'			=> $this->row['codigo']
					);

				unset($this->row);

				return true;
			}
		}

		return false;
	}

}
?>