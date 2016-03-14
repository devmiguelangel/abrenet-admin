<?php
/**
* Reportes Automotor Bisa Leasing
*/
class ReportAUBisaController
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

				if ($swBG === FALSE) {
					$bg = 'background: #EEF9F8;';
				} elseif ($swBG === TRUE) {
					$bg = 'background: #D1EDEA;';
				}

				$rowSpan = false;
				if ($nVH >= 2) {
					$rowSpan = true;
				}

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

						echo rep_automotor($this->row, $this->rowDt, $this->db, $arr_state, $bg, $rowSpan);
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
		  	    count(tblevd.id_emision_cabecera) as no_vh,
				tblevd.id_emision_cabecera as r_no_emision,
				tblevc.prefijo_producto as r_prefijo,
				(case tblevc.cl_emp
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
				(case tblevc.cl_emp
					when 0 then 'Natural'
					when 1 then 'Juridico'
				end) as cl_tipo_cliente,
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
				(case tblevc.forma_pago
					when 'contado' then 'Al Contado'
					when 'anualizado' then 'Anualizado'
				end) as r_forma_pago,
				--count(tblevd.id_emision_cabecera) as num_vh,
				(case tblevc.anulada
					when 'true' then 'SI'
					when 'false' then 'NO'
				end) as r_anulado,
				(select
						count(tblevc1.id_cotiza)
					from
						tbl_emision_vehiculo_cabecera as tblevc1
					where
						tblevc1.id_cotiza = tblevc.id_cotiza
							and tblevc1.anulada = 'true') as r_num_anulado,
				(if(tblevc.emitir = 'true'
						and tblevc.anulada = 'false',
					'Emitido',
					if(tblevc.emitir = 'false'
							and tblevc.anulada = 'false',
						'No Emitido',
						'Anulada'))) as r_estado
			from
				tbl_emision_vehiculo_cabecera as tblevc
					inner join
				tbl_emision_vehiculo_detalle as tblevd ON (tblevd.id_emision_cabecera = tblevc.id_emision)
					inner join
				tbl_clients as tblc ON (tblc.id_client = tblevc.id_client)
					inner join
				tblusuarios as tblu ON (tblu.idusuario = tblevc.user)
					left join
				tbl_vehiculo_facultativo as tblvf on (tblevc.id_emision = tblvf.id_emision)
					left join
				tbl_vehiculo_facultativo_pendiente as tblvfp on (tblevc.id_emision = tblvfp.id_emision)
			where
				tblevc.id_emision like '" . $this->data['nc'] . "'
		        and tblevc.prefijo_producto like '%" . $this->data['prefix'] . "%'
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

   				and tblevc.fecha_creacion between '" . $this->data['date-begin'] . "'
		        and '" . $this->data['date-end'] . "'

				and if(tblevc.cl_emp = 0, 'NAT', 'JUR') regexp '".$this->data['r-customer-type']."'

			    and if(tblvf.aprobado is null,
				if(tblvfp.id_pendiente_fac is not null,
					case tblvfp.respuesta
						when 1 then 'S'
						when 0 then 'O'
					end,
					if(tblevc.emitir = 'false'
							and tblevc.caso_facultativo = 'true',
						'P',
						'R')),
				'R') regexp '".$this->data['r-pendant']."'

				and if(tblvfp.id_estado is not null
					and tblevc.emitir = 'false'
					and tblevc.caso_facultativo = 'true',
				tblvfp.id_estado,
				'0') regexp '".$this->data['r-state']."'

				and if(tblvf.aprobado is not null,
				if(tblvf.aprobado = 'si',
					if(tblvf.tasa_recargo = 'si', 'EP', 'NP'),
					'R'),
				if(tblevc.emitir = true
					and tblevc.caso_facultativo = 'false',
				'NP',
				'R')) regexp '".$this->data['r-extra-premium']."'

				and if(tblevc.emitir = 'true',
				'EM',
				if(tblvf.aprobado is not null,
					if(tblvf.aprobado = 'si', 'NE', 'R'),
					'NE')) regexp '".$this->data['r-issued']."'

				and if(tblvf.aprobado is not null,
				if(tblvf.aprobado = 'no', 'RE', 'R'),
				'R') regexp '".$this->data['r-rejected']."'

				and if(tblevc.anulada = 'true', 'AN', 'R') regexp '".$this->data['r-canceled']."'

			group by tblevc.id_emision
			order by tblevc.id_emision asc
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
				tblevd.id_emision as id_vehiculo,
				tblevd.tipo_vehiculo as vh_tipo,
				tblma.marcas as vh_marca,
				tblmo.modelos as vh_modelo,
				tblevd.anio as vh_anio,
				tblevd.placa as vh_placa,
				(case tblevd.uso_vehiculo
					when 'publico' then 'Publico'
					when 'privado' then 'Privado'
				end) as vh_uso,
				(case
					when tblevd.traccion = 'vpesado' then 'Vehiculo Pesado'
					else tblevd.traccion
				end) as vh_traccion,
				upper(tblevd.cero_km) as vh_km,
				(case tblevd.categoria
					when 'rac' then 'Rent a Car'
					when 'vp' then 'Vehiculo Privado'
				end) as vh_categoria,
				tblevd.valor_asegurado_usd as vh_valor_asegurado,
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
				date_format(tblevd.fecha_creacion, '%d/%m/%Y') as r_fecha_creacion
			from
				tbl_emision_vehiculo_detalle as tblevd
					inner join
				tbl_emision_vehiculo_cabecera as tblevc ON (tblevc.id_emision = tblevd.id_emision_cabecera)
					inner join
				tblmarcasauto as tblma ON (tblma.idmarcasauto = tblevd.marca)
					inner join
				tblmodelosauto as tblmo ON (tblmo.idmodelosauto = tblevd.modelo)
					inner join
				tblusuarios as tblu ON (tblu.idusuario = tblevc.user)
			where
				tblevd.id_emision_cabecera = ".$this->row['r_no_emision']."
					and tblevd.aprobado = true
			order by tblevd.id_emision asc
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