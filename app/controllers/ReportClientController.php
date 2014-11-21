<?php
/**
* Reportes Clientes
*/

require_once $_SESSION['dir'] . '/app/config/administrator.php';
require_once 'ReportClientDBController.php';

class ReportClientController extends Administrator
{
	private $sql, $rs, $row, $product,
            $xls, $xlsTitle; 
	private $ef = array(), $in = array();

	public $data = array();
	public $err = false;
	
	function __construct($pr, $data, $xls = false)
	{
		parent::__construct();

		$this->product = $pr;
		$this->xls = $xls;
		$this->setData($data);
	}

	private function setData($data){
		/*$this->data['nc'] = $this->real_escape_string(trim($data['r-nc']));
		$this->data['prefix'] = $this->real_escape_string(trim($data['r-prefix']));
		if(empty($this->data['nc']) === true) $this->data['nc'] = '%%';
		if(empty($this->data['prefix']) === true) $this->data['prefix'] = '%%';

		$this->data['client'] = $this->real_escape_string(trim($data['r-client']));*/
		$this->data['dni'] = $this->real_escape_string(trim($data['r-dni']));
		$this->data['comp'] = $this->real_escape_string(trim($data['r-comp']));
		$this->data['ext'] = $this->real_escape_string(trim($data['r-ext']));
		$this->data['date-begin'] = $this->real_escape_string(trim($data['r-date-b']));
		$this->data['date-end'] = $this->real_escape_string(trim($data['r-date-e']));

		$this->data['r-ef'] = $this->real_escape_string(trim($data['r-ef']));
		$this->data['r-in'] = $this->real_escape_string(trim($data['r-in']));

		/*$this->data['r-pendant'] = $this->real_escape_string(trim($data['r-pendant']));
		$this->data['r-state'] = $this->real_escape_string(trim($data['r-state']));
		$this->data['r-free-cover'] = $this->real_escape_string(trim($data['r-free-cover']));
		$this->data['r-extra-premium'] = $this->real_escape_string(trim($data['r-extra-premium']));
		$this->data['r-issued'] = $this->real_escape_string(trim($data['r-issued']));
		$this->data['r-rejected'] = $this->real_escape_string(trim($data['r-rejected']));
		$this->data['r-canceled'] = $this->real_escape_string(trim($data['r-canceled']));*/

		if (empty($this->data['r-ef']) === false) {
			$this->ef = str_split($this->data['r-ef'], 2);
		}

		if (empty($this->data['r-in']) === false) {
			$this->in = str_split($this->data['r-in'], 2);
		}
	}

	public function setResult()
	{
		if ($this->getEFProduct($this->product) === true) {
?>
<table class="result-list" id="result-cl">
    <thead>
        <tr>
            <td style="width: 20%;">Cliente</td>
            <td style="width: 10%;">C.I. / NIT</td>
            <td style="width: 10%;">Ciudad</td>
            <td style="width: 10%;"><?=htmlentities('Género', ENT_QUOTES, 'UTF-8');?></td>
            <td style="width: auto;"><?=htmlentities('Teléfono', ENT_QUOTES, 'UTF-8');?></td>
            <td style="width: auto;">Email</td>
            <td style="width: 10%;">Ramo</td>
            <td style="width: auto;">Entidad Financiera</td>
            <td style="width: auto;">Aseguradora</td>
            <td style="width: auto;">No. de Certificado</td>
            <td style="width: auto;">Monto Solicitado</td>
            <td style="width: auto;">Moneda</td>
            <td style="width: auto;">Plazo</td>
        </tr>
    </thead>
    <tbody>
<?php			
			while ($this->row = $this->rs->fetch_array(MYSQLI_ASSOC)) {
				$cl = new ReportClientDBController($this->row, $this->data, $this->xls);
			}
?>
    </tbody>
    <tfoot>
    	<tr>
        	<td colspan="29" style="text-align:left;">
<?php
	if ($this->xls === false) {
		echo '<a href="report.php?data-pr=' . $this->product
			. '&xls=' . md5('TRUE') 
			// . '&frp-nc=' . $this->data['nc'] 
			// . '&frp-prefix=' . $this->data['prefix'] 
			// . '&frp-client=' . $this->data['client'] 
			. '&frp-dni=' . $this->data['dni'] 
			. '&frp-comp=' . $this->data['comp'] 
			. '&frp-ext=' . $this->data['ext'] 
			. '&frp-date-b=' . $this->data['date-begin'] 
			. '&frp-date-e=' . $this->data['date-end'] 
			. '&frp-ef=' . $this->data['r-ef'] 
			. '&frp-in=' . $this->data['r-in'] 
			// . '&frp-pendant=' . $this->data['r-pendant'] 
			// . '&frp-state=' . $this->data['r-state'] 
			// . '&frp-free-cover=' . $this->data['r-free-cover'] 
			// . '&frp-extra-premium=' . $this->data['r-extra-premium'] 
			// . '&frp-issued=' . $this->data['r-issued'] 
			// . '&frp-rejected=' . $this->data['r-rejected'] 
			// . '&frp-canceled=' . $this->data['r-canceled'] 
			. '" class="send-xls" target="_blank">Exportar a Formato Excel</a>';
	}
?>
			</td>
        </tr>
    </tfoot>
</table>
<?php
		} else {
			$this->err = true;
		}
	}

	private function getEFProduct($pr)
	{
		$this->sql = 'select 
			sef.id as ef_id,
			sef.nombre as ef_nombre,
			sef.codigo as ef_codigo,
			sef.db_host,
			sef.db_database,
			sef.db_user,
			sef.db_password,
			sa.id as in_id,
			sa.nombre as in_nombre,
			sa.codigo as in_codigo
		from 
			sa_entidad_financiera as sef
				inner join
			sa_ef_aseguradora as sea ON (sea.entidad_financiera = sef.id)
				inner join
			sa_aseguradora as sa ON (sa.id = sea.aseguradora)
		where
			sef.codigo regexp "' . $this->data['r-ef'] . '"
				and sa.codigo regexp "' . $this->data['r-in'] . '"
				and sef.activado = true
				and sa.activado = true
		group by sef.id
		order by sef.id asc
		;';
		// echo $this->sql;
		if (($this->rs = $this->query($this->sql, MYSQLI_STORE_RESULT)) !== false) {
			if ($this->rs->num_rows > 0) {
				return true;
			}
		}

		return false;
	}

}
?>