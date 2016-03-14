<?php
/**
* Reportes Automotor Ecofuturo
*/
class ReportAUEcofuturoController
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

	public function setResultEcofuturo(){
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

					if ($this->queryEcofuturoDt($nVH) === true) {
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


		if( ($nat == 0 and $jur == 0 and $sw == 0) or ($jur == 1 and $sw == 0) ){

			if ($this->queryEcofuturoEmemp() === true) {
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

					if ($this->queryEcofuturoDtemp($nVH) === true) {
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
	}

	private function queryEcofuturoEm()
	{
		$this->sql = "select
				count(tblvc.id_emision) as no_vh,
				tblvc.id_emision r_no_emision,
				tblvc.prefijo_producto as r_prefijo,
				CONCAT (tblc.nombres, ' ', tblc.ap_paterno, ' ', tblc.ap_materno) as cl_nombre,
				tblc.ci_persona as cl_cinit,
				upper(tblc.complemento) as cl_complemento,
				(case tblc.sexo
					when 'varon' then 'Masculino'
					when 'mujer' then 'Femenino'
				end) as cl_genero,
				if(tblvc.id_emision > 0, 'Natural', '') as cl_tipo_cliente,
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
				tblvc.forma_pago as r_forma_pago,
				(case tblvc.anulada
					when 'true' then 'SI'
					when 'false' then 'NO'
				end) as r_anulado,
				(select
						count(tblevc1.id_cotiza)
					from
						tbl_emision_vehiculo_cabecera as tblevc1
					where
						tblevc1.id_cotiza = tblvc.id_cotiza
							and tblevc1.anulada = 'true') as r_num_anulado,
				(if(tblvc.emitir = 'true'
						and tblvc.anulada = 'false',
					'Emitido',
					if(tblvc.emitir = 'false'
							and tblvc.anulada = 'false',
						'No Emitido',
						'Anulada'))) as r_estado
				from
				tbl_emision_vehiculo_cabecera AS tblvc
					inner join
				tbl_emision_vehiculo_detalle AS tblvd ON (tblvd.id_emision = tblvc.id_emision)
					inner join
				tbl_clients as tblc ON (tblc.id_client = tblvc.id_client)
					inner join
				tblusuarios as tblu ON (tblu.idusuario = tblvc.user)
					inner join
				tblvehiculocabecera as tblvcc ON (tblvc.id_cotiza = tblvcc.idvehiculocabecera)
					inner join
				tblvehiculofila as tblvf ON (tblvcc.idvehiculocabecera = tblvf.idvehiculocabecera)
					inner join
				tblvehiculopersona as tblvp ON (tblvcc.idvehiculopersona = tblvp.idvehiculopersona)
					inner join
				tblmarcasauto as tblma ON (tblvd.marca = tblma.idmarcasauto)
					inner join
				tblmodelosauto as tblmo ON (tblvd.modelo = tblmo.idmodelosauto)
				where
 				tblvc.id_emision like '" . $this->data['nc'] . "'
		        and tblvc.prefijo_producto like '%" . $this->data['prefix'] . "%'
		        and CONCAT(tblc.nombres,
		            ' ',
		            tblc.ap_paterno,
		            ' ',
		            tblc.ap_materno) like '%" . $this->data['client'] . "%'

		        and tblc.ci_persona like '%" . $this->data['dni'] . "%'
		        and tblc.complemento like '%" . $this->data['comp'] . "%'
		        and tblc.ci_ext like '%" . $this->data['ext'] . "%'
		        and tblvd.fecha_creacion between '" . $this->data['date-begin'] . "'
		        and '" . $this->data['date-end'] . "'
				and
					if(tblvc.emitir = 'true',
					'EM', 'NE') regexp '".$this->data['r-issued']."'
					and if(tblvc.anulada = 'true', 'AN', 'R') regexp '".$this->data['r-canceled']."'
				group by tblvc.id_emision
				order by tblvc.id_emision asc
		;";

		if (($this->rs = $this->cx->query($this->sql, MYSQLI_STORE_RESULT)) !== false) {
			if ($this->rs->num_rows > 0) {
				return true;
			}
		}

		return false;
	}

	private function queryEcofuturoDt($nVH)
	{
		$this->sqlDt = "select
				tblvd.id_emision as id_vehiculo,
				tblvd.tipo_vehiculo as vh_tipo,
				tblma.marcas as vh_marca,
				tblmo.modelos as vh_modelo,
				tblvd.anio as vh_anio,
				tblvd.placa as vh_placa,
				(case tblvd.uso_vehiculo
					when 'publico' then 'Publico'
					when 'privado' then 'Privado'
				end) as vh_uso,
				(case
					when tblvd.traccion = 'vpesado' then 'Vehiculo Pesado'
					else tblvd.traccion
				end) as vh_traccion,
				(case tblvd.cero_km
			        when '1' then 'SI'
			        when '2' then 'NO'
		   		end) AS vh_km,
				(case tblvd.categoria
					when 'rac' then 'Rent a Car'
					when 'vp' then 'Vehiculo Privado'
				end) as vh_categoria,
				tblvd.valor_asegurado_usd as vh_valor_asegurado,
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
		   		date_format(tblvd.fecha_creacion, '%d/%m/%Y') as r_fecha_creacion
			from
				tbl_emision_vehiculo_cabecera AS tblvc
					inner join
				tbl_emision_vehiculo_detalle AS tblvd ON (tblvd.id_emision = tblvc.id_emision)
					inner join
				tblusuarios as tblu ON (tblu.idusuario = tblvc.user)
					inner join
				tblvehiculocabecera as tblvcc ON (tblvc.id_cotiza = tblvcc.idvehiculocabecera)
					inner join
				tblvehiculofila as tblvf ON (tblvcc.idvehiculocabecera = tblvf.idvehiculocabecera)
					inner join
				tblvehiculopersona as tblvp ON (tblvcc.idvehiculopersona = tblvp.idvehiculopersona)
					inner join
				tblmarcasauto as tblma ON (tblvd.marca = tblma.idmarcasauto)
					inner join
				tblmodelosauto as tblmo ON (tblvd.modelo = tblmo.idmodelosauto)
			where
				tblvc.id_emision = ".$this->row['r_no_emision']."
			order by tblvcc.idvehiculocabecera asc
		;";

		if (($this->rsDt = $this->cx->query($this->sqlDt, MYSQLI_STORE_RESULT)) !== false) {
			if ($this->rsDt->num_rows === $nVH) {
				return true;
			}
		}

		return false;
	}


	private function queryEcofuturoEmemp()
	{
		$this->sql = "select
				count(tblvc.id_emision) as no_vh,
				tblvc.id_emision r_no_emision,
				tblvc.prefijo_producto as r_prefijo,
				tblc.razon_social as cl_nombre,
				tblc.nit as cl_cinit,
				if(tblvc.id_emision > 0, 'Juridico', '') as cl_tipo_cliente,

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
				tblvc.forma_pago as r_forma_pago,
				(case tblvc.anulada
					when 'true' then 'SI'
					when 'false' then 'NO'
				end) as r_anulado,

				(select
						count(tblevc1.id_cotiza)
					from
						tbl_emision_vehiculo_cabecera as tblevc1
					where
						tblevc1.id_cotiza = tblvc.id_cotiza
							and tblevc1.anulada = 'true') as r_num_anulado,

				(if(tblvc.emitir = 'true'
						and tblvc.anulada = 'false',
					'Emitido',
					if(tblvc.emitir = 'false'
							and tblvc.anulada = 'false',
						'No Emitido',
						'Anulada'))) as r_estado
				from
				tbl_emision_vehiculo_cabeceraemp AS tblvc
					inner join
				tbl_emision_vehiculo_detalleemp AS tblvd ON (tblvd.id_emision = tblvc.id_emision)
					inner join
				tbl_clientsemp as tblc ON (tblc.id_client = tblvc.id_client)
					inner join
				tblusuarios as tblu ON (tblu.idusuario = tblvc.user)
					inner join
				tblvehiculocabeceraemp as tblvcc ON (tblvc.id_cotiza = tblvcc.idvehiculocabecera)
					inner join
				tblvehiculofilaemp as tblvf ON (tblvcc.idvehiculocabecera = tblvf.idvehiculocabecera)
					inner join
				tblvehiculoempresa as tblvp ON (tblvcc.idvehiculopersona = tblvp.idvehiculopersona)
					inner join
				tblmarcasauto as tblma ON (tblvd.marca = tblma.idmarcasauto)
					inner join
				tblmodelosauto as tblmo ON (tblvd.modelo = tblmo.idmodelosauto)
				where
				tblvc.id_emision like '" . $this->data['nc'] . "'
  				and	tblvc.prefijo_producto like '%" . $this->data['prefix'] . "%'
				and tblc.razon_social like '%" . $this->data['client'] . "%'
				and tblc.nit like '%" . $this->data['dni'] . "%'
				and tblc.departamento like '%" . $this->data['ext'] . "%'
				and tblvd.fecha_creacion between '" . $this->data['date-begin'] . "'
		        and '" . $this->data['date-end'] . "'
				and
					if(tblvc.emitir = 'true',
					'EM', 'NE') regexp '".$this->data['r-issued']."'
					and if(tblvc.anulada = 'true', 'AN', 'R') regexp '".$this->data['r-canceled']."'
				group by tblvc.id_emision
				order by tblvc.id_emision asc
		;";

		if (($this->rs = $this->cx->query($this->sql, MYSQLI_STORE_RESULT)) !== false) {
			if ($this->rs->num_rows > 0) {
				return true;
			}
		}

		return false;
	}

	private function queryEcofuturoDtemp($nVH)
	{
		$this->sqlDt = "select
				tblvd.id_emision as id_vehiculo,
				tblvd.tipo_vehiculo as vh_tipo,
				tblma.marcas as vh_marca,
				tblmo.modelos as vh_modelo,
				tblvd.anio as vh_anio,
				tblvd.placa as vh_placa,
				(case tblvd.uso_vehiculo
					when 'publico' then 'Publico'
					when 'privado' then 'Privado'
				end) as vh_uso,
				(case
					when tblvd.traccion = 'vpesado' then 'Vehiculo Pesado'
					else tblvd.traccion
				end) as vh_traccion,
				(case tblvd.cero_km
			        when '1' then 'SI'
			        when '2' then 'NO'
		   		end) AS vh_km,
				(case tblvd.categoria
					when 'rac' then 'Rent a Car'
					when 'vp' then 'Vehiculo Privado'
				end) as vh_categoria,
				tblvd.valor_asegurado_usd as vh_valor_asegurado,
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
				date_format(tblvd.fecha_creacion, '%d/%m/%Y') as r_fecha_creacion
			from
				tbl_emision_vehiculo_cabeceraemp AS tblvc
					inner join
				tbl_emision_vehiculo_detalleemp AS tblvd ON (tblvd.id_emision = tblvc.id_emision)
					inner join
				tblusuarios as tblu ON (tblu.idusuario = tblvc.user)
					inner join
				tblvehiculocabeceraemp as tblvcc ON (tblvc.id_cotiza = tblvcc.idvehiculocabecera)
					inner join
				tblvehiculofilaemp as tblvf ON (tblvcc.idvehiculocabecera = tblvf.idvehiculocabecera)
					inner join
				tblvehiculoempresa as tblvp ON (tblvcc.idvehiculopersona = tblvp.idvehiculopersona)
					inner join
				tblmarcasauto as tblma ON (tblvd.marca = tblma.idmarcasauto)
					inner join
				tblmodelosauto as tblmo ON (tblvd.modelo = tblmo.idmodelosauto)
			where
				tblvc.id_emision = ".$this->row['r_no_emision']."
			order by tblvcc.idvehiculocabecera asc
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