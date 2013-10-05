<?php 
    require_once( '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'init.php' ); 
    //Class instance
    $session = new Session();
    $pid     = $session->get_patient_id();
?>

<div>
    <ul class="pool">
    <?php if($pid != ""){?>
        <li>
            <a href="#">Vital Signs:</a>
            <ul>
                <li>
                    <form id="frm_vitals" name="frm_vitals" method="post">
                        <table class="visible_table">
                            <tr>
                                <td>Temp:</td>
                                <td><?php Form::textbox('txt_tmp'); ?></td>
                            </tr>
                            <tr>
                                <td>BP:</td>
                                <td><?php Form::textbox('txt_bp', '', array('placeholder' => 'Optional')); ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><?php Form::button('btn_vs','Save Vitals'); ?></td>
                            </tr>
                        </table>
                    </form>
                </li>
            </ul>
        </li>
    <?php } ?>
        <li>
            <a href="#">Nurses Pool (3)</a>
            <ul>
                <li>
                    <a>[1] P1308/879</a>
                </li>
                <li>
                    <a>[4] P1202/475</a>
                </li>
                <li>
                    <a>[6] P1306/159</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#">Doctors Pool (3)</a>
            <ul>
                <li>
                    <a>[2] P1308/279</a>
                </li>
                <li>
                    <a>[5] P1202/445</a>
                </li>
                <li>
                    <a>[7] P1306/136</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#">Admissions (1)</a>
            <ul>
                <li>
                    <a>[3] P1308/059</a>
                </li>
            </ul>
        </li>
    </ul>
</div>

<script type="text/javascript">
    $(document).ready(function()
    {
        
        // Switch on validator for certain form fields
        $validator.activate([
            {'name':'#txt_tmp','type':'text'},     // Temperature
        ]);
        
        // Reset the form field appearance
        $("input").on('keyup', function()
        {
            $(this).parent("div.outer_box").css({"border":"#CCC solid 1px"});
            
            // Switch-off the tooltip
            $validator.hide_tooltip();
        });
        
        // Form        
        $("#frm_vitals").on('submit', function($this)
        {
            // Prevent the form from submitting
            $this.preventDefault();
            
            // Error flag
            var $no_error = true;
            
            // Serialize the form values
            var $form       = $(this).serializeArray();
            
            $.each($form, function( e, $form )
            {
                //alert($form.name + ' => ' + $form.value);
                var $div = $("#"+$form.name);
                
                if (($div.prop("validate") == "text") && ($div.prop("value") == ""))
                {
                    $div.focus().css({"border":"red solid 2px"});
                    
                    var $div_top  = $div.position().top + $div.height() + 18,
                        $div_left = $div.position().left - 100;
                    
                    // Positioning the tooltip
                    $validator.show_tooltip([{
                        'caller':$div,
                        'top':$div_top,
                        'left':$div_left,
                        'msg':'Please,&nbsp;fill&nbsp;out&nbsp;this&nbsp;field.'
                    }]);
                    
                    // Error flag
                    $no_error = false;
                    
                    return false;
                }
            });
            
            if ($no_error)
            {
                // Create an instance of the FormData() object to assemble form elements
                var formData = new FormData($("#frm_vitals")[0]);
                formData.append('opt', 'insert_vitals');
                $.ajax({
                    url: "../calls/includes/switch.php",
                    type: "POST",
                    data: formData,
                    dataType: "json",                
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function($json)
                    {
                        if($json.status == "true")
                        {
                            $ui_engine.block({title:'Alert!',file:'alert_successful',width:'200',height:'120',buttons:'NNY'});
                        }
                        else
                        {
                            $ui_engine.block({title:'Alert!',file:'alert_failure',width:'200',height:'120',buttons:'NNY'});
                        }
                    },
                    error: function(request, status, error)
                    {
                        //alert(request.responseText);
                        $ui_engine.block({title:'Alert!',file:'alert_connection',width:'200',height:'120',buttons:'NNY'});
                    }
                });
            }
            
        });
        
    });
</script>