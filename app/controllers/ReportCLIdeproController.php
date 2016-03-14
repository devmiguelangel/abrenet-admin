<?php
/**
* Reportes Clientes Idepro
*/
class ReportCLIdeproController
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

	public function setResultIdepro()
	{
		if ($this->queryIdepro() === true) {
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

	private function queryIdepro()
	{
		$this->sql = "(SELECT 
		    sde.id_emision AS ide,
		    'Desgravamen' AS r_ramo,
		    sde.no_emision AS r_no_emision,
		    sde.prefijo AS r_prefijo,
		    sde.monto_solicitado AS r_monto_solicitado,
		    (CASE sde.moneda
		        WHEN 'BS' THEN 'Bolivianos'
		        WHEN 'USD' THEN 'Dolares'
		    END) AS r_moneda,
		    sde.plazo AS r_plazo,
		    (CASE sde.tipo_plazo
		        WHEN 'Y' THEN 'Años'
		        WHEN 'M' THEN 'Meses'
		        WHEN 'W' THEN 'Semanas'
		        WHEN 'D' THEN 'Días'
		    END) AS r_tipo_plazo,
		    su.nombre AS r_creado_por,
		    su.usuario AS user,
		    DATE_FORMAT(sde.fecha_creacion, '%d/%m/%Y') AS r_fecha_creacion,
		    sde.fecha_creacion,
		    sc.id_cliente AS idCl,
		    CONCAT(sc.nombre,
		            ' ',
		            sc.paterno,
		            ' ',
		            sc.materno) AS cl_nombre,
		    sc.ci AS cl_ci,
		    sc.complemento AS cl_complemento,
		    sdepc.codigo AS cl_extension,
		    sdepc.departamento AS cl_ciudad,
		    (CASE sc.genero
		        WHEN 'M' THEN 'Hombre'
		        WHEN 'F' THEN 'Mujer'
		    END) AS cl_genero,
		    sc.telefono_domicilio AS cl_telefono,
		    sc.telefono_celular AS cl_celular,
		    sc.email AS cl_email,
		    (CASE sdd.titular
		        WHEN 'DD' THEN 'Deudor'
		        WHEN 'CC' THEN 'Codeudor'
		    END) AS cl_titular
		FROM
		    s_de_em_cabecera AS sde
		        INNER JOIN
		    s_de_em_detalle AS sdd ON (sdd.id_emision = sde.id_emision)
		        INNER JOIN
		    s_cliente AS sc ON (sc.id_cliente = sdd.id_cliente)
		        INNER JOIN
		    s_usuario AS su ON (su.id_usuario = sde.id_usuario)
		        INNER JOIN
		    s_departamento AS sdepc ON (sdepc.id_depto = sc.extension)
		WHERE
		    sc.ci LIKE '%" . $this->data['dni'] . "%'
		        AND sc.complemento LIKE '%" . $this->data['comp'] . "%'
		        AND sdepc.codigo LIKE '%" . $this->data['ext'] . "%'
		        AND sde.fecha_creacion BETWEEN '" . $this->data['date-begin'] . "' 
		        	AND '" . $this->data['date-end'] . "'
		ORDER BY sde.id_emision DESC)
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