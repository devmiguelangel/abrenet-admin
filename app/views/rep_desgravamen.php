<?php
function rep_desgravamen($row, $rowDt, $db, $arr_state, $bg, $rowSpan, $rprint = false) {
    ob_start();
?>
<tr style=" <?=$bg;?> ">
    <td <?=$rowSpan;?>><?=$row['r_prefijo'] . '-' . $row['r_no_emision'];?></td>
<?php
    if ($rprint === true) {
        echo '<td ' . $rowSpan . '>
            <a href="' . $row['host'] . '&rp=' . sha1('rprint') . '" target="_blank" 
            class="fancybox fancybox.ajax view-detail">Certificado</a>
        </td>';
    }
?>    
    <td <?=$rowSpan;?>><?=$db['ef_nombre'];?></td>
    <td <?=$rowSpan;?>><?=$db['in_nombre'];?></td>
    <td><?=htmlentities($rowDt['cl_nombre'], ENT_QUOTES, 'UTF-8');?></td>
    <td><?=$rowDt['cl_ci'].$rowDt['cl_complemento'].' '.$rowDt['cl_extension'];?></td>
    <td><?=$rowDt['cl_genero'];?></td>
    <td><?=$rowDt['cl_ciudad'];?></td>
    <td><?=$rowDt['cl_telefono'];?></td>
    <td><?=$rowDt['cl_celular'];?></td>
    <td><?=$rowDt['cl_email'];?></td>
    <td><?=number_format($row['r_monto_solicitado'],2,'.',',');?></td>
    <td><?=$row['r_moneda'];?></td>
    <td><?=$row['r_plazo'].' '.htmlentities($row['r_tipo_plazo'], ENT_QUOTES, 'UTF-8');?></td>
    <td><?=$rowDt['cl_estatura'];?></td>
    <td><?=$rowDt['cl_peso'];?></td>
    <td><?=(int)$rowDt['cl_participacion'];?></td>
    <td><?=$rowDt['cl_titular'];?></td>
    <td><?=$rowDt['cl_edad'];?></td>
    <td><?=htmlentities($row['r_creado_por'], ENT_QUOTES, 'UTF-8');?></td>
    <td><?=$row['r_fecha_creacion'];?></td>
    <td><?=$row['r_sucursal'];?></td>
    <td><?=htmlentities($row['r_agencia'], ENT_QUOTES, 'UTF-8');?></td>
    <td><?=$row['r_anulado'];?></td>
    <td><?=htmlentities($row['r_anulado_nombre'], ENT_QUOTES, 'UTF-8');?></td>
    <td><?=$row['r_anulado_fecha'];?></td>
    <td><?=htmlentities($arr_state['txt'], ENT_QUOTES, 'UTF-8');?></td>
    <td><?=$arr_state['txt_bank'];?></td>
    <td><?=$arr_state['obs'];?></td>
    <td><?=$row['extra_prima'];?></td>
    <td><?=$row['fecha_resp_final_cia'];?></td>
    <td><?=$row['dias_proceso'];?></td>
    <td><?=$row['dias_ultima_modificacion'];?></td>
    <td><?=htmlentities($row['duracion_caso'].' días', ENT_QUOTES, 'UTF-8');?></td>
</tr>
<?php
    $html = ob_get_clean();
    return $html;
}

function get_state(&$arr_state, $row, $token, $product, $issue)
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
?>