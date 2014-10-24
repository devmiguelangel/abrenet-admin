<div class="rp-pr-container" id="rp-tab-au" style=" <?=$display;?> ">
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
        <input type="hidden" id="pr" name="pr" value="au">
        <br>

        <div id="accordion" class="accordion">
            <h5>Entidad Financiera</h5>
            <div>
<?php
$ef = array();
if ($pr->getEFProduct('AU') === true) {
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
                    <input type="checkbox" id="frp-ef-1" name="frp-ef-1" value="1">
                    Pendiente
                </label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-ef-2" name="frp-ef-2" value="2">
                    Subsanado/Pendiente
                </label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-ef-3" name="frp-ef-3" value="3">
                    Observado
                </label><br>

                <label class="lbl-cb">
                    <input type="checkbox" id="frp-estado-1" name="frp-estado-1" 
                        value="1">&nbsp;Reaseguro</label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-estado-2" name="frp-estado-2" 
                        value="2">&nbsp;Aclaraciones</label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-estado-3" name="frp-estado-3" 
                        value="3">&nbsp;Error en Datos</label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-estado-4" name="frp-estado-4" 
                        value="4">&nbsp;Inspeccion</label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-estado-5" name="frp-estado-5" 
                        value="5">&nbsp;Medidas de Seguridad</label>
            </div>

            <h5>Aprobado</h5>
            <div>
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
        <div class="result-loading rl-au"></div>
        <div class="result-search rs-au">
            <table class="result-list" id="result-de">
                <thead>
                    <tr>
                        <td>No. de Certificado</td>
                        <td>Entidad Financiera</td>
                        <td>Cliente</td>
                        <td>C.I.</td>
                        <td>Ciudad</td>
                        <td><?=htmlentities('Género', ENT_QUOTES, 'UTF-8');?></td>
                        <td><?=htmlentities('Teléfono', ENT_QUOTES, 'UTF-8');?></td>
                        <td>Celular</td>
                        <td>Email</td>
                        <td>Avenida o calle</td>
                        <td><?=htmlentities('Dirección', ENT_QUOTES, 'UTF-8');?></td>
                        <td>Numero domicilio</td>
                        <td><?=htmlentities('Opción', ENT_QUOTES, 'UTF-8');?></td>
                        <td><?=htmlentities('Tipo de vehículo', ENT_QUOTES, 'UTF-8');?></td>
                        <td>Marca</td>
                        <td>Modelo</td>
                        <td><?=htmlentities('Año', ENT_QUOTES, 'UTF-8');?></td>
                        <td>Placa</td>
                        <td><?=htmlentities('Uso de vehículo', ENT_QUOTES, 'UTF-8');?></td>
                        <td><?=htmlentities('Tracción', ENT_QUOTES, 'UTF-8');?></td>
                        <td>Valor asegurado</td>
                        <td><?=htmlentities('No Póliza', ENT_QUOTES, 'UTF-8');?></td>
                        <td>Forma de pago</td>
                        <td>Creado por</td>
                        <td>Fecha de ingreso</td>
                        <td>Sucursal</td>
                        <td>Agencia</td>
                        <td>Emitido</td>
                        <td>Certificados anulados</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>