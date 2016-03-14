<?php
/**
* Reportes Clientes Sartawi
*/
class ReportCLSartawiController
{
	private $cx, $sql, $sqlDt, $data, $db, $xls;

	private $row, $rowDt, $rs, $rsDt;

	public $result = '';
	
	function __construct($cx, $data, $db, $xls)
	{
		$this->cx = $cx;
		$this->data = $data;
		$this->db = $db;
		$this->xls = $xls;
	}

	public function setResultSartawi()
	{
		if ($this->querySartawi() === true) {
			$swBG = FALSE;
			$arr_state = array('txt' => '', 'txt_bank' => '', 'action' => '', 
				'obs' => '', 'link' => '', 'bg' => '');

			$nCl = 1;
			while ($this->row = $this->rs->fetch_array(MYSQLI_ASSOC)) {
				if ($swBG === FALSE) {
					$bg = 'background: #EEF9F8;';
				} elseif ($swBG === TRUE) {
					$bg = 'background: #D1EDEA;';
				}
							
				$rowSpan = false;
				
				if ($rowSpan === true) {
					$rowSpan = 'rowspan="' . $nCl . '"';
				} elseif ($rowSpan === false) {
					$rowSpan = '';
				} elseif ($rowSpan === 'rowspan="' . $nCl . '"') {
					$rowSpan = 'style="display:none;"';
				}

				if ($this->xls === true) {
					$rowSpan = '';
				}

				$this->result .= rep_client($this->row, $this->rowDt, $this->db, $arr_state, $bg, $rowSpan);

				if ($swBG === false) {
					$swBG = true;
				} elseif ($swBG === true) {
					$swBG = false;
				}
			}
		}
	}

	private function querySartawi()
	{
		$this->sql = "(SELECT 
		    tedc.id_emision AS ide,
		    'Desgravamen' AS r_ramo,
		    (CASE tedc.tipo_prefijo
				WHEN 'V' THEN nc_vg
				WHEN 'DE' THEN nc_de
		    END) AS r_no_emision,
		    tedc.tipo_prefijo AS r_prefijo,
		    tedc.monto_solicitado AS r_monto_solicitado,
		    (CASE tedc.moneda
		        WHEN 'boliviano' THEN 'Bolivianos'
		        WHEN 'dolar' THEN 'Dolares'
		    END) AS r_moneda,
		    tedc.plazo_credito AS r_plazo,
		    (CASE tedc.tipo_plazo
		        WHEN 'anios' THEN 'Años'
		        WHEN 'meses' THEN 'Meses'
		        WHEN 'semanas' THEN 'Semanas'
		        WHEN 'dias' THEN 'Días'
		    END) AS r_tipo_plazo,
		    tu.nombre AS r_creado_por,
		    tedc.creadopor,
		    DATE_FORMAT(tedc.fecha_creacion, '%d/%m/%Y') AS r_fecha_creacion,
		    tedc.fecha_creacion,
		    tc.id_client AS idCl,
		    CONCAT(tc.nombres,
		            ' ',
		            tc.ap_paterno,
		            ' ',
		            tc.ap_materno) AS cl_nombre,
		    tc.ci_persona AS cl_ci,
		    tc.complemento AS cl_complemento,
		    (CASE tc.ci_ext
		        WHEN 'lapaz' THEN 'LP'
		        WHEN 'oruro' THEN 'OR'
		        WHEN 'potosi' THEN 'PT'
		        WHEN 'tarija' THEN 'TJ'
		        WHEN 'sucre' THEN 'CH'
		        WHEN 'cochabamba' THEN 'CB'
		        WHEN 'pando' THEN 'PA'
		        WHEN 'beni' THEN 'BN'
		        WHEN 'santacruz' THEN 'SC'
		    END) AS cl_extension,
		    (CASE tc.ciudad_domicilio
		        WHEN 'lapaz' THEN 'La Paz'
		        WHEN 'oruro' THEN 'Oruro'
		        WHEN 'potosi' THEN 'Potosi'
		        WHEN 'tarija' THEN 'Tarija'
		        WHEN 'sucre' THEN 'Chuquisaca'
		        WHEN 'cochabamba' THEN 'Cochabamba'
		        WHEN 'pando' THEN 'Pando'
		        WHEN 'beni' THEN 'Beni'
		        WHEN 'santacruz' THEN 'Santa Cruz'
		    END) AS cl_ciudad,
		    (CASE tc.sexo
		        WHEN 'varon' THEN 'Hombre'
		        WHEN 'mujer' THEN 'Mujer'
		    END) AS cl_genero,
		    tc.tel_domicilio AS cl_telefono,
		    tc.email AS cl_email,
		    (CASE tedp.deudor_codeudor
		        WHEN 'deudor' THEN 'Deudor'
		        WHEN 'codeudor' THEN 'Codeudor'
		    END) AS cl_titular
		FROM
		    tbl_emision_des_cabecera2 AS tedc
		        INNER JOIN
		    tbl_emision_des_personas AS tedp ON (tedp.id_emision = tedc.id_emision)
		        INNER JOIN
		    tbl_clients AS tc ON (tc.id_client = tedp.id_client)
		        LEFT JOIN
		    tblusuarios AS tu ON (tu.idusuario = tedc.creadopor)
		WHERE
		    tc.ci_persona LIKE '%" . $this->data['dni'] . "%'
		        AND tc.complemento LIKE '%" . $this->data['comp'] . "%'
		        AND (CASE tc.ci_ext
		        WHEN 'lapaz' THEN 'LP'
		        WHEN 'oruro' THEN 'OR'
		        WHEN 'potosi' THEN 'PT'
		        WHEN 'tarija' THEN 'TJ'
		        WHEN 'sucre' THEN 'CH'
		        WHEN 'cochabamba' THEN 'CB'
		        WHEN 'pando' THEN 'PA'
		        WHEN 'beni' THEN 'BN'
		        WHEN 'santacruz' THEN 'SC'
		    END) LIKE '%" . $this->data['ext'] . "%'
		        AND tedc.fecha_creacion BETWEEN '" . $this->data['date-begin'] . "' 
		        	AND '" . $this->data['date-end'] . "'
		ORDER BY tedc.id_emision DESC)
		;";
		// echo $this->sql;
		if (($this->rs = $this->cx->query($this->sql, MYSQLI_STORE_RESULT)) !== false) {
			if ($this->rs->num_rows > 0) {
				return true;
			}
		}

		return false;
	}

}
?>