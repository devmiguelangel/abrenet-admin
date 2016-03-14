<div class="rp-pr-container" id="rp-tab-1" style=" display:block; ">
	<form class="f-reports">
        <label style="width:auto;">C.I.: <span class="error">(*)</span></label>
        <input type="text" id="frp-dni" name="frp-dni" value="" autocomplete="off">

        <label style="width:auto;">Complemento: </label>
        <input type="text" id="frp-comp" name="frp-comp" value="" autocomplete="off" style="width:40px;">

        <label style="width:auto;">Extensión: <span class="error">(*)</span></label>
        <input type="text" id="frp-ext" name="frp-ext" value="" autocomplete="off" style="width:40px;">

        <label style="">Fecha: </label>
        <label style="width:auto;">desde: </label>
        <input type="text" id="frp-date-b" name="frp-date-b" value=""
        	autocomplete="off" class="date" readonly>

        <label style="width:auto;">hasta: </label>
        <input type="text" id="frp-date-e" name="frp-date-e" value=""
        	autocomplete="off" class="date" readonly>

        <input type="hidden" id="data-pr" name="data-pr" value="CL" >
        <input type="hidden" id="pr" name="pr" value="CL">
        <br>
        <div id="err_cl" class="error" style="display: none;">
            El Carnet de Identidad y la extensión son obligatorios
        </div>
        <br>

        <div id="accordion" class="accordion">

			<h5>Entidad Financiera</h5>
            <div>
<?php
$ef = array();
if ($pr->getEFProductClient($_SESSION['id_user']) === true) {
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
            
        </div>
    </div>
</div>