<?php
function rep_automotor($row, $rowDt, $db, $arr_state, $bg, $rowSpan) {
    ob_start();
?>
<tr style=" <?=$bg;?> ">
    <td <?=$rowSpan;?>><?=$row['r_prefijo'] . '-' . $row['r_no_emision'];?></td>
    <td <?=$rowSpan;?>><?=$db['ef_nombre'];?></td>
    <td <?=$rowSpan;?>><?=$db['in_nombre'];?></td>
    <td <?=$rowSpan;?>><?=$row['cl_tipo_cliente'];?></td>
    <td <?=$rowSpan;?>><?=htmlentities($row['cl_nombre'], ENT_QUOTES, 'UTF-8');?></td>
    <td <?=$rowSpan;?>><?=$row['cl_cinit'];?><? if (isset($row['cl_complemento'])) { echo $row['cl_complemento'];}?></td>
    <td <?=$rowSpan;?>><?=$row['cl_ciudad'];?></td>
    <td <?=$rowSpan;?>><? if (isset($row['cl_genero'])) { echo $row['cl_genero'];}?></td>
    <td <?=$rowSpan;?>><?=$row['cl_telefono'];?></td>
    <td <?=$rowSpan;?>><? if (isset($row['cl_celular'])) { echo $row['cl_celular'];}?></td>
    <td <?=$rowSpan;?>><?=$row['cl_email'];?></td>
    <td <?=$rowSpan;?>><?=$row['cl_avenida_calle'];?></td>
    <td <?=$rowSpan;?>><?=htmlentities($row['cl_dir_domicilio'], ENT_QUOTES, 'UTF-8');?></td>
    <td <?=$rowSpan;?>><?=$row['cl_num_domicilio'];?></td>

    <td><?=$rowDt['vh_tipo'];?></td>
    <td><?=$rowDt['vh_marca'];?></td>
    <td><?=$rowDt['vh_modelo'];?></td>
    <td><?=(int)$rowDt['vh_anio'];?></td>
    <td><?=$rowDt['vh_placa'];?></td>
    <td><?=$rowDt['vh_uso'];?></td>
    <td><?=$rowDt['vh_traccion'];?></td>
    <td><?=$rowDt['vh_km'];?></td>
    <td><?=number_format($rowDt['vh_valor_asegurado'],2,'.',',');?> USD</td>

    <td <?=$rowSpan;?>><?=$row['r_forma_pago'];?></td>
    <td <?=$rowSpan;?>><?=htmlentities($rowDt['r_creado_por'], ENT_QUOTES, 'UTF-8');?></td>
    <td <?=$rowSpan;?>><?=$rowDt['r_fecha_creacion'];?></td>
    <td <?=$rowSpan;?>><?=$rowDt['r_sucursal'];?></td>
    <td <?=$rowSpan;?>><?=$row['r_estado'];?></td>
    <td <?=$rowSpan;?>><?=$row['r_num_anulado'];?></td>
</tr>
<?php
    $html = ob_get_clean();
    return $html;
}
/*
function get_state_1(&$arr_state, $row, $token, $product, $issue)
    {
        $state_bank = 0;
        if($token === 2) {
            $state_bank = (int)$row['estado_banco'];
        }
        $pr = strtolower($product);

        switch($row['estado']){
            case 'A':
                $arr_state['txt'] = 'APROBADO';
                if($token < 2){
                    if ($issue === TRUE) {
                        $arr_state['action'] = 'Emitir';
                        $arr_state['link'] = 'fac-issue-policy.php?ide=' . base64_encode($row['ide'])
                            . '&pr=' . base64_encode($product);
                    }
                }
                $arr_state['obs'] = 'APROBADO';
                $arr_state['bg'] = '';

                if($token === 4){
                    $arr_state['action'] = 'Anular Certificado';
                    $arr_state['link'] = 'cancel-policy.php?ide=' . base64_encode($row['ide'])
                        . '&pr=' . base64_encode($product);
                }

                break;
            case 'R':
                $arr_state['txt'] = 'RECHAZADO';
                $arr_state['obs'] = 'RECHAZADO';
                $arr_state['bg'] = '';

                break;
            case 'O':
                $arr_state['txt'] = 'OBSERVADO';
                $arr_state['bg'] = 'background: #009148; color: #FFF;';
                break;
            case 'S':
                $arr_state['txt'] = 'SUBSANADO/PENDIENTE';
                $arr_state['bg'] = 'background: #FFFF2D; color: #666;';
                break;
            case 'P':
                $arr_state['txt'] = 'PENDIENTE';

                if($token === 2){
                    if ($state_bank === 3 && (int)$row['estado_facultativo'] === 0) {
                        $arr_state['txt'] = 'PRE APROBADO';
                    } elseif($state_bank === 2 && (int)$row['estado_facultativo'] === 0) {
                        $arr_state['txt'] = 'APROBADO';
                    }
                } elseif ($token === 5 || $token === 3) {
                    if ((int)$row['estado_facultativo'] === 0) {
                        $arr_state['txt'] = 'PRE APROBADO';
                    }
                    Approve:
                    if ($token === 5) {
                        $arr_state['action'] = 'APROBAR/RECHAZAR SOLICITUD';
                        $arr_state['link'] = 'implant-approve-policy.php?ide='.base64_encode($row['ide']).'&pr='.base64_encode($product);
                    } elseif ($token === 3) {
                        goto PreApprove;
                    }
                }
                $arr_state['bg'] = 'background: #FF3C3C; color: #FFF;';
                break;
            case 'F':
                if (($token === 2 || $token === 3 || $token === 5 || $token === 6) && (int)$row['estado_facultativo'] === 0) {
                    $arr_state['txt'] = 'APROBADO FREE COVER';
                } elseif($token === 4) {
                    $arr_state['txt'] = 'APROBADO FREE COVER';
                }
                if($token === 3){
                    PreApprove:
                    $arr_state['action'] = 'Editar Datos';
                    $arr_state['link'] = $pr . '-quote.php?ms=' . md5('MS_' . $product)
                        . '&page=91a74b6d637860983cc6c1d33bf4d292&pr='
                        . base64_encode($product . '|05') . '&ide=' . base64_encode($row['ide'])
                        . '&flag=' . md5('i-read') . '&cia=' . base64_encode($row['id_compania']);
                } elseif($token === 4){
                    $arr_state['action'] = 'Anular Certificado';
                    $arr_state['link'] = 'cancel-policy.php?ide=' . base64_encode($row['ide']) . '&pr=' . base64_encode($product);
                } elseif ($token === 5) {
                    goto Approve;
                } elseif ($token === 7) {
                    $arr_state['txt'] = 'SOLICITUD PENDIENTE';
                }
                break;
        }

        if($row['observacion'] === 'E' && $row['estado'] !== 'A'){
            $arr_state['obs'] = $row['estado_pendiente'];
            if($token === 1){
                if ($row['estado'] === 'S') {
                    goto Response;
                }
                $arr_state['link'] = $pr.'-quote.php?ms=&page=&pr='.base64_encode($product.'|05').'&ide='.base64_encode($row['ide']).'&cia='.base64_encode($row['id_compania']).'&flag='.md5('i-read').'&target='.md5('ERROR-C');
                $arr_state['action'] = 'Editar Certificado';
            } elseif ($token === 0) {
                if ($row['estado'] === 'S') {
                    goto Response;
                }
            }
        }elseif($row['observacion'] === 'NE' && $row['estado'] !== 'A' && $row['estado'] !== 'R'){
            $arr_state['obs'] = $row['estado_pendiente'];
            if($row['estado_codigo'] === 'AC' && $row['estado'] !== 'S' && $token === 1){
                $arr_state['link'] = 'fac-'.$pr.'-observation.php?ide='.base64_encode($row['ide']).'&resp='.md5('R0');
                $arr_state['action'] = 'Responder';
                if ($product === 'AU') {
                    $arr_state['link'] .= '&idvh='.base64_encode($row['idVh']);
                }
            }elseif($row['estado_codigo'] && $row['estado'] === 'S'){
                Response:
                $arr_state['link'] = 'fac-'.$pr.'-observation.php?ide='.base64_encode($row['ide']).'&resp='.md5('R1');
                $arr_state['action'] = 'Respondido';
                if ($product === 'AU') {
                    $arr_state['link'] .= '&idvh='.base64_encode($row['idVh']);
                }
            }
        }elseif($row['observacion'] === NULL && $row['estado'] !== 'A' && $row['estado'] !== 'R'){
            $arr_state['obs'] = 'NINGUNA';

            if ($token === 5) {

            }
        }

        if($token === 2){
            switch($state_bank){
                case 1: $arr_state['txt_bank'] = 'ANULADO'; break;
                case 2: $arr_state['txt_bank'] = 'EMITIDO'; break;
                case 3: $arr_state['txt_bank'] = 'NO EMITIDO'; break;
            }
        }

        if ($token === 4 && ($product === 'AU' || $product === 'TRD')) {
            $arr_state['action'] = 'Anular Certificado';
            $arr_state['link'] = 'cancel-policy.php?ide=' . base64_encode($row['ide']) . '&pr=' . base64_encode($product);
        }

        if ($token === 6 && ($product === 'AU' || $product === 'TRD')) {
            $arr_state['action'] = '<br>Cambiar Certificado Provisional';
            $arr_state['link'] = 'provisional-certificate.php?ide='.base64_encode($row['ide']).'&pr='.base64_encode($product);
        }
    }
    */
?>