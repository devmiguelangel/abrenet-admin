<?php
/**
* Reportes Automotores
*/
require $_SESSION['dir'] . '/app/views/rep_automotor.php';
require 'ReportAUEcofuturoController.php';
require 'ReportAUBisaController.php';

class ReportAUController
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
			ob_start();
			header("Content-Type:   application/vnd.ms-excel; charset=iso-8859-1");
			header("Content-Disposition: attachment; filename=Reportes_Automotor.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}

		switch ($this->db['ef_codigo']) {
		case 'EC':
			$ecofuturo = new ReportAUEcofuturoController($this->cx, $this->data, $this->db, $this->xls);
			$ecofuturo->setResultEcofuturo();
			$this->cx->close();

			break;
		case 'BL':
			$bisaleasing = new ReportAUBisaController($this->cx, $this->data, $this->db, $this->xls);
			$bisaleasing->setResultBisa();
			$this->cx->close();

			break;
		}
	}
}

?>