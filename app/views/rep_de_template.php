<div class="rp-pr-container" id="rp-tab-de" style=" <?=$display;?> ">
    <form class="f-reports">
        
        <label>No. de Certificado: </label>
        <input type="text" id="frp-nc" name="frp-nc" value="" autocomplete="off">

        <br>
        <label>Cliente: </label>
        <input type="text" id="frp-client" name="frp-client" value="" autocomplete="off">

        <label style="width:auto;">C.I.: </label>
        <input type="text" id="frp-dni" name="frp-dni" value="" autocomplete="off">

        <label style="width:auto;">Complemento: </label>
        <input type="text" id="frp-comp" name="frp-comp" value="" autocomplete="off" style="width:40px;">

        <label style="width:auto;">Extensión: </label>
        <select id="frp-ext" name="frp-ext">
            <option value="">Seleccione...</option>
<?php
foreach ($depto as $key => $value) {
    echo '<option value="' . $value['codigo'] . '">' . $value['departamento'] . '</option>';
}
?>
        </select><br>

        <label style="">Fecha: </label>
        <label style="width:auto;">desde: </label>
        <input type="text" id="frp-date-b" name="frp-date-b" value=""
            autocomplete="off" class="date" readonly>

        <label style="width:auto;">hasta: </label>
        <input type="text" id="frp-date-e" name="frp-date-e" value=""
            autocomplete="off" class="date" readonly>

        <input type="hidden" id="data-pr" name="data-pr" value="DE" >
        <input type="hidden" id="pr" name="pr" value="de">
        <br>
        <div id="accordion" class="accordion">

            <h5>Entidad Financiera</h5>
            <div>
<?php
$ef = array();
if ($pr->getEFProduct('DE') === true) {
    $ef = $pr->data;

    foreach ($ef as $key => $value) {
        echo '<label class="lbl-cb">
            <input type="checkbox" id="frp-ef-' . $value['ef_codigo'] 
                . '" name="frp-ef-' . $value['ef_codigo'] . '" value="' 
                . base64_encode($value['ef_id']) . '">
            ' . $value['ef_nombre'] . '
        </label> ';
    }
}
?>
            </div>

            <h5>Aseguradora</h5>
            <div>
<?php
$in = array();
if ($pr->getInsurer() === true) {
    $in = $pr->data;

    foreach ($in as $key => $value) {
        echo '<label class="lbl-cb">
            <input type="checkbox" id="frp-in-' . $value['as_codigo'] 
                . '" name="frp-in-' . $value['as_codigo'] . '" value="' 
                . base64_encode($value['as_id']) . '">
            ' . $value['as_nombre'] . '
        </label> ';
    }
}
?>
            </div>

            <h5>Pendiente</h5>
            <div>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-pe" name="frp-pe" value="P">
                    Pendiente
                </label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-sp" name="frp-sp" value="S">
                    Subsanado/Pendiente
                </label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-ob" name="frp-ob" value="O">
                    Observado
                </label><br>
                
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-estado-14" name="frp-estado-14" 
                        value="14">&nbsp;Examenes Medicos y/o Requisitos</label> 
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-estado-15" name="frp-estado-15" 
                        value="15">&nbsp;Reaseguro</label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-estado-16" name="frp-estado-16" 
                        value="16">&nbsp;Aclaraciones</label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-estado-17" name="frp-estado-17" 
                        value="17">&nbsp;Error en Datos</label>
            </div>

            <h5>Aprobado</h5>
            <div>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-approved-fc" name="frp-approved-fc" value="FC">
                        Free Cover
                </label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-approved-nf" name="frp-approved-nf" value="NF">
                        No Free Cover
                </label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-approved-ep" name="frp-approved-ep" value="EP">
                        Extraprima
                </label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-approved-np" name="frp-approved-np" value="NP">
                        No Extraprima
                </label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-approved-em" name="frp-approved-em" value="EM">
                        Emitido
                </label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-approved-ne" name="frp-approved-ne" value="NE">
                        No Emitido
                </label>
            </div>

            <h5>Rechazado</h5>
            <div>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-rejected" name="frp-rejected" value="RE">
                        Rechazado                    
                </label>
            </div>

            <h5>Anulado</h5>
            <div>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-canceled" name="frp-canceled" value="AN">
                        Anulado
                </label>
            </div>
        </div>

        <div align="center">
            <input type="submit" id="frp-search" name="frp-search"
                value="Buscar" class="frp-btn">
            <input type="reset" id="frp-reset" name="frp-reset"
                value="Restablecer Campos" class="frp-btn">
        </div>
    </form>

    <div class="result-container">
        <div class="result-loading rl-de"></div>
        <div class="result-search rs-de">
            <table class="result-list" id="result-de">
                <thead>
                    <tr>
                        <td>No. Certificado</td>
                        <td>Entidad Financiera</td>
                        <td>Cliente</td>
                        <td>CI</td>
                        <td><?=htmlentities('Género', ENT_QUOTES, 'UTF-8');?></td>
                        <td>Ciudad</td>
                        <td><?=htmlentities('Teléfono', ENT_QUOTES, 'UTF-8');?></td>
                        <td>Celular</td>
                        <td>Email</td>
                        <td>Monto Solicitado</td>
                        <td>Moneda</td>
                        <td><?=htmlentities('Plazo Crédito', ENT_QUOTES, 'UTF-8');?></td>
                        <td>Estatura (cm)</td>
                        <td>Peso (kg)</td>
                        <td><?=htmlentities('Participación (%)', ENT_QUOTES, 'UTF-8');?></td>
                        <td>Deudor / Codeudor</td>
                        <td>Edad</td>
                        <td>Creado Por</td>
                        <td>Fecha de Ingreso</td>
                        <td>Sucursal</td>
                        <td>Agencia</td>
                        <td>Certificados Anulados</td>
                        <td>Anulado por</td>
                        <td><?=htmlentities('Fecha de Anulación', ENT_QUOTES, 'UTF-8');?></td>
                        <td><?=htmlentities('Estado Compañia', ENT_QUOTES, 'UTF-8');?></td>
                        <td>Estado Banco</td>
                        <td><?=htmlentities('Motivo Estado Compañia', ENT_QUOTES, 'UTF-8');?></td>
                        <td>Porcentaje Extraprima</td>
                        <td><?=htmlentities('Fecha Respuesta final Compañia', ENT_QUOTES, 'UTF-8');?></td>
                        <td><?=htmlentities('Días en Proceso', ENT_QUOTES, 'UTF-8');?></td>
                        <td><?=htmlentities('Días de Ultima Modificación', ENT_QUOTES, 'UTF-8');?></td>
                        <td><?=htmlentities('Duración total del caso', ENT_QUOTES, 'UTF-8');?></td>
                        <td>Solicitud Enviada</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>