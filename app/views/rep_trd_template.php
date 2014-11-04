<div class="rp-pr-container" id="rp-tab-trd" style=" <?=$display;?> ">
	<form class="f-reports">
    	<label>Prefijo: </label>
        <input type="text" id="frp-prefix" name="frp-prefix" value="" autocomplete="off"
            style="width: 50px;">
        
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
        <input type="text" id="frp-ext" name="frp-ext" value="" autocomplete="off" style="width:40px;">
        <!-- <select id="frp-ext" name="frp-ext">
<?php
foreach ($depto as $key => $value) {
    echo '<option value="' . $value['codigo'] . '">' . $value['departamento'] . '</option>';
}
?>
        </select> -->
        <br>

        <label style="">Fecha: </label>
        <label style="width:auto;">desde: </label>
        <input type="text" id="frp-date-b" name="frp-date-b" value=""
        	autocomplete="off" class="date" readonly>

        <label style="width:auto;">hasta: </label>
        <input type="text" id="frp-date-e" name="frp-date-e" value=""
        	autocomplete="off" class="date" readonly>

        <input type="hidden" id="data-pr" name="data-pr" value="TRD" >
        <input type="hidden" id="pr" name="pr" value="trd">
        <br>
        <div id="accordion" class="accordion">

			<h5>Entidad Financiera</h5>
            <div>
<?php
$ef = array();
if ($pr->getEFProduct('TRD', $_SESSION['id_user']) === true) {
    $ef = $pr->data;

    $nef = 0;
    foreach ($ef as $key => $value) {
        $nef += 1;
        echo '<label class="lbl-cb">
            <input type="checkbox" id="frp-ef-' . $nef 
                . '" name="frp-ef-' . $nef . '" value="' 
                . $value['ef_codigo'] . '" > ' . $value['ef_nombre'] . ' 
        </label> ';
    }

    echo '<input type="hidden" id="nef" name="nef" value="' . $nef . '" >';
}
?>
            </div>

			<h5>Aseguradora</h5>
            <div>
<?php
$in = array();
if ($pr->getInsurer() === true) {
    $in = $pr->data;

    $nin = 0;
    foreach ($in as $key => $value) {
        $nin += 1;
        echo '<label class="lbl-cb">
            <input type="checkbox" id="frp-in-' . $nin 
                . '" name="frp-in-' . $nin . '" value="' 
                . $value['as_codigo'] . '"> ' . $value['as_nombre'] . '
        </label> ';
    }

    echo '<input type="hidden" id="nin" name="nin" value="' . $nin . '" >';
}
?>
            </div>

            <h5>Tipo de Cliente</h5>
            <div>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-customer-type-1" name="frp-customer-type-1" value="NAT">
                    Natural
                </label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-customer-type-2" name="frp-customer-type-2" value="JUR">
                    Jurídico
                </label>
            </div>

            <h5>Aprobado</h5>
            <div>
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
        <div class="result-loading rl-trd"></div>
        <div class="result-search rs-trd">
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
                        <td>Avenida o calle</td>
                        <td><?=htmlentities('Dirección', ENT_QUOTES, 'UTF-8');?></td>
                        <td>Numero domicilio</td>
                        <td>Email</td>
                        <td><?=htmlentities('Teléfono', ENT_QUOTES, 'UTF-8');?></td>
                        <td><?=htmlentities('Opción', ENT_QUOTES, 'UTF-8');?></td>
                        <td>Tipo inmueble</td>
                        <td>Uso</td>
                        <td>Estado</td>
                        <td>Departamento</td>
                        <td>Zona</td>
                        <td><?=htmlentities('Dirección', ENT_QUOTES, 'UTF-8');?></td>
                        <td>Monto inmueble</td>
                        <td><?=htmlentities('Tipo vehículo', ENT_QUOTES, 'UTF-8');?></td>
                        <td>Marca</td>
                        <td>Modelo</td>
                        <td>Placa</td>
                        <td><?=htmlentities('Uso vehículo', ENT_QUOTES, 'UTF-8');?></td>
                        <td><?=htmlentities('Tracción', ENT_QUOTES, 'UTF-8');?></td>
                        <td>Cero KM </td>
                        <td><?=htmlentities('Monto vehículo', ENT_QUOTES, 'UTF-8');?></td>
                        <td><?=htmlentities('Plazo crédito', ENT_QUOTES, 'UTF-8');?></td>
                        <td><?=htmlentities('No. póliza', ENT_QUOTES, 'UTF-8');?></td>
                        <td>Forma Pago</td>
                        <td>Emitido</td>
                        <td>Sucursal</td>
                        <td>Agencia</td>
                        <td>Creado por</td>
                        <td>Fecha de ingreso</td>
                        <td>Certificados anulados</td>
                        <td>Certificado inmueble</td>
                        <td><?=htmlentities('Certificado vehículo', ENT_QUOTES, 'UTF-8');?></td>
                        <td><?=htmlentities('Cotización inmueble', ENT_QUOTES, 'UTF-8');?></td>
                        <td><?=htmlentities('Cotización vehículo', ENT_QUOTES, 'UTF-8');?></td>
				    </tr>
                </thead>
			</table>
        </div>
    </div>
</div>