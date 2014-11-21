<?php
/**
* Reportes Desgravamen
*/
require $_SESSION['dir'] . '/app/views/rep_desgravamen.php';

class ReportDEController
{
	private $db, $data, $xls, $cx, $url, $host;
	public $err;
	
	function __construct($db, $data, $xls)
	{
		$this->db = $db;
		$this->data = $data;
		$this->xls = $xls;

		@$this->cx = new mysqli($db['db_host'], $db['db_user'], $db['db_password'], $db['db_database']);
		
		if ($this->cx->connect_error) {
			die('Error de Conexión (' . $this->cx->connect_errno . ' ) ' . $this->cx->connect_error);
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

		$this->setBankHost();
		// echo $this->db['ef_dominio'];

		$result = '';

		switch ($this->db['ef_codigo']) {
		case 'EC':
			require 'ReportDEEcofuturoController.php';
			$ecofuturo = new ReportDEEcofuturoController($this->cx, $this->data, $this->db, $this->xls);
			$ecofuturo->setResultEcofuturo();

			$result .= $ecofuturo->result;
			unset($ecofuturo->result);
			
			$this->cx->close();
			break;
		case 'SS':
			require 'ReportDESartawiController.php';
			$sartawi = new ReportDESartawiController($this->cx, $this->data, $this->db, $this->xls);
			$sartawi->setResultSartawi();

			$result .= $sartawi->result;
			unset($sartawi->result);

			$this->cx->close();
			break;
		case 'EM':
			require 'ReportDEEmprenderController.php';
			$emprender = new ReportDEEmprenderController($this->cx, $this->data, $this->db, $this->xls);
			$emprender->setResultEmprender();

			$result .= $emprender->result;
			unset($emprender->result);

			$this->cx->close();
			break;
		case 'PV':
			require 'ReportDEPauloviController.php';
			$paulovi = new ReportDEPauloviController($this->cx, $this->data, $this->db, $this->xls);
			$paulovi->setResultPaulovi();

			$result .= $paulovi->result;
			unset($paulovi->result);

			$this->cx->close();
			break;
		case 'ID':
			require 'ReportDEIdeproController.php';
			$idepro = new ReportDEIdeproController($this->cx, $this->data, $this->db, $this->xls);
			$idepro->setResultIdepro();

			$result .= $idepro->result;
			unset($idepro->result);

			$this->cx->close();
			break;
		case 'CR':
			require 'ReportDECrecerController.php';
			$crecer = new ReportDECrecerController($this->cx, $this->data, $this->db, $this->xls);
			$crecer->setResultCrecer();

			$result .= $crecer->result;
			unset($crecer->result);

			$this->cx->close();
			break;
		}

		echo $result;
		unset($result);
	}

	private function setBankHost()
	{
		$self = $_SERVER['HTTP_HOST'];
		$this->url = 'http://' . $self . '/';
		
		$this->host = $this->db['ef_dominio'] . '.';
		
		if (strpos($self, 'localhost') !== false || filter_var($self, FILTER_VALIDATE_IP) !== false) {
			$this->url .= trim($this->host, '.') . '/';
		} elseif (strpos($self, $this->host . 'abrenet.com') === false){
			$this->url .= trim($this->host, '.') . '/';
		} else {
			$this->url .= '';
		}

		$this->db['ef_dominio'] = $this->url;
	}
}

?>