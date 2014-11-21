<?php
require_once $_SESSION['dir'] . '/app/controllers/ProductController.php';
require_once $_SESSION['dir'] . '/app/controllers/BankController.php';
require_once $_SESSION['dir'] . '/app/controllers/UserController.php';

$pr = new ProductController($rp);

if ($pr->getProduct() === true) {
    $product = $pr->data;

    $user = new UserController();

    $depto = array();
    if ($user->getDepto() === true) {
        $depto = $user->dataDepto;
    }

    $dis_accordion = $check_option = '';

    switch ($rp) {
    case 1:
        echo '<h3 class="h3">Reportes Generales</h3>';

        $active = 'rp-active';
        $k = 0;
?>
<table class="rp-link-container">
    <tr>
<?php
        foreach ($product as $key => $value) {
            $k += 1;

            if ($k !== 1) {
                $active = '';
            }

            echo '<td style="width:20%;">
                <a href="#" class="rp-link ' . $active . '" rel="' 
                . strtolower($value['codigo']) . '">' . $value['producto'] . '</a>
            </td>';
        }
?>
        <td style="width:20%; border-bottom:1px solid #CECECE;">
            <input type="hidden" id="flag" name="flag" value="bac953e88f6d79514b0b6fc42eb6f3b7">
        </td>
    </tr>
</table>
<?php
        break;
    case 2:
        echo '<h3 class="h3">Reportes Clientes</h3>';
        break;
    case 4:
        echo '<h3 class="h3">Re-impresión de Certificados</h3>';
?>
<table class="rp-link-container">
    <tr>
<?php
        $active = 'rp-active';
        $k = 0;
        foreach ($product as $key => $value) {
            $k += 1;
            if ($k !== 1) {
                $active = '';
            }

            if ($value['codigo'] === 'DE') {
                echo '<td style="width:20%;">
                    <a href="#" class="rp-link ' . $active . '" rel="' 
                    . strtolower($value['codigo']) . '">' . $value['producto'] . '</a>
                </td>';
            } else {
                echo '<td style="width:20%; border-bottom: 1px solid #CECECE;">
                    
                </td>';
            }
        }
?>
        <td style="width:20%; border-bottom:1px solid #CECECE;">
            <input type="hidden" id="flag" name="flag" value="bac953e88f6d79514b0b6fc42eb6f3b7">
        </td>
    </tr>
</table>
<?php
        break;
    }
?>
<div class="rc-records">
<?php
    switch ($rp) {
    case 1:
        $k = 0;
        $display = 'display:block;';
        foreach ($product as $key => $value) {
            $k += 1;
            $prefix = strtolower($value['codigo']);

            if ($k !== 1) {
                $display = 'display:none;';
            }

            require_once 'rep_' . $prefix . '_template.php';
            /*if ($pr->getEFProduct(strtoupper($prefix), $_SESSION['id_user']) === true) {
            }*/
        }
        break;
    case 4:
        $k = 0;
        $display = 'display:block;';
        $dis_accordion = 'display:none;';
        $check_option = 'checked';
        
        foreach ($product as $key => $value) {
            $k += 1;
            $prefix = strtolower($value['codigo']);

            if ($k !== 1) {
                $display = 'display:none;';
            }

            if ($value['codigo'] === 'DE') {
                require_once 'rep_' . $prefix . '_template.php';
            }
            /*if ($pr->getEFProduct(strtoupper($prefix), $_SESSION['id_user']) === true) {
            }*/
        }
        break;
    default:
        require_once 'rep_cl_template.php';
        break;
    }
?>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $(".date").datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy-mm-dd',
        yearRange: "c-100:c+100"
    });

    $(".date").datepicker($.datepicker.regional[ "es" ]);

    $('input').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });

    $(".rp-link").click(function(e){
        e.preventDefault();
        $(".rp-link").removeClass('rp-active');
        $(this).addClass('rp-active');

        var pr = $(this).attr('rel');
        $(".rp-pr-container").hide();
        $("#rp-tab-"+pr).fadeIn();
    });

    var icons = {
      header: "ui-icon-circle-arrow-e",
      activeHeader: "ui-icon-circle-arrow-s"
    };

    $(".accordion" ).accordion({
        collapsible: true,
        icons: icons,
        heightStyle: "content",
        active: 0
    });

    $(".f-reports").submit(function(e){
        e.preventDefault();
        $(this).find(":submit").prop('disabled', true);
        var pr = $(this).find('#pr').prop('value').toLowerCase();

        var _data = $(this).serialize();

        if (pr === 'cl') {
            ci = $('#frp-dni').prop('value');
            ext = $('#frp-ext').prop('value');

            if (ci.length === 0 || ext.length === 0) {
                $('#err_cl').show();
                $(".f-reports :submit").prop('disabled', false);
                return false;
            }

            $('#err_cl').hide();
        }

        $.ajax({
            url:'report.php',
            type:'GET',
            data:'frc=&' + _data,
            //dataType:"json",
            async:true,
            cache:false,
            beforeSend: function(){
                $(".rs-" + pr).hide();
                $(".rl-" + pr).show();
            },
            complete: function(){
                $(".rl-" + pr).hide();
                $(".rs-" + pr).show();
            },
            success: function(result){
                $(".rs-" + pr).html(result);
                $(".f-reports :submit").prop('disabled', false);
            }
        });
        return false;
    });
});
</script>
<?php
} else {
    echo '<h3 class="h3">No existen productos</h3>';
}
?>