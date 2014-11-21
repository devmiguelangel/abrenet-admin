<?php
/**
* Reportes Desgravamen
*/
require $_SESSION['dir'] . '/app/views/rep_client.php';
require 'ReportCLEcofuturoController.php';
require 'ReportCLSartawiController.php';
require 'ReportCLBisaLeasingController.php';
require 'ReportCLEmprenderController.php';
require 'ReportCLPauloviController.php';
require 'ReportCLIdeproController.php';
require 'ReportCLCrecerController.php';

class ReportClientDBController
{
	private $db, $data, $xls, $cx;
	public $err;
	
	function __construct($db, $data, $xls)
	{
		$this->db = $db;
		$this->data = $data;
		$this->xls = $xls;

		@$this->cx = new mysqli($db['db_host'], $db['db_user'], $db['db_password'], $db['db_database']);
		
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
			header("Content-Disposition: attachment; filename=Reportes_Clientes.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}

		$result = '';

		switch ($this->db['ef_codigo']) {
		case 'EC':
			$ecofuturo = new ReportCLEcofuturoController($this->cx, $this->data, $this->db, $this->xls);
			$ecofuturo->setResultEcofuturo();

			$result .= $ecofuturo->result;
			unset($ecofuturo->result);
			
			$this->cx->close();
			break;
		case 'SS':
			$sartawi = new ReportCLSartawiController($this->cx, $this->data, $this->db, $this->xls);
			$sartawi->setResultSartawi();

			$result .= $sartawi->result;
			unset($sartawi->result);
			break;
		case 'BL':
			$bisa = new ReportCLBisaLeasingController($this->cx, $this->data, $this->db, $this->xls);
			$bisa->setResultBisaLeasing();

			$result .= $bisa->result;
			unset($bisa->result);
			break;
		case 'EM':
			$emprender = new ReportCLEmprenderController($this->cx, $this->data, $this->db, $this->xls);
			$emprender->setResultEmprender();

			$result .= $emprender->result;
			unset($emprender->result);
			break;
		case 'PV':
			$paulovi = new ReportCLPauloviController($this->cx, $this->data, $this->db, $this->xls);
			$paulovi->setResultPaulovi();

			$result .= $paulovi->result;
			unset($paulovi->result);
			break;
		case 'ID':
			$idepro = new ReportCLIdeproController($this->cx, $this->data, $this->db, $this->xls);
			$idepro->setResultIdepro();

			$result .= $idepro->result;
			unset($idepro->result);
			break;
		case 'CR':
			$crecer = new ReportCLCrecerController($this->cx, $this->data, $this->db, $this->xls);
			$crecer->setResultCrecer();

			$result .= $crecer->result;
			unset($crecer->result);
			break;
		}

		echo $result;
		unset($result);
	}
}

?>