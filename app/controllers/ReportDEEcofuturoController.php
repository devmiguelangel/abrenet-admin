<?php
/**
* Reportes Desgravamen Ecofuturo
*/
class ReportDEEcofuturoController
{
	private $cx, $sql, $sqlDt, $data, $xls;

	private $rs, $rsDt;
	
	function __construct($cx, $data, $xls)
	{
		$this->cx = $cx;
		$this->data = $data;
		$this->xls = $xls;
	}

	public function setResultEcofuturo()
	{
		
	}
}
?>