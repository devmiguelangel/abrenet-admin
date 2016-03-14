<?php
/**
* Reportes Paulo VI
*/
class ReportDEPauloviController
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

	public function setResultPaulovi()
	{
		if ($this->queryPauloviEm() === true) {
			$swBG = FALSE;
			$arr_state = array('txt' => '', 'action' => '', 'obs' => '', 'link' => '', 'bg' => '');

			$user = '';
			if ($this->data['rprint'] === true) {
				session_start();
				$user = base64_decode($_SESSION['user']);
			}

			while ($this->row = $this->rs->fetch_array(MYSQLI_ASSOC)) {
				$this->row['host'] = $this->db['ef_dominio'] . '064cf398ca384f04af3b4fa4b43dea66/' 
					. 'formulario_desgravamen_detalle.php?usuario_admin=' . $user 
					. '&idcotizacabecera=' . $this->row['idc'] 
					. '&idcompania=' 
					. '&tipocobertura=' 
					. '&idproducto=' 
					. '&idemision=' . $this->row['ide'] 
					. '&ciudad_logueado=' 
					. '&verdetalle=3&conect=log'
					. '&url=' . base64_encode($this->db['ef_dominio']);

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

				if ($this->queryPauloviDt($nCl) === true) {
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

						$this->result .= rep_desgravamen($this->row, $this->rowDt, 
							$this->db, $arr_state, $bg, $rowSpan, $this->data['rprint']);
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

	private function queryPauloviEm()
	{
		$this->sql = "SELECT 
		    tedc.id_emision AS ide,
		    tedc.id_cotiza AS idc,
		    COUNT(tc.id_client) AS no_cl,
		    0 bc,
		    tedc.id_emision AS r_no_emision,
		    tedc.prefijo_producto AS r_prefijo,
		    tedc.id_compania,
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
		    (CASE tu.departamento
		        WHEN 'lapaz' THEN 'La Paz'
		        WHEN 'oruro' THEN 'Oruro'
		        WHEN 'potosi' THEN 'Potosi'
		        WHEN 'tarija' THEN 'Tarija'
		        WHEN 'sucre' THEN 'Chuquisaca'
		        WHEN 'cochabamba' THEN 'Cochabamba'
		        WHEN 'pando' THEN 'Pando'
		        WHEN 'beni' THEN 'Beni'
		        WHEN 'sc' THEN 'Santa Cruz'
		    END) AS r_sucursal,
		    tag.desc_agencia AS r_agencia,
		    (CASE tedc.anulada
		        WHEN 'true' THEN 'SI'
		        WHEN 'false' THEN 'NO'
		    END) AS r_anulado,
		    IF(tedc.anulada = 'true',
		        tua.nombre,
		        '') AS r_anulado_nombre,
		    IF(tedc.anulada = 'true',
		        DATE_FORMAT(tedc.fecha_anulacion, '%d/%m/%Y'),
		        '') AS r_anulado_fecha,
		    (SELECT 
		            COUNT(tedc1.id_emision)
		        FROM
		            tbl_emision_des_cabecera AS tedc1
		        WHERE
		            tedc1.id_cotiza = tedc.id_cotiza
		                AND tedc1.anulada = 'true') AS r_num_anulado,
		    IF(tdf.aprobado IS NULL,
		        IF(tdp.id_pendiente_fac IS NOT NULL,
		            CASE tdp.id_respuesta
		                WHEN 1 THEN 'S'
		                WHEN 0 THEN 'O'
		            END,
		            IF((tedc.emitir = 'false')
		                    OR tedc.caso_facultativo = 'true',
		                'P',
		                IF(tedc.emitir = 'false'
		                        AND tedc.caso_facultativo = 'false',
		                    'P',
		                    'F'))),
		        CASE tdf.aprobado
		            WHEN 'si' THEN 'A'
		            WHEN 'no' THEN 'R'
		        END) AS estado,
		    CASE
		        WHEN tds.id_estado = 4 THEN 'E'
		        WHEN tds.id_estado != 4 THEN 'NE'
		        ELSE NULL
		    END AS observacion,
		    tds.id_estado,
		    tds.descripcion AS estado_pendiente,
		    '' AS estado_codigo,
		    IF(tedc.anulada = 'true',
		        1,
		        IF(tedc.emitir = 'true', 2, 3)) AS estado_banco,
		    CASE tedc.caso_facultativo
		        WHEN 'true' THEN 1
		        WHEN 'false' THEN 0
		    END AS estado_facultativo,
		    IF(tdf.porcentaje_recargo IS NOT NULL,
		        tdf.porcentaje_recargo,
		        0) AS extra_prima,
		    IF(tdf.fechacreacion IS NOT NULL,
		        DATE_FORMAT(tdf.fechacreacion, '%d/%m/%Y'),
		        '') AS fecha_resp_final_cia,
		    IF(tedc.emitir = 'true',
		        DATEDIFF(tedc.fecha_real_emision,
		                tedc.fecha_creacion),
		        DATEDIFF(CURDATE(), tedc.fecha_creacion)) AS duracion_caso,
		    @fum:=(IF(tdf.aprobado IS NULL,
		        DATEDIFF(CURDATE(), tdp.fecha_creacion),
		        DATEDIFF(CURDATE(), tdf.fechacreacion))) AS fum,
		    IF(@fum IS NOT NULL, @fum, 0) AS dias_ultima_modificacion,
		    IF(tedc.emitir = 'true',
		        IF(tdf.aprobado IS NOT NULL,
		            DATEDIFF(tdf.fechacreacion, tedc.fecha_creacion),
		            DATEDIFF(tedc.fecha_real_emision,
		                    tedc.fecha_creacion)),
		        IF(tdf.aprobado IS NULL,
		            DATEDIFF(CURDATE(), tedc.fecha_creacion),
		            DATEDIFF(tdf.fechacreacion, tedc.fecha_creacion))) AS dias_proceso,
		    DATE_FORMAT(tdp.fecha_creacion, '%d/%m/%Y') AS fecha_ultima_respuesta,
		    IF(tedc.emitir = 'false', 0, 1) AS solicitud
		FROM
		    tbl_emision_des_cabecera AS tedc
		        INNER JOIN
		    tbl_emision_des_personas AS tedp ON (tedp.id_emision = tedc.id_emision)
		        INNER JOIN
		    tbl_clients AS tc ON (tc.id_client = tedp.id_client)
		        LEFT JOIN
		    tbl_des_facultativo AS tdf ON (tdf.id_emision = tedc.id_emision)
		        LEFT JOIN
		    tbl_des_facultativo_pendiente AS tdp ON (tdp.id_emision = tedc.id_emision)
		        LEFT JOIN
		    tbl_estado AS tds ON (tds.id_estado = tdp.id_estado)
		        LEFT JOIN
		    tblusuarios AS tu ON (tu.idusuario = tedc.creadopor)
		        LEFT JOIN
		    tblagencia AS tag ON (tag.id_agencia = tu.id_agencia)
		        LEFT JOIN
		    tblusuarios AS tua ON (tua.idusuario = tedc.anulado_por)
		WHERE
		    tedc.id_emision LIKE '" . $this->data['nc'] . "'
		        AND tedc.prefijo_producto LIKE '%" . $this->data['prefix'] . "%'
		        AND CONCAT(tc.nombres,
		            ' ',
		            tc.ap_paterno,
		            ' ',
		            tc.ap_materno) LIKE '%" . $this->data['client'] . "%'
		        AND tc.ci_persona LIKE '%" . $this->data['dni'] . "%'
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
		        AND IF(tdf.aprobado IS NULL,
		        IF(tdp.id_pendiente_fac IS NOT NULL,
		            CASE tdp.id_respuesta
		                WHEN 1 THEN 'S'
		                WHEN 0 THEN 'O'
		            END,
		            IF(tedc.emitir = 'false'
		                    AND tedc.caso_facultativo = 'true',
		                'P',
		                'R')),
		        'R') REGEXP '" . $this->data["r-pendant"] . "'
				AND IF(tds.id_estado IS NOT NULL
		            AND tedc.emitir = 'false'
		            AND tedc.caso_facultativo = 'true',
		        (CASE tds.id_estado
		        	WHEN 1 THEN 'EM'
		        	WHEN 2 THEN 'RA'
		        	WHEN 3 THEN 'AC'
		        	WHEN 4 THEN 'ED'
		        END),
		        '0') REGEXP '" . $this->data["r-state"] . "'
				AND IF(tdf.aprobado IS NULL,
		        IF(tedc.emitir = 'true'
		                AND tedc.anulada = 'false',
		            'FC',
		            'R'),
		        CASE tdf.aprobado
		            WHEN 'si' THEN 'NF'
		            WHEN 'no' THEN 'R'
		        END) REGEXP '" . $this->data["r-free-cover"] . "'
				AND IF(tdf.aprobado IS NOT NULL,
		        IF(tdf.aprobado = 'si',
		            IF(tdf.tasa_recargo = 'si', 'EP', 'NP'),
		            'R'),
		        IF(tedc.emitir = 'true'
		                AND tedc.caso_facultativo = 'false',
		            'NP',
		            'R')) REGEXP '" . $this->data["r-extra-premium"] . "'
				AND IF(tedc.emitir = 'true',
		        'EM',
		        IF(tdf.aprobado IS NOT NULL,
		            IF(tdf.aprobado = 'si', 'NE', 'R'),
		            'NE')) REGEXP '" . $this->data['r-issued'] . "'
		        AND IF(tdf.aprobado IS NOT NULL,
		        IF(tdf.aprobado = 'no', 'RE', 'R'),
		        'R') REGEXP '" . $this->data['r-rejected'] . "'
		        AND IF(tedc.anulada = 'true', 'AN', 'R') REGEXP '" . $this->data['r-canceled'] . "'
		GROUP BY tedc.id_emision
		ORDER BY tedc.id_emision DESC
		-- LIMIT 0 , 100
		;";

		if (($this->rs = $this->cx->query($this->sql, MYSQLI_STORE_RESULT)) !== false) {
			if ($this->rs->num_rows > 0) {
				return true;
			}
		}

		return false;
	}

	private function queryPauloviDt($nCl)
	{
		$this->sqlDt = "SELECT 
		    tdc.id_client AS idCl,
		    CONCAT(tdc.nombres,
		            ' ',
		            tdc.ap_paterno,
		            ' ',
		            tdc.ap_materno) AS cl_nombre,
		    tdc.ci_persona AS cl_ci,
		    tdc.complemento AS cl_complemento,
		    (CASE tdc.ci_ext
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
		    (CASE tdc.ciudad_domicilio
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
		    (CASE tdc.sexo
		        WHEN 'varon' THEN 'Hombre'
		        WHEN 'mujer' THEN 'Mujer'
		    END) AS cl_genero,
		    tdc.tel_domicilio AS cl_telefono,
		    tdc.tel_movil AS cl_celular,
		    tdc.email AS cl_email,
		    (CASE tedp.deudor_codeudor
		        WHEN 'deudor' THEN 'Deudor'
		        WHEN 'codeudor' THEN 'Codeudor'
		    END) AS cl_titular,
		    tedp.estatura_cm AS cl_estatura,
		    tedp.peso_kg AS cl_peso,
		    tedp.por_participacion AS cl_participacion,
		    (YEAR(CURDATE()) - YEAR(tdc.fecha_nac)) AS cl_edad,
		    tedp.id_des_personas AS id_detalle
		FROM
		    tbl_clients AS tdc
		        INNER JOIN
		    tbl_emision_des_personas AS tedp ON (tedp.id_client = tdc.id_client)
		WHERE
		    tedp.id_emision = '" . $this->row['ide'] . "'
		        AND CONCAT(tdc.nombres,
		            ' ',
		            tdc.ap_paterno,
		            ' ',
		            tdc.ap_materno) LIKE '%" . $this->data["client"] . "%'
		        AND tdc.ci_persona LIKE '%" . $this->data["dni"] . "%'
		        AND tdc.complemento LIKE '%" . $this->data["comp"] . "%'
		        AND (CASE tdc.ci_ext
				        WHEN 'lapaz' THEN 'LP'
				        WHEN 'oruro' THEN 'OR'
				        WHEN 'potosi' THEN 'PT'
				        WHEN 'tarija' THEN 'TJ'
				        WHEN 'sucre' THEN 'CH'
				        WHEN 'cochabamba' THEN 'CB'
				        WHEN 'pando' THEN 'PA'
				        WHEN 'beni' THEN 'BN'
				        WHEN 'santacruz' THEN 'SC'
				    END) LIKE '%" . $this->data["ext"] . "%'
		ORDER BY tedp.id_des_personas ASC
		;";

		if (($this->rsDt = $this->cx->query($this->sqlDt, MYSQLI_STORE_RESULT)) !== false) {
			if ($this->rsDt->num_rows === $nCl) {
				return true;
			}
		}

		return false;
	}

	public function apsPauloVI($qs)
	{
		$err = false;

		$sql = 'select max(idpregunta) + 1 as idpregunta 
		from tblpreguntamadrede
		;';

		if (($rs = $this->cx->query($sql, MYSQLI_STORE_RESULT)) !== false) {
			if ($rs->num_rows === 1) {
				$row = $rs->fetch_array(MYSQLI_ASSOC);
				$rs->free();

				$id = $row['idpregunta'];

				$sql = 'alter table tblpreguntamadrede 
					add (activado boolean not null default false);
				update tblpreguntamadrede
		        	set activado = false ; 
				update tbl_certificado_version
		        	set activo = 0 ;
		        update tbl_certificado_version
		        	set activo = 1 
		        where id_certificado_version = 3;
		        ALTER TABLE tblcotizacabecerade 
		        	ADD vg BOOLEAN NOT NULL DEFAULT FALSE,
		        	ADD tasa DOUBLE(10,3) NOT NULL;
				ALTER TABLE tbl_emision_des_cabecera 
					ADD vg BOOLEAN NOT NULL DEFAULT FALSE,
					ADD tasa DOUBLE(10,3) NOT NULL;
		        ';

		        $sql .= '
		        insert into tblpreguntamadrede
		            values ';
				
				foreach ($qs as $key => $value) {
					$sql .= '
					("' . $id . '", "' . utf8_decode($value) . '", curdate(), "admin", ' . $key . ', 2, true),';

					$id += 1;
				}

				$sql = trim($sql, ',') . ' ;';

				$id = $row['idpregunta'];

				$sql .= '
				insert into tblrespuestaesperadade
					values ';
					
				foreach ($qs as $key => $value) {
					$sql .= '
					(null, "' . $id . '", 4, 2, curdate()),';
					$id += 1;
				}
				
				$sql = trim($sql, ',') . ' ;';
				
		        if ($this->cx->multi_query($sql) === true) {
		        	do {
		        		if ($this->cx->errno !== 0) {
		        			$err = true;
		        		}
		        	} while ($this->cx->more_results() && $this->cx->next_result());
		        } else {
		        	$err = true;
		        }

		        if ($err === false) {
		        	return true;
		        }
			}
		}

        return false;
	}

}
?>