SELECT 
    sdc.id_cliente AS idCl,
    CONCAT(sdc.nombre,
            ' ',
            sdc.paterno,
            ' ',
            sdc.materno) AS cl_nombre,
    sdc.ci AS cl_ci,
    sdc.complemento AS cl_complemento,
    sdep.codigo AS cl_extension,
    sdep.departamento AS cl_ciudad,
    (CASE sdc.genero
        WHEN 'M' THEN 'Hombre'
        WHEN 'F' THEN 'Mujer'
    END) AS cl_genero,
    sdc.telefono_domicilio AS cl_telefono,
    sdc.telefono_celular AS cl_celular,
    sdc.email AS cl_email,
    (CASE sdd.titular
        WHEN 'DD' THEN 'Deudor'
        WHEN 'CC' THEN 'Codeudor'
    END) AS cl_titular,
    sdc.estatura AS cl_estatura,
    sdc.peso AS cl_peso,
    sdd.porcentaje_credito AS cl_participacion,
    (YEAR(CURDATE()) - YEAR(sdc.fecha_nacimiento)) AS cl_edad,
    sdd.id_detalle
FROM
    s_cliente AS sdc
        INNER JOIN
    s_de_em_detalle AS sdd ON (sdd.id_cliente = sdc.id_cliente)
        INNER JOIN
    s_departamento AS sdep ON (sdep.id_depto = sdc.extension)
WHERE
    sdd.id_emision = '@S#1$2013540b23d8b6e585.35854638'
        AND CONCAT(sdc.nombre,
            ' ',
            sdc.paterno,
            ' ',
            sdc.materno) LIKE '%%'
        AND sdc.ci LIKE '%%'
        AND sdc.complemento LIKE '%%'
        AND sdc.extension LIKE '%%'
ORDER BY sdc.id_cliente ASC