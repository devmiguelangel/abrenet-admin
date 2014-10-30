SELECT 
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
    tedp.id_emision = 65919
        AND CONCAT(tdc.nombres,
            ' ',
            tdc.ap_paterno,
            ' ',
            tdc.ap_materno) LIKE '%%'
        AND tdc.ci_persona LIKE '%%'
        AND tdc.complemento LIKE '%%'
        AND tdc.ci_ext LIKE '%%'
ORDER BY tdc.id_client ASC
;