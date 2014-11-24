<?php
/**
* Entidad Financiera
*/
require_once $GLOBALS['DOCUMENT_ROOT'] . '/app/config/administrator.php';

class BankController extends Administrator
{
	public
		$id = '',
		$name = '',
		$code = '',
		$db_host = '',
		$db_database = '',
		$db_user = '',
		$db_password = '',
		$active = false,
		$product = array(),
		$insurance = array(),

		$sql, $rs, $row;
	
	function __construct()
	{
		parent::__construct();
	}

	public function getBankData($id = '')
	{
		if (empty($id) === true) {
			$id = '%' . $this->real_escape_string(trim($id)) . '%';
		}

		$this->sql = '
		SELECT 
		    sef.id AS ef_id,
		    sef.nombre AS ef_nombre,
		    sef.codigo AS ef_codigo,
		    sef.db_host,
		    sef.db_database,
		    sef.db_user,
		    sef.db_password,
		    sef.activado AS ef_activado
		FROM
		    sa_entidad_financiera AS sef
		WHERE
		    sef.id LIKE "' . $id . '"
		ORDER BY sef.id ASC
		;';
		// echo $this->sql;
		if (($this->rs = $this->query($this->sql, MYSQLI_STORE_RESULT)) !== false) {
			if ($this->rs->num_rows === 1) {
				$this->row = $this->rs->fetch_array(MYSQLI_ASSOC);
				$this->rs->free();

				$this->id = $this->row['ef_id'];
				$this->name = $this->row['ef_nombre'];
				$this->code = $this->row['ef_codigo'];
				$this->db_host = $this->row['db_host'];
				$this->db_database = $this->row['db_database'];
				$this->db_user = $this->row['db_user'];
				$this->db_password = $this->row['db_password'];
				$this->active = $this->row['ef_activado'];

				unset($this->row);

				return true;
			} elseif ($this->rs->num_rows > 0) {
				return true;
			}
		}

		return false;
	}

	public function addBank()
	{
		$this->sql = 'insert into sa_entidad_financiera 
		(id, nombre, codigo, db_host, db_database, 
			db_user, db_password, activado)
		values
		("' . $this->id . '", "' . $this->name . '", "' . $this->code . '", 
			"' . $this->db_host . '", "' . $this->db_database . '", 
			"' . $this->db_user . '", "' . $this->db_password . '", false)
		;';

		if ($this->query($this->sql) === true) {
			if ($this->affected_rows > 0) {
				if ($this->addProductBank() === true) {
					if ($this->addInsuranceBank() === true) {
						return true;
					}
				}
			}
		}

		return false;
	}

	public function updateBank()
	{
		$this->sql = 'update sa_entidad_financiera 
		set nombre = "' . $this->name . '", 
			codigo = "' . $this->code . '", 
			db_host = "' . $this->db_host . '", 
			db_database = "' . $this->db_database . '", 
			db_user = "' . $this->db_user . '", 
			db_password = "' . $this->db_password . '"
		where id = ' . $this->id . '
		;';

		if ($this->query($this->sql) === true) {
			if ($this->addProductBank() === true) {
				if ($this->addInsuranceBank() === true) {
					return true;
				}
			}
		}

		return false;
	}

	private function addProductBank()
	{
		if ($this->dropOldProductBank() === true) {
			
		}

		if (count($this->product) > 0) {
			$this->sql = 'insert into sa_ef_producto 
			(id, entidad_financiera, producto)
			values ';

			$idEp = date('U');

			foreach ($this->product as $value) {
				$idEp += 1;
				$this->sql .= '(' . $idEp . ', ' . $this->id . ', ' . $value . '),';
			}

			$this->sql = trim($this->sql, ',') . ' ;';
			
			if ($this->query($this->sql) === true) {
				if ($this->affected_rows > 0) {
					return true;
				}
			}

			return false;
		}

		return true;
	}

	private function addInsuranceBank()
	{
		if ($this->dropOldInsuranceBank() === true) {
			
		}

		if (count($this->insurance) > 0) {
			$this->sql = 'insert into sa_ef_aseguradora 
			(id, entidad_financiera, aseguradora)
			values ';

			$idEa = date('U');

			foreach ($this->insurance as $value) {
				$idEa += 1;
				$this->sql .= '(' . $idEa . ', ' . $this->id . ', ' . $value . '),';
			}

			$this->sql = trim($this->sql, ',') . ' ;';
			
			if ($this->query($this->sql) === true) {
				if ($this->affected_rows > 0) {
					return true;
				}
			}

			return false;
		}

		return true;
	}

	private function dropOldProductBank()
	{
		$this->sql = 'delete from sa_ef_producto
		where entidad_financiera = ' . $this->id . '
		;';
		
		if ($this->query($this->sql) === true) {
			if ($this->affected_rows > 0) {
				return true;
			}
		}

		return false;
	}

	private function dropOldInsuranceBank()
	{
		$this->sql = 'delete from sa_ef_aseguradora
		where entidad_financiera = ' . $this->id . '
		;';
		
		if ($this->query($this->sql) === true) {
			if ($this->affected_rows > 0) {
				return true;
			}
		}

		return false;
	}

	public function activateDeactivateBank()
	{
		$this->sql = 'update sa_entidad_financiera 
		set activado = ' . (int)$this->active . '
		where id = ' . $this->id . '
		;';

		if ($this->query($this->sql) === true) {
			if ($this->affected_rows === 1) {
				return true;
			}
		}

		return false;
	}

	public function getBankProduct($id)
	{
		$sql = '
		SELECT 
		    spr.id AS pr_id,
		    spr.nombre AS pr_nombre,
		    spr.codigo AS pr_codigo,
		    sef.id AS ef_id,
		    sef.nombre AS ef_nombre,
		    sef.codigo AS ef_codigo
		FROM
		    sa_producto AS spr
		        INNER JOIN
		    sa_ef_producto AS sep ON (sep.producto = spr.id)
		        INNER JOIN
		    sa_entidad_financiera AS sef ON (sef.id = sep.entidad_financiera)
		WHERE
		    sef.id = "' . $id . '"
		;';

		if (($rs = $this->query($sql, MYSQLI_STORE_RESULT)) !== false) {
			if ($rs->num_rows > 0) {
				return $rs;
			}
		}

		return false;
	}

	public function getBankInsurance($id)
	{
		$sql = '
		SELECT 
		    sas.id AS as_id,
		    sas.nombre AS as_nombre,
		    sas.codigo AS as_codigo,
		    sef.id AS ef_id,
		    sef.nombre AS ef_nombre,
		    sef.codigo AS ef_codigo
		FROM
		    sa_aseguradora AS sas
		        INNER JOIN
		    sa_ef_aseguradora AS sea ON (sea.aseguradora = sas.id)
		        INNER JOIN
		    sa_entidad_financiera AS sef ON (sef.id = sea.entidad_financiera)
		WHERE
		    sef.id = "' . $id . '"
		;';

		if (($rs = $this->query($sql, MYSQLI_STORE_RESULT)) !== false) {
			if ($rs->num_rows > 0) {
				return $rs;
			}
		}

		return false;
	}

	public function getProduct()
	{
		$sql = 'select 
			spr.id as pr_id,
			spr.nombre as pr_nombre,
			spr.codigo as pr_codigo
		from 
			sa_producto as spr
		where
			spr.activado = true
		order by spr.id asc
		;';

		if (($rs = $this->query($sql, MYSQLI_STORE_RESULT)) !== false) {
			if ($rs->num_rows > 0) {
				return $rs;
			}
		}

		return false;
	}

	public function getInsurance()
	{
		$sql = 'select 
			sa.id as as_id,
			sa.nombre as as_nombre,
			sa.codigo as as_codigo
		from 
			sa_aseguradora as sa
		;';

		if (($rs = $this->query($sql, MYSQLI_STORE_RESULT)) !== false) {
			if ($rs->num_rows > 0) {
				return $rs;
			}
		}

		return false;
	}

	public function getBankByCode()
	{
		$this->sql = '
		SELECT 
		    sef.id AS ef_id,
		    sef.nombre AS ef_nombre,
		    sef.codigo AS ef_codigo,
		    sef.db_host,
		    sef.db_database,
		    sef.db_user,
		    sef.db_password,
		    sef.activado AS ef_activado
		FROM
		    sa_entidad_financiera AS sef
		WHERE
		    sef.codigo = "' . $this->code . '"
		ORDER BY sef.id ASC
		;';
		// echo $this->sql;
		if (($this->rs = $this->query($this->sql, MYSQLI_STORE_RESULT)) !== false) {
			if ($this->rs->num_rows === 1) {
				$this->row = $this->rs->fetch_array(MYSQLI_ASSOC);
				$this->rs->free();

				$this->id = $this->row['ef_id'];
				$this->name = $this->row['ef_nombre'];
				$this->code = $this->row['ef_codigo'];
				$this->db_host = $this->row['db_host'];
				$this->db_database = $this->row['db_database'];
				$this->db_user = $this->row['db_user'];
				$this->db_password = $this->row['db_password'];
				$this->active = $this->row['ef_activado'];

				unset($this->row);

				return true;
			} elseif ($this->rs->num_rows > 0) {
				return true;
			}
		}

		return false;
	}
}
?>