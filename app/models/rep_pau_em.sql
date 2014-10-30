SELECT 
    tedc.id_emision AS ide,
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
    tedc.id_emision LIKE '65918'
        AND tedc.prefijo_producto LIKE '%%'
        AND CONCAT(tc.nombres,
            ' ',
            tc.ap_paterno,
            ' ',
            tc.ap_materno) LIKE '%%'
        AND tc.ci_persona LIKE '%%'
        AND tc.complemento LIKE '%%'
        AND tc.ci_ext LIKE '%%'
        AND tedc.fecha_creacion BETWEEN '' AND ''
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
        'R') REGEXP 'P'
        AND IF(tds.id_estado IS NOT NULL
            AND tedc.emitir = 'false'
            AND tedc.caso_facultativo = 'true',
        tds.id_estado,
        '0') REGEXP 'P'
        AND IF(tdf.aprobado IS NULL,
        IF(tedc.emitir = 'true'
                AND tedc.anulada = 'false',
            'FC',
            'R'),
        CASE tdf.aprobado
            WHEN 'si' THEN 'NF'
            WHEN 'no' THEN 'R'
        END) REGEXP 'P'
        AND IF(tdf.aprobado IS NOT NULL,
        IF(tdf.aprobado = 'si',
            IF(tdf.tasa_recargo = 'si', 'EP', 'NP'),
            'R'),
        IF(tedc.emitir = 'true'
                AND tedc.caso_facultativo = 'false',
            'NP',
            'R')) REGEXP 'P'
        AND IF(tedc.emitir = 'true',
        'EM',
        IF(tdf.aprobado IS NOT NULL,
            IF(tdf.aprobado = 'si', 'NE', 'R'),
            'NE')) REGEXP 'P'
        AND IF(tdf.aprobado IS NOT NULL,
        IF(tdf.aprobado = 'no', 'RE', 'R'),
        'R') REGEXP 'P'
        AND IF(tedc.anulada = 'true', 'AN', 'R') REGEXP 'P'
GROUP BY tedc.id_emision
ORDER BY tedc.id_emision DESC
LIMIT 0 , 100
;