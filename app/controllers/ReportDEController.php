<?php
/**
* Reportes Desgravamen
*/
require '/../views/rep_desgravamen.php';

class ReportDEController
{
	private $db, $sql, $rs, $row, $sqlDt, $rsDt, $rowDt, 
			$data, $xls, $cx;
	public $err;
	
	function __construct($db, $data, $xls)
	{
		$this->db = $db;
		$this->data = $data;
		$this->xls = $xls;

		$this->cx = new mysqli($db['db_host'], $db['db_user'], $db['db_password'], $db['db_database']);
		
		if ($this->cx->connect_error) {
			die('Error de Conexion (' . $this->cx->connect_errno . ' ) ' . $this->cx->connect_error);
		}

		$this->setResult();
	}

	private function setResult()
	{
		if($this->xls === true){
			header("Content-Type:   application/vnd.ms-excel; charset=iso-8859-1");
			header("Content-Disposition: attachment; filename=Reportes_Desgravamen.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}

		switch ($this->db['ef_codigo']) {
		case 'EC':
			require 'ReportDEEcofuturoController.php';
			$ecofuturo = new ReportDEEcofuturoController($this->cx, $this->data, $this->db, $this->xls);
			$ecofuturo->setResultEcofuturo();
			
			$this->cx->close();
			break;
		case 'SS':
			
			break;
		case 'EM':
			
			break;
		case 'PV':
			
			break;
		case 'ID':
			
			break;
		case 'CR':
			require 'ReportDECrecerController.php';
			$crecer = new ReportDECrecerController($this->cx, $this->data, $this->db, $this->xls);
			$crecer->setResultCrecer();		

			$this->cx->close();
			break;
		}
	}
}

?>