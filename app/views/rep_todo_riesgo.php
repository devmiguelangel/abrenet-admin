<?php
function rep_todo_riesgo($row, $rowDt, $db, $arr_state, $bg, $rowSpan) {
    ob_start();
?>
<tr style=" <?=$bg;?> ">
    <td <?=$rowSpan;?>><?=$row['r_prefijo'] . '-' . $row['r_no_emision'];?></td>
    <td <?=$rowSpan;?>><?=$db['ef_nombre'];?></td>
    <td <?=$rowSpan;?>><?=$db['in_nombre'];?></td>
    <td <?=$rowSpan;?>><?=$row['cl_tipo_cliente'];?></td>
    <td <?=$rowSpan;?>><?=htmlentities($row['cl_nombre'], ENT_QUOTES, 'UTF-8');?></td>
    <td <?=$rowSpan;?>><?=$row['cl_cinit'];?><? if (isset($row['cl_complemento'])) { echo $row['cl_complemento'];}?></td>
    <td <?=$rowSpan;?>><?php if (isset($row['cl_genero'])) { echo $row['cl_genero'];}?></td>
    <td <?=$rowSpan;?>><?=$row['cl_ciudad'];?></td>
    <td <?=$rowSpan;?>><?=$row['cl_telefono'];?></td>
    <td <?=$rowSpan;?>><?php if (isset($row['cl_celular'])) { echo $row['cl_celular'];}?></td>
    <td <?=$rowSpan;?>><?=$row['cl_email'];?></td>
    <td <?=$rowSpan;?>><?=$row['cl_avenida_calle'];?></td>
    <td <?=$rowSpan;?>><?=htmlentities($row['cl_dir_domicilio'], ENT_QUOTES, 'UTF-8');?></td>
    <td <?=$rowSpan;?>><?=htmlentities($row['cl_num_domicilio'], ENT_QUOTES, 'UTF-8');?></td>
    <td><?php if (isset($rowDt['r_material'])) { echo $rowDt['r_material'];}?></td>
    <td><?php if (isset($rowDt['r_valor_asegurado'])) { echo $rowDt['r_valor_asegurado'];}?></td>
    <td><?php if (isset($row['in_tipo_inmueble'])) { echo $row['in_tipo_inmueble'];}?></td>
    <td><?php if (isset($row['in_uso'])) { echo $row['in_uso'];}?></td>
    <td><?php if (isset($row['in_estado'])) { echo $row['in_estado'];}?></td>
    <td><?php if (isset($row['in_departamento'])) { echo $row['in_departamento'];}?></td>
    <td><?php if (isset($row['in_zona'])) { echo $row['in_zona'];}?></td>
    <td><?php if (isset($row['in_direccion'])) { echo $row['in_direccion'];}?></td>
    <td><?php if (isset($row['in_valor_asegurado_usd'])) { echo $row['in_valor_asegurado_usd'];}?></td>
    <td><?php if (isset($row['vh_tipo_vehiculo'])) { echo $row['vh_tipo_vehiculo'];}?></td>
    <td><?php if (isset($row['vh_marca'])) { echo $row['vh_marca'];}?></td>
    <td><?php if (isset($row['vh_modelo'])) { echo $row['vh_modelo'];}?></td>
    <td><?php if (isset($row['vh_placa'])) { echo $row['vh_placa'];}?></td>
    <td><?php if (isset($row['vh_uso'])) { echo $row['vh_uso'];}?></td>
    <td><?php if (isset($row['vh_traccion'])) { echo $row['vh_traccion'];}?></td>
    <td><?php if (isset($row['vh_km'])) { echo $row['vh_km'];}?></td>
    <td><?php if (isset($row['vh_valor_asegurado_usd'])) { echo $row['vh_valor_asegurado_usd'];}?></td>
    <td><?php if (isset($row['r_plazo_credito'])) { echo $row['r_plazo_credito']." ".utf8_encode($row['r_plazo']);}?></td>
    <td <?=$rowSpan;?>><?=$row['r_forma_pago'];?></td>
    <td <?=$rowSpan;?>><?=htmlentities($row['r_creado_por'], ENT_QUOTES, 'UTF-8');?></td>
    <td <?=$rowSpan;?>><?=$row['r_fecha_creacion'];?></td>
    <td <?=$rowSpan;?>><?=$row['r_sucursal'];?></td>
    <td <?=$rowSpan;?>><?=$row['r_estado'];?></td>
    <td <?=$rowSpan;?>><?=$row['r_num_anulado'];?></td>
</tr>
<?php
    $html = ob_get_clean();
    return $html;
}
?>