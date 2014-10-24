<div class="rp-pr-container" id="rp-tab-1" style=" display:block; ">
	<form class="f-reports">
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
        </select>

        <label style="">Fecha: </label>
        <label style="width:auto;">desde: </label>
        <input type="text" id="frp-date-b" name="frp-date-b" value=""
        	autocomplete="off" class="date" readonly>

        <label style="width:auto;">hasta: </label>
        <input type="text" id="frp-date-e" name="frp-date-e" value=""
        	autocomplete="off" class="date" readonly>

        <input type="hidden" id="pr" name="pr" value="CL">
        <br>
        <div id="accordion" class="accordion">

			<h5>Entidad Financiera</h5>
            <div>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-ef-1" name="frp-ef-1" value="1">
                	Ecofuturo
                </label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-ef-2" name="frp-ef-2" value="2">
                	Idepro
                </label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-ef-3" name="frp-ef-3" value="3">
                	Crecer
                </label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-ef-4" name="frp-ef-4" value="4">
                	 Sartawi
                </label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-ef-5" name="frp-ef-5" value="5">
                	 BISA LEASING
                </label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-ef-6" name="frp-ef-6" value="6">
                	 Emprender
                </label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-ef-7" name="frp-ef-7" value="7">
                	 Paulo VI
                </label>
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

        </div>

        <div align="center">
            <input type="submit" id="frp-search" name="frp-search"
            	value="Buscar" class="frp-btn">
            <input type="reset" id="frp-reset" name="frp-reset"
            	value="Restablecer Campos" class="frp-btn">
        </div>
    </form>

    <div class="result-container">
        <div class="result-loading rl-cl"></div>
        <div class="result-search rs-cl">
            <table class="result-list" id="result-cl">
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
                        <td>Ramo</td>
                        <td>Aseguradora</td>
                        <td>Monto</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>