<?php
/**
* Reportes Generales
*/

require_once $_SESSION['dir'] . '/app/config/administrator.php';
require_once 'ReportDEController.php';
require_once 'ReportAUController.php';
require_once 'ReportTRDController.php';

class ReportGeneralController extends Administrator
{
	private $sql, $rs, $row, $product,
            $xls, $xlsTitle; 

	private $ef = array(), $in = array();

	public $data = array();
	public $err = false;
	
	public function __construct($pr, $data, $xls = false)
	{
		parent::__construct();

		$this->product = $pr;
		$this->xls = $xls;
		$this->setData($data);
	}

	private function setData($data)
	{
		$this->data['nc'] = $this->real_escape_string(trim($data['r-nc']));
		$this->data['prefix'] = $this->real_escape_string(trim($data['r-prefix']));
		if(empty($this->data['nc']) === true) $this->data['nc'] = '%%';
		if(empty($this->data['prefix']) === true) $this->data['prefix'] = '%%';

		$this->data['client'] = $this->real_escape_string(trim($data['r-client']));
		$this->data['dni'] = $this->real_escape_string(trim($data['r-dni']));
		$this->data['comp'] = $this->real_escape_string(trim($data['r-comp']));
		$this->data['ext'] = $this->real_escape_string(trim($data['r-ext']));
		$this->data['date-begin'] = $this->real_escape_string(trim($data['r-date-b']));
		$this->data['date-end'] = $this->real_escape_string(trim($data['r-date-e']));

		$this->data['r-ef'] = $this->real_escape_string(trim($data['r-ef']));
		$this->data['r-in'] = $this->real_escape_string(trim($data['r-in']));

		$this->data['r-pendant'] = $this->real_escape_string(trim($data['r-pendant']));
		$this->data['r-state'] = $this->real_escape_string(trim($data['r-state']));
		$this->data['r-free-cover'] = $this->real_escape_string(trim($data['r-free-cover']));
		$this->data['r-extra-premium'] = $this->real_escape_string(trim($data['r-extra-premium']));
		$this->data['r-issued'] = $this->real_escape_string(trim($data['r-issued']));
		$this->data['r-rejected'] = $this->real_escape_string(trim($data['r-rejected']));
		$this->data['r-canceled'] = $this->real_escape_string(trim($data['r-canceled']));

		$this->data['r-customer-type'] = $this->real_escape_string(trim($data['r-customer-type']));

		if (empty($this->data['r-ef']) === false) {
			$this->ef = str_split($this->data['r-ef'], 2);
		}

		if (empty($this->data['r-in']) === false) {
			$this->in = str_split($this->data['r-in'], 2);
		}

		$this->data['rprint'] = $data['rprint'];
	}

	public function setResult()
	{
?>
<table class="result-list" id="result-de">
<?php
		switch ($this->product) {
		case 'DE':
			if ($this->getEFProduct($this->product) === true) {
?>
	<thead>
        <tr>
            <td>No. Certificado</td>
<?php
			if ($this->data['rprint'] === true) {
				echo '<td>Certificado</td>';
			}
?>
            <td>Entidad Financiera</td>
            <td>Aseguradora</td>
            <td>Cliente</td>
            <td>CI</td>
            <td><?=htmlentities('Género', ENT_QUOTES, 'UTF-8');?></td>
            <td>Ciudad</td>
            <td><?=htmlentities('Teléfono', ENT_QUOTES, 'UTF-8');?></td>
            <td>Celular</td>
            <td>Email</td>
            <td>Monto Solicitado</td>
            <td>Moneda</td>
            <td><?=htmlentities('Plazo Crédito', ENT_QUOTES, 'UTF-8');?></td>
            <td>Estatura (cm)</td>
            <td>Peso (kg)</td>
            <td><?=htmlentities('Participación (%)', ENT_QUOTES, 'UTF-8');?></td>
            <td>Deudor / Codeudor</td>
            <td>Edad</td>
            <td>Creado Por</td>
            <td>Fecha de Ingreso</td>
            <td>Sucursal</td>
            <td>Agencia</td>
            <td>Certificados Anulados</td>
            <td>Anulado por</td>
            <td><?=htmlentities('Fecha de Anulación', ENT_QUOTES, 'UTF-8');?></td>
            <td><?=htmlentities('Estado Compañia', ENT_QUOTES, 'UTF-8');?></td>
            <td>Estado Banco</td>
            <td><?=htmlentities('Motivo Estado Compañia', ENT_QUOTES, 'UTF-8');?></td>
            <td>Porcentaje Extraprima</td>
            <td><?=htmlentities('Fecha Respuesta final Compañia', ENT_QUOTES, 'UTF-8');?></td>
            <td><?=htmlentities('Días en Proceso', ENT_QUOTES, 'UTF-8');?></td>
            <td><?=htmlentities('Días de Ultima Modificación', ENT_QUOTES, 'UTF-8');?></td>
            <td><?=htmlentities('Duración total del caso', ENT_QUOTES, 'UTF-8');?></td>
        </tr>
    </thead>
    <tbody>
<?php
				while ($this->row = $this->rs->fetch_array(MYSQLI_ASSOC)) {
					$de = new ReportDEController($this->row, $this->data, $this->xls);
					
				}
?>
	</tbody>
    
<?php
			} else {
				$this->err = true;
			}
			break;
		case 'AU':
			if ($this->getEFProduct($this->product) === true) {
?>
	<thead>
        <tr>
			<td>No. de Certificado</td>
			<td>Entidad Financiera</td>
			<td>Aseguradora</td>
			<td>Tipo de Cliente</td>
			<td>Cliente</td>
			<td>C.I.</td>
			<td>Ciudad</td>
			<td><?=htmlentities('Género', ENT_QUOTES, 'UTF-8');?></td>
			<td><?=htmlentities('Teléfono', ENT_QUOTES, 'UTF-8');?></td>
			<td>Celular</td>
			<td>Email</td>
			<td>Avenida o calle</td>
			<td><?=htmlentities('Dirección', ENT_QUOTES, 'UTF-8');?></td>
			<td>Numero domicilio</td>
			<td><?=htmlentities('Tipo de vehículo', ENT_QUOTES, 'UTF-8');?></td>
			<td>Marca</td>
			<td>Modelo</td>
			<td><?=htmlentities('Año', ENT_QUOTES, 'UTF-8');?></td>
			<td>Placa</td>
			<td><?=htmlentities('Uso de vehículo', ENT_QUOTES, 'UTF-8');?></td>
			<td><?=htmlentities('Tracción', ENT_QUOTES, 'UTF-8');?></td>
			<td>0 km</td>
			<td>Valor asegurado</td>
			<td>Forma de pago</td>
			<td>Creado por</td>
			<td>Fecha de ingreso</td>
			<td>Sucursal</td>
			<td>Estado</td>
			<td>Certificados anulados</td>
        </tr>
    </thead>
    <tbody>
<?php
				while ($this->row = $this->rs->fetch_array(MYSQLI_ASSOC)) {
					$au = new ReportAUController($this->row, $this->data, $this->xls);

				}
?>
	</tbody>
<?php
			} else {
				$this->err = true;
			}
			break;
		case 'TRD':
			if ($this->getEFProduct($this->product) === true) {
?>
	<thead>
        <tr>
			<td>No. Certificado</td>
			<td>Entidad Financiera</td>
			<td>Aseguradora</td>
			<td>Tipo de Cliente</td>
			<td>Cliente</td>
			<td>CI</td>
			<td><?=htmlentities('Género', ENT_QUOTES, 'UTF-8');?></td>
			<td>Ciudad</td>
			<td><?=htmlentities('Teléfono', ENT_QUOTES, 'UTF-8');?></td>
			<td>Celular</td>
			<td>Email</td>
			<td>Avenida o calle</td>
			<td><?=htmlentities('Dirección', ENT_QUOTES, 'UTF-8');?></td>
			<td>Numero domicilio</td>
			<td>Materia Asegurada</td>
			<td>Valor Asegurado</td>
  	        <td>Tipo inmueble</td>
			<td>Uso</td>
			<td>Estado</td>
			<td>Departamento</td>
			<td>Zona</td>
			<td><?=htmlentities('Dirección', ENT_QUOTES, 'UTF-8');?></td>
			<td>Monto inmueble</td>
  	        <td><?=htmlentities('Tipo vehículo', ENT_QUOTES, 'UTF-8');?></td>
			<td>Marca</td>
			<td>Modelo</td>
			<td>Placa</td>
			<td><?=htmlentities('Uso vehículo', ENT_QUOTES, 'UTF-8');?></td>
			<td><?=htmlentities('Tracción', ENT_QUOTES, 'UTF-8');?></td>
			<td>Cero KM </td>
			<td><?=htmlentities('Monto vehículo', ENT_QUOTES, 'UTF-8');?></td>
			<td><?=htmlentities('Plazo crédito', ENT_QUOTES, 'UTF-8');?></td>
			<td>Forma Pago</td>
			<td>Creado por</td>
			<td>Fecha de ingreso</td>
			<td>Sucursal</td>
			<td>Estado</td>
			<td>Certificados anulados</td>
        </tr>
    </thead>
    <tbody>
<?php
				while ($this->row = $this->rs->fetch_array(MYSQLI_ASSOC)) {
					$trd = new ReportTRDController($this->row, $this->data, $this->xls);
				}
?>
	</tbody>
<?php
			} else {
				$this->err = true;
			}
			break;
		default:
			$this->err = true;
			break;
		}

		if ($this->err === false) {
?>
	<tfoot>
    	<tr>
        	<td colspan="10" style="text-align:left;">
<?php
	if ($this->xls === false) {
		echo '<a href="report.php?data-pr=' . $this->product
			. '&xls=' . md5('TRUE')
			. '&frp-nc=' . $this->data['nc']
			. '&frp-prefix=' . $this->data['prefix']
			. '&frp-client=' . $this->data['client']
			. '&frp-dni=' . $this->data['dni']
			. '&frp-comp=' . $this->data['comp']
			. '&frp-ext=' . $this->data['ext']
			. '&frp-date-b=' . $this->data['date-begin']
			. '&frp-date-e=' . $this->data['date-end']
			. '&frp-ef=' . $this->data['r-ef']
			. '&frp-in=' . $this->data['r-in']
			. '&frp-pendant=' . $this->data['r-pendant']
			. '&frp-state=' . $this->data['r-state']
			. '&frp-free-cover=' . $this->data['r-free-cover']
			. '&frp-extra-premium=' . $this->data['r-extra-premium']
			. '&frp-issued=' . $this->data['r-issued']
			. '&frp-rejected=' . $this->data['r-rejected']
			. '&frp-canceled=' . $this->data['r-canceled']
			. '&frp-customer-type=' . $this->data['r-customer-type']
			. '" class="send-xls" target="_blank">Exportar a Formato Excel</a>';
	}
?>
			</td>
        </tr>
    </tfoot>
<?php
		}
?>
</table>
<?php
	}

	private function getEFProduct($pr)
	{
		$this->sql = 'select 
			sef.id as ef_id,
			sef.nombre as ef_nombre,
			sef.codigo as ef_codigo,
			sef.dominio as ef_dominio,
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
			sa_ef_producto as sep ON (sep.entidad_financiera = sef.id)
				inner join
			sa_producto as spr ON (spr.id = sep.producto)
				inner join
			sa_ef_aseguradora as sea ON (sea.entidad_financiera = sef.id)
				inner join
			sa_aseguradora as sa ON (sa.id = sea.aseguradora)
		where
			spr.codigo = "' . $pr . '"
				and sef.codigo regexp "' . $this->data['r-ef'] . '"
				and sa.codigo regexp "' . $this->data['r-in'] . '"
				and sef.activado = true
				and sa.activado = true
				and spr.activado = true
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