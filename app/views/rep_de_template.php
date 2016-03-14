<div class="rp-pr-container" id="rp-tab-de" style=" <?=$display;?> ">
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
            <option value="">Seleccione...</option>
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

<?php
if ($rp === 4) {
    echo '<label style="width:auto;">hasta: </label>
    <input type="text" id="frp-date-e" name="frp-date-e" value="2014-12-31"
        autocomplete="off" class="" readonly>';
} else {
    echo '<label style="width:auto;">hasta: </label>
    <input type="text" id="frp-date-e" name="frp-date-e" value=""
        autocomplete="off" class="date" readonly>';
}
?>

        <input type="hidden" id="data-pr" name="data-pr" value="DE" >
        <input type="hidden" id="pr" name="pr" value="de">
        <br>

        <div id="accordion" class="accordion" style="<?=$dis_accordion;?>">

            <h5>Entidad Financiera</h5>
            <div>
<?php
$ef = array();
if ($pr->getEFProduct('DE', $_SESSION['id_user']) === true) {
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
} else {
    $bank = new BankController();
    $bank->code = base64_decode($_SESSION['ef']);

    if ($bank->getBankByCode() === true) {
        echo '<label class="lbl-cb">
            <input type="checkbox" id="frp-ef-1" name="frp-ef-1" value="' 
                . $bank->code . '" ' . $check_option . '> ' . $bank->name . ' 
        </label> ';

        echo '<input type="hidden" id="nef" name="nef" value="1" >
            <input type="hidden" id="rprint" name="rprint" value="' . sha1('p') . '" >';
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
                    <input type="checkbox" id="frp-estado-1" name="frp-estado-1" 
                        value="EM">&nbsp;Examenes Medicos y/o Requisitos</label> 
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-estado-2" name="frp-estado-2" 
                        value="RA">&nbsp;Reaseguro</label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-estado-3" name="frp-estado-3" 
                        value="AC">&nbsp;Aclaraciones</label>
                <label class="lbl-cb">
                    <input type="checkbox" id="frp-estado-4" name="frp-estado-4" 
                        value="ED">&nbsp;Error en Datos</label>
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
                    <input type="checkbox" id="frp-approved-em" name="frp-approved-em" value="EM"
                        <?=$check_option;?>>
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
            
        </div>
    </div>
</div>