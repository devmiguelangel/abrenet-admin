<?php
/**
* Reportes Desgravamen Crecer
*/

class ReportDECrecerController
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

	public function setResultCrecer()
	{
		if (($this->queryCrecerEm()) === true) {
			$swBG = FALSE;
			$arr_state = array('txt' => '', 'action' => '', 'obs' => '', 'link' => '', 'bg' => '');

			while ($this->row = $this->rs->fetch_array(MYSQLI_ASSOC)) {
				$nCl = (int)$this->row['no_cl'];

				$bc = (boolean)$this->row['bc'];

				if ($swBG === FALSE) {
					$bg = 'background: #EEF9F8;';
				} elseif ($swBG === TRUE) {
					$bg = 'background: #D1EDEA;';
				}
							
				$rowSpan = false;
				if ($nCl >= 2) {
					$rowSpan = true;
				}
				
				$arr_state['txt'] = '';		$arr_state['txt_bank'] = '';	$arr_state['action'] = '';
				$arr_state['obs'] = '';		$arr_state['link'] = '';	$arr_state['bg'] = '';

				get_state($arr_state, $this->row, 2, 'DE', false);

				if ($this->queryCrecerDt($nCl) === true) {
					while ($this->rowDt = $this->rsDt->fetch_array(MYSQLI_ASSOC)) {
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

						$arr_detf = array();
						$arr_detp = array();

						if ($bc === true) {
							$arr_detp = json_decode($this->rowDt['detalle_p'], true);
							$arr_detf = json_decode($this->rowDt['detalle_f'], true);

							$arr_state['obs'] = '';
							$this->row['fecha_ultima_modificacion'] = '';
							$this->row['dias_ultima_modificacion'] = 0;
							$arr_state['txt'] = '';
							$arr_state['bg'] = '';

							$arr_state['txt'] = 'Aprobado';
							$arr_state['bg'] = 'background: #FF3C3C; color: #FFF;';

							$this->row['extra_prima'] = 0;

							if (empty($arr_detf) === true) {
								if (count($arr_detp) > 0) {
									$arr_state['obs'] = $arr_detp['estado'];
									$this->row['fecha_ultima_modificacion'] = $arr_detp['fecha_creacion'];

									$date1 = new DateTime(
										date('Y-m-d', strtotime(str_replace('/', '-', $arr_detp['fecha_creacion']))));
									$date2 = new DateTime(date('Y-m-d'));
									$interval = $date1->diff($date2);
									$this->row['dias_ultima_modificacion'] = $interval->format('%a');

									if ($arr_detp['respuesta'] === null) {
										$arr_state['txt'] = 'Observado';
										$arr_state['bg'] = 'background: #009148; color: #FFF;';
									} else {
										$arr_state['txt'] = 'Subsanado/Pendiente';
										$arr_state['bg'] = 'background: #FFFF2D; color: #666;';
									}
								}
							} else {
								if (count($arr_detf) > 0) {
									if ($arr_detf['aprobado'] === 'SI') {
										$arr_state['obs'] = $arr_state['txt'] = 'Aprobado';
										if ($arr_detf['tasa_recargo'] === 'SI') {
											$this->row['extra_prima'] = $arr_detf['porcentaje_recargo'];
										}
									} else {
										$arr_state['obs'] = $arr_state['txt'] = 'Rechazado';
										$cl_aprobado = true;
									}
									
									$this->row['fecha_ultima_modificacion'] = $arr_detf['fecha_creacion'];
									
									$date1 = new DateTime(
										date('Y-m-d', strtotime(str_replace('/', '-', $arr_detf['fecha_creacion']))));
									$date2 = new DateTime(date('Y-m-d'));
									$interval = $date1->diff($date2);
									$this->row['dias_ultima_modificacion'] = $interval->format('%a');

									$date3 = new DateTime(date('Y-m-d', strtotime($this->row['fecha_creacion'])));
									$interval2 = $date1->diff($date3);
									$this->row['dias_proceso'] = $interval2->format('%a');
								}
							}
						}

						echo rep_de_crecer($this->row, $this->rowDt, $this->db, $arr_state, $bg, $rowSpan);
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

	private function queryCrecerEm()
	{
		$this->sql = 'select 
			sde.id_emision as ide,
			count(sc.id_cliente) as no_cl,
			if(lower(spc.nombre) = "banca comunal", 1, 0) as bc,
			sef.id_ef as idef,
			sef.nombre as ef_nombre,
			sde.no_emision as r_no_emision,
			sde.prefijo as r_prefijo,
			sde.id_compania,
			sde.monto_solicitado as r_monto_solicitado,
			(case sde.moneda
				when "BS" then "Bolivianos"
				when "USD" then "Dolares"
			end) as r_moneda,
			sde.plazo as r_plazo,
			(case sde.tipo_plazo
				when "Y" then "Años"
				when "M" then "Meses"
				when "W" then "Semanas"
				when "D" then "Días"
			end) as r_tipo_plazo,
			su.nombre as r_creado_por,
			date_format(sde.fecha_creacion, "%d/%m/%Y") as r_fecha_creacion,
			sde.fecha_creacion,
			sdep.departamento as r_sucursal,
			sag.agencia as r_agencia,
			(case sde.anulado
				when 1 then "SI"
				when 0 then "NO"
			end) as r_anulado,
			if(sde.anulado = true, sua.nombre, "") as r_anulado_nombre,
			if(sde.anulado = true,
				date_format(sde.fecha_anulado, "%d/%m/%Y"),
				"") as r_anulado_fecha,
			(select 
					count(sde1.id_emision)
				from
					s_de_em_cabecera as sde1
				where
					sde1.id_cotizacion = sde.id_cotizacion
						and sde1.anulado = true) as r_num_anulado,
			if(sdf.aprobado is null,
				if(sdp.id_pendiente is not null,
					case sdp.respuesta
						when 1 then "S"
						when 0 then "O"
					end,
					if((sde.emitir = 0 and sde.aprobado = 1)
                       or sde.facultativo = 1,
                       "P",
                       if(sde.emitir = 0 and sde.aprobado = 0
                          and sde.facultativo = 0,
                          "P",
                          "F")
                       )),
				case sdf.aprobado
					when "SI" then "A"
					when "NO" then "R"
				end) as estado,
			case
				when sds.codigo = "ED" then "E"
		        when sds.codigo != "ED" then "NE"
				else null
			end as observacion,
			sds.id_estado,
			sds.estado as estado_pendiente,
			sds.codigo as estado_codigo,
			if(sde.anulado = 1,
				1,
				if(sde.emitir = true, 2, 3)) as estado_banco,
			sde.facultativo as estado_facultativo,
			if(sdf.porcentaje_recargo is not null,
				sdf.porcentaje_recargo,
				0) as extra_prima,
			if(sdf.fecha_creacion is not null,
				date_format(sdf.fecha_creacion, "%d/%m/%Y"),
				"") as fecha_resp_final_cia,
			if(sde.emitir = true,
				datediff(sde.fecha_emision, sde.fecha_creacion),
				datediff(curdate(), sde.fecha_creacion)) as duracion_caso,
			@fum:=(if(sdf.aprobado is null,
				datediff(curdate(), sdp.fecha_creacion),
				datediff(curdate(), sdf.fecha_creacion))) as fum,
			if(@fum is not null, @fum, 0) as dias_ultima_modificacion,
			if(sde.emitir = true,
				if(sdf.aprobado is not null,
					datediff(sdf.fecha_creacion, sde.fecha_creacion),
					datediff(sde.fecha_emision, sde.fecha_creacion)),
				if(sdf.aprobado is null,
					datediff(curdate(), sde.fecha_creacion),
					datediff(sdf.fecha_creacion, sde.fecha_creacion))) as dias_proceso,
			date_format(sdp.fecha_creacion, "%d/%m/%Y") as fecha_ultima_respuesta,
			if(sde.emitir = false, 
				if(sde.aprobado = true, 1, 0),
				1) as solicitud
		from
			s_de_em_cabecera as sde
				inner join
			s_de_em_detalle as sdd ON (sdd.id_emision = sde.id_emision)
				inner join
			s_cliente as sc ON (sc.id_cliente = sdd.id_cliente)
				left join
			s_de_facultativo as sdf ON (sdf.id_emision = sde.id_emision)
				left join
			s_de_pendiente as sdp ON (sdp.id_emision = sde.id_emision)
				left join
			s_estado as sds ON (sds.id_estado = sdp.id_estado)
				inner join
			s_usuario as su ON (su.id_usuario = sde.id_usuario)
				inner join
			s_departamento as sdep ON (sdep.id_depto = su.id_depto)
				left join
			s_agencia as sag ON (sag.id_agencia = su.id_agencia)
				inner join
			s_usuario as sua ON (sua.id_usuario = sde.and_usuario)
				inner join
			s_entidad_financiera as sef ON (sef.id_ef = sde.id_ef)
				inner join
    		s_producto_cia as spc on (spc.id_prcia = sde.id_prcia)
		where
			sde.no_emision like "' . $this->data['nc'] . '"
				and sde.prefijo like "%' . $this->data['prefix'] . '%"
				and concat(sc.nombre,
					" ",
					sc.paterno,
					" ",
					sc.materno) like "%' . $this->data['client'] . '%"
				and sc.ci like "%' . $this->data['dni'] . '%"
				and sc.complemento like "%' . $this->data['comp'] . '%"
				and sc.extension like "%' . $this->data['ext'] . '%"
				and sde.fecha_creacion 
					between "' . $this->data['date-begin'] . '" and "' . $this->data['date-end'] . '"
				and if(sdf.aprobado is null,
				if(sdp.id_pendiente is not null,
					case sdp.respuesta
						when 1 then "S"
						when 0 then "O"
					end,
					if(sde.emitir = false
							and sde.facultativo = true,
						"P",
						"R")),
				"R") regexp "' . $this->data["r-pendant"] . '"
				and if(sds.id_estado is not null
					and sde.emitir = false
					and sde.facultativo = true,
				sds.id_estado,
				"0") regexp "' . $this->data["r-state"] . '"
				and if(sdf.aprobado is null,
				if(sde.emitir = true
						and sde.anulado = false,
					"FC",
					"R"),
				case sdf.aprobado
					when "SI" then "NF"
					when "NO" then "R"
				end) regexp "' . $this->data["r-free-cover"] . '"
				and if(sdf.aprobado is not null,
				if(sdf.aprobado = "SI",
					if(sdf.tasa_recargo = "SI", "EP", "NP"),
					"R"),
				if(sde.emitir = true
					and sde.facultativo = false,
				"NP",
				"R")) regexp "' . $this->data["r-extra-premium"] . '" 
				and if(sde.emitir = true,
				"EM",
				if(sdf.aprobado is not null,
					if(sdf.aprobado = "SI", "NE", "R"),
					"NE")) regexp "' . $this->data["r-issued"] . '"
				and if(sdf.aprobado is not null,
				if(sdf.aprobado = "NO", "RE", "R"),
				"R") regexp "' . $this->data["r-rejected"] . '"
				and if(sde.anulado = true, "AN", "R") regexp "' . $this->data["r-canceled"] . '" 
		group by sde.id_emision
		order by sde.id_emision desc
		;';

		if (($this->rs = $this->cx->query($this->sql, MYSQLI_STORE_RESULT)) !== false) {
			if ($this->rs->num_rows > 0) {
				return true;
			}
		}
		return false;
	}

	private function queryCrecerDt($nCl)
	{
		$this->sqlDt = 'select 
			sdc.id_cliente as idCl,
			concat(sdc.nombre,
					" ",
					sdc.paterno,
					" ",
					sdc.materno) as cl_nombre,
			sdc.ci as cl_ci,
			sdc.complemento as cl_complemento,
			sdep.codigo as cl_extension,
			sdep.departamento as cl_ciudad,
			(case sdc.genero
				when "M" then "Hombre"
				when "F" then "Mujer"
			end) as cl_genero,
			sdc.telefono_domicilio as cl_telefono,
			sdc.telefono_celular as cl_celular,
			sdc.email as cl_email,
			(case sdd.titular
				when "DD" then "Deudor"
				when "CC" then "Codeudor"
			end) as cl_titular,
			sdc.estatura as cl_estatura,
			sdc.peso as cl_peso,
			sdd.porcentaje_credito as cl_participacion,
			(year(curdate()) - year(sdc.fecha_nacimiento)) as cl_edad,
			sdd.id_detalle,
			sdd.detalle_f,
			sdd.detalle_p
		from
			s_cliente as sdc
				inner join
			s_de_em_detalle as sdd ON (sdd.id_cliente = sdc.id_cliente)
				inner join
			s_departamento as sdep ON (sdep.id_depto = sdc.extension)
		where
			sdd.id_emision = "' . $this->row["ide"] . '"
				and concat(sdc.nombre,
					" ",
					sdc.paterno,
					" ",
					sdc.materno) like "%' . $this->data["client"] . '%"
				and sdc.ci like "%' . $this->data["dni"] . '%"
				and sdc.complemento like "%' . $this->data["comp"] . '%"
				and sdc.extension like "%' . $this->data["ext"] . '%"
		order by sdc.id_cliente asc
		;';

		if (($this->rsDt = $this->cx->query($this->sqlDt, MYSQLI_STORE_RESULT)) !== false) {
			if ($this->rsDt->num_rows === $nCl) {
				return true;
			}
		}

		return false;
	}
}

?>