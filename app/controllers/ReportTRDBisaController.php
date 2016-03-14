<?php
/**
* Reportes Todo Riesgo Bisa Leasing
*/
class ReportTRDBisaController
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

	public function setResultBisa()
	{
		if ($this->queryBisaEm() === true) {
			$swBG = FALSE;
			$arr_state = array('txt' => '', 'action' => '', 'obs' => '', 'link' => '', 'bg' => '');

			while ($this->row = $this->rs->fetch_array(MYSQLI_ASSOC)) {
				$nVH = (int)$this->row['no_vh'];

				//$bc = (boolean)$this->row['bc'];

				if ($swBG === FALSE) {
					$bg = 'background: #EEF9F8;';
				} elseif ($swBG === TRUE) {
					$bg = 'background: #D1EDEA;';
				}

				$rowSpan = false;
				if ($nVH >= 2) {
					$rowSpan = true;
				}

				//$arr_state['txt'] = '';		$arr_state['txt_bank'] = '';	$arr_state['action'] = '';
				//$arr_state['obs'] = '';		$arr_state['link'] = '';	$arr_state['bg'] = '';

				//get_state($arr_state, $this->row, 2, 'DE', false);

				if ($this->queryBisaDt($nVH) === true) {
					while ($this->rowDt = $this->rsDt->fetch_array(MYSQLI_ASSOC)) {
						if ($rowSpan === true) {
							$rowSpan = 'rowspan="' . $nVH . '"';
						} elseif ($rowSpan === false) {
							$rowSpan = '';
						} elseif ($rowSpan === 'rowspan="' . $nVH . '"') {
							$rowSpan = 'style="display:none;"';
						}

						if ($this->xls === true) {
							$rowSpan = '';
						}

						echo rep_todo_riesgo($this->row, $this->rowDt, $this->db, $arr_state, $bg, $rowSpan);
					}
				}

				$this->rsDt->free();

				if ($swBG === false) {
					$swBG = true;
				} elseif ($swBG === true) {
					$swBG = false;
				}
			}
		}
	}

	private function queryBisaEm()
	{
		$this->sql = "select
				count(tbltrd.id_emision) as no_vh,
				tbltre.id_emision as r_no_emision,
				if(tbltrd.id_emision>0, 'MR','') as r_prefijo,
				(case tbltre.cl_emp
					when 0 then 'Natural'
					when 1 then 'Juridico'
				end) as cl_tipo_cliente,
				(case tbltre.cl_emp
					when
						0
					then
						concat(tblc.nombres,
								' ',
								tblc.ap_paterno,
								' ',
								tblc.ap_materno)
					when 1 then tblc.razon_social
				end) as cl_nombre,
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
				tbltre.valor_asegurado_total as r_valor_asegurado_total,
				(case tbltre.forma_pago
					when 'contado' then 'Al Contado'
					when 'anualizado' then 'Anualizado'
				end) as r_forma_pago,
				tblu.nombre as r_creado_por,
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
				date_format(tbltre.fecha_creacion, '%d/%m/%Y') as r_fecha_creacion,
				(case tbltre.anulada
					when 1 then 'SI'
					when 0 then 'NO'
				end) as r_anulado,
				(select
						count(tbltre1.id_tr_cabecera)
					from
						tbl_emision_tr_cabecera as tbltre1
					where
						tbltre1.id_tr_cabecera = tbltre.id_tr_cabecera
							and tbltre1.anulada = 1) as r_num_anulado,
				(if(tbltre.emitir = 1 and tbltre.anulada = 0,
					'Emitido',
					if(tbltre.emitir = 0 and tbltre.anulada = 0,
						'No Emitido',
						'Anulada'))) as r_estado
				from
					tbl_emision_tr_cabecera as tbltre
						inner join
					tbl_emision_tr_detalle as tbltrd ON (tbltrd.id_emision = tbltre.id_emision)
						inner join
					tbl_clients as tblc ON (tblc.id_client = tbltre.id_client)
						inner join
					tblusuarios as tblu ON (tblu.idusuario = tbltre.user)
						left join
					tbl_tr_facultativo as tbltrf on (tbltre.id_emision = tbltrf.id_emision)
						left join
					tbl_tr_facultativo_pendiente as tbltrfp on (tbltre.id_emision = tbltrfp.id_emision)
				where
					tbltre.id_emision like '" . $this->data['nc'] . "'
	 				and CONCAT(tblc.ap_paterno,
			            ' ',
			            tblc.ap_paterno,
			            ' ',
			            tblc.ap_materno,
			            ' ',
						tblc.razon_social
			            ) like '%" . $this->data['client'] . "%'
	 				and tblc.ci_persona like '%" . $this->data['dni'] . "%'
			        and tblc.complemento like '%" . $this->data['comp'] . "%'
			        and tblc.ci_ext like '%" . $this->data['ext'] . "%'

					and tbltre.fecha_creacion between '" . $this->data['date-begin'] . "'
			        and '" . $this->data['date-end'] . "'

			        and if(tbltre.cl_emp = 0, 'NAT', 'JUR') regexp '".$this->data['r-customer-type']."'

				    and if(tbltrf.aprobado is null,
					if(tbltrfp.id_pendiente_fac is not null,
						case tbltrfp.respuesta
							when 1 then 'S'
							when 0 then 'O'
						end,
						if(tbltre.emitir = 0
								and tbltre.facultativo = 1,
							'P',
							'R')),
					'R') regexp '".$this->data['r-pendant']."'

					and if(tbltrfp.id_estado is not null
						and tbltre.emitir = 0
						and tbltre.facultativo = 1,
					tbltrfp.id_estado,
					'0') regexp '".$this->data['r-state']."'

					and if(tbltrf.aprobado is not null,
					if(tbltrf.aprobado = 'si',
						if(tbltrf.tasa_recargo = 'si', 'EP', 'NP'),
						'R'),
					if(tbltre.emitir = 0
						and tbltre.facultativo = 1,
					'NP',
					'R')) regexp '".$this->data['r-extra-premium']."'

					and if(tbltre.emitir = 1,
					'EM',
					if(tbltrf.aprobado is not null,
						if(tbltrf.aprobado = 'si', 'NE', 'R'),
						'NE')) regexp '".$this->data['r-issued']."'

					and if(tbltrf.aprobado is not null,
					if(tbltrf.aprobado = 'no', 'RE', 'R'),
					'R') regexp '".$this->data['r-rejected']."'

					and if(tbltre.anulada = '1', 'AN', 'R') regexp '".$this->data['r-canceled']."'
				group by tbltre.id_emision
				order by tbltre.id_emision asc
		;";

		if (($this->rs = $this->cx->query($this->sql, MYSQLI_STORE_RESULT)) !== false) {
			if ($this->rs->num_rows > 0) {
				return true;
			}
		}

		return false;
	}

	private function queryBisaDt($nVH)
	{
		$this->sqlDt = "select
					tbltrd.id_tr, tbltrd.material as r_material, tbltrd.valor_asegurado r_valor_asegurado
				from
					tbl_emision_tr_detalle as tbltrd
						inner join
					tbl_emision_tr_cabecera as tbltre ON (tbltre.id_emision = tbltrd.id_emision)
				where
					tbltrd.id_emision = ".$this->row['r_no_emision']."
		;";

		if (($this->rsDt = $this->cx->query($this->sqlDt, MYSQLI_STORE_RESULT)) !== false) {
			if ($this->rsDt->num_rows === $nVH) {
				return true;
			}
		}

		return false;
	}
}
?>