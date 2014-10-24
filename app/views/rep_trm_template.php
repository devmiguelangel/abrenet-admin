<div class="rp-pr-container" id="rp-tab-trm" style=" <?=$display;?> ">
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
            <option value="1">La Paz</option>
            <option value="2">Oruro</option>
            <option value="3">Potosí</option>
            <option value="4">Cochabamba</option>
            <option value="5">Chuquisaca</option>
            <option value="6">Tarija</option>
            <option value="7">Santa Cruz</option>
            <option value="8">Beni</option>
            <option value="9">Pando</option>
        </select><br>

        <label style="">Fecha: </label>
        <label style="width:auto;">desde: </label>
        <input type="text" id="frp-date-b" name="frp-date-b" value=""
        	autocomplete="off" class="date" readonly>

        <label style="width:auto;">hasta: </label>
        <input type="text" id="frp-date-e" name="frp-date-e" value=""
        	autocomplete="off" class="date" readonly>

        <input type="hidden" id="pr" name="pr" value="trm">
        <br>
        <div id="accordion" class="accordion">

			<h5>Entidad Financiera</h5>
            <div>
<?php
$ef = array();
if ($pr->getEFProduct('TRM') === true) {
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
                    <input type="checkbox" id="frp-estado-10" name="frp-estado-10" value="10">&nbsp;
                    Reaseguro
                </label> 
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-estado-11" name="frp-estado-11" value="11">&nbsp;
                    Aclaraciones
                </label> 
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-estado-12" name="frp-estado-12" value="12">&nbsp;
                    Error en Datos
                </label> 
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-estado-13" name="frp-estado-13" value="13">&nbsp;
                    Medidas de Seguridad
                </label>
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
        <div class="result-loading rl-trm"></div>
        <div class="result-search rs-trm">
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
                        <td><?=htmlentities('Plazo Crédito', ENT_QUOTES, 'UTF-8');?></td>
                        <td>Forma de Pago</td>
                        <td>Materia Asegurada</td>
                        <td>Valor Asegurado</td>
                        <td>Creado Por</td>
                        <td>Sucursal</td>
                        <td>Agencia</td>
                        <td>Fecha de Ingreso</td>
                        <td>Certificados Anulados</td>
                        <td>Anulado por</td>
                        <td><?=htmlentities('Fecha de Anulación', ENT_QUOTES, 'UTF-8');?></td>
                        <td><?=htmlentities('Estado Compañia', ENT_QUOTES, 'UTF-8');?></td>
                        <td>Estado Banco</td>
                        <td><?=htmlentities('Motivo Estado Compañia', ENT_QUOTES, 'UTF-8');?></td>
                        <td>Porcentaje Extraprima</td>
                        <td><?=htmlentities('Fecha Respuesta final Compañia', ENT_QUOTES, 'UTF-8');?></td>
                        <td><?=htmlentities('Duración total del caso', ENT_QUOTES, 'UTF-8');?></td>
				    </tr>
                </thead>
			</table>
        </div>
    </div>
</div>