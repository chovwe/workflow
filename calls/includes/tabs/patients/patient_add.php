<?php
    require_once( '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'init.php' );
    require_once( INCLUDES.DIRECTORY_SEPARATOR.'functions.php' );
    
    // Class instances
    $int_profile  = new Int_Profile();
    $hospital     = new Hospital();
    $option       = new Option();
    
    // Patient ID Alias Generator
    $pid_alias = $option->next_code('pid_alias');
    if ($pid_alias != '')
    {
        $next_code = 'P' . date('ym') . '/' . pad($pid_alias, 2);
    } else {
        $next_code = '';
    }
?>
    
<form name="frm_new_patient" id="frm_new_patient" method="post">
    <div class="outter_pad">
        <div class="l_float percent50">
            <div class="inner_pad">
                <div class="fieldset">
                    <div class="legend">Personal Details:</div>
                    <table class="visible_table">
                        <tr>
                            <td class="percent35">Title:</td>
                            <td><?php Form::selectbox($option->dropdown_list('title'),'sel_title'); ?></td>
                        </tr>
                        <tr>
                            <td class="percent35">First Name:</td>
                            <td><?php Form::textbox('txt_fname'); ?></td>
                        </tr>
                        <tr>
                            <td>Middle Name:</td>
                            <td><?php Form::textbox('txt_mname'); ?></td>
                        </tr>
                        <tr>
                            <td>Surname:</td>
                            <td><?php Form::textbox('txt_sname'); ?></td>
                        </tr>
                        <tr>
                            <td>Gender:</td>
                            <td><?php Form::selectbox(item_array('gender'),'sel_gender'); ?></td>
                        </tr>
                    </table>
                    <!-- Tooltip -->
                    <div class="tooltip"><span class="dark_gray"></span><div class="tail"></div></div>
                </div>
            </div>
        </div>
            
        <div class="l_float percent50">
            <div class="inner_pad">
                <div class="fieldset" style="border:none;padding:0;">
                    <table class="percent100">
                        <tr>
                            <td style="padding-right:15px;">
                                <div>
                                    <div style='height:0px;width:0px;overflow:hidden;'><input type="file" name="fil_patient_pix" id="fil_patient_pix" onchange="javascript:$process_uploader();" accept="image/*" title="Please select an image" /></div>
                                    <button type="button" name="btn_patient_pix" id="btn_patient_pix" class="btn_pix rnd_oooo"><img id="pix_display" src="../calls/images/patients/sample.jpg" class="rnd_oooo" /></button>
                                </div>
                            </td>
                            <td class="percent100" style="vertical-align:top;">
                                <table class="visible_table">
                                    <tr>
                                        <td>Patient&nbsp;ID:</td><td><?php Form::textbox('txt_pid_alias',$next_code); ?></td>
                                    </tr>
                                    <tr>
                                        <td>First&nbsp;Visit:</td><td class="bold"><?php echo date('F d, Y.') ?></td>
                                    </tr>
                                    <tr>
                                        <td>No.&nbsp;of&nbsp;Visits:</td><td class="bold">0</td>
                                    </tr>
                                </table>
                            </td>
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
                <div id="fieldset_contact" class="fieldset">
                    <div class="legend">Contact Details:</div>
                    <table class="visible_table">
                        <tr>
                            <td class="percent35" style="vertical-align:top;">Address:</td>
                            <td><?php Form::textarea('txta_address'); ?></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><?php Form::textbox('txt_email'); ?></td>
                        </tr>
                        <tr>
                            <td>Phone Number 1:</td>
                            <td><?php Form::textbox('txt_phone1'); ?></td>
                        </tr>
                        <tr>
                            <td>Phone Number 2:</td>
                            <td><?php Form::textbox('txt_phone2'); ?></td>
                        </tr>
                    </table>
                    <!-- Tooltip -->
                    <div class="tooltip"><span class="dark_gray"></span><div class="tail"></div></div>
                </div>
            </div>
        </div>
        
        <div class="l_float percent50">
            <div class="inner_pad">
                <div id="fieldset_official" class="fieldset">
                    <div class="legend">Official Details:</div>
                    <table class="visible_table">
                        <tr>
                            <td class="percent35">Patient Type:</td>
                            <td><?php Form::selectbox($option->dropdown_list('patient_type'),'sel_ptype'); ?></td>
                        </tr>
                        <tr>
                            <td>Assigned Doctor:</td>
                            <td><?php Form::selectbox($int_profile->dropdown_list('Doctor'),'sel_intdoc'); ?></td>
                        </tr>
                        <tr>
                            <td class="percent35">Blood Type:</td>
                            <td>
                                <table class="inner_table">
                                    <tr>
                                        <td class="percent40"><?php Form::selectbox(item_array('blood_type'),'sel_bloodtype'); ?></td>
                                        <td class="r_align">RH: </td>
                                        <td class="percent40"><?php Form::selectbox(item_array('rh'),'sel_rh'); ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>Referring Hospital:</td>
                            <td>
                                <?php
                                    Form::selectbox($hospital->dropdown_list('EXT'),'sel_refhospital','',array(
                                        'onchange' => "javascript:\$ajax_loading('ref_doc','../calls/includes/switch.php','&opt=ref_doc&value='+this.value);"
                                    ));
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Referring Doctor:</td>
                            <td id="ref_doc"><?php Form::selectbox(array(),'sel_extdoc'); ?></td>
                        </tr>
                        <tr>
                            <td>Account Status:</td>
                            <td><?php Form::selectbox($option->dropdown_list('account_status'),'sel_status','12'); ?></td>
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
                <div id="fieldset_nok" class="fieldset">
                    <div class="legend">Next of Kin Details:</div>
                    <table class="visible_table">
                        <tr>
                            <td class="percent35">First Name:</td>
                            <td><?php Form::textbox('txt_kin_fname'); ?></td>
                        </tr>
                        <tr>
                            <td>Middle Name:</td>
                            <td><?php Form::textbox('txt_kin_mname'); ?></td>
                        </tr>
                        <tr>
                            <td>Surname:</td>
                            <td><?php Form::textbox('txt_kin_sname'); ?></td>
                        </tr>
                        <tr>
                            <td>Gender:</td>
                            <td><?php Form::selectbox(item_array('gender'),'sel_kin_gender'); ?></td>
                        </tr>
                        <tr>
                            <td class="percent35" style="vertical-align:top;">Address:</td>
                            <td><?php Form::textarea('txta_kin_address'); ?></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><?php Form::textbox('txt_kin_email'); ?></td>
                        </tr>
                        <tr>
                            <td>Phone Number 1:</td>
                            <td><?php Form::textbox('txt_kin_phone1'); ?></td>
                        </tr>
                        <tr>
                            <td>Phone Number 2:</td>
                            <td><?php Form::textbox('txt_kin_phone2'); ?></td>
                        </tr>
                        <tr>
                            <td>Relationship:</td>
                            <td><?php Form::selectbox($option->dropdown_list('relationship'),'sel_kin_relate'); ?></td>
                        </tr>
                    </table>
                    <!-- Tooltip -->
                    <div class="tooltip"><span class="dark_gray"></span><div class="tail"></div></div>
                </div>
            </div>
        </div>
        
        <div class="l_float percent50">
            <div class="inner_pad">
                <div id="fieldset_other" class="fieldset">
                    <div class="legend">Other Details:</div>
                    <table class="visible_table">
                        <tr>
                            <td class="percent35">Date of Birth:</td>
                            <td>
                                <table class="inner_table">
                                    <tr>
                                        <td class="percent60">
                                            <?php
                                                Form::textbox('txt_dob','',array(
                                                    'onchange' => "javascript:\$date_engine.get_age(this.value,'#txt_age');",
                                                    'readonly' => 'true'                                                    
                                                ));
                                            ?>
                                        </td>
                                        <td class="r_align">Age:</td>                                        
                                        <td class="r_align percent15">
                                            <?php
                                                Form::textbox('txt_age','',array(
                                                    'onkeyup'  => "javascript:\$date_engine.get_dob(this.value,'#txt_dob');"
                                                ));
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>Marital Status:</td>
                            <td><?php Form::selectbox($option->dropdown_list('marital_status'),'sel_marital'); ?></td>
                        </tr>
                        <tr>
                            <td>Religion:</td>
                            <td><?php Form::selectbox($option->dropdown_list('religion'),'sel_religion'); ?></td>
                        </tr>
                        <tr>
                            <td>Occupation:</td>
                            <td><?php Form::selectbox($option->dropdown_list('occupation'),'sel_occupation'); ?></td>
                        </tr>
                        <tr>
                            <td>Country:</td>
                            <td><?php Form::selectbox($option->dropdown_list('country'),'sel_country'); ?></td>
                        </tr>
                    </table>
                    <!-- Tooltip -->
                    <div class="tooltip"><span class="dark_gray"></span><div class="tail"></div></div>
                </div>
            </div>
        </div>
        
        <div class="percent100 clear"></div>
        
        <div class="l_float percent100">
            <div class="inner_pad">
                <div class="fieldset">
                    <div class="legend">Controls:</div>
                    <table class="visible_table">
                        <tr>
                            <td colspan="2"><button type="submit">Add Patient</button></td>
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
        $init.equalize_heights(['#fieldset_contact','#fieldset_official']);
        $init.equalize_heights(['#fieldset_nok','#fieldset_other']);
        
        // File uploader
        $('#btn_patient_pix').on('click', function()
        {
            $('#fil_patient_pix').trigger('click');
        });
        
        // Jquery date picker
        $( "#txt_dob" ).datepicker({ dateFormat: "dd/mm/yy", changeMonth: true, changeYear: true });
        
        // Switch on validator for certain form fields
        $validator.activate([
            {'name':'#sel_title','type':'select'},   // Title
            {'name':'#txt_fname','type':'text'},     // First Name
            {'name':'#txt_sname','type':'text'},     // Surname
            {'name':'#sel_gender','type':'select'},  // Gender
            {'name':'#txta_address','type':'text'},  // Address
            {'name':'#txt_phone1','type':'text'},    // Phone 1
            {'name':'#txt_pid_alias','type':'text'}, // Patient ID
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
                formData.append('opt', 'insert_patient');
                
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
                            $file_loader.load_middle_pane('patients/patient_display');
                            $file_loader.load_left_pane('patients/menu_left');
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
    
    // Process file upload
    var $process_uploader = function()
    {
        var pix = $('#fil_patient_pix');
        if(pix.val() === "")
        {
            $ui_engine.block({title:'Alert!',file:'alert_failure',width:'200',height:'120',buttons:'NNY'});
        } else {
            // Create an instance of the FileReader object
            reader = new FileReader();
            var file = $('#fil_patient_pix').prop("files")[0];
            
            reader.onload = function(event)
            {
                imgUrl = event.target.result;
                $("#pix_display").attr({
                    src: imgUrl,
                    width: 100,
                    height: 100
                });
            }
            
            reader.onerror = function(event) 
            {
                console.error("File could not be read! Code " + event.target.error.code);
            };
            
            reader.readAsDataURL(file);
        }
    }
</script>