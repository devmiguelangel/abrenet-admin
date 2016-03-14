<?php
/**
* Reportes Todo Riesgo Ecofuturo
*/
class ReportTRDEcofuturoController
{
	private $cx, $sql, $sqlDt, $data, $db, $xls;

	private $row, $rowDt, $rs, $rsDt;

	function __construct($cx, $data, $db, $xls)
	{
		$this->cx = $cx;
		$this->data = $data;
		$this->db = $db;
		$this->xls = $xls;
	}

	public function setResultEcofuturo()
	{
	$sw = 0;
	$nat = 0;
	$jur = 0;

		if (strpos($this->data['r-customer-type'], 'NAT') !== false) {
			$nat = 1;
		}
		if (strpos($this->data['r-customer-type'], 'JUR') !== false) {
			$jur = 1;
		}

		if (strpos($this->data['r-state'], '1') !== false) { $sw = 1;}
		if (strpos($this->data['r-state'], '2') !== false) { $sw = 1;}
		if (strpos($this->data['r-state'], '3') !== false) { $sw = 1;}
		if (strpos($this->data['r-state'], '4') !== false) { $sw = 1;}
		if (strpos($this->data['r-state'], '5') !== false) { $sw = 1;}

		if (strpos($this->data['r-pendant'], 'P') !== false) { $sw = 1;}
		if (strpos($this->data['r-pendant'], 'S') !== false) { $sw = 1;}
		if (strpos($this->data['r-pendant'], 'O') !== false) { $sw = 1;}

		if (strpos($this->data['r-pendant'], 'P') !== false) { $sw = 1;}
		if (strpos($this->data['r-pendant'], 'S') !== false) { $sw = 1;}
		if (strpos($this->data['r-pendant'], 'O') !== false) { $sw = 1;}

		if (strpos($this->data['r-extra-premium'], 'EP') !== false) { $sw = 1;}
		//if (strpos($this->data['r-extra-premium'], 'NP') !== false) { $sw = 1;}
		if (strpos($this->data['r-rejected'], 'RE') !== false) { $sw = 1;}


		if( ($nat == 0 and $jur == 0 and $sw == 0) or ($nat == 1 and $sw == 0) ){

			if ($this->queryEcofuturoEm() === true) {
				$swBG = FALSE;
				$arr_state = array('txt' => '', 'action' => '', 'obs' => '', 'link' => '', 'bg' => '');

				while ($this->row = $this->rs->fetch_array(MYSQLI_ASSOC)) {

					if ($swBG === FALSE) {
						$bg = 'background: #EEF9F8;';
					} elseif ($swBG === TRUE) {
						$bg = 'background: #D1EDEA;';
					}

					$this->rowDt='';
					$rowSpan = '';
							echo rep_todo_riesgo($this->row, $this->rowDt, $this->db, $arr_state, $bg, $rowSpan);

					if ($swBG === false) {
						$swBG = true;
					} elseif ($swBG === true) {
						$swBG = false;
					}
				}
			}
		}

		if( ($nat == 0 and $jur == 0 and $sw == 0) or ($jur == 1 and $sw == 0) ){

			if ($this->queryEcofuturoEmemp() === true) {
			$swBG = FALSE;
			$arr_state = array('txt' => '', 'action' => '', 'obs' => '', 'link' => '', 'bg' => '');

			while ($this->row = $this->rs->fetch_array(MYSQLI_ASSOC)) {

				if ($swBG === FALSE) {
					$bg = 'background: #EEF9F8;';
				} elseif ($swBG === TRUE) {
					$bg = 'background: #D1EDEA;';
				}

				$this->rowDt='';
				$rowSpan = '';
						echo rep_todo_riesgo($this->row, $this->rowDt, $this->db, $arr_state, $bg, $rowSpan);

				if ($swBG === false) {
					$swBG = true;
				} elseif ($swBG === true) {
					$swBG = false;
				}
			}
		}

		}
	}

	private function queryEcofuturoEm()
	{
		$this->sql = "select
				tbletc.id_emision as r_no_emision,
				tbletc.prefijo_producto as r_prefijo,
				if(tbletc.id_emision > 0, 'Natural', '') as cl_tipo_cliente,
				CONCAT (tblc.nombres, ' ', tblc.ap_paterno, ' ', tblc.ap_materno) as cl_nombre,
				tblc.ci_persona as cl_cinit,
				upper(tblc.complemento) as cl_complemento,
				(case tblc.sexo
					when 'varon' then 'Masculino'
					when 'mujer' then 'Femenino'
				end) as cl_genero,
				(case tblc.ciudad_domicilio
			        when 'lapaz' then 'La Paz'
			        when 'oruro' then 'Oruro'
			        when 'potosi' then 'Potosi'
			        when 'tarija' then 'Tarija'
			        when 'sucre' then 'Chuquisaca'
			        when 'cochabamba' then 'Cochabamba'
			        when 'pando' then 'Pando'
			        when 'beni' then 'Beni'
			        when 'santacruz' then 'Santa Cruz'
		   		end) AS cl_ciudad,
				tblc.tel_domicilio as cl_telefono,
				tblc.tel_movil as cl_celular,
				tblc.email as cl_email,
				tblc.avenida_calle as cl_avenida_calle,
				tblc.dir_domicilio as cl_dir_domicilio,
				tblc.num_domicilio as cl_num_domicilio,
				tblti.tipo_inmueble as in_tipo_inmueble,
				tblti.uso as in_uso,
				tblti.estado as in_estado,
				(case tbld.departamento
			        when 'lapaz' then 'La Paz'
			        when 'oruro' then 'Oruro'
			        when 'potosi' then 'Potosi'
			        when 'tarija' then 'Tarija'
			        when 'sucre' then 'Chuquisaca'
			        when 'cochabamba' then 'Cochabamba'
			        when 'pando' then 'Pando'
			        when 'beni' then 'Beni'
			        when 'santacruz' then 'Santa Cruz'
		   		end) AS in_departamento,
				tblti.zona as in_zona,
				tblti.direccion as in_direccion,
				tblti.valor_asegurado_usd as in_valor_asegurado_usd,
				tbltv.tipo_vehiculo as vh_tipo_vehiculo,
				tblma.marcas as vh_marca,
				tblmo.modelos as vh_modelo,
				tbltv.placa as vh_placa,
				tbltv.uso_vehiculo as vh_uso,
				tbltv.traccion as vh_traccion,
				tbltv.cero_km as vh_km,
				tbltv.valor_asegurado_usd as vh_valor_asegurado_usd,
				tbletc.plazo_credito as r_plazo_credito,
				tbltp.plazo as r_plazo,
				tbletc.forma_pago as r_forma_pago,
				tbletc.user as r_creado_por,
				date_format(tbletc.fecha_creacion, '%d/%m/%Y') as r_fecha_creacion,
				(case tblu.departamento
			        when 'lapaz' then 'La Paz'
			        when 'oruro' then 'Oruro'
			        when 'potosi' then 'Potosi'
			        when 'tarija' then 'Tarija'
			        when 'sucre' then 'Chuquisaca'
			        when 'cochabamba' then 'Cochabamba'
			        when 'pando' then 'Pando'
			        when 'beni' then 'Beni'
			        when 'santacruz' then 'Santa Cruz'
		   		end) AS r_sucursal,
				(if(tbletc.emitir = 'true'
						and tbletc.anulada = 'false',
					'Emitido',
					if(tbletc.emitir = 'false'
							and tbletc.anulada = 'false',
						'No Emitido',
						'Anulada'))) as r_estado,
				(select
						count(tbletc1.id_cotiza)
					from
						tbl_emision_tr_cabecera as tbletc1
					where
						tbletc1.id_cotiza = tbletc.id_cotiza
							and tbletc1.anulada = 'true') as r_num_anulado
			from
				tbl_emision_tr_cabecera AS tbletc
					inner join
				tbl_clients AS tblc  ON tblc.id_client = tbletc.id_client
					left outer join
				tbl_emision_tr_vehiculo_detalle AS tbltv ON tbletc.id_emision = tbltv.id_emision
					inner join
				tbl_tr_inmueble AS tblti ON tbletc.id_emision = tblti.id_emision
					left outer join
				tblmarcasauto AS tblma ON tbltv.marca = tblma.idmarcasauto
					left outer join
				tblmodelosauto AS tblmo ON tbltv.modelo = tblmo.idmodelosauto
					left join
				tblusuarios AS tblu ON tblu.idusuario = tbletc.user
					left outer join
				tblcerokm AS tblck ON tbltv.cero_km = tblck.idcerokm
					inner join
				tbldepartamento AS tbld ON tbld.iddepartamento = tblti.departamento
					inner join
				tblplazocredito AS tbltp ON tbletc.tipo_plazo = tbltp.idplazocredito
					left outer join
				tblagencia AS tbla ON tblu.id_agencia = tbla.id_agencia
			where
 				tbletc.id_emision like '" . $this->data['nc'] . "'
		        and tbletc.prefijo_producto like '%" . $this->data['prefix'] . "%'
		        and CONCAT(tblc.nombres,
		            ' ',
		            tblc.ap_paterno,
		            ' ',
		            tblc.ap_materno) like '%" . $this->data['client'] . "%'
		        and tblc.ci_persona like '%" . $this->data['dni'] . "%'
		        and tblc.complemento like '%" . $this->data['comp'] . "%'
		        and tblc.ci_ext like '%" . $this->data['ext'] . "%'
		        and tbletc.fecha_creacion between '" . $this->data['date-begin'] . "'
		        and '" . $this->data['date-end'] . "'
				and
					if(tbletc.emitir = 'true',
					'EM', 'NE') regexp '".$this->data['r-issued']."'
					and if(tbletc.anulada = 'true', 'AN', 'R') regexp '".$this->data['r-canceled']."'
		;";

		if (($this->rs = $this->cx->query($this->sql, MYSQLI_STORE_RESULT)) !== false) {
			if ($this->rs->num_rows > 0) {
				return true;
			}
		}

		return false;
	}



	private function queryEcofuturoEmemp()
	{
		$this->sql = "select
				tbletc.id_emision as r_no_emision,
				tbletc.prefijo_producto as r_prefijo,
				if(tbletc.id_emision > 0, 'Juridico', '') as cl_tipo_cliente,
				CONCAT (tblc.razon_social) as cl_nombre,
				tblc.nit as cl_cinit,
				(case tblc.departamento
			        when 'lapaz' then 'La Paz'
			        when 'oruro' then 'Oruro'
			        when 'potosi' then 'Potosi'
			        when 'tarija' then 'Tarija'
			        when 'sucre' then 'Chuquisaca'
			        when 'cochabamba' then 'Cochabamba'
			        when 'pando' then 'Pando'
			        when 'beni' then 'Beni'
			        when 'santacruz' then 'Santa Cruz'
		   		end) AS cl_ciudad,
				tblc.tel_oficina as cl_telefono,
				tblc.email as cl_email,
				tblc.avenida_calle as cl_avenida_calle,
				tblc.direccion as cl_dir_domicilio,
				tblc.num_direccion as cl_num_domicilio,
				tblti.tipo_inmueble as in_tipo_inmueble,
				tblti.uso as in_uso,
				tblti.estado as in_estado,
				(case tbld.departamento
			        when 'lapaz' then 'La Paz'
			        when 'oruro' then 'Oruro'
			        when 'potosi' then 'Potosi'
			        when 'tarija' then 'Tarija'
			        when 'sucre' then 'Chuquisaca'
			        when 'cochabamba' then 'Cochabamba'
			        when 'pando' then 'Pando'
			        when 'beni' then 'Beni'
			        when 'santacruz' then 'Santa Cruz'
		   		end) AS in_departamento,
				tblti.zona as in_zona,
				tblti.direccion as in_direccion,
				tblti.valor_asegurado_usd as in_valor_asegurado_usd,
				tbltv.tipo_vehiculo as vh_tipo_vehiculo,
				tblma.marcas as vh_marca,
				tblmo.modelos as vh_modelo,
				tbltv.placa as vh_placa,
				tbltv.uso_vehiculo as vh_uso,
				tbltv.traccion as vh_traccion,
				tbltv.cero_km as vh_km,
				tbltv.valor_asegurado_usd as vh_valor_asegurado_usd,
				tbletc.plazo_credito as r_plazo_credito,
				tbltp.plazo as r_plazo,
				tbletc.forma_pago as r_forma_pago,
				tbletc.user as r_creado_por,
				date_format(tbletc.fecha_creacion, '%d/%m/%Y') as r_fecha_creacion,
				(case tblu.departamento
			        when 'lapaz' then 'La Paz'
			        when 'oruro' then 'Oruro'
			        when 'potosi' then 'Potosi'
			        when 'tarija' then 'Tarija'
			        when 'sucre' then 'Chuquisaca'
			        when 'cochabamba' then 'Cochabamba'
			        when 'pando' then 'Pando'
			        when 'beni' then 'Beni'
			        when 'santacruz' then 'Santa Cruz'
		   		end) AS r_sucursal,
				(if(tbletc.emitir = 'true'
						and tbletc.anulada = 'false',
					'Emitido',
					if(tbletc.emitir = 'false'
							and tbletc.anulada = 'false',
						'No Emitido',
						'Anulada'))) as r_estado,
				(select
						count(tbletc1.id_cotiza)
					from
						tbl_emision_tr_cabecera as tbletc1
					where
						tbletc1.id_cotiza = tbletc.id_cotiza
							and tbletc1.anulada = 'true') as r_num_anulado
			from

				tbl_emision_tr_cabeceraemp AS tbletc
					inner join
				tbl_clientsemp AS tblc  ON tblc.id_client = tbletc.id_client
					left outer join
				tbl_emision_tr_vehiculo_detalleemp AS tbltv ON tbletc.id_emision = tbltv.id_emision
					inner join
				tbl_tr_inmuebleemp AS tblti ON tbletc.id_emision = tblti.id_emision
					left outer join
				tblmarcasauto AS tblma ON tbltv.marca = tblma.idmarcasauto
					left outer join
				tblmodelosauto AS tblmo ON tbltv.modelo = tblmo.idmodelosauto
					left join
				tblusuarios AS tblu ON tblu.idusuario = tbletc.user
					left outer join
				tblcerokm AS tblck ON tbltv.cero_km = tblck.idcerokm
					Inner Join
				tbldepartamento AS tbld ON tbld.iddepartamento = tblti.departamento
					Inner Join
				tblplazocredito AS tbltp ON tbletc.tipo_plazo = tbltp.idplazocredito
					Left Outer Join
				tblagencia AS tbla ON tblu.id_agencia = tbla.id_agencia
			where
 				tbletc.id_emision like '" . $this->data['nc'] . "'
		        and tbletc.prefijo_producto like '%" . $this->data['prefix'] . "%'
		        and tblc.razon_social like '%" . $this->data['client'] . "%'

		        and tblc.nit like '%" . $this->data['dni'] . "%'
		        and tblc.departamento like '%" . $this->data['ext'] . "%'
		        and tbletc.fecha_creacion between '" . $this->data['date-begin'] . "'
		        and '" . $this->data['date-end'] . "'
				and
					if(tbletc.emitir = 'true',
					'EM', 'NE') regexp '".$this->data['r-issued']."'
					and if(tbletc.anulada = 'true', 'AN', 'R') regexp '".$this->data['r-canceled']."'
		;";

		if (($this->rs = $this->cx->query($this->sql, MYSQLI_STORE_RESULT)) !== false) {
			if ($this->rs->num_rows > 0) {
				return true;
			}
		}

		return false;
	}

}
?>