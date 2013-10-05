<?php
    require_once( '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'init.php' );
    require_once( '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'functions.php' );
    
    // Class instances
    $session     = new Session();
    $int_profile = new Int_Profile();
    $option      = new Option();
    
    // Init.
    $int_profile_id = $kin_fname = $kin_mname = $kin_sname = $kin_gender = $kin_address = $kin_email = $kin_phone1 = $kin_phone2 = $kin_relate = $dob = $marital = $religion = $qualification = $country = '';
    
    if ($int_profile instanceof Int_Profile)
    {
        // Init.
        $pid = '';
        
        // Fetching the Patient ID from memory
        if ($session instanceof Session) $pid = (int)$session->user_id;
        
        $profile_obj = $int_profile->fetch_profile_by_user_id($pid);
        if(!empty($profile_obj))
        {
            $int_profile_id= $profile_obj->int_profile_id;
            $kin_fname     = $profile_obj->kin_first_name;
            $kin_mname     = $profile_obj->kin_middle_name;
            $kin_sname     = $profile_obj->kin_surname;
            $kin_gender    = $profile_obj->kin_gender;
            $kin_address   = $profile_obj->kin_address;
            $kin_email     = $profile_obj->kin_email;
            $kin_phone1    = $profile_obj->kin_phone_1;
            $kin_phone2    = $profile_obj->kin_phone_2;
            $kin_relate    = $profile_obj->relationship;
        }
    }
?>
<form name="frm_new_patient" id="frm_new_patient" method="post">
    <div class="outter_pad">        
        <div class="l_float percent50">
            <div class="inner_pad">
                <div id="fieldset_nok" class="fieldset">
                    <div class="legend">Next of Kin Details:</div>
                    <table class="visible_table">
                        <tr>
                            <td class="percent35">First Name:</td>
                            <td>
                                <?php Form::hidden_field('int_profile_id',$int_profile_id); ?>
                                <?php Form::textbox('fname',$kin_fname); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Middle Name:</td>
                            <td><?php Form::textbox('mname',$kin_mname); ?></td>
                        </tr>
                        <tr>
                            <td>Surname:</td>
                            <td><?php Form::textbox('sname',$kin_sname); ?></td>
                        </tr>
                        <tr>
                            <td>Gender:</td>
                            <td><?php Form::selectbox(item_array('gender'),'gender',$kin_gender); ?></td>
                        </tr>
                        <tr>
                            <td class="percent35" style="vertical-align:top;">Address:</td>
                            <td><?php Form::textarea('address',$kin_address); ?></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><?php Form::textbox('email',$kin_email); ?></td>
                        </tr>
                        <tr>
                            <td>Phone Number 1:</td>
                            <td><?php Form::textbox('phone1',$kin_phone1); ?></td>
                        </tr>
                        <tr>
                            <td>Phone Number 2:</td>
                            <td><?php Form::textbox('phone2',$kin_phone2); ?></td>
                        </tr>
                        <tr>
                            <td>Relationship:</td>
                            <td><?php Form::selectbox($option->dropdown_list('relationship'),'relationship',$kin_relate); ?></td>
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
        // Switch on validator for certain form fields
        $validator.activate([
            {'name':'#sel_title','type':'select'},   // Title
            {'name':'#txt_fname','type':'text'},     // First Name
            {'name':'#txt_sname','type':'text'},     // Surname
            {'name':'#sel_gender','type':'select'},  // Gender
            {'name':'#txta_address','type':'text'},  // Address
            {'name':'#txt_phone1','type':'text'},    // Phone 1
            //{'name':'#txt_pid_alias','type':'text'}, // Patient ID
            {'name':'#sel_ptype','type':'select'},   // Patient Type
            {'name':'#sel_intdoc','type':'select'},  // Assigned Doctor
            {'name':'#sel_status','type':'select'},  // Patient Status
            {'name':'#txt_age','type':'text'}        // Age
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
        $("#frm_new_patient").on('submit', function($this)
        {
            // Prevent the form from submitting
            $this.preventDefault();
            tinymce.triggerSave();
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
                var formData = new FormData($("#frm_new_patient")[0]);
                formData.append('opt', 'update_kin');
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
                            $file_loader.load_middle_pane('my_profile/profile_display');
                            $file_loader.load_left_pane('my_profile/menu_left');
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