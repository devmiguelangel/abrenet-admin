<?php
function rep_client($row, $rowDt, $db, $arr_state, $bg, $rowSpan) {
    ob_start();
?>
<tr style=" <?=$bg;?> ">
    <td><?=htmlentities($row['cl_nombre'], ENT_QUOTES, 'UTF-8');?></td>
    <td><?=$row['cl_ci'].$row['cl_complemento'].' '.$row['cl_extension'];?></td>
    <td><?=$row['cl_ciudad'];?></td>
    <td><?=$row['cl_genero'];?></td>
    <td><?=$row['cl_telefono'];?></td>
    <td><?=$row['cl_email'];?></td>
    <td><?=$row['r_ramo'];?></td>
    <td <?=$rowSpan;?>><?=$db['ef_nombre'];?></td>
    <td <?=$rowSpan;?>><?=$db['in_nombre'];?></td>
    <td <?=$rowSpan;?>><?=$row['r_prefijo'] . '-' . $row['r_no_emision'];?></td>
    <td><?=number_format($row['r_monto_solicitado'],2,'.',',');?></td>
    <td><?=$row['r_moneda'];?></td>
    <td><?=$row['r_plazo'].' '.htmlentities($row['r_tipo_plazo'], ENT_QUOTES, 'UTF-8');?></td>
</tr>
<?php
    $html = ob_get_clean();
    return $html;
}


?>