<?php
    require_once( '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'init.php' );
    require_once( INCLUDES.DIRECTORY_SEPARATOR.'functions.php' );
    
    // Class instances
    $session      = new Session();
    $int_profile  = new Int_Profile();
    $option       = new Option();
    $patient      = new Patient();
    $ward         = new Ward();
    $bed          = new Bed();
    
    $pid = $name = "";
    
    // Check if a patient has been loadded into memory
    
    // Fetch patient based on patient ID
    $patient      = $patient->fetch_patient((int)$session->get_patient_id());
    
    if($patient)
    {
        $pid      = $patient[0]['patient_id'];
        $name     = $patient[0]['surname']." ".$patient[0]['first_name'];
    }
?>
    
<form name="frm_new_admission" id="frm_new_admission" method="post">
    <div class="outter_pad">
        <div class="l_float percent50">
            <div class="inner_pad">
                <div class="fieldset">
                    <div class="legend">New Admission Details:</div>
                    <table class="visible_table">
                        <tr>
                            <td class="percent35">Patient Name:</td>
                            <td>
                                <?php Form::textbox('name', $name, array('readonly' => 'true')); ?>
                                <?php Form::hidden_field('patient_id', $pid); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Ward:</td>
                            <td><?php Form::selectbox($ward = $ward->dropdown_list(),'ward_id'); ?></td>
                        </tr>
                        <tr>
                            <td>Bed:</td>
                            <td id="ward_bed"><?php Form::selectbox(array(), 'bed_id'); ?></td>
                        </tr>
                        <tr>
                            <td  style="vertical-align:top;">Remarks:</td>
                            <td><?php Form::textarea("remarks"); ?></td>
                        </tr>
                        <tr>
                            <td>Start Date:</td>
                            <td><?php Form::textbox('start_date', '', array('readonly' => 'true')); ?></td>
                        </tr>
                        <tr>
                            <td>End Date:</td>
                            <td><?php Form::textbox('end_date', '', array('readonly' => 'true')); ?></td>
                        </tr>
                    </table>
                    <!-- Tooltip -->
                    <div class="tooltip"><span class="dark_gray"></span><div class="tail"></div></div>
                </div>
            </div>
        </div>
            
        <div class="percent100 clear"></div>
        
        <div class="l_float percent50">
            <div class="inner_pad">
                <div class="fieldset">
                    <div class="legend">Controls:</div>
                    <table class="visible_table">
                        <tr>
                            <td colspan="2"><button type="submit">Save</button></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="clear"></div>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function()
    {
        // Jquery date picker
        $( "#start_date" ).datepicker({ dateFormat: "yy-mm-dd", minDate: 0});
        $( "#end_date" ).datepicker({ dateFormat: "yy-mm-dd", minDate: 0});
        
        //
        $("#ward_id").on('change', function()
        {
            ward_id = $(this).val();
            $ajax_loading('ward_bed', '../calls/includes/switch.php', '&opt=ward&sub_opt=ward_bed&ward_id=' + ward_id);
        });
        
        // Switch on validator for certain form fields
        $validator.activate([
            {'name':'#name','type':'text'},   // Title
            {'name':'#ward_id','type':'select'},     // ward_id
            {'name':'#bed_id','type':'select'},     // bed_id
            {'name':'#start_date','type':'text'},  // start_date
            {'name':'#end_date','type':'text'}  // end_date
        ]);
        
        // Reset the form field appearance
        $("input, textarea").on('keyup', function()
        {
            $(this).parent("div.outer_box").css({"border":"#CCC solid 1px"});
            
            // Switch-off the tooltip
            $validator.hide_tooltip();
        });
        $("input, textarea").on('change', function()
        {
            $(this).parent("div.outer_box").css({"border":"#CCC solid 1px"});
            
            // Switch-off the tooltip
            $validator.hide_tooltip();
        });
        $("select").on('change', function()
        {
            $(this).parent("div.outer_box").css({"border":"#CCC solid 1px"});
            
            // Switch-off the tooltip
            $validator.hide_tooltip();
        });
        
        // Form        
        $("#frm_new_admission").on('submit', function($this)
        {
            // Prevent the form from submitting
            $this.preventDefault();
            
            // Return all input controls to their default color
            //$(this).find("input, textarea, select").css({"border":"#CCC solid 1px"});
                    
            // Error flag
            var $no_error = true;
            
            // Serialize the form values
            var $form       = $(this).serializeArray();
            
            // Loop through the form values
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
                
                else if (($div.prop("validate") == "select") && ($div.prop("value") == ""))
                {
                    $div.focus().css({"border":"red solid 2px"});
                    
                    var $div_top  = $div.position().top + $div.height() + 18,
                        $div_left = $div.position().left - 100;
                    
                    // Positioning the tooltip
                    $validator.show_tooltip([{
                        'caller':$div,
                        'top':$div_top,
                        'left':$div_left,
                        'msg':'Please,&nbsp;select&nbsp;this&nbsp;field.'
                    }]);
                    
                    // Error flag
                    $no_error = false;
                    
                    return false;
                }
            });
            
            if ($no_error)
            {
                // Create an instance of the FormData() object to assemble form elements
                var formData = new FormData($("#frm_new_admission")[0]);
                formData.append('opt', 'insert_admission');
                
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
                            //$file_loader.load_middle_pane('admissions/admission_list');
                            $file_loader.load_left_pane('admissions/menu_left');
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