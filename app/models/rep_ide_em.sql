SELECT 
    sde.id_emision AS ide,
    COUNT(sc.id_cliente) AS no_cl,
    IF(LOWER(spc.nombre) = 'banca comunal',
        1,
        0) AS bc,
    sef.id_ef AS idef,
    sef.nombre AS ef_nombre,
    sde.no_emision AS r_no_emision,
    sde.prefijo AS r_prefijo,
    sde.id_compania,
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
    DATE_FORMAT(sde.fecha_creacion, '%d/%m/%Y') AS r_fecha_creacion,
    sde.fecha_creacion,
    sdep.departamento AS r_sucursal,
    sag.agencia AS r_agencia,
    (CASE sde.anulado
        WHEN 1 THEN 'SI'
        WHEN 0 THEN 'NO'
    END) AS r_anulado,
    IF(sde.anulado = TRUE, sua.nombre, '') AS r_anulado_nombre,
    IF(sde.anulado = TRUE,
        DATE_FORMAT(sde.fecha_anulado, '%d/%m/%Y'),
        '') AS r_anulado_fecha,
    (SELECT 
            COUNT(sde1.id_emision)
        FROM
            s_de_em_cabecera AS sde1
        WHERE
            sde1.id_cotizacion = sde.id_cotizacion
                AND sde1.anulado = TRUE) AS r_num_anulado,
    IF(sdf.aprobado IS NULL,
        IF(sdp.id_pendiente IS NOT NULL,
            CASE sdp.respuesta
                WHEN 1 THEN 'S'
                WHEN 0 THEN 'O'
            END,
            IF((sde.emitir = 0 AND sde.aprobado = 1)
                    OR sde.facultativo = 1,
                'P',
                IF(sde.emitir = 0 AND sde.aprobado = 0
                        AND sde.facultativo = 0,
                    'P',
                    'F'))),
        CASE sdf.aprobado
            WHEN 'SI' THEN 'A'
            WHEN 'NO' THEN 'R'
        END) AS estado,
    CASE
        WHEN sds.codigo = 'ED' THEN 'E'
        WHEN sds.codigo != 'ED' THEN 'NE'
        ELSE NULL
    END AS observacion,
    sds.id_estado,
    sds.estado AS estado_pendiente,
    sds.codigo AS estado_codigo,
    IF(sde.anulado = 1,
        1,
        IF(sde.emitir = TRUE, 2, 3)) AS estado_banco,
    sde.facultativo AS estado_facultativo,
    IF(sdf.porcentaje_recargo IS NOT NULL,
        sdf.porcentaje_recargo,
        0) AS extra_prima,
    IF(sdf.fecha_creacion IS NOT NULL,
        DATE_FORMAT(sdf.fecha_creacion, '%d/%m/%Y'),
        '') AS fecha_resp_final_cia,
    IF(sde.emitir = TRUE,
        DATEDIFF(sde.fecha_emision, sde.fecha_creacion),
        DATEDIFF(CURDATE(), sde.fecha_creacion)) AS duracion_caso,
    @fum:=(IF(sdf.aprobado IS NULL,
        DATEDIFF(CURDATE(), sdp.fecha_creacion),
        DATEDIFF(CURDATE(), sdf.fecha_creacion))) AS fum,
    IF(@fum IS NOT NULL, @fum, 0) AS dias_ultima_modificacion,
    IF(sde.emitir = TRUE,
        IF(sdf.aprobado IS NOT NULL,
            DATEDIFF(sdf.fecha_creacion, sde.fecha_creacion),
            DATEDIFF(sde.fecha_emision, sde.fecha_creacion)),
        IF(sdf.aprobado IS NULL,
            DATEDIFF(CURDATE(), sde.fecha_creacion),
            DATEDIFF(sdf.fecha_creacion, sde.fecha_creacion))) AS dias_proceso,
    DATE_FORMAT(sdp.fecha_creacion, '%d/%m/%Y') AS fecha_ultima_respuesta,
    IF(sde.emitir = FALSE,
        IF(sde.aprobado = TRUE, 1, 0),
        1) AS solicitud
FROM
    s_de_em_cabecera AS sde
        INNER JOIN
    s_de_em_detalle AS sdd ON (sdd.id_emision = sde.id_emision)
        INNER JOIN
    s_cliente AS sc ON (sc.id_cliente = sdd.id_cliente)
        LEFT JOIN
    s_de_facultativo AS sdf ON (sdf.id_emision = sde.id_emision)
        LEFT JOIN
    s_de_pendiente AS sdp ON (sdp.id_emision = sde.id_emision)
        LEFT JOIN
    s_estado AS sds ON (sds.id_estado = sdp.id_estado)
        INNER JOIN
    s_usuario AS su ON (su.id_usuario = sde.id_usuario)
        INNER JOIN
    s_departamento AS sdep ON (sdep.id_depto = su.id_depto)
        LEFT JOIN
    s_agencia AS sag ON (sag.id_agencia = su.id_agencia)
        INNER JOIN
    s_usuario AS sua ON (sua.id_usuario = sde.and_usuario)
        INNER JOIN
    s_entidad_financiera AS sef ON (sef.id_ef = sde.id_ef)
        INNER JOIN
    s_producto_cia AS spc ON (spc.id_prcia = sde.id_prcia)
WHERE
    sde.no_emision LIKE '%%'
        AND sde.prefijo LIKE '%%'
        AND CONCAT(sc.nombre,
            ' ',
            sc.paterno,
            ' ',
            sc.materno) LIKE '%%'
        AND sc.ci LIKE '%%'
        AND sc.complemento LIKE '%%'
        AND sc.extension LIKE '%%'
        AND sde.fecha_creacion BETWEEN '2000-01-01' AND '2020-01-01'
        AND IF(sdf.aprobado IS NULL,
        IF(sdp.id_pendiente IS NOT NULL,
            CASE sdp.respuesta
                WHEN 1 THEN 'S'
                WHEN 0 THEN 'O'
            END,
            IF(sde.emitir = FALSE
                    AND sde.facultativo = TRUE,
                'P',
                'R')),
        'R') REGEXP '.'
        AND IF(sds.id_estado IS NOT NULL
            AND sde.emitir = FALSE
            AND sde.facultativo = TRUE,
        sds.id_estado,
        '0') REGEXP '.'
        AND IF(sdf.aprobado IS NULL,
        IF(sde.emitir = TRUE
                AND sde.anulado = FALSE,
            'FC',
            'R'),
        CASE sdf.aprobado
            WHEN 'SI' THEN 'NF'
            WHEN 'NO' THEN 'R'
        END) REGEXP '.'
        AND IF(sdf.aprobado IS NOT NULL,
        IF(sdf.aprobado = 'SI',
            IF(sdf.tasa_recargo = 'SI', 'EP', 'NP'),
            'R'),
        IF(sde.emitir = TRUE
                AND sde.facultativo = FALSE,
            'NP',
            'R')) REGEXP '.'
        AND IF(sde.emitir = TRUE,
        'EM',
        IF(sdf.aprobado IS NOT NULL,
            IF(sdf.aprobado = 'SI', 'NE', 'R'),
            'NE')) REGEXP '.'
        AND IF(sdf.aprobado IS NOT NULL,
        IF(sdf.aprobado = 'NO', 'RE', 'R'),
        'R') REGEXP '.'
        AND IF(sde.anulado = TRUE, 'AN', 'R') REGEXP '.'
GROUP BY sde.id_emision
ORDER BY sde.id_emision DESC