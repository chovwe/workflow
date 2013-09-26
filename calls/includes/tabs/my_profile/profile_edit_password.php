<?php
    require_once( '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'init.php' );
    require_once( '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'functions.php' );
    
    // Class instances
    $session     = new Session();
    $int_profile = new Int_Profile();
    $option      = new Option();
    $document    = new Document();
    
    // Init.
    $int_profile_id = $title = $fname = $mname = $sname = $gender = $user_id = $last_login = $total_logins = $address = $email = $phone1 = $phone2 = $kin_fname = $dob = $marital = $religion = $qualification = $country = '';
    
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
            $title         = $profile_obj->title;
            $fname         = $profile_obj->first_name;
            $mname         = $profile_obj->middle_name;
            $sname         = $profile_obj->surname;
            $gender        = $profile_obj->gender;
            $address       = $profile_obj->address;
            $email         = $profile_obj->email;
            $phone1        = $profile_obj->phone_1;
            $phone2        = $profile_obj->phone_2;
            $dob           = $profile_obj->date_of_birth;
            $marital       = $profile_obj->marital_status;
            $religion      = $profile_obj->religion;
            $qualification = $profile_obj->qualification;
            $country       = $profile_obj->country;
        }
    }
?>
<form name="frm_new_patient" id="frm_new_patient" method="post">
    <div class="outter_pad">
        
        <div class="l_float percent50">
            <div class="inner_pad">
                <div class="fieldset">
                    <div class="legend">Change Password:</div>
                    <table class="visible_table">
                        <tr>
                            <td colspan="2">New Password:</td>
                            <td colspan="2">
                                <?php Form::password('new_pass'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Re-enter Password:</td>
                            <td colspan="2">
                                <?php Form::password('re_pass'); ?>
                            </td>
                        </tr>
                    </table>
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
        $init.equalize_heights(['#fieldset_contact','#fieldset_other']);
        $init.equalize_heights(['#fieldset_nok','#fieldset_qualification']);
        
        // Switch on validator for certain form fields
        $validator.activate([
            {'name':'#new_pass','type':'password'},
            {'name':'#re_pass','type':'password'}
        ]);
        
        // Reset the form field appearance
        $("input").on('keyup', function()
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
                    
            // Error flag
            var $no_error = true;
            
            // Serialize the form values
            var $form       = $(this).serializeArray();
            
            // Loop through the form values
            $.each($form, function( e, $form )
            {
                //alert($form.name + ' => ' + $form.value);
                var $div = $("#"+$form.name);
                
                if (($div.prop("validate") == "password") && ($div.prop("value") == ""))
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
                var formData = new FormData($("#frm_new_patient")[0]);
                formData.append('opt', 'edit_password');
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

